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
 * @property string $shipmentId
 * @property string $shipmentServiceId
 * @property string $warehouseId
 * @property string $promoId
 * @property string $discountId
 * @property string $orderStatus
 * @property string $createdAt
 * @property string $updatedAt
 */
class Order extends ActiveRecord
{
    const ORDER_STATUS_PACKING   = 'packing';
    const ORDER_STATUS_SUCCESS   = 'success';
    const ORDER_STATUS_PENDING   = 'pending';
    const ORDER_STATUS_CANCELLED = 'cancelled';
    const ORDER_STATUS_FAILED    = 'failed';

    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETED  = 'deleted';

    public static function orderStatuses()
    {
        return [
            self::ORDER_STATUS_PACKING   => \Yii::t('app', 'Packing'),
            self::ORDER_STATUS_SUCCESS   => \Yii::t('app', 'Success'),
            self::ORDER_STATUS_PENDING   => \Yii::t('app', 'Pending'),
            self::ORDER_STATUS_CANCELLED => \Yii::t('app', 'Cancelled'),
            self::ORDER_STATUS_FAILED    => \Yii::t('app', 'Failed')
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE   => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => \Yii::t('app', 'Inactive'),
        ];
    }

    public static function tableName()
    {
        return '{{%order}}';
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['customerId' => 'id']);
    }

    public function getShipment()
    {
        return $this->hasOne(Shipment::class, ['shipmentId' => 'id']);
    }

    public function getShipmentService()
    {
        return $this->hasOne(ShipmentService::class, ['shipmentServiceId' => 'id']);
    }

    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'warehouseId']);
    }

    public function getPromo()
    {
        return $this->hasOne(ProductPromo::class, ['id' => 'promoId']);
    }

    public function getDiscount()
    {
        return $this->hasOne(ProductDiscount::class, ['id' => 'discountId']);
    }


}