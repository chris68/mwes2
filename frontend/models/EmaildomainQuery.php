<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * Defines the query and scope functions
 */
class EmaildomainQuery extends ActiveQuery
{
	/**
	 * Scope for the owner
	 */
	public function ownerScope()
	{
		$this->andWhere("{{%emaildomain}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
		return $this;
	}

	/**
	 * Email domains which the current user may use to link email entities to
	 */
	public function linkScope()
	{
		$this->andWhere("({{%emaildomain}}.owner_id = :owner or {{%emaildomain}}.id = 0)", [':owner' => \Yii::$app->user->id]);
		return $this;
	}
}
