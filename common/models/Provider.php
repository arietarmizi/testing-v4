<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 3/26/2018
 * Time: 4:48 PM
 */

namespace common\models;


use common\base\ActiveRecord;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Provider
 *
 * @package common\models
 *
 * @property string           $id
 * @property string           $name
 * @property string           $type
 * @property string           $authMethod
 * @property string           $authUser
 * @property string           $authKey
 * @property string           $host
 * @property string           $authUrl
 * @property string           $token
 * @property int              $tokenExpired
 * @property string           $requestMethod
 * @property string           $requestBody
 * @property int              $requestTimeout
 * @property string           $responseLanguage
 * @property string           $status
 * @property string           $createdAt
 * @property string           $updatedAt
 *
 * @property ProviderConfig[] $configs
 * @property Client           $client
 * @property array            $configGroup
 */
class Provider extends ActiveRecord
{

    const TYPE_TOKOPEDIA = 'tokopedia';
    const TYPE_SHOPEE    = 'shopee';
    const TYPE_BUKALAPAK = 'bukalapak';

    const AUTH_METHOD_FORM   = 'form';
    const AUTH_METHOD_BASIC  = 'basic';
    const AUTH_METHOD_BEARER = 'bearer';
    const AUTH_METHOD_HEADER = 'header';

    const REQUEST_METHOD_POST = 'post';
    const REQUEST_METHOD_GET  = 'get';

    const REQUEST_BODY_JSON      = 'json';
    const REQUEST_BODY_FORM      = 'form_params';
    const REQUEST_BODY_MULTIPART = 'multipart';

    const RESPONSE_LANGUAGE_JSON = 'json';
    const RESPONSE_LANGUAGE_XML  = 'xml';

    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    const DEFAULT_REQUEST_TIMEOUT = 100;

    public $sender;
    public $title;
    public $message;
    public $recipients;
    public $logs;

    /** @var Client */
    private $_client;
    private $_headers      = [];
    private $_options      = ['verify' => false];
    private $_verify       = false;
    private $_query        = [];
    private $_requestBody  = [];
    private $recipientKey  = false;
    private $recipientsKey = false;

    public static function authMethods()
    {
        return [
            self::AUTH_METHOD_BASIC  => \Yii::t('app', 'HTTP Basic'),
            self::AUTH_METHOD_BEARER => \Yii::t('app', 'HTTP Bearer'),
            self::AUTH_METHOD_FORM   => \Yii::t('app', 'Form Parameter'),
        ];
    }

    public static function requestMethods()
    {
        return [
            self::REQUEST_METHOD_POST => \Yii::t('app', 'POST'),
            self::REQUEST_METHOD_GET  => \Yii::t('app', 'GET'),
        ];
    }

    public static function requestBodies()
    {
        return [
            self::REQUEST_BODY_JSON      => \Yii::t('app', 'JSON'),
            self::REQUEST_BODY_FORM      => \Yii::t('app', 'Form Parameters'),
            self::REQUEST_BODY_MULTIPART => \Yii::t('app', 'Multipart'),
        ];
    }

    public static function responseLanguages()
    {
        return [
            self::RESPONSE_LANGUAGE_XML  => \Yii::t('app', 'XML'),
            self::RESPONSE_LANGUAGE_JSON => \Yii::t('app', 'JSON'),
        ];
    }

