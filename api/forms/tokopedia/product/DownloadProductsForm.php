<?php

namespace api\forms\tokopedia\product;

use api\components\BaseForm;
use api\config\ApiCode;
use common\models\Marketplace;
use common\models\Product;
use common\models\ProductVariant;
use common\models\Provider;
use common\models\Shop;
use GuzzleHttp\Exception\ClientException;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class DownloadProductsForm extends BaseForm
{
//    public  $fsId = '15394';
	public  $fsId;
	public  $page;
	public  $perPage;
	public  $id;
	public  $shopId;
	public  $categoryId;
	public  $code;
	public  $condition;
	public  $description;
	public  $minimumOrder;
	public  $status;
	public  $name;

	private $_response;

	/** @var Product */
	private $_product;

	/** @var ProductVariant */
	private $_productVariant;

	public function init()
	{
		parent::init();
	}

	public function rules()
	{
		return [
			[['fsId','shopId'], 'required'],
			[['shopId', 'fsId'], 'number'],
		];
	}

	public function submit()
	{

		$provider                 = \Yii::$app->tokopediaProvider;
		$provider->_url           = 'inventory/v1/fs/'.$this->fsId.'/product/info?shop_id='.$this->shopId.'&page=1&per_page=50';
//		$provider->_url           = 'inventory/v1/fs/'.$this->fsId.'/product/info?product_id=2597248264';
		$provider->_requestMethod = Provider::REQUEST_METHOD_GET;

		$this->_response = $provider->send();

		$shop = Shop::find()
			->where(['marketPlaceShopId' => $this->shopId])
			->one();

		$remoteProducts = $this->_response['data'];

		foreach ($remoteProducts as $remoteProduct) {

//			echo "<pre>";
//			print_r($remoteProduct);
//			echo "</pre>";
//			die();

			$this->_product = Product::find()
				->where(['marketplaceProductId' => (string)$remoteProduct['basic']['productID']])
				->one();

			$db          = \Yii::$app->db;
			$transaction = $db->beginTransaction();
			$success     = true;

			try {
				if (!$this->_product) {
					$this->_product = new Product();
				}

				$this->_product->shopId 								= $shop['id'];
				$this->_product->marketplaceProductId		= $remoteProduct['basic']['productID'];
				$this->_product->productCategoryId 			= $remoteProduct['basic']['childCategoryID'];
				$this->_product->name										= $remoteProduct['basic']['name'];
				$this->_product->condition							= ($remoteProduct['basic']['condition'] == 1) ? 'new' : 'second';
				$this->_product->minOrder								= $remoteProduct['extraAttribute']['minOrder'];
				$this->_product->description						= isset($remoteProduct['basic']['shortDesc']) ? $remoteProduct['basic']['shortDesc'] : null ;
				$this->_product->isMaster								= 1;
				$this->_product->status									= ($remoteProduct['basic']['status'] == 1) ? 'active' : 'inactive';

				$success &= $this->_product->save() && $this->_product->refresh();

				$this->_productVariant = ProductVariant::find()
					->where(['name' => $this->_product->name])
					->one();

				if(!$this->_productVariant){
					$this->_productVariant = new ProductVariant();
				}

				$this->_productVariant->sku 						= isset($remoteProduct['other']['sku']) ? $remoteProduct['other']['sku'] : null ;
				$this->_productVariant->productId 			= $this->_product->id;
				$this->_productVariant->name 						= $this->_product->name;
				$this->_productVariant->minOrder				= $this->_product->minOrder;
				$this->_productVariant->description			= $this->_product->description;
				$this->_productVariant->defaultPrice		= $remoteProduct['price']['value'];

				if($remoteProduct['volume']){
					$this->_productVariant->length					= $remoteProduct['volume']['length'];
					$this->_productVariant->width						= $remoteProduct['volume']['width'];
					$this->_productVariant->height					= $remoteProduct['volume']['height'];
				}

				$this->_productVariant->weight					= $remoteProduct['weight']['value'];
				$this->_productVariant->isPreOrder			= isset($remoteProduct['preorder']) ? 1 : 0;
				$this->_productVariant->warehouseId			= $remoteProduct['warehouses'][0]['warehouseID'];
				$this->_productVariant->isWholesale			= isset($remoteProduct['wholesale']) ? 1 : 0;
				$this->_productVariant->isMustInsurance	= $remoteProduct['basic']['mustInsurance'];

				$success &= $this->_productVariant->save() && $this->_productVariant->refresh();

				if (isset($remoteProduct['variant']['childrenID']) && is_array($remoteProduct['variant'])) {
					foreach ($remoteProduct['variant']['childrenID'] as $productId){
						$variant = $this->getVariant($productId);

//						echo "<pre>";
//						print_r($variant);
//						echo "<pre>";
						if($variant){
							$this->setVariant($variant[0]);
						}

						$success &= $this->_productVariant->save() && $this->_productVariant->refresh();
					}
				}

				$success ? $transaction->commit() : $transaction->rollBack();

			} catch (\Exception $e){
				$transaction->rollBack();
				return false;
			}
		}
		return $success;
	}

	public function getVariant($product_id){
		$provider                 = \Yii::$app->tokopediaProvider;
//		$provider->_url           = 'inventory/v1/fs/'.$this->fsId.'/product/info?shop_id='.$this->shopId.'&page=1&per_page=50';
		$provider->_url           = 'inventory/v1/fs/'.$this->fsId.'/product/info?product_id='.$product_id;
		$provider->_requestMethod = Provider::REQUEST_METHOD_GET;

		$response = $provider->send();

		return $response['data'];
	}

	public function setVariant($arrVariant){
		$this->_productVariant = ProductVariant::find()
			->where(['name' => $arrVariant['basic']['name']])
			->one();

		if(!$this->_productVariant){
			$this->_productVariant = new ProductVariant();
		}

		$this->_productVariant->sku 						= isset($arrVariant['other']['sku']) ? $arrVariant['other']['sku'] : null ;
		$this->_productVariant->productId 			= $this->_product->id;
		$this->_productVariant->name 						= $arrVariant['basic']['name'];
		$this->_productVariant->minOrder				= $arrVariant['extraAttribute']['minOrder'];
		$this->_productVariant->description			=	isset($arrVariant['basic']['shortDesc']) ? $arrVariant['basic']['shortDesc'] : null ;
		$this->_productVariant->defaultPrice		= $arrVariant['price']['value'];

		if($arrVariant['volume']){
			$this->_productVariant->length					= $arrVariant['volume']['length'];
			$this->_productVariant->width						= $arrVariant['volume']['width'];
			$this->_productVariant->height					= $arrVariant['volume']['height'];
		}

		$this->_productVariant->weight					= $arrVariant['weight']['value'];
		$this->_productVariant->isPreOrder			= isset($arrVariant['preorder']) ? 1 : 0;
		$this->_productVariant->warehouseId			= $arrVariant['warehouses'][0]['warehouseID'];
		$this->_productVariant->isWholesale			= isset($arrVariant['wholesale']) ? 1 : 0;
		$this->_productVariant->isMustInsurance	= $arrVariant['basic']['mustInsurance'];
	}

	public function response()
	{
		return $this->_response;
	}

}