<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[RefDistributor]].
 *
 * @see RefDistributor
 */
class RefDistributorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RefDistributor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RefDistributor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
