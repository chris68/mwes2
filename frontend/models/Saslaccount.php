<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%foreignemailaccount}}".
 *
 * @property integer $id
 * @property string $accesshint
 * @property integer $senderalias_id
 * @property string $token_unhashed
 * @property string $token_sha512
 *
 * @property Emailmapping $senderalias
 */
class Saslaccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%saslaccount}}';
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        // The senderalias backlink make the forms sufficently unique
        // No new vs. existing id necessary since the senderalias will always be set
        return parent::formName().'_'.$this->senderalias_id;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['accesshint', 'trim'],
            ['accesshint', 'default'],
            ['token_unhashed', 'trim'],
            ['token_unhashed', 'default'],
            ['token_unhashed', 'string', 'length' => [32]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Eigner',
            'senderalias_id' => 'Addresse',
            'accesshint' => 'Zugriff',
            'token_unhashed' => 'Passwort/Zugangstoken',
            'token_sha512' => 'Passwort/Zugangstoken (hashed)',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new SaslaccountQuery(get_called_class());
    }

    /**
     * @inheritdoc
     * Delete existing id's if the record is new to cope with multiple megative pseudo ids of newly created objects
     */
    function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            unset($this->id);
        }
        return parent::save($runValidation, $attributeNames);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSenderalias()
    {
        return $this->hasOne(Emailmapping::className(), ['id' => 'senderalias_id']);
    }

}
