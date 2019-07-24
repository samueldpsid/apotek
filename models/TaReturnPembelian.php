<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_return_pembelian".
 *
 * @property string $id
 * @property string $obat_id
 * @property int $jumlah
 * @property int $distributor_id
 * @property string $tanggal
 * @property int $waktu_entri
 * @property int $kd_user
 * @property string $status
 *
 * @property TaPenerimaanReturnPembelian[] $taPenerimaanReturnPembelians
 * @property RefDistributor $distributor
 * @property RefObat $obat
 */
class TaReturnPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ta_return_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['obat_id', 'jumlah', 'distributor_id', 'tanggal', 'waktu_entri', 'kd_user', 'status'], 'required'],
            [['jumlah', 'distributor_id', 'waktu_entri', 'kd_user'], 'integer'],
            [['tanggal'], 'safe'],
            [['status'], 'string'],
            [['id'], 'string', 'max' => 20],
            [['obat_id'], 'string', 'max' => 12],
            [['id'], 'unique'],
            [['distributor_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDistributor::className(), 'targetAttribute' => ['distributor_id' => 'id']],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefObat::className(), 'targetAttribute' => ['obat_id' => 'id']],
            [['id'], 'autonumber', 'format'=>'RPB-' . '?', 'digit' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No Transaksi',
            'obat_id' => 'Kode Obat',
            'jumlah' => 'Jumlah',
            'distributor_id' => 'Distributor ID',
            'tanggal' => 'Tanggal',
            'waktu_entri' => 'Waktu Entri',
            'kd_user' => 'Kd User',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaPenerimaanReturnPembelians()
    {
        return $this->hasMany(TaPenerimaanReturnPembelian::className(), ['return_pembelian_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributor()
    {
        return $this->hasOne(RefDistributor::className(), ['id' => 'distributor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObat()
    {
        return $this->hasOne(RefObat::className(), ['id' => 'obat_id']);
    }

    /**
     * {@inheritdoc}
     * @return TaReturnPembelianQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaReturnPembelianQuery(get_called_class());
    }
}
