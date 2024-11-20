<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 */
class User extends \yii\db\ActiveRecord
{
    public $password;
    public $role;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['username', 'email', 'role'], 'required'], // Regular required fields
            [['password'], 'string', 'min' => 6, 'on' => 'create'], // Password validation
            [['auth_key', 'password_hash', 'password_reset_token', 'verification_token', 'created_at', 'updated_at'], 'safe'], // Automatically managed fields

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->password)) {
                // Hash the password and store it in the password_hash field
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            }

            if ($this->isNewRecord) {
                // Generate auth_key for new records
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->created_at = time(); // Set created_at timestamp
            }

            // Always update the updated_at timestamp
            $this->updated_at = time();

            return true;
        }
        return false;
    }
}
