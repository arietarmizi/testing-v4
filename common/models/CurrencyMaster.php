<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class CurrencyMaster
 * @package common\models
 *
 * @property string $id
 * @property string $name
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class CurrencyMaster extends ActiveRecord
{
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static function statuses()
    {
        return [
            self:: STATUS_ACTIVE  => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => \Yii::t('app', 'Inactive')
        ];
    }

    public static function tableName()
    {
        return '{{%currency_master}}';
    }
}