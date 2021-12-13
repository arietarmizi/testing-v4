<?php


namespace api\forms\product;


use api\components\BaseForm;
use api\components\HttpException;
use common\models\Product;

class UpdateProductForm extends BaseForm
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

    public function rules()
    {
        return [
            [['shopId', 'name'], 'required'],
            [['name', 'description', 'condition', 'productDescription'], 'string'],
            [['id', 'shopId', 'productSubCategoryId', 'minOrder', 'isMaster'], 'number'],
            ['id', 'validateProduct']
        ];
    }

    public function submit()
    {
        $findId = \Yii::$app->request->get('id');

        $query = Product::find()
            ->where(['id' => $findId])
            ->one();
        if (!$query) {
            throw new HttpException(400, \Yii::t('app', 'Product ID Not Found.'));
        }

        $product->shopId               = $this->shopId;
        $product->productSubCategoryId = $this->productSubCategoryId;
        $product->name                 = $this->name;
        $product->condition            = $this->condition;
        $product->minOrder             = $this->minOrder;
        $product->productDescription   = $this->productDescription;
        $product->description          = $this->description;
        $product->isMaster             = $this->isMaster;

        $success = true;

        if ($query->save())
            if ($query->hasErrors()) {
                $this->addError($query->errors);
                throw new HttpException(400, \Yii::t('app', 'Update Product Failed.'));
            } else {
                $success &= $query->save();
            }
        return $success;
    }

    public function response()
    {
        return [];
    }

}