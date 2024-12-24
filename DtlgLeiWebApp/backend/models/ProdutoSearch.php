<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Produto;

/**
 * ProdutoSearch represents the model behind the search form of `common\models\Produto`.
 */
class ProdutoSearch extends Produto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idProduto', 'stock', 'idCategoria', 'fornecedores_idfornecedores'], 'integer'],
            [['nome', 'descricao'], 'safe'],
            [['preco'], 'number'],
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
        $query = Produto::find();

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
            'idProduto' => $this->idProduto,
            'preco' => $this->preco,
            'stock' => $this->stock,
            'idCategoria' => $this->idCategoria,
            'fornecedores_idfornecedores' => $this->fornecedores_idfornecedores,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
    public function searchWithFilters($params)
    {
        $query = Produto::find();
        $this->load($params);

        // Validação de dados
        if (!$this->validate()) {
            return new ActiveDataProvider([
                'query' => Produto::find()->where('0=1'), // Retorna sem resultados se a validação falhar
            ]);
        }

        // Aplica o filtro de categoria
        $query->andFilterWhere([
            'idCategoria' => $this->idCategoria,
        ]);

        // Aplica o filtro de palavra-chave
        if (!empty($this->nome)) {
            $query->andFilterWhere(['like', 'nome', $this->nome]);
        }

        // Retorna o dataProvider
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }

}
