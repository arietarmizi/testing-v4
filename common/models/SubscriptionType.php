<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class SubscriptionType
 * @package common\models
 *
 * @property string  $id
 * @property string  $merchantId
 * @property boolean $isSupportMultiple
 * @property double  $maxOutlet
 * @property double  $duration
 * @property string  $durationType
 * @property string  $description
 * @property string  $status
 * @property string  $createdAt
 * @property string  $updatedAt
 */
class SubscriptionType extends ActiveRecord
{
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    const DURATION_YEAR  = 'year';
    const DURATION_MONTH = 'month';
    const DURATION_WEEK  = 'week';
    const DURATION_DAY   = 'day';

    public static function durations()
    {
        return [
            self::DURATION_YEAR  => \Yii::t('app', 'Year'),
            self::DURATION_MONTH => \Yii::t('app', 'Month'),
            self::DURATION_WEEK  => \Yii::t('app', 'Week'),
            self::DURATION_DAY   => \Yii::t('app', 'Day'),
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE   => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => \Yii::t('app', 'inactive'),
        ];
    }

    public static function tableName()
    {
        return '{{%subscription_type}}';
    }

}