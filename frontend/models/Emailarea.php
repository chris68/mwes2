<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%emailarea}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $resolvedname
 * @property string $description
 *
 */
class Emailarea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%emailarea}}';
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
            'name' => 'Name',
            'description' => 'Beschreibung',
        ];
    }
}
