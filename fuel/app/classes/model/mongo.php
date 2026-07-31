<?php

/**
 * MongoDBを操作する共通Model
 */
abstract class Model_Mongo extends Model
{
    /**
     * 各Modelで使用するコレクション名
     */
    protected static $collection = '';

    /**
     * データを登録
     */
    protected static function insert_data(array $data)
    {
        return Mongo_Db::instance()
            ->insert(static::$collection, $data);
    }

    /**
     * データを全件取得
     */
    protected static function get_all_data()
    {
        return Mongo_Db::instance()
            ->get(static::$collection);
    }

    /**
     * IDを指定してデータを1件取得
     */
    protected static function get_data($id)
    {
        return Mongo_Db::instance()
            ->where(array(
                '_id' => new MongoId($id),
            ))
            ->get_one(static::$collection);
    }

    /**
     * IDを指定してデータを更新
     */
    protected static function update_data($id, array $data)
    {
        return Mongo_Db::instance()
            ->where(array(
                '_id' => new MongoId($id),
            ))
            ->update(static::$collection, $data);
    }

    /**
     * IDを指定してデータを削除
     */
    protected static function delete_data($id)
    {
        return Mongo_Db::instance()
            ->where(array(
                '_id' => new MongoId($id),
            ))
            ->delete(static::$collection);
    }
}