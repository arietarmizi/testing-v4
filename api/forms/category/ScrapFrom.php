<?php

namespace api\forms\category;

use api\components\BaseForm;
use common\models\Product;
use common\models\ProductCategory;
use common\models\ProductSubCategory;
use common\models\Provider;
use yii\helpers\ArrayHelper;

class ScrapFrom extends BaseForm
{
    public $fsId;
    public $id;
    public $name;
    public $child;

    private $_response;

    public function rules()
    {
        return [
            [['fsId'], 'required'],
            [['id', 'fsId'], 'number'],
            ['name', 'string']
        ];
    }

    public function submit()
    {
        $provider                 = \Yii::$app->tokopediaProvider;
        $provider->_url           = 'inventory/v1/fs/' . $this->fsId . '/product/category';
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;

        $this->_response = $provider->send();

        $remoteCategories = $this->_response['data'];
        foreach ($remoteCategories['categories'] as $remoteCategory) {
//            $category = Category::find()
//                ->where(['id' => (string)$remoteCategory['id']])
//                ->one();
//            if (!$category) {
            $category = new ProductCategory();
//            }
            $category->id   = $remoteCategory['id'];
            $category->name = $remoteCategory['name'];
            $category->save(false);
//            var_dump($remoteCategory['child']);
//            die;

            if (!isset($remoteCategory['child']) || !is_array($remoteCategory['child'])) {
                continue;
            }

            foreach ($remoteCategory['child'] as $remoteCategoryChild) {
//                $categoryDetail = ProductCategoryDetail::find()
//                    ->where(['id' => (string)$remoteCategoryChild['id']])
//                    ->one();
//                if (!$remoteCategoryChild) {
                $categoryDetail = new ProductSubCategory();
//                }
                $categoryDetail->productCategoryId = $remoteCategory['id'];
                $categoryDetail->id                = $remoteCategoryChild['id'];
                $categoryDetail->name              = $remoteCategoryChild['name'];
                $categoryDetail->save(false);
            }
        }

        return true;
    }

    public function response()
    {
        return $this->_response;
    }
}

