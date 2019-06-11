<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TaDetailPembelian]].
 *
 * @see TaDetailPembelian
 */
class TaDetailPembelianQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaDetailPembelian[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaDetailPembelian|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
