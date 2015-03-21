<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%userlog}}".
 *
 * @property integer $id
 * @property string $ts
 * @property string $event
 * @property string $log
 * @property integer $owner_id
 *
 * @property User $owner
 */
class Userlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%userlog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ts' => 'Zeitpunkt',
            'event' => 'Ereignis',
            'log' => 'Logging-Details',
            'owner_id' => 'Nutzer',
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
     * Create a log entry
     * @param type $event The event
     * @param type $log The log message
     * @param type $user The user; if null the currently logged in user will be taken
     */
    public static function log($event, $log, $user = NULL)
    {
        $userlog = new Userlog();
        
        if ($user === NULL) {
            $user = Yii::$app->getUser()->getIdentity()->getId();
        }

        $userlog->owner_id = $user;
        $userlog->ts = new \yii\db\Expression ('NOW()');
        $userlog->event = $event;
        $userlog->log = $log;
        $userlog->save();
    }
}
