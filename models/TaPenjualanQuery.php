<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TaPenjualan]].
 *
 * @see TaPenjualan
 */
class TaPenjualanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaPenjualan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaPenjualan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
