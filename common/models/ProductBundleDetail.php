<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class ProductBundleDetail
 * @package common\models
 *
 * @property string $id
 * @property string $sku
 * @property string $productVariantId
 * @property double $defaultPrice
 * @property double $quantity
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class ProductBundleDetail extends ActiveRecord
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
        return '{{%product_bundle_detail}}';
    }

}