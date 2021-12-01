<?php

namespace api\forms\auth;

use api\components\BaseForm;
use common\models\User;
use common\validators\PhoneNumberValidator;

class RegisterForm extends BaseForm
{
    public $id;
    public $fileId;
    public $merchantId;
    public $identityCardNumber;
    public $name;
    public $phoneNumber;
    public $email;
    public $type;
    public $birthDate;
    public $address;
    public $verified;
    public $verifiedAt;
    public $password;
    public $confirmPassword;
    public $passwordResetToken;
    public $verifiedToken;
    public $status;

    /** @var User */
    protected $_user;

    public function init()
    {
        parent::init();
    }

    public function rules()
    {
        return [
            [['identityCardNumber', 'name', 'phoneNumber', 'email', 'birthDate', 'address', 'password', 'confirmPassword'], 'required'],
            ['type', 'in', 'range' => array_keys(User::types())],
            ['phoneNumber', PhoneNumberValidator::class],
//            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['password', 'confirmPassword'], 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password']
        ];
    }

    public function submit()
    {
        return $this->_createUser();
    }

    protected function _createUser()
    {
        $transaction = \Yii::$app->db->beginTransaction();

        $user                     = new User();
        $user->identityCardNumber = $this->identityCardNumber;
        $user->name               = $this->name;
        $user->phoneNumber        = $this->phoneNumber;
        $user->email              = $this->email;
        $user->type               = $this->type ? $this->type : User::types();
        $user->birthDate          = $this->birthDate;
        $user->address            = $this->address;
        $user->verified           = false;
//        $user->verifiedAt
        $user->setPassword($this->password);
        if ($user->save()) {
            $user->refresh();
            $this->_user = $user;
            $transaction->commit();
            return true;
        } else {
            $this->addErrors($this->getErrors());
            $transaction->rollBack();
            return false;
        }
    }

    public function response()
    {
        $query = $this->_user->toArray();

        unset($query['createdAt']);
        unset($query['updatedAt']);

        return ['user' => $query];
    }
}