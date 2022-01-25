<?php

class Good extends Model {
    protected static $table = 'goods';

    protected static function setProperties()
    {
        self::$properties['id'] = [
            'type' => 'int'
        ];

        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['price'] = [
            'type' => 'float'
        ];

        self::$properties['description'] = [
            'type' => 'text'
        ];

        self::$properties['category'] = [
            'type' => 'int'
        ];
    }

    public static function getGoods($categoryId=0)
    {
        return db::getInstance()->Select(
            "SELECT catalog.id as goodId, catalog.title as goodTitle, price, images.id as imageId, images.title as imageTitle FROM catalog LEFT JOIN images on images.good_id = catalog.id"
        );
    }

    public function getGoodInfo(){
        $sql = "SELECT catalog.id as goodId, catalog.title as goodTitle, description, price, images.title AS imageTitle, images.id as imageId FROM `catalog` LEFT JOIN images ON images.good_id = catalog.id WHERE catalog.id = :id";
        return db::getInstance()->Select($sql, ['id' => (int)$this->id])[0];
    }
}