<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class Warehouse
 * @package common\models
 *
 * @property string $id
 * @property string $shopId
 * @property string $name
 * @property string $address
 * @property string $type
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $description
 * @property string $subDistrictId
 * @property string $email
 * @property float  $phoneNumber
 * @property string $whType
 * @property string $isDefault
 * @property string $latLon
 * @property string $latitude
 * @property string $longitude
 * @property string $branchShopSubscription
 * @property string $status
 */
class Warehouse extends ActiveRecord
{
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETED  = 'deleted';

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

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }
}