<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "{{%emaildomain}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $owner_id
 * @property boolean $stickyownership
 * @property string $description
 *
 * @property User $owner
 * @property Emailentity[] $emailentities
 */
class Emaildomain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%emaildomain}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            [['name'], 'filter', 'filter' => 'mb_strtolower', 'skipOnEmpty' => true],
            [['owner_id'], 'integer'],
            [['owner_id'], 'default', 'value' => NULL],
            [['owner_id'], 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['stickyownership'], 'boolean'],
            [['stickyownership'], 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],
            [['name'], 'required'],
            [['name'], 'match', 'pattern' => '/^([a-z0-9][a-z0-9_-]+)$/i', 'message' => 'Der Name darf nur aus ASCII-Zeichen (ohne Umlaute, etc.), Ziffern und Unterstrichen oder Gedankenstrichen als Trenner bestehen' ], // the i for case independent is needed for the client check where the lower case is not done yet!
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'owner_id' => 'Owner ID',
            'stickyownership' => 'Stickyownership',
            'description' => 'Beschreibung',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function find()
    {
        return new EmaildomainQuery(get_called_class());
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
                'ensureOnFind' => false, // todo Currently we cannot assure it one find since that would block access to the global domain!
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailentities()
    {
        return $this->hasMany(Emailentity::className(), ['emaildomain_id' => 'id']);
    }
    
    /**
     * @return string The complete domain name like e.g. 'ct.mailwitch.com'
     */
    public function getCompleteDomainname()
    {
        return $this->getResolvedDomainname().'mailwitch.com';
    }
    
    /**
     * @return string The resolved domain name like e.g. 'ct.mailwitch.com'
     */
    public function getResolvedDomainname()
    {
        if ($this->id === 0) {
            return '';
        } else {
            return $this->name.'.';
        }
    }
}
