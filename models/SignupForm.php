<?php

namespace app\models;

use Yii;
use app\models\gii\Profile;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $name;
    public $surname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required', 'on'=>'insert'],
            ['password', 'string', 'min' => 6, 'max' => 40],
            // TODO: how to set ->passwordInput() in view by gii??

            ['name', 'string', 'min' => 3, 'max' => 40],
            ['surname', 'string', 'min' => 3, 'max' => 40],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            // TODO: how to make transaction??
            $user = new User();
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save()) {
                $profile = new Profile();
                $profile->name = $this->name;
                $profile->surname = $this->surname;
                $profile->user_id = $user->id;
                $profile->save();

                // the following three lines were added:
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getPermission('user');
                $auth->assign($authorRole, $user->getId());

                return $user;
            }
        }
        return null;
    }
}
