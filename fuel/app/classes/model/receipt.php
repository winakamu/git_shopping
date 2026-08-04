<?php

/**
 * レシート情報を管理するModelです。
 *
 * 【機能】
 * ・レシート登録
 * ・レシート全件取得
 * ・レシート1件取得
 * ・レシート作成
 * ・レシート削除
 * ・レシート一覧の日付整形
 * ・レシート詳細の日付整形
 */
class Model_Receipt extends Model_Mongo
{
    /**
     * 使用するコレクション名
     *
     * @var string
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
     * 作成日時の降順で取得します。
     *
     * @return array レシート一覧
     */
    public static function get_receipts()
    {
        return self::get_all_data([
            '_id' => 'desc',
        ]);
    }

    /**
     * レシートを1件取得します。
     *
     * @param string $id 取得するレシートのID
     * @return array|null レシート情報
     */
    public static function get_receipt($id)
    {
        return self::get_data($id);
    }

    /**
     * 商品情報からレシートを作成して登録します。
     *
     * 商品ごとの価格と税区分から、税率別小計、消費税額、
     * 合計金額を計算してMongoDBへ登録します。
     *
     * @param array $items 購入商品一覧
     * @return string 登録したレシートのMongoDB ID
     */
    public static function create_receipt(array $items)
    {
        // 税率ごとの小計を初期化
        $subtotal = [
            'tax_8' => [
                'excluding_tax' => 0,
                'consumption_tax' => 0,
            ],
            'tax_10' => [
                'excluding_tax' => 0,
                'consumption_tax' => 0,
            ],
            'tax_exempt' => [
                'excluding_tax' => 0,
                'consumption_tax' => 0,
            ],
            'tax_included' => [
                'excluding_tax' => 0,
                'consumption_tax' => 0,
            ],
        ];

        // 合計金額を初期化
        $total = 0;

        // 商品ごとの税額と合計金額を計算
        foreach ($items as &$item) {
            // 価格を整数へ変換
            $item['price'] = (int) $item['price'];

            $price = $item['price'];
            $tax = $item['tax'];

            if ($tax === '8') {
                $tax_amount = (int) floor($price * 0.08);

                $subtotal['tax_8']['excluding_tax'] += $price;
                $subtotal['tax_8']['consumption_tax'] += $tax_amount;

                $total += $price + $tax_amount;

            } elseif ($tax === '10') {
                $tax_amount = (int) floor($price * 0.10);

                $subtotal['tax_10']['excluding_tax'] += $price;
                $subtotal['tax_10']['consumption_tax'] += $tax_amount;

                $total += $price + $tax_amount;

            } elseif ($tax === 'exempt') {
                $subtotal['tax_exempt']['excluding_tax'] += $price;

                $total += $price;

            } elseif ($tax === 'included') {
                $subtotal['tax_included']['excluding_tax'] += $price;

                $total += $price;
            }
        }
        unset($item);

        // レシートデータを作成
        $receipt = [
            'items' => $items,
            'subtotal' => $subtotal,
            'total' => $total,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // MongoDBへレシートを登録
        return self::insert_receipt($receipt);
    }

    /**
     * レシートを削除します。
     *
     * @param string $id 削除するレシートのID
     * @return mixed 削除結果
     */
    public static function delete_receipt($id)
    {
        return self::delete_data($id);
    }

    /**
     * レシート一覧の日付を表示用に整形します。
     *
     * @param array $receipts レシート一覧
     * @return array 日付を整形したレシート一覧
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
     * レシートの日付を表示用に整形します。
     *
     * @param array $receipt_data レシート情報
     * @return array 日付を整形したレシート情報
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
            '日', '月', '火', '水', '木', '金', '土'
        ];

        $weekday = $weekdays[(int) date('w', $timestamp)];

        $receipt_data['view_date'] =
            date('Y年m月d日', $timestamp)
            . '(' . $weekday . ') '
            . date('H時i分', $timestamp);

        return $receipt_data;
    }
}