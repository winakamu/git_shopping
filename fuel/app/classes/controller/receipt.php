<?php

/**
 * レシートコントローラ
 *
 * 【機能】
 * ・お会計画面表示
 * ・レシート作成
 * ・レシート一覧表示
 * ・レシート詳細表示
 * ・レシート削除
 */
class Controller_Receipt extends Controller
{
    /**
     * お会計画面表示
     * index = default action（クラスにアクセスした場合、FuelPHPが自動で探して実行する）
     */
    public function action_index()
    {
        // お会計画面を生成
        $view = View::forge('receipt/register');

        // 商品一覧を取得して画面へ渡す
        $view->items = Model_Item::get_items();

        return $view;
    }

    /**
     * レシート詳細表示
     */
    public function action_receipt_view($id = null)
    {
        // レシートIDがない場合は一覧へ戻る
        if (empty($id)) {
            return Response::redirect('/receipt/list');
        }

        // 指定されたレシート情報を取得
        $receipt_data = Model_Receipt::get_receipt($id);

        // レシートが存在しない場合は一覧へ戻る
        if (empty($receipt_data)) {
            return Response::redirect('/receipt/list');
        }

        // 日付を画面表示用に整形
        $receipt_data = Model_Receipt::format_receipt($receipt_data);

        // レシート詳細画面へデータを渡す
        return View::forge('receipt/receipt', array(
            'receipt_data' => $receipt_data,
        ));
    }

    /**
     * レシート一覧表示
     */
    public function action_list()
    {
        // レシート一覧を取得
        $items = Model_Receipt::get_receipts();

        // レシート一覧の日付を画面表示用に整形
        $items = Model_Receipt::format_receipts($items);

        // 一覧画面へデータを渡す
        return View::forge('receipt/list', array(
            'items' => $items,
        ));
    }

    /**
     * レシート作成
     */
    public function action_receipt_create()
    {
        // POST以外のアクセスは禁止
        if (Input::method() !== 'POST') {
            return Response::redirect('/receipt');
        }

        // 購入商品を取得
        $items = Input::post('items', array());

        // 商品が選択されていない場合はお会計画面へ戻る
        if (empty($items)) {
            return Response::redirect('/receipt');
        }

        // priceを整数へ変換
        foreach ($items as &$item) {
            $item['price'] = (int) $item['price'];
        }
        unset($item);

        // 税率ごとの小計を初期化
        $subtotal = array(
            'tax_8' => array(
                'excluding_tax' => 0,
                'consumption_tax' => 0,
            ),
            'tax_10' => array(
                'excluding_tax' => 0,
                'consumption_tax' => 0,
            ),
            'tax_exempt' => array(
                'excluding_tax' => 0,
                'consumption_tax' => 0,
            ),
            'tax_included' => array(
                'excluding_tax' => 0,
                'consumption_tax' => 0,
            ),
        );

        // 合計金額を初期化
        $total = 0;

        // 商品ごとの税額・合計金額を計算
        foreach ($items as $item) {

            $price = $item['price'];
            $tax = $item['tax'];

            if ($tax === '8') {

                $taxAmount = floor($price * 0.08);

                $subtotal['tax_8']['excluding_tax'] += $price;
                $subtotal['tax_8']['consumption_tax'] += $taxAmount;

                $total += $price + $taxAmount;

            } elseif ($tax === '10') {

                $taxAmount = floor($price * 0.10);

                $subtotal['tax_10']['excluding_tax'] += $price;
                $subtotal['tax_10']['consumption_tax'] += $taxAmount;

                $total += $price + $taxAmount;

            } elseif ($tax === 'exempt') {

                $subtotal['tax_exempt']['excluding_tax'] += $price;
                $total += $price;

            } elseif ($tax === 'included') {

                $subtotal['tax_included']['excluding_tax'] += $price;
                $total += $price;
            }
        }

        // レシートデータを作成
        $receipt = array(
            'items' => $items,
            'subtotal' => $subtotal,
            'total' => $total,
            'created_at' => date('Y-m-d H:i:s'),
        );

        // MongoDBへレシートを登録
        $receipt_id = Model_Receipt::insert_receipt($receipt);

        // 登録結果確認（デバッグ用）
        //Debug::dump($receipt_id);
        // exit;
        return Response::redirect('/receipt/list');
    }

    /**
     * レシート削除
     */
    public function action_delete($id = null)
    {
        // レシートIDがない場合は一覧へ戻る
        if (empty($id)) {
            return Response::redirect('/receipt/list');
        }

        // レシートを削除
        Model_Receipt::delete_receipt($id);

        // 一覧画面へ戻る
        return Response::redirect('/receipt/list');
    }
}