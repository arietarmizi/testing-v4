<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class Merchant
 * @package common\models
 * @property string $id
 * @property string $userId
 * @property string $subscriptionTypeId
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $status
 * @property string $registerStatus
 * @property string $registerAt
 * @property string $expiredAt
 * @property string $createdAt
 * @property string $updatedAt
 */
class Merchant extends ActiveRecord
{
    const STATUS_ACTIVE    = 'active';
    const STATUS_INACTIVE  = 'inactive';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_BLOCKED   = 'blocked';

    const REGISTER_NEW     = 'new';
    const REGISTER_RENEWAL = 'renewal';

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE    => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE  => \Yii::t('app', 'inactive'),
            self::STATUS_SUSPENDED => \Yii::t('app', 'Suspended'),
            self::STATUS_BLOCKED   => \Yii::t('app', 'Blocked'),
        ];
    }

    public static function registers()
    {
        return [
            self::REGISTER_NEW     => \Yii::t('app', 'New'),
            self::REGISTER_RENEWAL => \Yii::t('app', 'Renewal'),
        ];
    }

    public static function tableName()
    {
        return '{{%merchant}}';
    }

}