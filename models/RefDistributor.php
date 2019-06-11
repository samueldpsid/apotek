<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_distributor".
 *
 * @property int $id
 * @property string $distributor
 *
 * @property TaPembelian[] $taPembelians
 */
class RefDistributor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_distributor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distributor'], 'required'],
            [['distributor'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'distributor' => 'Distributor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaPembelians()
    {
        return $this->hasMany(TaPembelian::className(), ['distributor_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RefDistributorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefDistributorQuery(get_called_class());
    }
}
