<?php

/**
 * MongoDBの共通処理を行うModelです。
 *
 * 【機能】
 * ・データ登録
 * ・データ全件取得
 * ・データ1件取得
 * ・データ更新
 * ・データ削除
 */
abstract class Model_Mongo extends Model
{
    /**
     * 各Modelで使用するコレクション名
     *
     * @var string
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
     * 並び順が指定された場合は、指定した順序でデータを取得します。
     *
     * @param array $order 並び順
     * @return array データ一覧
     */
    protected static function get_all_data(array $order = [])
    {
        $query = Mongo_Db::instance();

        if (!empty($order)) {
            $query->order_by($order);
        }

        return $query->get(static::$collection);
    }

    /**
     * IDを指定してデータを1件取得します。
     *
     * @param string $id 取得するデータのID
     * @return array|null データ情報
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