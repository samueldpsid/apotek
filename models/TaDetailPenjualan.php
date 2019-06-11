<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_detail_penjualan".
 *
 * @property int $id
 * @property string $penjualan_id
 * @property string $obat_id
 * @property int $jumlah
 * @property double $sub_total
 *
 * @property TaPenjualan $penjualan
 * @property RefObat $obat
 */
class TaDetailPenjualan extends \yii\db\ActiveRecord
{
    public $sum_jumlah;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ta_detail_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_id', 'obat_id', 'jumlah', 'sub_total'], 'required'],
            [['jumlah'], 'integer'],
            [['sub_total'], 'number'],
            [['penjualan_id'], 'string', 'max' => 20],
            [['obat_id'], 'string', 'max' => 12],
            [['penjualan_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaPenjualan::className(), 'targetAttribute' => ['penjualan_id' => 'id']],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefObat::className(), 'targetAttribute' => ['obat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penjualan_id' => 'Penjualan ID',
            'obat_id' => 'Obat ID',
            'jumlah' => 'Jumlah',
            'sub_total' => 'Sub Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualan()
    {
        return $this->hasOne(TaPenjualan::className(), ['id' => 'penjualan_id']);
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
     * @return TaDetailPenjualanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaDetailPenjualanQuery(get_called_class());
    }
}
