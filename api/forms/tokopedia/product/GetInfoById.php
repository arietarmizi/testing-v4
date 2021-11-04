<?php


namespace api\forms\tokopedia\product;


use api\components\BaseForm;
use common\models\Provider;
use GuzzleHttp\Exception\ClientException;

class GetInfoById extends BaseForm
{
    private $_response;
    public $fsId     = '15394';
    public $productId = 2029029231;

    public function rules()
    {
    return [];
    }

    public function submit()
    {
        $provider = \Yii::$app->tokopediaProvider;
        $provider->_url = 'inventory/v1/fs/' . $this->fsId .'/product/info';
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;
        $provider->_query = [
            'product_id' => $this->productId,
        ];
        try {
            $this->_response = $provider->send();
        } catch (ClientException $e) {
            $this->_response->getResponse();
            return false;
        }
        return true;
    }

    public function response()
    {
        return $this->_response;
    }
}