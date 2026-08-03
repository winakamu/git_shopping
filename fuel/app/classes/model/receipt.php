<?php

class Model_Receipt extends Model_Mongo
{
    /**
     * 使用するコレクション名
     */
    protected static $collection = 'receipt';

    /**
     * レシートを登録します。
     *
     * @param array $receipt 登録するレシート情報
     * @return string 登録したレシートのMongoDB ID
     */
    public static function insert_receipt(array $receipt)
    {
        return self::insert_data($receipt);
    }

    /**
     * レシートを全件取得します。
     *
     * @return array レシート一覧
     */
    public static function get_receipts()
    {
        return self::get_all_data();
    }

    /**
     * 指定されたレシートを1件取得します。
     *
     * @param string $id 取得するレシートID
     * @return array レシート情報
     */
    public static function get_receipt($id)
    {
        return self::get_data($id);
    }

    /**
     * 指定されたレシートを削除します。
     *
     * @param string $id 削除するレシートID
     * @return mixed 削除結果
     */
    public static function delete_receipt($id)
    {
        return self::delete_data($id);
    }

    /**
     * レシート一覧の日付を表示用に整形します。
     *
     * 各レシートに対して日付整形処理を行い、
     * 表示用の日付をview_dateへ設定します。
     *
     * @param array $receipts 整形するレシート一覧
     * @return array 日付整形後のレシート一覧
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
     * レシート1件の日付を表示用に整形します。
     *
     * created_atを「YYYY年MM月DD日(曜日) HH時MM分」の形式に変換し、
     * view_dateへ設定します。
     *
     * @param array $receipt_data 整形するレシート情報
     * @return array 日付整形後のレシート情報
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

        $weekdays = [
            '日', '月', '火', '水', '木', '金', '土',
        ];

        $weekday = $weekdays[(int) date('w', $timestamp)];

        $receipt_data['view_date'] =
            date('Y年m月d日', $timestamp)
            . '(' . $weekday . ') '
            . date('H時i分', $timestamp);

        return $receipt_data;
    }
}