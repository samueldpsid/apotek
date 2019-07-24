<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaReturnPembelian;

/**
 * TaReturnPembelianSearch represents the model behind the search form of `app\models\TaReturnPembelian`.
 */
class TaReturnPembelianSearch extends TaReturnPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'obat_id', 'tanggal', 'status'], 'safe'],
            [['jumlah', 'distributor_id', 'waktu_entri', 'kd_user'], 'integer'],
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
        $query = TaReturnPembelian::find();

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
            'jumlah' => $this->jumlah,
            'distributor_id' => $this->distributor_id,
            'tanggal' => $this->tanggal,
            'waktu_entri' => $this->waktu_entri,
            'kd_user' => $this->kd_user,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'obat_id', $this->obat_id])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
