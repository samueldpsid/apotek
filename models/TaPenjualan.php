<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_penjualan".
 *
 * @property string $id
 * @property double $grand_total
 * @property string $tanggal
 * @property int $waktu_entri
 * @property int $kd_user
 *
 * @property TaDetailPenjualan[] $taDetailPenjualans
 */
class TaPenjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ta_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'grand_total', 'tanggal', 'waktu_entri', 'kd_user'], 'required'],
            [['grand_total'], 'number'],
            [['tanggal'], 'safe'],
            [['waktu_entri', 'kd_user'], 'integer'],
            [['id'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['id'], 'autonumber', 'format'=>'PJ-' . '?', 'digit'=>6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No Transaksi',
            'grand_total' => 'Grand Total',
            'tanggal' => 'Tanggal Transaksi',
            'waktu_entri' => 'Waktu Entri',
            'kd_user' => 'Kd User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaDetailPenjualans()
    {
        return $this->hasMany(TaDetailPenjualan::className(), ['penjualan_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\TaPenjualanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaPenjualanQuery(get_called_class());
    }
}
