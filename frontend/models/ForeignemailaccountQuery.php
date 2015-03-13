<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * Defines the query and scope functions
 */
class ForeignemailaccountQuery extends ActiveQuery
{
    /**
     * Scope for the owner
     */
    public function ownerScope()
    {
        $this->andWhere("{{%foreignemailaccount}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
        return $this;
    }
    
}
