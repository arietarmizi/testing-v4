<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\Response;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use common\models\Shop;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AccountController extends Controller
{
    public function behaviors()
    {
        $behaviors                        = parent::behaviors();
        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'profile',
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'profile' => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return User::find()
                        ->where([User::tableName() . '.id' => \Yii::$app->user->id])
                        ->joinWith(['shop']);
                },
                'toArrayProperties' => [
                    User::class => [
                        'id',
                        'name',
                        'status',
                        'shop' => function ($model) {
                            /** @var User $model */
                            return [
                                $model->getShop()->all(),
//                        'name' => $model->shop->shopName,
                            ];
                        },
                    ]
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get user profile success'),
            ]
        ];
    }

    protected function verbs()
    {
        return [
            'profile' => ['get'],
        ];
    }
}