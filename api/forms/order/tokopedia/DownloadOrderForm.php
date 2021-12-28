<?php


namespace api\forms\order\tokopedia;


use api\components\BaseForm;
use api\components\HttpException;
use Carbon\Carbon;
use common\models\Customer;
use common\models\Order;
use common\models\Provider;
use common\models\Shipment;
use common\models\ShipmentService;
use common\models\Shop;

class DownloadOrderForm extends BaseForm {
    public $fsId;
    public $fromDate;
    public $toDate;
    public $shopId;
    public $warehouseId;
    public $orderStatus;

    private $_response;
    private $_page = 1;
    private $_perPage = 10;

    /** @var Order */
    private $_order;

    /** @var Customer */
    private $_customer;

    /** @var Shipment */
    private $_shipment;

    /** @var ShipmentService */
    private $_shipmentService;

    public function rules() {
        return [
            [['fsId', 'shopId'], 'required'],
            [['shopId', 'fsId'], 'number'],
            ['shopId', 'validateShop']
        ];
    }

    public function validateShop($attributes, $param = []) {
        $this->_shop = Shop::find()
            ->where([
                'marketplaceShopId' => $this->shopId,
                'fsId'              => $this->fsId
            ])->one();

        if (!$this->_shop) {
            $this->addError($attributes, \Yii::t('app', '{shopId} is not registered', ['shopId' => $this->shopId]));
        }
    }

    public function init() {
        parent::init();
    }

    public function getAllOrders($page, $perPage) {
        /** @var Provider $provider */
        $provider                 = \Yii::$app->tokopediaProvider;
        $provider->_url           = 'v2/order/list';
        $provider->_query         = [
            'fs_id'     => $this->fsId,
            'from_date' => $this->fromDate,
            'to_date'   => $this->toDate,
            'page'      => $page,
            'per-page'  => $perPage,
            'shop_id'   => $this->shopId
        ];
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;
        $response                 = $provider->send();
        return $response['data'];
    }

    public function getSingleOrder($order_id) {
        /** @var Provider $provider */
        $provider                 = \Yii::$app->tokopediaProvider;
        $provider->_url           = 'v2/fs/' . $this->fsId . '/order';
        $provider->_query         = [
            'order_id' => $order_id
        ];
        $provider->_requestMethod = Provider::REQUEST_METHOD_GET;
        $response                 = $provider->send();
        return $response['data'];
    }

    public function getCustomer($remoteBuyerInfo = []) {
        $customer = Customer::find()
            ->where(['marketplaceCustomerId' => $remoteBuyerInfo['buyer_id']])
            ->one();

        if (!$customer) {
            $customer = new Customer();
        }
        $customer->marketplaceCustomerId = $remoteBuyerInfo['buyer_id'];
        $customer->customerName          = $remoteBuyerInfo['buyer_fullname'];
        $customer->email                 = $remoteBuyerInfo['buyer_email'];
        $customer->phoneNumber           = $remoteBuyerInfo['buyer_phone'];
        $customer->save() && $customer->refresh();

        return $customer;
    }

    public function getShipment($marketplaceShipmentId) {
        $shipment = Shipment::find()
            ->where([
                'shopId'                => $this->shopId,
                'marketplaceShipmentId' => $marketplaceShipmentId
            ])->one();

        if (!$shipment) {
            $this->addError('shipmentId', \Yii::t('app', 'Shipment not found, you need to sync the shipment first.'));
            return false;
        }

        return $shipment;
    }

    public function getShipmentService($shipmentId, $marketplaceShipmentServiceId) {
        $shipmentService = ShipmentService::find()
            ->where([
                'shipmentId'                   => $shipmentId,
                'marketplaceShipmentServiceId' => $marketplaceShipmentServiceId
            ])->one();

        if (!$shipmentService) {
            $this->addError('shipmentServiceId',
                \Yii::t('app', 'Shipment service not found, you need to sync the shipment first.'));
            return false;
        }

        return $shipmentService;
    }

    public function submit() {
        $transaction = \Yii::$app->db->beginTransaction();
        $success     = true;

        try {
            $remoteOrders = $this->getAllOrders($this->_page, $this->_perPage);
            if ($remoteOrders) {
                foreach ($remoteOrders as $remoteOrder) {
                    $remoteSingleOrder      = $this->getSingleOrder($remoteOrder['order_id']);
                    $this->_customer        = $this->getCustomer($remoteSingleOrder['buyer_info']);
                    $this->_shipment        = $this->getShipment($remoteSingleOrder['shipping_info']['shipping_id']);
                    $this->_shipmentService = $this->getShipmentService(
                        $this->_shipment->id, $remoteSingleOrder['shipping_info']['sp_id']
                    );

                    $this->_order = Order::find()
                        ->where(['refInv' => $remoteOrder['invoice_ref_num']])
                        ->one();

                    if (!$this->_order) {
                        $this->_order = new Order();
                    }

                    $this->_order->orderDate         = Carbon::parse($remoteSingleOrder['create_time'])
                        ->setTimezone('UTC')->format('Y-m-d H:i:s');
                    $this->_order->refInv            = $remoteSingleOrder['invoice_number'];
                    $this->_order->customerId        = $this->_customer->id;
                    $this->_order->shipmentId        = $this->_shipment->id;
                    $this->_order->shipmentServiceId = $this->_shipmentService->id;
                    
                }

                $this->_page++;

            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}