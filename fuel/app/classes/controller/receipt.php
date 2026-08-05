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
     * お会計画面を表示します。
     *
     * indexはデフォルトアクションであり、
     * /receiptへアクセスした際に実行されます。
     *
     * @return View
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
     * 指定されたレシートの詳細画面を表示します。
     *
     * レシートIDが存在しない場合、またはレシートが見つからない場合は
     * レシート一覧画面へリダイレクトし、
     * レシートが存在する場合はレシート詳細画面を表示します。
     *
     * @param string|null $id 表示するレシートID
     * @return Response|View
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
        return View::forge('receipt/receipt', [
            'receipt_data' => $receipt_data,
        ]);
    }

    /**
     * レシート一覧画面を表示します。
     *
     * レシート一覧を取得し、表示用の日付形式へ変換して
     * レシート一覧画面を表示します。
     *
     * @return View
     */
    public function action_list()
    {
        // レシート一覧を取得
        $items = Model_Receipt::get_receipts();

        // レシート一覧の日付を画面表示用に整形
        $items = Model_Receipt::format_receipts($items);

        // 一覧画面へデータを渡す
        return View::forge('receipt/list', [
            'items' => $items,
        ]);
    }

    /**
     * レシートを作成します。
     *
     * POST以外のアクセス、または商品が選択されていない場合は
     * お会計画面へリダイレクトします。
     * 商品情報をModelへ渡してレシートを登録し、
     * 登録後はレシート詳細画面へリダイレクトします。
     *
     * @return Response
     */
    public function action_receipt_create()
    {
        // POST以外のアクセスは禁止
        if (Input::method() !== 'POST') {
            return Response::redirect('/receipt');
        }

        // 購入商品を取得
        $items = Input::post('items', []);

        // 商品が選択されていない場合はお会計画面へ戻る
        if (empty($items)) {
            return Response::redirect('/receipt');
        }

        // レシートを作成してMongoDBへ登録
        $receipt_id = Model_Receipt::create_receipt($items);

        // 登録したレシート詳細画面へリダイレクト
        return Response::redirect('/receipt/receipt_view/' . $receipt_id);
    }

    /**
     * 指定されたレシートを削除します。
     *
     * レシートIDが存在しない場合はレシート一覧画面へリダイレクトし、
     * 削除完了後はレシート一覧画面へリダイレクトします。
     *
     * @param string|null $id 削除するレシートID
     * @return Response
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