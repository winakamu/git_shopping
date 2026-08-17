<?php


/**
 * 介護報酬請求に関する処理を行うControllerです。
 *
 * 【機能】
 * ・単位数シミュレータ画面の表示
 * ・選択されたサービスの単位数計算
 * ・計算結果画面の表示
 */
class Controller_Claim extends Controller
{
    /**
     * 単位数シミュレータ
     *
     * @param string $user_id 単位数をシミュレートしたい利用者のMongoId
     * @return View
     */
    public function action_simulator($user_id = '')
    {
        // 単位数シミュレータ画面を生成
        $view = View::forge('claim/simulator');


        // 利用者情報を取得
        $user = Model_User::get_user($user_id);


        // 画面表示に必要なデータを設定
        $view->set('user', $user);
        $view->set(
            'service_code',
            Model_Pseudo::$service_code
        );


        return $view;
    }


    /**
     * 選択されたサービスの単位数を計算し、
     * 計算結果画面を表示します。
     *
     * @return Response|View
     */
    public function action_calc()
    {
        // POST以外のアクセスの場合は利用者一覧へ戻る
        if (Input::method() !== 'POST') {
            return Response::redirect('/user/list');
        }


        // POSTされた情報を取得
        $user_id = Input::post('user_id', '');
        $services = Input::post('services', []);


        // 必要な情報がない場合は利用者一覧へ戻る
        if (empty($user_id) || empty($services)) {
            return Response::redirect('/user/list');
        }


        // 利用者情報を取得
        $user = Model_User::get_user($user_id);


        // 介護度コードを表示用名称へ変換
        $user['care_level_name'] =
            Model_Pseudo::$care_level_name[
                $user['care_level']
            ];


        // サービスの単位数を計算
        $result = Model_Claim::calculate($services);


        // 計算結果画面を表示
        return View::forge('claim/result', [
            'user_id' => $user_id,
            'user' => $user,
            'result' => $result,
        ]);
    }
}