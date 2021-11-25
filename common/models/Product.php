<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class Product
 * @package common\models
 *
 * @property string $id
 * @property string $marketplaceId
 * @property string $productId
 * @property string $shopId
 * @property string $productCategoryId
 * @property string $sku
 * @property string $code
 * @property string $name
 * @property string $condition
 * @property string $minOrder
 * @property string $defaultPrice
 * @property string $stock
 * @property string $productDescription
 * @property string $description
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class Product extends ActiveRecord
{
    const STATUS_ACTIVE       = 'Active';
    const STATUS_INACTIVE     = 'Inactive';
    const STATUS_OUT_OF_STOCK = 'out of stock';

    const CONDITION_NEW    = 'new';
    const CONDITION_SECOND = 'second';

    public static function tableName()
    {
        return '{{%product}}';
    }

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE       => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE     => \Yii::t('app', 'Inactive'),
            self::STATUS_OUT_OF_STOCK => \Yii::t('app', 'Out Of Stock')
        ];
    }

    public static function conditions()
    {
        return [
            self::CONDITION_NEW    => \Yii::t('app', 'New'),
            self::CONDITION_SECOND => \Yii::t('app', 'Second'),
        ];
    }

    public function getCategory()
    {
        return $this->hasMany(Product::class, ['categoryId' => 'id']);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['uuid']);
        return $behaviors;
    }

}