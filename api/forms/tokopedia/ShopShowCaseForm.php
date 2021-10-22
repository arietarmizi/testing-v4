<?php

namespace api\forms;

use api\components\BaseForm;

class ShopShowCaseForm extends BaseForm
{

    public $shopId;

    public $mode;

    public function rules()
    {
        return [
            [['shopId'], 'required'],
            [['page', 'page_count', 'hide_zero', 'display'], 'string'],
        ];
    }

    public function validateShop($attribute, $params)
    {
    }

    public function submit()
    {
        $provider             = \Yii::$app->pushSenderOverseas;
        $provider->sender     = $this->sender;
        $provider->recipients = $this->recipients;
        $provider->title      = $this->title;
        $provider->message    = $this->message;
        $provider->logs       = $this->logs;

        $providerResponses = $provider->send();
        return true;

    }

    public function response()
    {
        return $this->response;
    }

}