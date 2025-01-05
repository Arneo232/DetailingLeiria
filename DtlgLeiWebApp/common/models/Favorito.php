<?php

namespace common\models;

use common\models\Produto;
use common\models\Profile;
use Yii;

/**
 * This is the model class for table "favorito".
 *
 * @property int $produto_id
 * @property int $profile_id
 * @property int $idfavorito
 *
 * @property Produto $produto
 * @property Profile $profile
 */
class Favorito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produto_id', 'profile_id'], 'required'],
            [['produto_id', 'profile_id'], 'integer'],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'idProduto']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'idprofile']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produto_id' => 'Produto ID',
            'profile_id' => 'Profile ID',
            'idfavorito' => 'Idfavorito',
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['idProduto' => 'produto_id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['idprofile' => 'profile_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $produto = Produto::findOne($this->produto_id);

            if ($produto) {
                $mensagem = "O produto {$produto->nome} foi adicionado aos favoritos por um utilizador.";
                $this->FazPublishNoMosquitto("INSERT_FAV", $mensagem);
            }
        }
    }
    public function afterDelete()
    {
        parent::afterDelete();

        $produto = Produto::findOne($this->produto_id);

        $messagem = "O produto {$produto->nome} foi removido dos favoritos por um utilizador.";

        $this->FazPublishNoMosquitto('REMOVER_FAV', $messagem);
    }
    public function FazPublishNoMosquitto($canal,$msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = "phpMQTT-publisher";
        $mqtt = new \common\mosquitto\phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password))
        {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }
        else { file_put_contents('debug.output','Time out!'); }
    }
}
