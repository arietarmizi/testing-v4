<?php

namespace api\forms\productpromo;


use api\components\BaseForm;
use common\models\ProductPromo;

class StoreProductPromoForm extends BaseForm
{
    public $productVariantId;
    public $minQuantity;
    public $maxQuantity;
    public $defaultPrice;
    public $status;

    private $_query;

    public function rules()
    {
        return [
            [['productVariantId', 'minQuantity', 'defaultPrice'], 'required'],
            [['minQuantity', 'maxQuantity', 'defaultPrice'], 'double']
        ];
    }

    public function submit()
    {
        $query                   = new ProductPromo();
        $query->productVariantId = $this->productVariantId;
        $query->minQuantity      = $this->minQuantity;
        $query->maxQuantity      = $this->maxQuantity;
        $query->defaultPrice     = $this->defaultPrice;
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

        return ['productPromo' => $query];
    }
}