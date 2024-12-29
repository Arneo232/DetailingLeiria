<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\venda;

/**
 * VendaSearch represents the model behind the search form of `common\models\venda`.
 */
class VendaSearch extends venda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idVenda', 'metodoPagamento_id', 'metodoEntrega_id', 'idCarrinhoFK', 'idProfileFK'], 'integer'],
            [['total'], 'number'],
            [['datavenda'], 'safe'],
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
        $query = venda::find();

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
            'idVenda' => $this->idVenda,
            'total' => $this->total,
            'datavenda' => $this->datavenda,
            'metodoPagamento_id' => $this->metodoPagamento_id,
            'metodoEntrega_id' => $this->metodoEntrega_id,
            'idCarrinhoFK' => $this->idCarrinhoFK,
            'idProfileFK' => $this->idProfileFK,
        ]);

        return $dataProvider;
    }
}
