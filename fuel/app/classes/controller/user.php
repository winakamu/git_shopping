<?php

class Controller_User extends Controller
{
    /**
     * 利用者 登録・編集画面
     * @param string $user_id 編集したい利用者のMongoId(新規の時は空)
     */
    public function action_upsert($user_id = '')
    {
            $view = View::forge('user/insert');
            // $view = View::forge('user/edit');

        return $view;
    }

    /**
     * 利用者一覧
     */
    public function action_list()
    {
        $view = View::forge('user/list');
        return $view;
    }
}