<?php

namespace api\forms\shop;

use api\components\BaseForm;
use common\models\Shop;

class StoreShopForm extends BaseForm
{
    public $marketplaceShopId;
    public $marketplaceId;
    public $fsId;
    public $userId;
    public $shopName;
    public $description;
    public $isOpen;

    private $_shop;

    public function rules()
    {
        return [
            [['marketplaceShopId', 'fsId', 'marketplaceId', 'shopName'], 'required'],
            [['fsId', 'userId', 'shopName', 'description'], 'string']
        ];
    }

    public function submit()
    {
        $user = \Yii::$app->user->identity;

        $shop                    = new Shop();
        $shop->marketplaceShopId = $this->marketplaceShopId;
        $shop->marketplaceId     = $this->marketplaceId;
        $shop->fsId              = $this->fsId;
        $shop->userId            = $user->id;
        $shop->shopName          = $this->shopName;
        $shop->description       = $this->description;
        $shop->isOpen            = true;

        $shop->save();
        $shop->refresh();

        $this->_shop = $shop;
        return true;
    }

    public function response()
    {
        $query = $this->_shop->toArray();

        unset($query['createdAt']);
        unset($query['updatedAt']);

        return ['marketplace' => $query];
    }
}