    public static function tableName()
    {
        return '{{%provider}}';
    }

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE   => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => \Yii::t('app', 'Inactive'),
        ];
    }

    public static function types()
    {
        return [
            self::TYPE_TOKOPEDIA => \Yii::t('app', 'Tokopedia'),
            self::TYPE_BUKALAPAK => \Yii::t('app', 'Bukalapak'),
            self::TYPE_SHOPEE    => \Yii::t('app', 'Shopee'),
        ];
    }

    public function getConfigs()
    {
        return $this->hasMany(ProviderConfig::className(), ['providerId' => 'id']);
    }

    public function getHeaders()
    {
        return $this->_headers;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->setClient();
    }


    public function send()
    {
        $client = $this->getClient();
        $this->setRequestBody();
        /** @var bool $isXML */
        $isXML = ($this->responseLanguage == self::RESPONSE_LANGUAGE_XML);


        if ($this->recipientsKey) {
            ArrayHelper::setValue($this->_requestBody, $this->recipientsKey, $this->recipients);
        } else {
            ArrayHelper::setValue($this->_requestBody, $this->recipientKey, $this->recipients[0]);
        }

        $response = $client->request($this->requestMethod, $this->routeSender, $this->getRequestOptions());

        return [
            [
                'recipient' => $this->recipients,
                'code'      => $response->getStatusCode(),
                'contents'  => $this->getResponseContents($response, $isXML)
            ]
        ];
    }

    public function getClient()
    {
        return $this->_client;
    }

    public function setClient()
    {
        $this->addAuthorization();
        $this->addHeaders();
        $this->setRequestOptions();
        $this->_client = new Client([
            'base_uri'       => $this->host,
            'timeout'        => ArrayHelper::getValue($this, 'requestTimeout', 10),
            'headers'        => $this->_headers,
            'requestOptions' => $this->_options
        ]);
    }

    public function setRequestBody()
    {

        foreach ($this->configs as $config) {
            if ($config->group == ProviderConfig::GROUP_ATTRIBUTE_KEY) {
                $bodyIdentifier = $config->key;
                $keys           = explode('.', $config->value);

                if ($bodyIdentifier == ProviderConfig::ATTRIBUTE_KEY_SENDER) {
                    ArrayHelper::setValue($this->_requestBody, $keys, $this->sender);
                } elseif ($bodyIdentifier == ProviderConfig::ATTRIBUTE_KEY_RECIPIENT) {
                    $this->recipientKey = $config->value;
                } elseif ($bodyIdentifier == ProviderConfig::ATTRIBUTE_KEY_MULTIPLE_RECIPIENT) {
                    $this->recipientsKey = $config->value;
                } elseif ($bodyIdentifier == ProviderConfig::ATTRIBUTE_KEY_TITLE) {
                    ArrayHelper::setValue($this->_requestBody, $keys, $this->title);
                } elseif ($bodyIdentifier == ProviderConfig::ATTRIBUTE_KEY_MESSAGE) {
                    ArrayHelper::setValue($this->_requestBody, $keys, $this->message);
                }
            }
        }
    }

    public function getRequestOptions()
    {
        $requestOptions = [
            'verify' => $this->_verify,
        ];

        if ($this->requestMethod == self::REQUEST_METHOD_GET) {
            $this->_query      = ArrayHelper::merge($this->_query, $this->_requestBody);
            $this->requestBody = [];
        }

        $requestOptions['query'] = $this->_query;
        if ($this->requestBody) {
            $requestOptions[$this->requestBody] = $this->_requestBody;
        }

        return $requestOptions;

    }

    private function getResponseContents(Response $response, $isXML)
    {
        if ($isXML) {
            $responseContent = simplexml_load_string($response->getBody()->getContents());
            return $responseContent->message;
        } else {
            return Json::decode($response->getBody()->getContents());
        }
    }

    public function getConfigGroup()
    {
        return ArrayHelper::map($this->configs, 'key', 'value', 'group');
    }

    private function setRequestOptions()
    {
        $this->_query       = ArrayHelper::getValue($this->configGroup, ProviderConfig::GROUP_QUERY, []);
        $this->_requestBody = ArrayHelper::getValue($this->configGroup, ProviderConfig::GROUP_JSON_BODY, []);

    }

    private function addAuthorization()
    {
        if ($this->authMethod) {
            if ($this->authMethod == self::AUTH_METHOD_BASIC) {
                $this->_headers['Authorization'] = 'Basic ' . base64_encode($this->authUser . ":" . $this->authKey);
            } elseif ($this->authMethod == self::AUTH_METHOD_BEARER) {
                $this->_headers['Authorization'] = 'Bearer ' . $this->authKey;
            } else {
                $this->_headers['Authorization'] = $this->authUser . $this->authKey;
            }
        }
    }

    private function addHeaders()
    {
        $configHeaders = ArrayHelper::getValue($this->configGroup, ProviderConfig::GROUP_HEADER, []);

        foreach ($configHeaders as $headerKey => $headerValue) {
            $this->_headers[$headerKey] = $headerValue;
        }
    }

}