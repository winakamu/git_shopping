<?php

/**
 * 利用者情報に関する処理を行うControllerです。
 *
 * 【機能】
 * ・利用者の新規登録
 * ・利用者情報の編集
 * ・利用者一覧の表示
 * ・利用者情報の削除
 */
class Controller_User extends Controller
{
    /**
     * 利用者 登録・編集画面
     *
     * 利用者IDが指定されている場合は既存データを取得し、
     * 編集画面として表示します。
     *
     * POSTされた場合は入力内容をチェックし、
     * 問題がなければ新規登録または更新を行います。
     *
     * @param string $user_id 編集したい利用者のMongoId(新規の時は空)
     * @return Response|View
     */
    public function action_upsert($user_id = '')
    {
        // 利用者登録・編集画面を生成
        $view = View::forge('user/insert');

        /*
         * 編集画面を最初に開いた場合
         */
        if (empty(Input::post()) && $user_id !== '') {
            // 利用者IDから既存の利用者情報を取得
            $user = Model_User::get_user($user_id);

            // 利用者情報が見つからない場合は一覧画面へ戻る
            if (empty($user)) {
                return Response::redirect('/user/list');
            }

            // 既存の利用者情報をViewへ渡す
            $view->set('user', $user);
            $view->set('user_id', $user_id);
        }

        /*
         * 登録・更新ボタンを押した場合
         */
        if (!empty(Input::post())) {
            // 入力内容を取得
            $user_name = trim(
                (string) Input::post('user_name', '')
            );

            $care_level =
                (string) Input::post('care_level', '');

            $rate = trim(
                (string) Input::post('rate', '')
            );

            // 入力エラーを格納
            $errors = [];

            // 利用者名未入力チェック
            if ($user_name === '') {
                $errors['user_name'] =
                    '利用者名が空欄です';
            }

            // 介護度未選択・不正値チェック
            if ($care_level === '') {
                $errors['care_level'] =
                    '介護度が未選択です';

            } elseif (
                !isset(Model_Pseudo::$limit_unit[$care_level])
            ) {
                $errors['care_level'] =
                    '不正な介護度です';
            }

            // 介護保険給付率未入力チェック
            if ($rate === '') {
                $errors['rate'] =
                    '介護保険給付率(%)が空欄です';
            }

            /*
             * 入力エラーがある場合は、
             * 入力内容を保持したまま同じ画面を表示
             */
            if (!empty($errors)) {
                $view->set('errors', $errors);

                $view->set('user', [
                    'user_name' => $user_name,
                    'care_level' => $care_level,
                    'rate' => $rate,
                ]);

                $view->set('user_id', $user_id);

                return $view;
            }

            // 保存する利用者データを作成
            $user = [
                'user_name' => $user_name,
                'care_level' => $care_level,
                'rate' => $rate,
                'limit_unit' =>
                    Model_Pseudo::$limit_unit[$care_level],
            ];

            /*
             * 利用者IDがある場合は更新、
             * ない場合は新規登録
             */
            if ($user_id !== '') {
                Model_User::update_user($user_id, $user);
            } else {
                Model_User::insert_user($user);
            }

            // 登録・更新後は利用者一覧へ戻る
            return Response::redirect('/user/list');
        }

        return $view;
    }

    /**
     * 利用者一覧
     *
     * MongoDBから利用者情報を全件取得し、
     * 一覧画面へ渡します。
     *
     * @return View
     */
    public function action_list()
    {
        // 利用者一覧画面を生成
        $view = View::forge('user/list');

        // 利用者情報を全件取得
        $users = Model_User::get_users();

        // 利用者一覧をViewへ渡す
        $view->set('users', $users);

        return $view;
    }

    /**
     * 指定された利用者を削除します。
     *
     * 利用者IDが指定されている場合のみ削除処理を行い、
     * 処理後は利用者一覧画面へ戻ります。
     *
     * @param string $user_id 削除対象の利用者ID
     * @return Response
     */
    public function action_delete($user_id = '')
    {
        // 利用者IDがある場合のみ削除
        if (!empty($user_id)) {
            Model_User::delete_user($user_id);
        }

        // 削除後は利用者一覧へ戻る
        return Response::redirect('/user/list');
    }
}