<?php


namespace api\forms\tokopedia\product;


use api\components\BaseForm;
use common\models\Provider;
use GuzzleHttp\Exception\ClientException;

class GetInfoByIdForm extends BaseForm
{
    public  $fsId;
    public  $productId;
    public  $sku;
    private $_response;

    public function rules()
    {
        return [
            [['fsId'], 'required'],
            ['productId', 'number'],
        ];
    }

    public function submit()
    {
        $provider                 = \Yii::$app->tokopediaProvider;
        $provider->_url           = 'inventory/v1/fs/' . $this->fsId . '/product/info';
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;
        $provider->_query         = [
            'product_id' => $this->productId,
//            'sku'        => $this->sku
        ];
        $this->_response          = $provider->send();
        return true;
    }

    public function response()
    {
        return $this->_response;
    }
}