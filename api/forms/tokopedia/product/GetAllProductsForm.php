<?php

namespace api\forms\tokopedia\product;

use api\components\BaseForm;
use common\models\Provider;
use GuzzleHttp\Exception\ClientException;

class GetAllProductsForm extends BaseForm
{
    public  $fsId     = '15394';
    public  $shop_id  = '11960781';
    public  $page     = 1;
    public  $per_page = 10;
    private $_response;

    public function rules()
    {
        return [];
    }

    public function submit()
    {
        $provider       = \Yii::$app->tokopediaProvider;
        $provider->_url = 'v2/products/fs/' . $this->fsId . '/' . $this->page . '/' . $this->per_page . '';
//        $provider->_url           = 'v2/products/fs/15394/2/10';
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;
//        $provider->_query         = [
//            'page'     => '2',
//            'per_page' => '10',
//        ];
        try {
            $this->_response = $provider->send();
        } catch (ClientException $e) {
            $this->_response = $e->getResponse();
//            var_dump($this->_response);
//            die();
            return false;
        }
        return true;
    }

    public function response()
    {
        return $this->_response;
    }
}