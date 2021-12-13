<?php

namespace api\controllers;

use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\components\Response;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\shop\StoreShopForm;
use api\forms\tokopedia\ShopShowCaseForm;
use common\models\Shop;
use common\models\User;
use yii\helpers\ArrayHelper;

class ShopController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'store'
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'store' => [
                'class'          => FormAction::className(),
                'formClass'      => StoreShopForm::className(),
                'messageSuccess' => \Yii::t('app', 'Store Shop Success.'),
                'messageFailed'  => \Yii::t('app', 'Store Shop Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'list' => [
                'class' => ListAction::class,
                'query' => function() {
                    return Shop::find()
                        ->joinWith(['marketplace', 'user']);
                },
                'toArrayProperties' => [
                    Shop::class => [
                        'id',
                        'fsId',
                        'marketplaceShopId',
                        'marketplace' => function ($model) {
                            /** @var Shop $model */
                            return [
                                'id'   => $model->marketplace->id,
                                'code' => $model->marketplace->code,
                                'name' => $model->marketplace->marketplaceName,
                            ];
                        },
                        'user'        => function ($model) {
                            /** @var User $model */
                            return [
                                'id'          => $model->user->id,
                                'name'        => $model->user->name,
                                'phoneNumber' => $model->user->phoneNumber,
                                'email'       => $model->user->email,
                                'birthDate'   => $model->user->birthDate,
                                'address'     => $model->user->address,
                                'status'      => $model->user->status,
                            ];
                        },
                        'shopName',
                        'shopLogo',
                        'shopUrl',
                        'description',
                        'domain',
                        'isOpen',
                        'status'
                    ]
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get product variant list success'),
            ]
        ];
    }


    protected function verbs()
    {
        return [
            'store' => ['post'],
        ];
    }
}
