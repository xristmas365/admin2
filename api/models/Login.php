<?php
/*
 * @author    Paul Storr <1230840.ps@gmail.com>
 * @package   live-song project
 * @version   1.0
 * @copyright Copyright (c) 2022, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Login Model
 *
 * @property array $token
 * @property User  $user
 */
class Login extends Model
{

    public string  $email;

    public string  $password;

    protected User $user;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }

    public function getToken()
    {
        return $this->user->auth_key;
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function in()
    {
        if(!$this->validate()) {
            return false;
        }

        $this->user = User::findOne(['email' => $this->email]);

        if(!$this->user) {
            $this->addError('email', 'Account Not Found');

            return false;
        }

        if(!Yii::$app->security->validatePassword($this->password, $this->user->password)) {
            $this->addError('email', 'Incorrect Email or Password');

            return false;
        }

        if($this->user->blocked) {
            $this->addError('email', 'Account Blocked');

            return false;
        }

        if(!$this->user->confirmed) {
            $this->addError('email', 'Confirm your Email');

            return false;
        }

        $this->user->auth_key = Yii::$app->security->generateRandomString();
        $this->user->last_login_at = time();

        return $this->user->save();
    }
}
