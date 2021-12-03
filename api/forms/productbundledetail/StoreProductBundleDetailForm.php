<?php

namespace api\forms\productbundledetail;

use api\components\BaseForm;
use common\models\ProductBundleDetail;

class StoreProductBundleDetailForm extends BaseForm
{
    public $productBundleId;
    public $productVariantId;
    public $quantity;

    private $_query;

    public function rules()
    {
        return [
            [['productBundleId', 'productVariantId', 'quantity'], 'required'],
            ['quantity', 'double'],
        ];
    }

    public function validateProductVariant($attribute, $params)
    {
        $query = ProductBundleDetail::find()
            ->where(['productVariantId' => $this->productVariantId])
            ->one();
        if (!$query) {
            $this->addError($attribute, \Yii::t('app', '{attribute} "{value}" is inactive.', [
                'attribute' => $attribute,
                'value'     => $this->productVariantId
            ]));
        }
    }

    public function submit()
    {
        $query = new ProductBundleDetail();

        $query->productBundleId  = $this->productBundleId;
        $query->productVariantId = $this->productVariantId;
        $query->quantity         = $this->quantity;
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

        return ['productBundleDetail' => $query];
    }
}