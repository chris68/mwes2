<?php

namespace frontend\models;

use Yii;
use common\models\User;
use frontend\models\Emaildomain;

/**
 * This is the model class for table "{{%emailentity}}".
 *
 * @property integer $id
 * @property integer $emaildomain_id
 * @property string $name
 * @property string $sortname
 * @property string $comment
 * @property integer $owner_id
 *
 * @property Emaildomain $emaildomain
 * @property User $owner
 */
class Emailentity extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%emailentity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emaildomain_id', 'owner_id'], 'integer'],
            [['emaildomain_id', 'owner_id'], 'default', 'value' => NULL],
            [['emaildomain_id', 'owner_id'], 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['emaildomain_id', 'name', 'sortname'], 'required'],
            [['name', 'sortname', 'comment'], 'string'],
            [['name'], 'match', 'pattern' => '/^([a-z0-9][a-z0-9._-]+)$/i', 'message' => 'Der Emailname darf nur aus ASCII-Zeichen (ohne Umlaute, etc.), Ziffern und Punkten,Unterstrichen oder Gedankenstrichen als Trenner bestehen' ], // the i for case independent is needed for the client check where the lower case is not done yet!
            [['emaildomain_id', 'name'], 'unique', 'targetAttribute' => ['emaildomain_id', 'name'], 'message' => 'Der gewählte Emailname wird in dem Adressbuch bereits genutzt'],
            [['emaildomain_id'], 'exist', 'targetAttribute' => 'id', 'targetClass' => Emaildomain::className()],
			[['emaildomain_id'], 
				'exist', 'targetAttribute' => 'id', 'targetClass' => Emaildomain::className(), 
				'filter' => function ($query) {return $query->linkScope();}, 
				'message' => 'Sie dürfen keine Emailnamen in dem Adressbuch anlegen'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emaildomain_id' => 'Adressbuch',
            'name' => 'Emailname',
            'sortname' => 'Sprechender Name',
            'comment' => 'Kommentar',
            'owner_id' => 'Owner ID',
        ];
    }

	/**
	 * {@inheritdoc}
	 */
    public static function find()
    {
        return new EmailentityQuery(get_called_class());
    }
	
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'EnsureOwnership' => [
				'class' => 'common\behaviors\EnsureOwnership',
				'ownerAttribute' => 'owner_id',
				'ensureOnFind' => true,
			],
		];
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmaildomain()
    {
        return $this->hasOne(Emaildomain::className(), ['id' => 'emaildomain_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return string The complete email name like e.g. 'chris@ct.mailwitch.com'
     */
    public function getCompleteEmailname()
    {
		if (isset($this->emaildomain)) {
			return $this->name.'@'.$this->emaildomain->getCompleteDomainname();
		} else {
			// If the email domain is not set yet 
			return $this->name.'@?.mailwitch.com';
		}
    }

	
}
