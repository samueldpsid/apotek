<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TaPenerimaanReturnPembelian]].
 *
 * @see TaPenerimaanReturnPembelian
 */
class TaPenerimaanReturnPembelianQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaPenerimaanReturnPembelian[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaPenerimaanReturnPembelian|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
