<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_penerimaan_return_pembelian".
 *
 * @property string $id
 * @property string $return_pembelian_id
 * @property string $tanggal
 * @property int $status
 *
 * @property TaReturnPembelian $returnPembelian
 */
class TaPenerimaanReturnPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ta_penerimaan_return_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['return_pembelian_id', 'tanggal'], 'required'],
            [['tanggal'], 'safe'],
            [['status'], 'integer'],
            [['id', 'return_pembelian_id'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['return_pembelian_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaReturnPembelian::className(), 'targetAttribute' => ['return_pembelian_id' => 'id']],
            [['id'], 'autonumber', 'format' => 'PRPB-' . '?', 'digit' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'return_pembelian_id' => 'Return Pembelian ID',
            'tanggal' => 'Tanggal',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnPembelian()
    {
        return $this->hasOne(TaReturnPembelian::className(), ['id' => 'return_pembelian_id']);
    }

    /**
     * {@inheritdoc}
     * @return TaPenerimaanReturnPembelianQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaPenerimaanReturnPembelianQuery(get_called_class());
    }
}
