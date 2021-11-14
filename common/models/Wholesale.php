<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class Wholesale
 * @package common\models
 *
 * @property string $id
 * @property string $productVariantId
 * @property double $minQuantity
 * @property double $maxQuantity
 * @property double $defaultPrice
 * @property string $idr
 * @property string $currencyId
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class Wholesale extends ActiveRecord
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
        return '{{%wholesale}}';
    }
}