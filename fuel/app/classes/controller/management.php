<?php
/**
 * 商品管理コントローラ
 *
 * 【機能】
 * ・商品登録
 * ・商品一覧表示
 * ・商品編集
 * ・商品更新
 * ・商品削除
 */

class Controller_Management extends Controller
{
    /**
     * 商品登録画面を表示し、POST送信時は商品を登録します。
     *
     * 初回表示または入力エラー時は商品登録画面を表示し、
     * 登録完了後は商品一覧画面へリダイレクトします。
     *
     * @return Response|View
     */
    public function action_insert()
    {
        // POST送信時のみ登録処理を実行
        if (Input::method() === 'POST') {

            // フォームから入力された値を取得
            $product_name = trim((string) Input::post('product_name', ''));
            $tax = (string) Input::post('tax', 'exempt');
            $price = trim((string) Input::post('price', ''));

            // 商品名または価格が未入力の場合は登録画面へ戻る
            if ($product_name === '' || $price === '') {
                return View::forge('management/insert');
            }

            // 価格が数値以外の場合は登録画面へ戻る
            if (!ctype_digit($price)) {
                return View::forge('management/insert');
            }

            // MongoDBへ登録する商品データを作成
            $item = [
                'name'  => $product_name, //商品名
                'tax'   => $tax,          //消費税
                'price' => (int) $price,  //1個あたりの値段(税抜)
            ];

            // 商品情報をMongoDBへ登録
            Model_Item::insert_item($item);

            // 登録完了後は商品一覧画面へリダイレクト
            return Response::redirect('/management/list');
        }

        // 初回表示時は商品登録画面を表示
        return View::forge('management/insert');
    }

    /**
     * 商品一覧を取得し、一覧画面を表示します。
     *
     * @return View
     */
    public function action_list()
    {
        // MongoDBから商品一覧を取得
        $items = Model_Item::get_items();

        // 商品一覧画面へデータを渡す
        return View::forge('management/list', [
            'items' => $items,
        ]);
    }

    /**
     * 指定された商品の編集画面を表示します。
     *
     * 商品IDが存在しない場合、または商品が見つからない場合は
     * 商品一覧画面へリダイレクトし、商品が存在する場合は
     * 商品編集画面を表示します。
     *
     * @param string|null $id 編集対象の商品ID
     * @return Response|View
     */
    public function action_edit($id = null)
    {
        // 商品IDが存在しない場合は一覧へ戻る
        if ($id === null) {
            return Response::redirect('/management/list');
        }

        // 指定された商品の情報を取得
        $item = Model_Item::get_item($id);

        // 商品が存在しない場合は一覧へ戻る
        if (empty($item)) {
            return Response::redirect('/management/list');
        }

        // 編集画面へ商品情報を渡す
        return View::forge('management/edit', [
            'item' => $item,
        ]);
    }

    /**
     * 指定された商品の情報を更新します。
     *
     * 商品IDが存在しない場合は商品一覧画面へリダイレクトし、
     * POST以外のアクセスまたは入力エラー時は商品編集画面へ
     * リダイレクトします。
     * 更新完了後は商品一覧画面へリダイレクトします。
     *
     * @param string|null $id 更新対象の商品ID
     * @return Response
     */
    public function action_update($id = null)
    {
        // 商品IDが存在しない場合は商品一覧へ戻る
        if ($id === null) {
            return Response::redirect('/management/list');
        }

        // POST以外のアクセスの場合は編集画面へ戻る
        if (Input::method() !== 'POST') {
            return Response::redirect('/management/edit/' . $id);
        }

        // フォームから入力された値を取得
        $product_name = trim((string) Input::post('product_name', ''));
        $tax = (string) Input::post('tax', 'exempt');
        $price = trim((string) Input::post('price', ''));

        // 商品名または価格が未入力の場合は編集画面へ戻る
        if ($product_name === '' || $price === '') {
            return Response::redirect('/management/edit/' . $id);
        }

        // 価格が数値以外の場合は編集画面へ戻る
        if (!ctype_digit($price)) {
            return Response::redirect('/management/edit/' . $id);
        }

        // 更新する商品データを作成
        $item = [
            'name'  => $product_name,
            'tax'   => $tax,
            'price' => (int) $price,
        ];

        // MongoDBの商品情報を更新
        Model_Item::update_item($id, $item);

        // 更新完了後は商品一覧画面へ戻る
        return Response::redirect('/management/list');
    }

    /**
     * 指定された商品を削除します。
     *
     * 商品IDが存在しない場合は商品一覧画面へリダイレクトし、
     * 削除完了後は商品一覧画面へリダイレクトします。
     *
     * @param string|null $id 削除対象の商品ID
     * @return Response
     */
    public function action_delete($id = null)
    {
        // 商品IDが存在しない場合は一覧へ戻る
        if ($id === null) {
            return Response::redirect('/management/list');
        }

        // 指定された商品を削除
        Model_Item::delete_item($id);

        // 削除完了後は商品一覧画面へ戻る
        return Response::redirect('/management/list');
    }
}