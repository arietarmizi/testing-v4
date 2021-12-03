<?php

namespace api\forms\productdiscount;

use api\components\BaseForm;
use Carbon\Carbon;
use common\models\ProductDiscount;
use common\models\ProductPromo;

class StoreProductDiscountForm extends BaseForm
{
    public $productVariantId;
    public $discountPrice;
    public $discountPercentage;
    public $startTime;
    public $endTime;
    public $initialQuota;
    public $remainingQuota;
    public $maxOrder;
    public $slashPriceStatusId;
    public $useWarehouse;
    public $status;

    private $_query;

    public function rules()
    {
        return [
            [['productVariantId', 'startTime', 'endTime'], 'required'],
            [['productVariantId', 'slashPriceStatusId'], 'string'],
            [['discountPrice', 'discountPercentage', 'initialQuota', 'remainingQuota', 'maxOrder'], 'double'],
            ['useWarehouse', 'boolean'],
        ];
    }

    public function submit()
    {
        $query = new ProductDiscount();

        $query->productVariantId   = $this->productVariantId;
        $query->discountPrice      = $this->discountPrice;
        $query->discountPercentage = $this->discountPercentage;
        $query->startTime          = $this->startTime;
        $query->endTime            = $this->endTime;
        $query->initialQuota       = $this->initialQuota;
        $query->remainingQuota     = $this->remainingQuota;
        $query->maxOrder           = $this->maxOrder;
        $query->slashPriceStatusId = $this->slashPriceStatusId;
        $query->useWarehouse       = $this->useWarehouse;

        $query->save();
        $query->refresh();

        $this->_query = $query;
        return true;
    }

    public function response()
    {
        $query = $this->_query->toArray();

        unset($query['createdAt']);
        unset($query['updatedAt']);

        return ['productDiscount' => $query];
    }
}