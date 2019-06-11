<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[RefObat]].
 *
 * @see RefObat
 */
class RefObatQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RefObat[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RefObat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
