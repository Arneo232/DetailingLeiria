<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Profile;
use yii\rbac\Role;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;

    public $role;

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['username', 'trim'],
            [['role', 'username'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function createForm()
    {
        if (!$this->validate()) {
            return null;
        }

        $role = new Role();
        $role = Yii::$app->authManager->getRole($this->role);

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = User::STATUS_ACTIVE;

        $user->save();

        $this->id = $user->getId();

        $auth = Yii::$app->authManager;
        $auth->assign($role, $user->id);

        return $user;
    }


    public function updateForm(){

        $user = User::findOne($this->id);


        $user->username = $this->username;
        $user->email = $this->email;
        // $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        $user->save(false);

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->role);
        $auth->revokeAll($this->id);
        $auth->assign($role, $user->id);


        return true;
    }

    public function colocarDados($id){
        $user = User::findOne($id);

        $userForm = new UserForm();

        $userForm->id = $user->id;
        $userForm->username = $user->username;
        $userForm->email = $user->email;
        $userForm->role = $user->getRole();

        return $userForm;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
