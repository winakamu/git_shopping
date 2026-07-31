<?php

class Model_Item extends Model_Mongo
{
    /**
     * 使用するコレクション名
     */
    protected static $collection = 'item';

    /**
     * 商品を登録
     */
    public static function insert_item(array $item)
    {
        return self::insert_data($item);
    }

    /**
     * 商品を全件取得
     */
    public static function get_items()
    {
        return self::get_all_data();
    }

    /**
     * 商品を1件取得
     */
    public static function get_item($id)
    {
        return self::get_data($id);
    }

    /**
     * 商品を更新
     */
    public static function update_item($id, array $item)
    {
        return self::update_data($id, $item);
    }

    /**
     * 商品を削除
     */
    public static function delete_item($id)
    {
        return self::delete_data($id);
    }
}