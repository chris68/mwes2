<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * Defines the query and scope functions
 */
class EmailmappingQuery extends ActiveQuery
{
    /**
     * Scope for the owner in a certain domain
     */
    public function ownerScope($domain)
    {
            $this->andWhere("{{%emailmapping}}.emailentity_id in (select id from tbl_emailentity where owner_id = :owner and emaildomain_id = :domain)", [':owner' => \Yii::$app->user->id, ':domain' => $domain]);
        return $this;
    }
    
}
