<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefObat;

/**
 * RefObatSearch represents the model behind the search form about `app\models\RefObat`.
 */
class RefObatSearch extends RefObat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nama_obat'], 'safe'],
            [['kategori_id', 'satuan_id', 'produsen_id', 'stok'], 'integer'],
            [['harga_beli', 'harga_jual'], 'number'],
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
        $query = RefObat::find();

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
            'kategori_id' => $this->kategori_id,
            'satuan_id' => $this->satuan_id,
            'produsen_id' => $this->produsen_id,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nama_obat', $this->nama_obat]);

        return $dataProvider;
    }
}
