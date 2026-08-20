<?php


/**
 * 利用者情報を管理するModelです。
 *
 * 【機能】
 * ・介護度コードと表示名称の管理
 * ・利用者一覧の取得
 * ・指定された利用者情報の取得
 * ・利用者の新規登録
 * ・利用者情報の更新
 * ・利用者情報の削除
 */
class Model_User extends Model_Mongo
{
    /**
     * 使用するMongoDBコレクション名
     *
     * @var string
     */
    protected static $collection = 'user';


    /**
     * 利用者情報を全件取得します。
     *
     * @return array 利用者一覧
     */
    public static function get_users()
    {
        return self::get_all_data();
    }


    /**
     * 指定された利用者を1件取得します。
     *
     * @param string $id 利用者ID
     * @return array|null 利用者情報
     */
    public static function get_user($id)
    {
        return self::get_data($id);
    }


    /**
     * 利用者を新規登録します。
     *
     * @param array $user 登録する利用者情報
     * @return string 登録した利用者のMongoDB ID
     */
    public static function insert_user(array $user)
    {
        return self::insert_data($user);
    }


    /**
     * 指定された利用者情報を更新します。
     *
     * @param string $id 利用者ID
     * @param array $user 更新する利用者情報
     * @return mixed 更新結果
     */
    public static function update_user($id, array $user)
    {
        return self::update_data($id, $user);
    }


    /**
     * 指定された利用者を削除します。
     *
     * @param string $id 利用者ID
     * @return mixed 削除結果
     */
    public static function delete_user($id)
    {
        return self::delete_data($id);
    }


    /**
     * 介護度コードと画面表示名称の対応表
     *
     * @var array
     */
    public static $care_level_name = [
        'integ' => '事業対象者',
        'prev1' => '要支援1',
        'prev2' => '要支援2',
        'care1' => '要介護1',
        'care2' => '要介護2',
        'care3' => '要介護3',
        'care4' => '要介護4',
        'care5' => '要介護5',
    ];

    /**
     * 指定された介護度の利用者情報を取得します。
     *
     * @param string $care_level 介護度
     * @return array 利用者一覧
     */
    public static function get_users_by_care_level($care_level)
    {
        //全利用者を取得(継承クラスより)
        $users = self::get_all_data();
        $filtered_users = [];

        foreach ($users as $user) {
            //指定された介護度と一致
            if ($user['care_level'] === $care_level) {
                $filtered_users[] = $user;
            }
        }
        //絞り込んだ利用者だけ返す
        return $filtered_users;
    }
}