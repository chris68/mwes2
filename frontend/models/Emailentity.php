<?php

namespace frontend\models;

use Yii;
use common\models\User;
use frontend\models\Emaildomain;
use frontend\models\Emailarea;

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
 * @property Emailmapping[] $emailmappings
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

    public function formName()
    {
        return parent::formName().'_'.(isset($this->id)?$this->id:'new');
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
            [['emaildomain_id', 'name', ], 'required'],
            [['name', 'sortname', 'comment'], 'string'],
            [['name', 'sortname', 'comment'], 'trim'],
            [['name'], 'filter', 'filter' => 'mb_strtolower', 'skipOnEmpty' => true],
            [['name'], 'match', 'pattern' => '/^([a-z0-9][a-z0-9._-]+)$/i', 'message' => 'Der Emailname darf nur aus ASCII-Zeichen (ohne Umlaute, etc.) und Ziffern sowie Punkten, Unterstrichen oder Gedankenstrichen als Trenner bestehen' ], // the i for case independent is needed for the client check where the lower case is not done yet!
            [['name'], 'match', 'pattern' => '/^.*\\.(main|home|work|extra1|extra2|extra3|all)$/i', 'not' => true, 'message' => 'Der Emailname darf nicht mit .main, .home, .work, .extra1, .extra2, .extra3 oder .all enden' ], // the i for case independent is needed for the client check where the lower case is not done yet!
            [['emaildomain_id', 'name'], 'unique', 'targetAttribute' => ['emaildomain_id', 'name'], 'message' => 'Der gewählte Emailname wird in dem Adressbuch bereits genutzt'],
            [['emaildomain_id'], 'exist', 'targetAttribute' => 'id', 'targetClass' => Emaildomain::className()],
            [['emaildomain_id'], 
                'exist', 'targetAttribute' => 'id', 'targetClass' => Emaildomain::className(), 
                'filter' => function ($query) {return $query->linkScope();}, 
                'message' => 'Sie dürfen keine Emailnamen in dem Adressbuch anlegen',
                'when' => function($model) { return isset(Yii::$app->user); }, // Check only if user component in use!
            ]
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
     * @inheritdoc
     */
    public static function find()
    {
        return new EmailentityQuery(get_called_class());
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
                    'ensureOnFind' => true,
                ],
            ];
        } else {
            return [];
        }
    }

    /**
     * Prepare the model for form exchange by adding the areas which do not exist yet
     * This will override the population of the relation 'emailmappings'
     */
    function prepareExchange() {
        if (!$this->isNewRecord) {
            $emailmappings = $this->getEmailmappings()->findFor('emailentities', $this);
            
            // Build up a new model for each mapping as a container for one new sasl account per mapping
            // Actually one could create further (and not only one) new records via this pattern!
            foreach ($emailmappings as $mapping) {
                // Get the existing saslaccounts
                $saslaccounts = $mapping->getSaslaccounts()->findFor('saslaccounts', $mapping);
                
                // Create a new one 
                $new_account = new Saslaccount();
                // Label it with a negative id as indicator for a newly created record (id will be unset on save)
                $new_account->id = -1; // First new record; use -2, -3 for further new records
                // Link it to the mapping
                $new_account->senderalias_id = $mapping->id;
                // Prefill with random unhashed token
                $new_account->token_unhashed = Yii::$app->getSecurity()->generateRandomString(32);
                // Make sure that also the backlink points to the correct mapping
                $new_account->populateRelation('senderalias',$mapping);
                // Add the new record under its (nagative) id to the existing records
                $saslaccounts[$new_account->id] = $new_account;

                ksort($saslaccounts);

                // And then hard set the relation saslaccounts 
                $mapping->populateRelation('saslaccounts', $saslaccounts);
            }
        } else {
            $emailmappings = [];
        }
        
        foreach (Emailarea::find()->where('id < 255')->all() as $emailarea) {
            if (!isset($emailmappings[$emailarea->id])) {
                $item = new Emailmapping();
                $item->emailentity_id = $this->id;
                $item->emailarea_id = $emailarea->id;

               $emailmappings[$emailarea->id] = $item;
            }

            // Make sure that the backlink always points to the correct and same object!
            $emailmappings[$emailarea->id]->populateRelation('emailentity',$this);
        }

        ksort($emailmappings);
        $this->populateRelation('emailmappings', $emailmappings);
    }

    private function _adjustInternalMappings() {
        // Delete the existing system generated mappings (all have id >= 255)
        Emailmapping::deleteAll(['and', ['=', 'emailentity_id', $this->id],['>=', 'emailarea_id', 255]]);

        // Generate the all mapping
        $all_mapping = new Emailmapping();
        $all_mapping->emailarea_id = 255;
        $all_mapping->emailentity_id = $this->id;
        $all_mapping->isvirtual = true;
        $all_mapping->target = '';
        $all_mapping->resolvedtarget = '';

        foreach ($this->emailmappings as $mapping) {
            if ($mapping->isActive() && !$mapping->locked) {
                $all_mapping->target .= ('+'.$mapping->emailarea->name.', ');
                $all_mapping->resolvedtarget .= ($mapping->resolvedaddress.', ');
            }
        }
        $all_mapping->save(false);
    }

    function saveDeep($runValidation = true, $attributeNames = null)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $res = parent::save($runValidation, $attributeNames);
            foreach ($this->emailmappings as $mapping) {
                if ($mapping->isActive()) {
                    if ($mapping->isNewRecord) {
                        $mapping->emailentity_id = $this->id;
                    }
                    $res = min($res,$mapping->save($runValidation));
                    
                    foreach ($mapping->saslaccounts as $account) {
                        if ($account->accesshint <> '') {
                            $res = min($res,$account->save($runValidation));
                        } else {
                            if (!$account->isNewRecord) {
                                $account->delete();
                            }
                        }
                        
                    }
                    
                } else {
                    $mapping->delete();
                }
            }
            $this->_adjustInternalMappings();
            if ($res) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            $res = false;
        }
        return $res;
    }

    function loadDeep($data, $formName = null)
    {
        $res = $this->load($data, $formName);
        if (isset($this->emailmappings)) {
            $res = min($res,\yii\base\Model::loadMultiple($this->emailmappings, $data));
        }
        foreach ($this->emailmappings as $mapping) {
            if (isset($mapping->saslaccounts) && count($mapping->saslaccounts)>0) {
                $res = min($res,\yii\base\Model::loadMultiple($mapping->saslaccounts, $data));
            }
        }
        return $res;
    }

    function validateDeep($attributeNames = null, $clearErrors = true)
    {
        $res = $this->validate($attributeNames, $clearErrors);
        if (isset($this->emailmappings)) {
            $res = min($res,\yii\base\Model::validateMultiple($this->emailmappings));
        }
        foreach ($this->emailmappings as $mapping) {
            if (isset($mapping->saslaccounts)) {
                $res = min($res,\yii\base\Model::validateMultiple($mapping->saslaccounts));
            }
        }
        return $res;
    }

    /**
     * Get the mappings relevant for display and entry (i.e. only the one below 255)
     * Index the resulting array by the area id (for faster access)
     *
     * @return \yii\db\ActiveQuery 
     */
    public function getEmailmappings()
    {
        return $this->hasMany(Emailmapping::className(), ['emailentity_id' => 'id'])->where('{{%emailmapping}}.emailarea_id < 255')->orderBy('{{%emailmapping}}.emailarea_id')->indexBy('emailarea_id');
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
        return $this->name.'@'.$this->getCompleteDomainname();
    }

    /**
     * @return string The complete domain name like e.g. 'ct.mailwitch.com'. Handles situation where domain is null
     */
    public function getCompleteDomainname()
    {
        return ($this->emaildomain !== null)?$this->emaildomain->getCompleteDomainname():'?.mailwitch.com';
    }

    
}
