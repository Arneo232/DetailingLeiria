<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tarefa;

/**
 * TarefaSearch represents the model behind the search form of `common\models\Tarefa`.
 */
class TarefaSearch extends Tarefa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idTarefa', 'feito', 'idProfileFK'], 'integer'],
            [['descricao'], 'safe'],
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
        $query = Tarefa::find();

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
            'idTarefa' => $this->idTarefa,
            'feito' => $this->feito,
            'idProfileFK' => $this->idProfileFK,
        ]);

        $query->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
