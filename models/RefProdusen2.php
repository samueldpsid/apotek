<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ref_produsen".
 *
 * @property int $id
 * @property string $produsen
 *
 * @property RefObat[] $refObats
 */
class RefProdusen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_produsen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produsen'], 'required'],
            [['produsen'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produsen' => 'Produsen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefObats()
    {
        return $this->hasMany(RefObat::className(), ['produsen_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\ReQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\ReQuery(get_called_class());
    }
}
