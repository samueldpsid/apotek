<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaDetailPenjualan;

/**
 * TaDetailPenjualanSearch represents the model behind the search form about `app\models\TaDetailPenjualan`.
 */
class TaDetailPenjualanSearch extends TaDetailPenjualan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'jumlah'], 'integer'],
            [['penjualan_id', 'obat_id'], 'safe'],
            [['sub_total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        // $query = TaDetailPenjualan::find();

        $query = TaDetailPenjualan::find()
                ->select('obat_id , sum(jumlah) as sum_jumlah')
                ->groupBy('obat_id')
                ->orderBy(['sum_jumlah' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'jumlah' => $this->jumlah,
            'sub_total' => $this->sub_total,
        ]);

        $query->andFilterWhere(['like', 'penjualan_id', $this->penjualan_id])
            ->andFilterWhere(['like', 'obat_id', $this->obat_id]);

        return $dataProvider;
    }
}
