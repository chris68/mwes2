<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%emailmapping}}".
 *
 * @property integer $id
 * @property integer $emailentity_id
 * @property integer $emailarea_id
 * @property string $target
 * @property string $resolvedtarget
 * @property string $preferredemailaddress  Use with http://www.postfix.org/relocated.5.html
 * @property string $targetformula
 * @property string $senderbcc
 * @property boolean $locked
 * @property boolean $isvirtual
 *
 * @property Emailentity $emailentity
 * @property Emailarea $emailarea
 */
class Emailmapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%emailmapping}}';
    }

    public function formName()
    {
        return parent::formName().'_'.(isset($this->emailentity_id)?$this->emailentity_id:'new');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['target', 'preferredemailaddress', 'targetformula', 'senderbcc'], 'string'],
            [['target', 'preferredemailaddress', 'targetformula', 'senderbcc'], 'trim'],

            [['targetformula'], 'default', 'value' => null],

            [['locked'], 'boolean', ],
            [['locked'], 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emailentity_id' => 'Emailentity ID',
            'emailarea_id' => 'Emailarea ID',
            'target' => 'Ziel',
            'resolvedtarget' => 'Zieladressen',
            'preferredemailaddress' => 'Bevorzuge Emailadresse',
            'targetformula' => 'Zielformel',
            'senderbcc' => 'Senderbcc',
            'locked' => 'Umleitung sperren',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailentity()
    {
        return $this->hasOne(Emailentity::className(), ['id' => 'emailentity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailarea()
    {
        return $this->hasOne(Emailarea::className(), ['id' => 'emailarea_id']);
    }

    public function isActive() {
        return $this->target !== NULL && $this->target !== '';
    }
}
