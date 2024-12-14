<?php
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Imagem;
use Yii;

class ImagemForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imagens;

    public function rules()
    {
        return [
            [['imagens'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 0],
        ];
    }

    public function saveImage($id){
        if($this->validate()){
            foreach($this->imagens as $file){
                $key = Yii::$app->getSecurity()->generateRandomString();

                $caminho = Yii::getAlias('@frontend/web/uploads/' . $key . '.' . $file->extension);

                $caminhoDir = dirname($caminho);

                if(!is_dir($caminhoDir)){
                    if(!mkdir($caminhoDir, 0777, true) && !is_dir($caminhoDir)){
                        throw new \Exception('Não foi possível criar a pasta');
                    }
                }

                if(!is_writable($caminhoDir)){
                    throw new \Exception('Não tens permissões');
                }

                if(!$file->saveAs($caminho)){
                    throw new \Exception('Não foi possível guardar a imagem');
                }

                $imagem = new Imagem();
                $imagem->fileName = $key . '.' . $file->extension;
                $imagem->produtoId = $id;

                if(!$imagem->save()){
                    throw new \Exception('Não foi possível guardar a imagem');
                }
            }
        }
    }

}
