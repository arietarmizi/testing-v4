<?php

namespace api\controllers;

use api\components\Controller;
use api\components\Response;
use common\encryption\Tokopedia;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class SiteController extends Controller
{

    public $responses = '{
   "header":{
      "process_time":0,
      "messages":"Your request has been processed successfully"
   },
   "data":{
      "order_id":879553968,
      "buyer_id":171477392,
      "seller_id":11960781,
      "payment_id":1181565356,
      "is_affiliate":false,
      "is_fulfillment":false,
      "order_warehouse":{
         "warehouse_id":11914139,
         "fulfill_by":0,
         "meta_data":{
            "warehouse_id":11914139,
            "partner_id":0,
            "shop_id":11960781,
            "warehouse_name":"Shop Location",
            "district_id":2265,
            "district_name":"Kebayoran Lama",
            "city_id":175,
            "city_name":"Jakarta Selatan",
            "province_id":13,
            "province_name":"DKI Jakarta",
            "status":1,
            "postal_code":"12210",
            "is_default":1,
            "latlon":",",
            "latitude":"",
            "longitude":"",
            "email":"",
            "address_detail":"",
            "country_name":"Indonesia",
            "is_fulfillment":false
         }
      },
      "order_status":0,
      "invoice_number":"INV/20210802/MPL/1463471138",
      "invoice_pdf":"Invoice-171477392-11960781-20210802172224-aWlpaWlpaWky.pdf",
      "invoice_url":"https://www.tokopedia.com/invoice.pl?id=879553968&pdf=Invoice-171477392-11960781-20210802172224-aWlpaWlpaWky",
      "open_amt":10100,
      "lp_amt":0,
      "cashback_amt":0,
      "info":"",
      "comment":"* 05/08/2021 17:27:02 : Penjual telah melebihi batas waktu pengiriman pesanan",
      "item_price":1000,
      "buyer_info":{
         "buyer_id":171477392,
         "buyer_fullname":"",
         "buyer_email":"",
         "buyer_phone":""
      },
      "shop_info":{
         "shop_owner_id":171477393,
         "shop_owner_email":"borwita_indah.sellerapi.test.account2@tokopedia.com",
         "shop_owner_form":"",
         "shop_name":"SellerAPI-Testing API",
         "shop_domain":"sellerapi-testingapi",
         "shop_id":11960781,
         "last_login_at":""
      },
      "shipment_fulfillment":{
         "id":569612236,
         "order_id":879553968,
         "payment_date_time":"2021-08-02T17:24:31Z",
         "is_same_day":false,
         "accept_deadline":"2021-08-03T17:24:31Z",
         "confirm_shipping_deadline":"2021-08-05T17:24:31Z",
         "item_delivered_deadline":{
            "Time":"0001-01-01T00:00:00Z",
            "Valid":false
         },
         "is_accepted":false,
         "is_confirm_shipping":false,
         "is_item_delivered":false,
         "fulfillment_status":0
      },
      "preorder":{
         "order_id":0,
         "preorder_type":0,
         "preorder_process_time":0,
         "preorder_process_start":"",
         "preorder_deadline":"",
         "shop_id":0,
         "customer_id":0
      },
      "order_info":{
         "order_detail":[
            {
               "order_detail_id":1463471139,
               "product_id":2029011498,
               "product_name":"Masker Hijab 3ply",
               "product_desc_pdp":"",
               "product_desc_atc":"",
               "product_price":100,
               "subtotal_price":1000,
               "weight":0.01,
               "total_weight":0.1,
               "quantity":10,
               "quantity_deliver":10,
               "quantity_reject":0,
               "is_free_returns":false,
               "insurance_price":0,
               "normal_price":100,
               "currency_id":1,
               "currency_rate":0,
               "min_order":1,
               "child_cat_id":4632,
               "campaign_id":"0",
               "product_picture":"https://ecs7.tokopedia.net/img/cache/100-square/VqbcmM/2021/7/27/36f7f788-97db-4a2b-97df-578e63120a5a.jpg",
               "snapshot_url":"https://www.tokopedia.com/snapshot_product?order_id=879553968&dtl_id=1463471139",
               "sku":"-"
            }
         ],
         "order_history":[
            {
               "action_by":"system-automatic",
               "hist_status_code":0,
               "message":"",
               "timestamp":"2021-08-05T17:27:02.583876Z",
               "comment":"Penjual telah melebihi batas waktu pengiriman pesanan",
               "create_by":0,
               "update_by":"system"
            },
            {
               "action_by":"seller",
               "hist_status_code":400,
               "message":"",
               "timestamp":"2021-08-03T17:20:27.593379Z",
               "comment":"",
               "create_by":171477393,
               "update_by":"Borwita Indah\'s Seller API Test Account"
            },
            {
               "action_by":"tokopedia",
               "hist_status_code":220,
               "message":"",
               "timestamp":"2021-08-02T17:24:31.882302Z",
               "comment":"",
               "create_by":0,
               "update_by":"tokopedia"
            },
            {
               "action_by":"tokopedia",
               "hist_status_code":190,
               "message":"",
               "timestamp":"2021-08-02T17:24:29.267763Z",
               "comment":"",
               "create_by":0,
               "update_by":"tokopedia"
            },
            {
               "action_by":"buyer",
               "hist_status_code":103,
               "message":"",
               "timestamp":"2021-08-02T17:22:24.883937Z",
               "comment":"",
               "create_by":171477392,
               "update_by":"Borwita Indah\'s Seller API Test Account"
            },
            {
               "action_by":"buyer",
               "hist_status_code":100,
               "message":"",
               "timestamp":"2021-08-02T17:22:24.883937Z",
               "comment":"",
               "create_by":171477392,
               "update_by":"Borwita Indah\'s Seller API Test Account"
            }
         ],
         "order_age_day":94,
         "shipping_age_day":0,
         "delivered_age_day":0,
         "partial_process":false,
         "shipping_info":{
            "sp_id":1,
            "shipping_id":1,
            "logistic_name":"JNE",
            "logistic_service":"Reguler",
            "shipping_price":9000,
            "shipping_price_rate":9000,
            "shipping_fee":0,
            "insurance_price":100,
            "fee":0,
            "is_change_courier":false,
            "second_sp_id":0,
            "second_shipping_id":0,
            "second_logistic_name":"",
            "second_logistic_service":"",
            "second_agency_fee":0,
            "second_insurance":0,
            "second_rate":0,
            "awb":"",
            "autoresi_cashless_status":0,
            "autoresi_awb":"",
            "autoresi_shipping_price":0,
            "count_awb":0,
            "isCashless":false,
            "is_fake_delivery":false
         },
         "destination":{
            "receiver_name":"",
            "receiver_phone":"",
            "address_street":"",
            "address_district":"Palmerah",
            "address_city":"Kota Administrasi Jakarta Barat",
            "address_province":"DKI Jakarta",
            "address_postal":"11410",
            "customer_address_id":152196375,
            "district_id":2258,
            "city_id":174,
            "province_id":13
         },
         "is_replacement":false,
         "replacement_multiplier":0
      },
      "origin_info":{
         "sender_name":"SellerAPI-Testing API",
         "origin_province":13,
         "origin_province_name":"DKI Jakarta",
         "origin_city":175,
         "origin_city_name":"Kota Administrasi Jakarta Selatan",
         "origin_address":"",
         "origin_district":2265,
         "origin_district_name":"Kebayoran Lama",
         "origin_postal_code":"12210",
         "origin_geo":",",
         "receiver_name":"",
         "destination_address":"",
         "destination_province":13,
         "destination_city":174,
         "destination_district":2258,
         "destination_postal_code":"11410",
         "destination_geo":",",
         "destination_loc":{
            "lat":0,
            "lon":0
         }
      },
      "payment_info":{
         "payment_id":1181565356,
         "payment_ref_num":"PYM/2021082/XXI/VIII/1181647298",
         "payment_date":"2021-08-02T17:22:05Z",
         "payment_method":0,
         "payment_status":"verified",
         "payment_status_id":2,
         "create_time":"2021-08-02T17:22:05Z",
         "pg_id":20,
         "gateway_name":"BCA Virtual Account",
         "discount_amount":0,
         "voucher_code":"",
         "voucher_id":0
      },
      "insurance_info":{
         "insurance_type":2
      },
      "hold_info":null,
      "cancel_request_info":null,
      "create_time":"2021-08-02T17:22:24.865862Z",
      "shipping_date":"",
      "update_time":"2021-08-05T17:27:02.571186Z",
      "payment_date":"2021-08-02T17:24:31Z",
      "delivered_date":"",
      "est_shipping_date":"",
      "est_delivery_date":"",
      "related_invoices":null,
      "custom_fields":null,
      "promo_order_detail":{
         "order_id":879553968,
         "total_cashback":0,
         "total_discount":0,
         "total_discount_product":0,
         "total_discount_shipping":0,
         "total_discount_details":null,
         "summary_promo":null
      },
      "encryption":{
         "secret":"aAmBsgA3IS/3HeaWqQaN+9TqsqIhVssjJsL7JNgn8Vk0Zk0eUy/Rhn7G3taPtc6KzC8VyKvAFWW6BKV1HePtdXVUwZPn+YIur3q1x753IpNfdKBKG6jETBQ1457IWXOhNSPlD5EkXMBza0aREmL6vfBCDel+2+fpMywft0t55GBU6IzVEm48PQoPDpBNk/tlLaoGh8ftoJJSuKbnO3CCVO7ChmPRnhyWd00dYGSrHrmVI9/AXPkClRK3XBzJzB5NPPcjDDXMxJOTl84rdFbPOZ+5s3eXiVb3ankQq2rYi1gpqq2JcSvkoGOptfcUZvEmchzluXBnub5RCPvbaaOO4g==",
         "content":"BrV/EsI9Pl6G15C3eX4Wf5zqqu6CqnOTmuEdEY5RE4Fhv+PJWzgqfYatfnOkeqgh3LGQh1GgnFiT1s8Li6n8g5WeZCJLT1I4KKlYMY28r0z15kwKRskKHfkDLCP3Q1lLymgLSMc2u/avDOOPACFWhemWOAYDkRJcoH3e8QnOvIwQdbhqCVjWtqf5VUvvDT40QVSlqy95BGzBCEThnIIPbT0u4mNqCg+mclhnruHroagIw4XrU1ia6uJC0m0VqfRJMbdI4f/VGXKYyB15UDPasoRHgyHakGtRfXedK9XbAnUTVvzNq0DgrH1d/s2QG4D9K7zNHH5sBg3QyQR72C7SoBMcHROOQy0MP5Rbndsh22usRyolbMHdI0QcX1A1xQXqSKeq3OSlZH6WDoWKBSnf9kW0RC9vRJn9JPWZehxgK/aEKyYlyLF33h2ZbIPmAZnap92Ilw=="
      }
   }
}';

    public function behaviors()
    {
        $behaviors                              = parent::behaviors();
        $behaviors['systemAppFilter']['except'] = ['index', 'encoded'];

        return $behaviors;
    }

    public function actionIndex()
    {
//        $response = new Response();

//        $response->name    = \Yii::$app->name;
//        $response->message = 'API is running';
//        $response->code    = 0;
//        $response->status  = 200;
//        $response->data    = 'You are accessing this endpoint from ' . \Yii::$app->request->getUserIP();


//        return $response;\
        $secret  = "aAmBsgA3IS/3HeaWqQaN+9TqsqIhVssjJsL7JNgn8Vk0Zk0eUy/Rhn7G3taPtc6KzC8VyKvAFWW6BKV1HePtdXVUwZPn+YIur3q1x753IpNfdKBKG6jETBQ1457IWXOhNSPlD5EkXMBza0aREmL6vfBCDel+2+fpMywft0t55GBU6IzVEm48PQoPDpBNk/tlLaoGh8ftoJJSuKbnO3CCVO7ChmPRnhyWd00dYGSrHrmVI9/AXPkClRK3XBzJzB5NPPcjDDXMxJOTl84rdFbPOZ+5s3eXiVb3ankQq2rYi1gpqq2JcSvkoGOptfcUZvEmchzluXBnub5RCPvbaaOO4g==";
        $content = "BrV/EsI9Pl6G15C3eX4Wf5zqqu6CqnOTmuEdEY5RE4Fhv+PJWzgqfYatfnOkeqgh3LGQh1GgnFiT1s8Li6n8g5WeZCJLT1I4KKlYMY28r0z15kwKRskKHfkDLCP3Q1lLymgLSMc2u/avDOOPACFWhemWOAYDkRJcoH3e8QnOvIwQdbhqCVjWtqf5VUvvDT40QVSlqy95BGzBCEThnIIPbT0u4mNqCg+mclhnruHroagIw4XrU1ia6uJC0m0VqfRJMbdI4f/VGXKYyB15UDPasoRHgyHakGtRfXedK9XbAnUTVvzNq0DgrH1d/s2QG4D9K7zNHH5sBg3QyQR72C7SoBMcHROOQy0MP5Rbndsh22usRyolbMHdI0QcX1A1xQXqSKeq3OSlZH6WDoWKBSnf9kW0RC9vRJn9JPWZehxgK/aEKyYlyLF33h2ZbIPmAZnap92Ilw==";
        try {
            $decryptedContent = Tokopedia::decryptContent($secret, $content);
            $responses = Json::decode($this->responses);
            $data      = ArrayHelper::getValue($responses, 'data', []);
            $merge     = ArrayHelper::merge($data, $decryptedContent);
            echo Json::encode($merge);
            exit();
//            echo $decryptedContent;
        } catch (\Exception $e) {
        }



    }

}
