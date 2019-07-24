<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TaDetailReturnPembelian]].
 *
 * @see TaDetailReturnPembelian
 */
class TaDetailReturnPembelianQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaDetailReturnPembelian[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaDetailReturnPembelian|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
