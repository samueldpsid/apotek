<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_obat".
 *
 * @property string $id
 * @property int $kategori_id
 * @property int $satuan_id
 * @property int $produsen_id
 * @property string $nama_obat
 * @property double $harga_beli
 * @property double $harga_jual
 * @property int $stok
 *
 * @property RefKategori $kategori
 * @property RefProdusen $produsen
 * @property RefSatuan $satuan
 * @property TaDetailPembelian[] $taDetailPembelians
 * @property TaDetailPenjualan[] $taDetailPenjualans
 */
class RefObat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_obat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kategori_id', 'satuan_id', 'produsen_id', 'nama_obat', 'harga_beli', 'harga_jual', 'stok'], 'required'],
            [['kategori_id', 'satuan_id', 'produsen_id', 'stok'], 'integer'],
            [['harga_beli', 'harga_jual'], 'number'],
            [['id'], 'string', 'max' => 12],
            [['nama_obat'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefKategori::className(), 'targetAttribute' => ['kategori_id' => 'id']],
            [['produsen_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProdusen::className(), 'targetAttribute' => ['produsen_id' => 'id']],
            [['satuan_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSatuan::className(), 'targetAttribute' => ['satuan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori_id' => 'Kategori ID',
            'satuan_id' => 'Satuan ID',
            'produsen_id' => 'Produsen ID',
            'nama_obat' => 'Nama Obat',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'stok' => 'Stok',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(RefKategori::className(), ['id' => 'kategori_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdusen()
    {
        return $this->hasOne(RefProdusen::className(), ['id' => 'produsen_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(RefSatuan::className(), ['id' => 'satuan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaDetailPembelians()
    {
        return $this->hasMany(TaDetailPembelian::className(), ['obat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaDetailPenjualans()
    {
        return $this->hasMany(TaDetailPenjualan::className(), ['obat_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RefObatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefObatQuery(get_called_class());
    }
}
