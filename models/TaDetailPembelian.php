<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_detail_pembelian".
 *
 * @property int $id
 * @property string $pembelian_id
 * @property string $obat_id
 * @property int $jumlah
 * @property double $sub_total
 *
 * @property RefObat $obat
 * @property TaPembelian $pembelian
 */
class TaDetailPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ta_detail_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian_id', 'obat_id', 'jumlah', 'sub_total'], 'required'],
            [['jumlah'], 'integer'],
            [['sub_total'], 'number'],
            [['pembelian_id'], 'string', 'max' => 20],
            [['obat_id'], 'string', 'max' => 12],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefObat::className(), 'targetAttribute' => ['obat_id' => 'id']],
            [['pembelian_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaPembelian::className(), 'targetAttribute' => ['pembelian_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pembelian_id' => 'Pembelian ID',
            'obat_id' => 'Obat ID',
            'jumlah' => 'Jumlah',
            'sub_total' => 'Sub Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObat()
    {
        return $this->hasOne(RefObat::className(), ['id' => 'obat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPembelian()
    {
        return $this->hasOne(TaPembelian::className(), ['id' => 'pembelian_id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\TaDetailPembelianQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaDetailPembelianQuery(get_called_class());
    }
}
