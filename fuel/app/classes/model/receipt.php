<?php

class Model_Receipt extends Model_Mongo
{
    /**
     * 使用するコレクション名
     */
    protected static $collection = 'receipt';

    /**
     * レシートを登録
     */
    public static function insert_receipt(array $receipt)
    {
        return self::insert_data($receipt);
    }

    /**
     * レシートを全件取得
     */
    public static function get_receipts()
    {
        return Mongo_Db::instance()
            ->order_by([
                '_id' => 'desc',
            ])
            ->get('receipt');
    }

    /**
     * レシートを1件取得
     */
    public static function get_receipt($id)
    {
        return self::get_data($id);
    }

    /**
     * レシートを削除
     */
    public static function delete_receipt($id)
    {
        return self::delete_data($id);
    }

    /**
     * レシート一覧の日付を表示用に整形
     */
    public static function format_receipts(array $receipts)
    {
        foreach ($receipts as &$receipt) {
            $receipt = self::format_receipt($receipt);
        }
        unset($receipt);

        return $receipts;
    }

    /**
     * レシート1件の日付を表示用に整形
     */
    public static function format_receipt(array $receipt_data)
    {
        if (empty($receipt_data['created_at'])) {
            $receipt_data['view_date'] = '';

            return $receipt_data;
        }

        $timestamp = strtotime($receipt_data['created_at']);

        // 日付変換に失敗した場合
        if ($timestamp === false) {
            $receipt_data['view_date'] = '';

            return $receipt_data;
        }

        $weekdays = array(
            '日', '月', '火', '水', '木', '金', '土'
        );

        $weekday = $weekdays[(int) date('w', $timestamp)];

        $receipt_data['view_date'] =
            date('Y年m月d日', $timestamp)
            . '(' . $weekday . ') '
            . date('H時i分', $timestamp);

        return $receipt_data;
    }
}