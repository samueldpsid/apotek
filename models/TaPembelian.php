<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_pembelian".
 *
 * @property string $id
 * @property int $distributor_id
 * @property string $tanggal
 * @property int $waktu_entri
 * @property int $kd_user
 *
 * @property TaDetailPembelian[] $taDetailPembelians
 * @property RefDistributor $distributor
 */
class TaPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ta_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'distributor_id', 'tanggal', 'waktu_entri', 'kd_user'], 'required'],
            [['grand_total'], 'number'],
            [['distributor_id', 'waktu_entri', 'kd_user'], 'integer'],
            [['tanggal'], 'safe'],
            [['id'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['distributor_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDistributor::className(), 'targetAttribute' => ['distributor_id' => 'id']],
            [['id'], 'autonumber', 'format'=>'PB-' . '?', 'digit'=>6],
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
            'distributor_id' => 'Distributor ID',
            'tanggal' => 'Tanggal',
            'waktu_entri' => 'Waktu Entri',
            'kd_user' => 'Kd User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaDetailPembelians()
    {
        return $this->hasMany(TaDetailPembelian::className(), ['pembelian_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributor()
    {
        return $this->hasOne(RefDistributor::className(), ['id' => 'distributor_id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\TaPembelianQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaPembelianQuery(get_called_class());
    }
}
