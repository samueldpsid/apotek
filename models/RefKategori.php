<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_kategori".
 *
 * @property int $id
 * @property string $kategori
 *
 * @property RefObat[] $refObats
 */
class RefKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori'], 'required'],
            [['kategori'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori' => 'Kategori',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefObats()
    {
        return $this->hasMany(RefObat::className(), ['kategori_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RefKategoriQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefKategoriQuery(get_called_class());
    }
}
