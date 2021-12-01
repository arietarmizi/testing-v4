<?php


namespace common\models;

use common\base\ActiveRecord;

/**
 * Class Shop
 * @package common\models
 *
 * @property $id
 * @property $marketplaceId
 * @property $fsId
 * @property $userId
 * @property $shopName
 * @property $isOpen
 * @property $description
 * @property $status
 * @property $createdAt
 * @property $updatedAt
 */
class Shop extends ActiveRecord
{
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE   => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => \Yii::t('app', 'inactive'),
        ];
    }

    public static function tableName()
    {
        return '{{%shop}}';
    }

    public function getMarketplace()
    {
        return $this->hasOne(Shop::class, ['id' => 'marketplaceId']);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['uuid']);

        return $behaviors;
    }
}