<?php

namespace api\forms\tokopedia\product;

use api\components\BaseForm;
use api\config\ApiCode;
use common\models\Marketplace;
use common\models\Product;
use common\models\Provider;
use common\models\Shop;
use GuzzleHttp\Exception\ClientException;
use yii\helpers\Json;

class GetAllProductsForm extends BaseForm
{
//    public  $fsId = '15394';
    public  $fsId;
    public  $page;
    public  $perPage;
    public  $id;
    public  $shopId;
    public  $categoryId;
    public  $code;
    public  $condition;
    public  $description;
    public  $minimumOrder;
    public  $status;
    public  $name;
    private $_response;

    public function rules()
    {
        return [
            [['page', 'perPage', 'fsId'], 'required'],
            [['id', 'fsId'], 'number'],
            ['name', 'string']
        ];
    }

    public function submit()
    {
        $provider                 = \Yii::$app->tokopediaProvider;
        $provider->_url           = 'v2/products/fs/' . $this->fsId . '/' . $this->page . '/' . $this->perPage . '';
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;

        $this->_response = $provider->send();

        $shop = Shop::find()
            ->where(['id' => $this->shopId])
            ->one();

        $remoteProducts = $this->_response['data'];
        foreach ($remoteProducts as $remoteProduct) {
            $product = Product::find()
                ->where(['id' => (string)$remoteProduct['product_id']])
                ->one();
            if (!$product) {
                $product = new Product();
            }
            $product->id                = $remoteProduct['product_id'];
            $product->name              = $remoteProduct['name'];
            $product->productCategoryId = $remoteProduct['category_id'];
            $product->description       = $remoteProduct['desc'];
            $product->status            = $remoteProduct['status'];
            $product->fsId              = $this->fsId;
            $product->save(false);
        }
        return true;
    }

    public function response()
    {
        return $this->_response;
    }

}