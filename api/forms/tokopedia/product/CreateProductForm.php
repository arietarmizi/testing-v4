<?php


namespace api\forms\tokopedia\product;


use api\components\BaseForm;
use common\models\Product;

class CreateProductForm extends BaseForm
{
    public $id;
    public $fsId;
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

    /** @var Product */
    protected $_product;

    public function init()
    {
        parent::init();
    }

    public function rules()
    {
        return [
            [['id', 'fsId', 'name'], 'required'],
            [['name', 'description'], 'string'],
            [['id', 'fsId', 'productCategoryId'], 'number'],
            [['id'], 'validateProduct']
        ];
    }

    public function submit()
    {
        return $this->_createProduct();
    }

    protected function _createProduct()
    {
        $transaction                = \Yii::$app->db->beginTransaction();
        $product                    = new Product();
        $product->id                = $this->id;
        $product->fsId              = $this->fsId;
        $product->productCategoryId = $this->productCategoryId;
        $product->name              = $this->name;
        $product->description       = $this->description;
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