<?php

namespace api\forms\tokopedia\product;

use api\components\BaseForm;
use common\models\Provider;
use GuzzleHttp\Exception\ClientException;

class GetAllProductsForm extends BaseForm
{
//    public  $fsId = '15394';
    public  $fsId;
    public  $page;
    public  $perPage;
    private $_response;

    public function rules()
    {
        return [
            [['page', 'perPage', 'fsId'], 'required'],
        ];
    }

    public function submit()
    {
        $provider                 = \Yii::$app->tokopediaProvider;
        $provider->_url           = 'v2/products/fs/' . $this->fsId . '/' . $this->page . '/' . $this->perPage . '';
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;

        $this->_response = $provider->send();
        return true;
    }

    public function response()
    {
        return $this->_response;
    }
}