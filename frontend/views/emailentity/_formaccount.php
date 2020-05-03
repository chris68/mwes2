<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Emailmapping;
use yii\base\Security;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model frontend\models\Saslaccount */
/* @var $form ActiveForm */
?>
<div class="tab-formaccount">
    <?= $form->field($model, "[{$model->id}]accesshint")->textInput() ?>
    <?= $form->field($model, "[{$model->id}]token_unhashed")->textInput() ?>
</div>
