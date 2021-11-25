<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class Customer
 * @package common\models
 * @property string $customerId
 * @property string $customerName
 * @property string $email
 * @property double $phoneNumber
 * @property string $address
 * @property string $createdAt
 * @property string $updatedAt
 */
class Customer extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%customer}}';
    }
}