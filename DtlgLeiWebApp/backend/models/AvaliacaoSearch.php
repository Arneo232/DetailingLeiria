<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Avaliacao;

/**
 * AvaliacaoSearch represents the model behind the search form of `common\models\Avaliacao`.
 */
class AvaliacaoSearch extends Avaliacao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idavaliacao', 'idProfileFK', 'idProdutoFK'], 'integer'],
            [['comentario'], 'safe'],
            [['rating'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Avaliacao::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idavaliacao' => $this->idavaliacao,
            'rating' => $this->rating,
            'idProfileFK' => $this->idProfileFK,
            'idProdutoFK' => $this->idProdutoFK,
        ]);

        $query->andFilterWhere(['like', 'comentario', $this->comentario]);

        return $dataProvider;
    }
}