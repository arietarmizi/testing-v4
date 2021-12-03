<?php


namespace api\forms\product;


use api\components\BaseForm;
use common\models\Product;

class CreateProductForm extends BaseForm
{
    public $id;
    public $shopId;
    public $productSubCategoryId;
    public $code;
    public $name;
    public $condition;
    public $minOrder;
    public $productDescription;
    public $isMaster;
    public $description;
    public $status;

    /** @var Product */
    protected $_product;

    public function init()
    {
        parent::init();
    }

    public function rules()
    {
        return [
            [['id', 'shopId', 'name'], 'required'],
            [['name', 'description', 'condition', 'productDescription'], 'string'],
            [['id', 'shopId', 'productSubCategoryId', 'minOrder', 'isMaster'], 'number'],
            ['id', 'validateProduct']
        ];
    }

    public function submit()
    {
        return $this->_createProduct();
    }

    protected function _createProduct()
    {
        $transaction                   = \Yii::$app->db->beginTransaction();
        $product                       = new Product();
        $product->id                   = $this->id;
        $product->shopId               = $this->shopId;
        $product->productSubCategoryId = $this->productSubCategoryId;
        $product->name                 = $this->name;
        $product->condition            = $this->condition;
        $product->minOrder             = $this->minOrder;
        $product->productDescription   = $this->productDescription;
        $product->description          = $this->description;
        $product->isMaster             = true;
        $product->save();
        if ($product->save()) {
            $product->refresh();
            $this->_product = $product;
            $transaction->commit();
            return true;
        } else {
            $this->addErrors($this->getErrors());
            $transaction->rollBack();
            return false;
        }
    }

    public function validateProduct($attribute, $params, $validator)
    {
        $product = Product::find()
            ->where(['id' => $this->id])
            ->one();
        if ($product) {
            $this->addError($attribute, 'id' . $this->id . 'has been created.');
        }
    }

    public function response()
    {
        $response = $this->_product->toArray();

        unset($response['createdAt']);
        unset($response['updatedAt']);
        unset($response['code']);
        unset($response['minOrder']);
        unset($response['productDescription']);

        return ['product' => $response];
    }
}