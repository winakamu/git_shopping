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
}