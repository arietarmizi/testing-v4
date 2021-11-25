<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class OrderDetail
 * @package common\models
 * @property string  $id
 * @property string  $sku
 * @property double  $quantity
 * @property double  $weight
 * @property double  $totalWeight
 * @property boolean $isFreeReturn
 * @property double  $productPrice
 * @property double  $insurancePrice
 * @property double  $subtotalPrice
 * @property string  $createdAt
 * @property string  $updatedAt
 */
class OrderDetail extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%order_detail}}';
    }
}