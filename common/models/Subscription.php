<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class Subscription
 * @package common\models
 * @property string  $id
 * @property string  $userId
 * @property string  $subscriptionTypeId
 * @property boolean $isSupportMultiple
 * @property string  $subscriptionDate
 * @property double  $remainingQuota
 * @property string  $expiredAt
 * @property string  $priority
 * @property string  $status
 * @property string  $createdAt
 * @property string  $updatedAt
 */
class Subscription extends ActiveRecord
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
        return '{{%subscription}}';
    }
}