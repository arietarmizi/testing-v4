<?php

namespace api\forms\tokopedia;

use api\components\BaseForm;

class ShopShowCaseForm extends BaseForm
{

    public $shopId;
    public  $mode;
    private $_response;

    public function rules()
    {
        return [
            [['shopId'], 'required'],
//            [['page', 'page_count', 'hide_zero', 'display'], 'string'],
        ];
    }

    public function validateShop($attribute, $params)
    {
    }

    public function submit()
    {
        $provider          = \Yii::$app->tokopediaProvider;
        $providerResponses = $provider->send();
        return true;

    }

    public function response()
    {
        return $this->_response;
    }

}