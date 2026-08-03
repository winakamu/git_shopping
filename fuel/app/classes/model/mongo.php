<?php

/**
 * MongoDBを操作する共通Modelです。
 */
abstract class Model_Mongo extends Model
{
    /**
     * 各Modelで使用するコレクション名
     */
    protected static $collection = '';

    /**
     * データを登録します。
     *
     * @param array $data 登録するデータ
     * @return string 登録したデータのMongoDB ID
     */
    protected static function insert_data(array $data)
    {
        return Mongo_Db::instance()
            ->insert(static::$collection, $data);
    }

    /**
     * データを全件取得します。
     *
     * @return array データ一覧
     */
    protected static function get_all_data()
    {
        return Mongo_Db::instance()
            ->get(static::$collection);
    }

    /**
     * IDを指定してデータを1件取得します。
     *
     * @param string $id 取得するデータのID
     * @return array データ情報
     */
    protected static function get_data($id)
    {
        return Mongo_Db::instance()
            ->where([
                '_id' => new MongoId($id),
            ])
            ->get_one(static::$collection);
    }

    /**
     * IDを指定してデータを更新します。
     *
     * @param string $id 更新対象のデータID
     * @param array $data 更新するデータ
     * @return mixed 更新結果
     */
    protected static function update_data($id, array $data)
    {
        return Mongo_Db::instance()
            ->where([
                '_id' => new MongoId($id),
            ])
            ->update(static::$collection, $data);
    }

    /**
     * IDを指定してデータを削除します。
     *
     * @param string $id 削除対象のデータID
     * @return mixed 削除結果
     */
    protected static function delete_data($id)
    {
        return Mongo_Db::instance()
            ->where([
                '_id' => new MongoId($id),
            ])
            ->delete(static::$collection);
    }
}