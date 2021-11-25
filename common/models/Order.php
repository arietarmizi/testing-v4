<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class Order
 * @package common\models
 * @property string $orderId
 * @property string $orderDate
 * @property string $shopId
 * @property string $refInv
 * @property string $customerId
 * @property string $courierId
 * @property string $warehouseId
 * @property string $promoId
 * @property string $discountId
 * @property string $orderStatus
 * @property string $createdAt
 * @property string $updatedAt
 */
class Order extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%order}}';
    }
}