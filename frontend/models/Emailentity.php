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
 * @property Emailmapping[] $emailmappings
 * @property Emaildomain $emaildomain
 * @property User $owner
 */
class Emailentity extends \yii\db\ActiveRecord
{
    /**
     *
     * @var Emailmapping[]
     */
    public $x_emailmappings;

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
            [['emaildomain_id', 'name', 'sortname'], 'required'],
            [['name', 'sortname', 'comment'], 'string'],
            [['name', 'sortname', 'comment'], 'trim'],
            [['name'], 'match', 'pattern' => '/^([a-z0-9][a-z0-9._-]+)$/i', 'message' => 'Der Emailname darf nur aus ASCII-Zeichen (ohne Umlaute, etc.) und Ziffern sowie Punkten, Unterstrichen oder Gedankenstrichen als Trenner bestehen' ], // the i for case independent is needed for the client check where the lower case is not done yet!
            [['name'], 'match', 'pattern' => '/^.*\\.(main|home|work|extra1|extra2|extra3|all)$/i', 'not' => true, 'message' => 'Der Emailname darf nicht mit .main, .home, .work, .extra1, .extra2, .extra3 oder .all enden' ], // the i for case independent is needed for the client check where the lower case is not done yet!
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

    function prepareExchange() {
        if (!$this->isNewRecord) {
            $this->x_emailmappings = Emailmapping::find()->where(['emailentity_id' => $this->id])->indexBy('emailarea_id')->all();
        } else {
            $this->x_emailmappings = [];
        }
        
        foreach (\frontend\models\Emailarea::find()->all() as $emailarea) {
            if (!isset($this->x_emailmappings[$emailarea->id])) {
                $item = new Emailmapping();
                $item->emailentity_id = $this->id;
                $item->emailarea_id = $emailarea->id;

               $this->x_emailmappings[$emailarea->id] = $item;
            }
            $this->x_emailmappings[$emailarea->id]->x_emailentity = $this;
        }

        ksort($this->x_emailmappings); unset($this->x_emailmappings[255]);
    }

    function save($runValidation = true, $attributeNames = null)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $res = parent::save($runValidation, $attributeNames);
            if (isset($this->x_emailmappings)) {
                foreach ($this->x_emailmappings as $x_mapping) {
                    //Yii::info(var_export($x_mapping,true));
                    if ($x_mapping->isActive()) {
                        if ($x_mapping->isNewRecord) {
                            $x_mapping->emailentity_id = $this->id;
                        }
                        $res = min($res,$x_mapping->save($runValidation));
                    } else {
                        $x_mapping->delete();
                    }
                }
            }
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

    function load($data, $formName = null)
    {
        $res = parent::load($data, $formName);
        if (isset($this->x_emailmappings)) {
            $res = min($res,\yii\base\Model::loadMultiple($this->x_emailmappings, $data));
        }
        return $res;
    }

    function validate($attributeNames = null, $clearErrors = true)
    {
        $res = parent::validate($attributeNames, $clearErrors);
        if (isset($this->x_emailmappings)) {
            $res = min($res,\yii\base\Model::validateMultiple($this->x_emailmappings));
        }
        return $res;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailmappings()
    {
        return $this->hasMany(Emailmapping::className(), ['emailentity_id' => 'id'])->orderBy('tbl_emailmapping.emailarea_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisplayemailmappings()
    {
        return $this->hasMany(Emailmapping::className(), ['emailentity_id' => 'id'])->where('tbl_emailmapping.emailarea_id <> 255')->orderBy('tbl_emailmapping.emailarea_id');
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
