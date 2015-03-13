<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%emailmapping}}".
 *
 * @property integer $id
 * @property integer $emailentity_id
 * @property integer $emailarea_id
 * @property string $resolvedaddress The calculated resolved email address (e.g. chris+work@cs.mailwitch.com)
 * @property string $target The list of email addresses in the target with all the surrounding text like e.g. Max Mustermann <max.mustermann@gmail.com>; also the short form like .main, +work, and just max.mustermann is supported here
 * @property string $resolvedtarget The calculated resolved list of just the email addresses (fully qualified) without any surronding text
 * @property string $preferredemailaddress  For future use with http://www.postfix.org/relocated.5.html (not used yet)
 * @property string $targetformula Formula to automatically calculate the target (not used yet)
 * @property string $senderbcc For future use with http://www.postfix.org/postconf.5.html#sender_bcc_maps (not used yet)
 * @property boolean $locked If true the mapping is no longer available
 * @property boolean $isvirtual If false then the list of emailaddresses contains just one entry and is then a canonical header rewriting mapping in postfix
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
            [['target', ], 'string'],
            [['target', ], 'trim'],

            // Not used yet
            //[['preferredemailaddress', 'targetformula', 'senderbcc'], 'string'],
            //[['preferredemailaddress', 'targetformula', 'senderbcc'], 'trim'],
            //[['targetformula'], 'default', 'value' => null],

            [['locked'], 'boolean', ],
            [['locked'], 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            [['target'], 'resolveTargetEmailList', ],
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
     * @inheritdoc
     */
    public static function find()
    {
        return new EmailmappingQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    function save($runValidation = true, $attributeNames = null)
    {
        $this->setResolvedaddress($this->getResolvedaddress());
        return parent::save($runValidation, $attributeNames);
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

    public function getResolvedaddress() {
        return $this->emailentity->name.$this->emailarea->resolvedname.'@'.$this->emailentity->getCompleteDomainname();
    }

    public function setResolvedaddress($value) {
        $this->setAttribute('resolvedaddress', $value);
    }

    /**
     * Validator to check if the comma separated list of email adresses in target is valid
     * Also fills in resolvedtarget and isvirtual
     */
    public function resolveTargetEmailList($attribute, $params)
    {
        $items = array_map('trim',str_getcsv($this->target));
        $this->isvirtual = (count($items) !== 1);
        $resolveditems = [];
        foreach ($items as $i => $item) {
            if (mb_substr($item,-1) === '>') {
                // An email enclosed in angle brackets
                $p = mb_strrpos($item,'<');
                if ($p === false) {
                    $this->addError('target', "Der Addressteil '$item' ist überhaupt nicht korrekt aufgebaut");
                    $resolveditems[$i] = '???';
                } else {
                    $resolveditems[$i] = trim(mb_substr($item,$p+1,mb_strlen($item)-$p-2));
                }
            } else {
                $resolveditems[$i] = $item;
            }

            if (mb_strpos($resolveditems[$i],'.') === 0) {
                if (count($this->emailentity->getErrors('name')) === 0) {
                    $resolveditems[$i] = $this->emailentity->name.$resolveditems[$i];
                } else {
                    $this->addError('target', "Kurzadressen wie '.work', '.home', etc. können erst gewandelt und geprüft werden, nachdem der Emailname korrekt gesetzt wurde");
                }
            } elseif (mb_strpos($resolveditems[$i],'+') === 0) {
                if (count($this->emailentity->getErrors('name')) === 0) {
                    $resolveditems[$i] = $this->emailentity->name.$resolveditems[$i];
                } else {
                    $this->addError('target', "Kurzadressen wie '+work', '+home', etc. können erst gewandelt und geprüft werden, nachdem der Emailname korrekt gesetzt wurde");
                }
            }

            if ($resolveditems[$i] !== '') {
                if (mb_strpos($resolveditems[$i],'@') === false) {
                    if (count($this->emailentity->getErrors('emaildomain_id')) === 0) {
                        $resolveditems[$i] = $resolveditems[$i].'@'.$this->emailentity->getCompleteDomainname();
                    } else {
                        $this->addError('target', "Rumpfadressen (ohne @) können erst gewandelt und geprüft werden, nachdem das Adressbuch korrekt gesetzt wurde");
                    }
                }

                $email = filter_var($resolveditems[$i], FILTER_VALIDATE_EMAIL);
                if ($email === false) {
                    $this->addError('target', "Die Emailadresse '{$resolveditems[$i]}' ist nicht korrekt aufgebaut");
                    $resolveditems[$i] = '<???>';
                } else {
                    $resolveditems[$i] = $email;
                }
            }
        }
        $this->resolvedtarget = mb_strtolower(implode(', ', $resolveditems));
    }

}
