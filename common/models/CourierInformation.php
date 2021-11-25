<?php


namespace common\models;


use common\base\ActiveRecord;

/**
 * Class CourierInformation
 * @package common\models
 * @property string $courierId
 * @property string $courierName
 */
class CourierInformation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%courier_information}}';
    }
}