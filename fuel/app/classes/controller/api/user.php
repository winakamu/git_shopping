<?php

/**
 * 利用者情報を取得するAPIコントローラー
 */
class Controller_Api_User extends Controller_Rest
{
    /**
     * 利用者一覧を取得する
     *
     * 指定された介護度に応じて利用者一覧を取得する。
     * 介護度が指定されていない場合は、全利用者を取得する。
     *
     * @return Response 利用者一覧
     */
    public function get_user_list()
    {
        $care_level = Input::get('care_level', '');

        // ① 介護度が選択されていない場合は全利用者を取得
        if ($care_level === '') {
            $users = Model_User::get_users();
        } else {
            // ② 選択された介護度の利用者のみ取得
            $users = Model_User::get_users_by_care_level($care_level);
        }

        // ③ APIレスポンス用に利用者情報を整形
        foreach ($users as &$user) {
            // MongoDB IDを文字列に変換
            $user['_id'] = (string) $user['_id'];

            // 介護度の表示名を追加
            $user['care_level_name'] =
                isset(Model_User::$care_level_name[$user['care_level']])
                    ? Model_User::$care_level_name[$user['care_level']]
                    : '不明';
        }

        // ④ 利用者一覧をレスポンスとして返却
        return $this->response($users);
    }
}