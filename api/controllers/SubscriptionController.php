<?php


namespace api\controllers;


use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\subscription\StoreSubscriptionForm;

class SubscriptionController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'store',
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'store' => [
                'class'          => FormAction::class,
                'formClass'      => StoreSubscriptionForm::class,
                'messageSuccess' => \Yii::t('app', 'Store Subscription Success.'),
                'messageFailed'  => \Yii::t('app', 'Store Subscription Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
        ];
    }

    public function verbs()
    {
        return [
            'store' => ['post'],
        ];
    }
}