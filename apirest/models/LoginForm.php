<?php
namespace apirest\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user;

    const EXPIRE_TIME = 86400; //token expiration time, 24 hours valid

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, 'Incorrect username.');
            }
            elseif (!$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) 
        {
            if ($this->getUser()) 
            {
                // solo generar un nuevo access-token si el anterior expiro
                if ($this->_user->expire_at < time()) 
                {
                    $access_token = $this->_user->generateAccessToken();
                    $expire_at = time() + static::EXPIRE_TIME;

                    $this->_user->expire_at = $expire_at;
                    $this->_user->password = $this->password;
                    $this->_user->save();
                }
                else 
                {
                    $access_token = $this->_user->access_token;
                    $expire_at = $this->_user->expire_at;
                }
                Yii::$app->user->login($this->_user, static::EXPIRE_TIME);
                return ['access_token'=>$access_token, 'expire_at'=>date('Y-m-d H:i:s', $expire_at)];
            }
        }
        return false;
    }    


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
