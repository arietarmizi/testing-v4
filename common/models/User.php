<?php


namespace common\models;


use common\base\ActiveRecord;
use Ramsey\Uuid\Uuid;
use yii\base\NotSupportedException;
use yii\filters\RateLimitInterface;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @package common\models
 *
 * @property string                $id
 * @property string                $fileId
 * @property string                $merchantId
 * @property string                $identityCardNumber
 * @property string                $name
 * @property string                $phoneNumber
 * @property string                $email
 * @property string                $type
 * @property string                $birthDate
 * @property string                $address
 * @property string                $verified
 * @property string                $verifiedAt
 * @property string                $passwordHash
 * @property string                $passwordResetToken
 * @property string                $verificationToken
 * @property string                $status
 * @property string                $createdAt
 * @property string                $updatedAt
 *
 * @property NotSupportedException $authKey
 */
class User extends ActiveRecord implements RateLimitInterface
{
    const TYPE_OWNER    = 'owner';
    const TYPE_EMPLOYEE = 'employee';

    const STATUS_ACTIVE    = 'active';
    const STATUS_INACTIVE  = 'inactive';
    const STATUS_BANNED    = 'banned';
    const STATUS_SUSPENDED = 'suspended';

    public  $rateLimit            = 10;
    public  $allowance;
    public  $allowance_updated_at;
    private $requestCodeDuration  = 5;
    private $requestResetDuration = 60;
    private $codeExpiredDuration  = 5;

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE    => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE  => \Yii::t('app', 'Inactive'),
            self::STATUS_SUSPENDED => \Yii::t('app', 'Suspended'),
            self::STATUS_BANNED    => \Yii::t('app', 'Banned'),
        ];
    }

    public static function types()
    {
        return [
            self::TYPE_OWNER    => \Yii::t('app', 'Owner'),
            self::TYPE_EMPLOYEE => \Yii::t('app', 'Employee'),
        ];
    }

    public static function tableName()
    {
        return '{{%user}}';
    }
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['passwordHash']);

        return $fields;
    }

    public function setPassword($password)
    {
        $this->passwordHash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->passwordHash);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(Uuid $id)
    {
        $this->id = $id;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException();
    }

    /**
     * @param string $authKey
     *
     * @return bool|void
     * @throws NotSupportedException
     * @since 2018-05-13 21:03:06
     *
     */

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
    }

    public function getRateLimit($request, $action)
    {
        return [$this->rateLimit, 20];
    }

    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance            = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }
}