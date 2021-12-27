<?php


namespace common\models;


use common\base\ActiveRecord;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

/**
 * Class Product
 * @package common\models
 *
 * @property string  $id
 * @property string  $marketplaceProductId
 * @property string  $marketplaceId
 * @property string  $productId
 * @property string  $shopId
 * @property string  $productCategoryId
 * @property string  $sku
 * @property string  $code
 * @property string  $name
 * @property string  $condition
 * @property string  $minOrder
 * @property string  $defaultPrice
 * @property string  $stock
 * @property string  $productDescription
 * @property string  $description
 * @property boolean $isMaster
 * @property string  $status
 * @property string  $createdAt
 * @property string  $updatedAt
 *
 * @property ProductVariant[] $productVariants
 * @property ProductImages $productImages
 * @property Category $productCategory
 * @property double $minPrice
 * @property double $maxPrice
 */
class Product extends ActiveRecord
{
    const STATUS_ACTIVE       = 'Active';
    const STATUS_INACTIVE     = 'Inactive';
    const STATUS_OUT_OF_STOCK = 'out of stock';
    const STATUS_DELETED      = 'deleted';

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
            self::STATUS_OUT_OF_STOCK => \Yii::t('app', 'Out Of Stock'),
            self::STATUS_DELETED      => \Yii::t('app', 'Deleted')
        ];
    }

    public static function conditions()
    {
        return [
            self::CONDITION_NEW    => \Yii::t('app', 'New'),
            self::CONDITION_SECOND => \Yii::t('app', 'Second'),
        ];
    }

    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::class, ['id' => 'productCategoryId']);
    }

    public function getShop()
    {
        return $this->hasOne(Shop::class, ['marketplaceShopId' => 'shopId']);
    }

    public function getProductImages()
    {
			return ProductImages::find()
				->joinWith('productVariant')
				->where([ProductVariant::tableName().'.productId' => $this->id]);
    }

    public  function getProductVariants()
		{
			return $this->hasMany(ProductVariant::class, ['productId' => 'id']);
		}

		public function getMinPrice()
		{
			return ProductVariant::find()
				->where([ProductVariant::tableName() . '.productId' => $this->id])
				->min(ProductVariant::tableName() . '.defaultPrice');
		}

		public function getMaxPrice()
		{
			return ProductVariant::find()
				->where([ProductVariant::tableName() . '.productId' => $this->id])
				->max(ProductVariant::tableName() . '.defaultPrice');
		}
}