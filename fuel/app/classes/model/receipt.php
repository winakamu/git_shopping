<?php

class Model_Receipt extends Model
{
    /**
     * レシートを登録
     */
    public static function insert_receipt(array $receipt)
    {
        return Mongo_Db::instance()
            ->insert('receipt', $receipt);
    }

    /**
     * レシートを全件取得
     */
    public static function get_receipts()
    {
        return Mongo_Db::instance()
            ->get('receipt');
    }

    /**
     * レシートを1件取得
     */
    public static function get_receipt($id)
    {
        return Mongo_Db::instance()
            ->where(array(
                '_id' => new MongoId($id),
            ))
            ->get_one('receipt');
    }

    /**
     * レシートを削除
     */
    public static function delete_receipt($id)
    {
        return Mongo_Db::instance()
            ->where(array(
                '_id' => new MongoId($id),
            ))
            ->delete('receipt');
    }
}