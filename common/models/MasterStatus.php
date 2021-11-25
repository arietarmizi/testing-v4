<?php


namespace common\models;


use common\base\ActiveRecord;


/**
 * Class MasterStatus
 * @package common\models
 * @property string $marketplaceId
 * @property string $statusCode
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class MasterStatus extends ActiveRecord
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
        return '{{%master_status}}';
    }

}