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
 * @property boolean $stickyownership Are all entities in the domain forced to the same ownership as the mothering domain (not used yet)
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

            // Not yet used
            //[['stickyownership'], 'boolean'],
            //[['stickyownership'], 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            [['name'], 'required'],
            [['name'], 'match', 'pattern' => '/^([a-z0-9][a-z0-9_-]+)$/i', 'message' => 'Der Name darf nur aus ASCII-Zeichen (ohne Umlaute, etc.) und Ziffern sowie Unterstrichen oder Gedankenstrichen als Trenner bestehen' ], // the i for case independent is needed for the client check where the lower case is not done yet!
            [['name'], 'unique'],
            [['name'], 'validateDomainnamechange'],
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
     * @inheritdoc
     */
    public static function find()
    {
        return new EmaildomainQuery(get_called_class());
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        if (isset(Yii::$app->user)) {
            return [
                'EnsureOwnership' => [
                    'class' => 'common\behaviors\EnsureOwnership',
                    'ownerAttribute' => 'owner_id',
                    'ensureOnFind' => false, // todo Currently we cannot assure it on find since that would block access to the global domain!
                ],
            ];
        } else {
            return [];
        }
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
     * @return string The resolved domain name like e.g. 'ct'
     */
    public function getResolvedDomainname()
    {
        if ($this->id === 0) {
            return '';
        } else {
            return $this->name.'.';
        }
    }
    /**
     * Validator to check if a change of the domain name is valid
     */
    public function validateDomainnamechange($attribute, $params)
    {
        if (!$this->isNewRecord && count($this->getDirtyAttributes(['name']))!==0 ) {
            if (count($this->emailentities) !== 0) {
                $this->addError('name', "Sie dürfen den Namen nur ändern, wenn das Adressbuch leer ist");
            }
        }
    }

    /**
     * Normalizes a telephone number to the default access code given via the tag 'tel-access' in the domain
     * @param string $tel The input tel no
     * @return string The normalized tel no
     */
    public function normalizeTel($tel) {
        $tel = trim($tel);
        preg_replace_callback(
            '/tel-access:\+([0-9]*)([ -\/])([0-9]*)([ -\/])/',
            function ($match) use(&$tel) {
                switch (substr($tel,0,1)) {
                    case '+':
                        break;
                    case '0': $tel='+'.$match[1].$match[2].substr($tel,1,100);
                        break;
                    default: $tel='+'.$match[1].$match[2].$match[3].$match[4].$tel;
                        break;
                }
                
            },
            $this->description,
            1
        );

        return $tel;
    }

}
