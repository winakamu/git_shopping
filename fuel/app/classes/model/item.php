<?php

/**
 * 商品情報を管理するModelです。
 *
 * 【機能】
 * ・商品登録
 * ・商品全件取得
 * ・商品1件取得
 * ・商品更新
 * ・商品削除
 */
class Model_Item extends Model_Mongo
{
    /**
     * 使用するコレクション名
     *
     * @var string
     */
    protected static $collection = 'item';

    /**
     * 商品を登録します。
     *
     * @param array $item 登録する商品情報
     * @return string 登録した商品のMongoDB ID
     */
    public static function insert_item(array $item)
    {
        return self::insert_data($item);
    }

    /**
     * 商品を全件取得します。
     *
     * @return array 商品一覧
     */
    public static function get_items()
    {
        return self::get_all_data();
    }

    /**
     * 商品を1件取得します。
     *
     * @param string $id 取得する商品のID
     * @return array|null 商品情報
     */
    public static function get_item($id)
    {
        return self::get_data($id);
    }

    /**
     * 商品情報を更新します。
     *
     * @param string $id 更新対象の商品ID
     * @param array $item 更新する商品情報
     * @return mixed 更新結果
     */
    public static function update_item($id, array $item)
    {
        return self::update_data($id, $item);
    }

    /**
     * 商品を削除します。
     *
     * @param string $id 削除する商品のID
     * @return mixed 削除結果
     */
    public static function delete_item($id)
    {
        return self::delete_data($id);
    }
}