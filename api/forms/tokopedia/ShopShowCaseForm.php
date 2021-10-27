<?php

namespace api\forms\tokopedia;

use api\components\BaseForm;
use common\models\Provider;

class ShopShowCaseForm extends BaseForm
{

    public  $fsId = '15394';
    private $_response;

    public function rules()
    {
        return [
        ];
    }

    public function validateShop($attribute, $params)
    {
    }

    public function submit()
    {
        $provider                 = \Yii::$app->tokopediaProvider;
        $provider->_url           = 'v1/showcase/fs/' . $this->fsId . '/get';
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;
        $provider->_query         = [
            'shop_id' => '11960781'
        ];
        $this->_response          = $provider->send();
        return true;
    }

    public function response()
    {
        return $this->_response;
    }

}