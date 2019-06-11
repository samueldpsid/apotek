<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_satuan".
 *
 * @property int $id
 * @property string $satuan
 *
 * @property RefObat[] $refObats
 */
class RefSatuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_satuan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['satuan'], 'required'],
            [['satuan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'satuan' => 'Satuan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefObats()
    {
        return $this->hasMany(RefObat::className(), ['satuan_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RefSatuanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefSatuanQuery(get_called_class());
    }
}
