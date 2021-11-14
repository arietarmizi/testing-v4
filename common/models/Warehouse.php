<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class Warehouse
 * @package common\models
 *
 * @property string $id
 * @property string $districtId
 * @property string $name
 * @property string $address
 * @property string $type
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class Warehouse extends ActiveRecord
{
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    const WAREHOUSE = 'warehouse';
    const STORE     = 'store';

    public static function warehouseTypes()
    {
        return [
            self::WAREHOUSE => \Yii::t('app', 'Warehouse'),
            self::STORE     => \Yii::t('app', 'Store'),
        ];
    }

    public static function statuses()
    {
        return [
            self:: STATUS_ACTIVE  => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => \Yii::t('app', 'Inactive')
        ];
    }

    public static function tableName()
    {
        return '{{%warehouse}}';
    }
}