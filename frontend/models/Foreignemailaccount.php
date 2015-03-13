<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%foreignemailaccount}}".
 *
 * @property integer $id
 * @property string $emailaddress
 * @property integer $confirmation_level
 * @property integer $owner_id
 * @property integer $senderalias_id
 * @property string $confirmation_token
 *
 * @property User $owner
 * @property Emailmapping $senderalias
 */
class Foreignemailaccount extends \yii\db\ActiveRecord
{
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CONFIRM = 'confirm';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%foreignemailaccount}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['emailaddress', 'filter', 'filter' => 'trim', 'on' => self::SCENARIO_REGISTER],
            ['emailaddress', 'required', 'on' => self::SCENARIO_REGISTER],
            ['emailaddress', 'email', 'on' => self::SCENARIO_REGISTER],
            ['emailaddress',
                'unique', 'targetAttribute' => 'emailaddress', 'targetClass' => Foreignemailaccount::className(),
                'filter' => function ($query) {return $query->ownerScope();},
                'message' => 'Die Emailaddresse wurde bereits registriert',
                'on' => self::SCENARIO_REGISTER,
            ],
                    
            ['senderalias_id', 'integer', 'on' => self::SCENARIO_UPDATE,],
            ['senderalias_id',
                'exist', 'targetAttribute' => 'id', 'targetClass' => Emailmapping::className(),
                'filter' => function ($query) {return $query->ownerScope(0);},
                'message' => 'Eine Umleitung auf diese Addresse ist nicht erlaubt',
                'on' => self::SCENARIO_UPDATE,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emailaddress' => 'Externe Emailaddresse',
            'owner_id' => 'Eigner',
            'senderalias_id' => 'Absenderumleitung',
            'confirmation_token' => 'Bestätigungstoken',
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_CONFIRM => self::OP_UPDATE,
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return parent::scenarios() + [
            self::SCENARIO_CONFIRM => [],
        ];
    }

    /**
     * @inheritdoc
     */

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            $this->confirmation_level = Yii::$app->user->identity->getId();
        }
        return parent::save($runValidation, $attributeNames);
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new ForeignemailaccountQuery(get_called_class());
    }

    /**
     * @inheritdoc
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
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSenderalias()
    {
        return $this->hasOne(Emailmapping::className(), ['id' => 'senderalias_id']);
    }

    /**
     * Finds out if confirmation token is valid
     *
     * @param string $token Confirmation token
     * @return boolean
     */
    public static function isConfirmationTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = 3600;
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * Generates new confirmation token
     */
    public function generateConfirmationToken()
    {
        $this->confirmation_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes confirmation token
     */
    public function removeConfirmationToken()
    {
        $this->confirmation_token = null;
    }

    /**
     * Confirms an email,
     *
     * @param string $token Confirmation token
     * @return boolean Returns true if sucessful
     */
    public function confirm($token)
    {
        if ($this->isConfirmationTokenValid($token) && $this->confirmation_token === $token) {
            $this->confirmation_level = 0;
            $this->removeConfirmationToken();
            // this handler is an anonymous function
            $this->on(self::EVENT_BEFORE_UPDATE, function ($event) {
                // Delete possibly existing other records for the same email address with confirmation level 0
                self::deleteAll('emailaddress=:e and confirmation_level = 0',[':e' => $this->emailaddress]);
            });
            return true;
        } else {
            return false;
        }
    }

}
