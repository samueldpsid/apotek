<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TaPembelian]].
 *
 * @see TaPembelian
 */
class TaPembelianQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaPembelian[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaPembelian|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
