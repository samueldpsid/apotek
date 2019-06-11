<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[RefKategori]].
 *
 * @see RefKategori
 */
class RefKategoriQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RefKategori[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RefKategori|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
