<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use frontend\models\Emaildomain;

/* @var $this yii\web\View */
/* @var $model frontend\models\EmailentitySearch */
?>

<?php 
    /* @var $form yii\bootstrap\ActiveForm */
    $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'id' => 'search_form',
]); 
?>

    <?= $form->field($model, 'sortname') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'comment') ?>

    <?= $form->field($model, 'emaildomain_id')->dropDownList(['' => 'Alle Adressen']+[0 => 'Globale Adressen']+ArrayHelper::map(Emaildomain::find()->ownerScope()->orderBy('name')->all(),'id','name')) ?>

    <?= '' // $form->field($model, 'id') ?>

    <?= '' // $form->field($model, 'owner_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Zurücksetzen', ['class' => 'btn btn-default']) ?>
    </div>

<?php
    ActiveForm::end();
?>