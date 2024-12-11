<?php

namespace frontend\models;

use backend\models\UserForm;
use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Profile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;

    public $ntelefone;
    public $morada;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['ntelefone', 'required'],
            ['ntelefone', 'string', 'max' => 1000000000],
            ['morada', 'required'],
            ['morada', 'string', 'max' => 255],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = User::STATUS_ACTIVE;

        $user->save();

        $this->id = $user->getId();

        // Save profile data
        $profile = new Profile();
        $profile->userId = $user->id;
        $profile->ntelefone = $this->ntelefone;
        $profile->morada = $this->morada;
        $profile->save();

        $auth = Yii::$app->authManager;
        $client = $auth->getRole('client');
        $auth->assign($client, $user->id);

        return $user;
    }

    public function updateForm(){

        $user = User::findOne($this->id);

        //update user
        $user->username = $this->username;
        $user->email = $this->email;
        // $user->setPassword($this->password);
        //$user->generateAuthKey();
        //$user->generateEmailVerificationToken();
        $user->save(false);

        // Update profile data
        $profile = $user->profile; // Use the relationship
        $profile->userId = $user->id;
        $profile->ntelefone = $this->ntelefone;
        $profile->morada = $this->morada;
        $profile->save();

        return true;
    }

    public function colocarDados($id){
        $user = User::findOne($id);

        $signupForm = new SignupForm();

        $signupForm->id = $user->id;
        $signupForm->username = $user->username;
        $signupForm->email = $user->email;

        // Load profile data
        $profile = $user->profile;  // Assuming the relation is set
        if ($profile) {
            $signupForm->ntelefone = $profile->ntelefone;
            $signupForm->morada = $profile->morada;
        }

        return $signupForm;
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
