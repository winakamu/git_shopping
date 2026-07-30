<?php

class Model_Item extends Model
{
    /**
     * 商品を登録
     */
    public static function insert_item(array $item)
    {
        return Mongo_Db::instance()
            ->insert('item', $item);
    }

    /**
     * 商品を全件取得
     */
    public static function get_items()
    {
        return Mongo_Db::instance()
            ->get('item');
    }

    /**
     * 商品を1件取得
     */
    public static function get_item($id)
    {
        return Mongo_Db::instance()
            ->where(array(
                '_id' => new MongoId($id),
            ))
            ->get_one('item');
    }

    /**
     * 商品を更新
     */
    public static function update_item($id, array $item)
    {
        return Mongo_Db::instance()
            ->where(array(
                '_id' => new MongoId($id),
            ))
            ->update('item', $item);
    }

    /**
     * 商品を削除
     */
    public static function delete_item($id)
    {
        return Mongo_Db::instance()
            ->where(array(
                '_id' => new MongoId($id),
            ))
            ->delete('item');
    }
}