<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_detail_return_pembelian".
 *
 * @property int $id
 * @property string $return_pembelian_id
 * @property string $obat_id
 * @property int $jumlah
 */
class TaDetailReturnPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ta_detail_return_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'return_pembelian_id', 'obat_id', 'jumlah'], 'required'],
            [['id', 'jumlah'], 'integer'],
            [['return_pembelian_id'], 'string', 'max' => 20],
            [['obat_id'], 'string', 'max' => 12],
            [['id'], 'unique'],
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
            'obat_id' => 'Obat ID',
            'jumlah' => 'Jumlah',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TaDetailReturnPembelianQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaDetailReturnPembelianQuery(get_called_class());
    }
}
