<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaPembelian;

/**
 * TaPembelianSearch represents the model behind the search form of `backend\models\TaPembelian`.
 */
class TaPembelianSearch extends TaPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tanggal'], 'safe'],
            [['grand_total'], 'number'],
            [['distributor_id', 'waktu_entri', 'kd_user'], 'integer'],
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
        $query = TaPembelian::find();

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
            'grand_total' => $this->grand_total,
            'distributor_id' => $this->distributor_id,
            'tanggal' => $this->tanggal,
            'waktu_entri' => $this->waktu_entri,
            'kd_user' => $this->kd_user,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id]);

        return $dataProvider;
    }
}
