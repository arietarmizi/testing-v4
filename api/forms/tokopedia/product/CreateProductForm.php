<?php


namespace api\forms\tokopedia\product;


use api\components\BaseForm;

class CreateProductForm extends BaseForm
{
    public $id;
    public $merchantId;
    public $productCategoryId;
    public $sku;
    public $code;
    public $name;
    public $condition;
    public $minOrder;
    public $defaultPrice;
    public $productDescription;
    public $description;
    public $status;

    public function rules()
    {
        [
            ['name']
        ];
    }

    public function submit()
    {
    }

    public function response()
    {

    }
}