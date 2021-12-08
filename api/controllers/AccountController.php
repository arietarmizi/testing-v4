<?php


namespace api\controllers;


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

    public function actionProfile()
    {
        $user = User::find()
//            ->leftJoin(User::tableName(), User::tableName() . '.id = ' . Shop::tableName() . '.userId')
            ->where([User::tableName() . '.id' => \Yii::$app->user->id])
            ->joinWith(['shop'])
            ->one();

        $response          = new Response();
        $response->status  = 200;
        $response->name    = 'Get Product Category Data.';
        $response->code    = ApiCode::DEFAULT_SUCCESS_CODE;
        $response->message = \Yii::t('app', 'Get Product Category Data Success.');
        $response->data    = ArrayHelper::toArray($user, [
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
        ]);
        return $response;
    }

    protected function verbs()
    {
        return [
            'profile' => ['get'],
        ];
    }
}