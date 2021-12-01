<?php


namespace api\forms\subscription;


use api\components\BaseForm;
use common\models\Subscription;

class StoreSubscriptionForm extends BaseForm
{
    public $userId;
    public $subscriptionTypeId;
    public $registerAt;
    public $expiredAt;
    public $usedQuota;
    public $remainingQuota;
    public $status;

    public function init()
    {
        parent::init();
    }

    public function rules()
    {
        return [
//            [['subscriptionTypeId'], 'required'],
//            [['subscriptionTypeId', 'userId'], 'string'],
//            [['usedQuota', 'remainingQuota'], 'double'],
//            [['registerAt', 'expiredAt'], 'date'],
        ];
    }

    public function submit()
    {
//        $transaction = \Yii::$app->db->beginTransaction();
//
//        $subscription                     = new Subscription();
//        $subscription->subscriptionTypeId = $this->subscriptionTypeId;
//        $subscription->userId             = $this->userId;
//        $subscription->registerAt         = $this->registerAt;
//        $subscription->expiredAt          = $this->expiredAt;
        var_dump(\Yii::$app->user->id);
        die();
    }

    public function response()
    {

    }
}