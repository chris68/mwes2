<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use yii\widgets\Pjax;
use frontend\models\Emaildomain;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */
/* @var $pjax boolean Shall the page be rendered using pjax? */
?>

<?php 
    if ($pjax) {
        Pjax::begin(['id' => 'item_'.($model->isNewRecord?'new':$model->id), 'enablePushState' => FALSE, ]);
    }
/* @var $form yii\bootstrap\ActiveForm */
    $form = ActiveForm::begin(['action' => $model->isNewRecord ? ['emailentity/create'] : ['emailentity/update', 'id' => $model->id] , 'options' => ['data-pjax' => true ], 'enableClientValidation' => false]);
?>
<div style="min-height: 12vh">
    <div class="row">
        <div class="col col-xs-12">
            <div>
                <?php if ($model->isNewRecord) : ?>
                <span class="lead">Neuer Eintrag</span>
                <?php else : ?>
                <span class="lead"><?= Html::encode(Html::encode($model->sortname))?></span>
                <span style="font-weight: bold">&lt;<?= Html::encode(Html::encode($model->getCompleteEmailname()))?>&gt;</span>
                <?php endif; ?>
                <span class="pull-right">
                    <?= Html::a('', $model->isNewRecord?['emailentity/empty']:['emailentity/view', 'id' => $model->id], ['class' => 'btn btn-sm btn-default glyphicon glyphicon-remove']) ?>
                    <?= Html::submitButton('', ['class' => 'btn btn-sm btn-primary glyphicon glyphicon-save']) ?>
                </span>
                <?= $form->errorSummary(array_merge(['' => $model],$model->x_emailmappings)) ?>
                <div id ="pjax-notification-sending" style="display: none" class="alert alert-info">Die Änderungen werden zum Server geschickt. Das sollte nur kurze Zeit dauern. Wenn es Probleme gibt, dann kommt eine Fehlermeldung</div>
                <div id ="pjax-notification-error" style="display: none" class="alert alert-danger"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-11 col-xs-offset-1">
            <fieldset>
            <legend>Stammdaten</legend>
            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'sortname')->textInput() ?>
            </fieldset>
            <fieldset>
            <legend>Kommentare, Adressen, Telefonnummern</legend>
            <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>
            </fieldset>
            <fieldset>
            <legend>Adressumleitungen</legend>
            <?php
            if(isset($model->emailmappings)) {
                $items = [];
                foreach ($model->x_emailmappings as $mapping) {
                    $items[$mapping->emailarea_id] = [
                        'label' => ($mapping->isActive()?($mapping->locked?'<s>':'<strong>'):'(').$mapping->emailarea->name.($mapping->isActive()?($mapping->locked?'</s>':'</strong>'):')'),
                        'encode' => false,
                        'content' => $this->render('_formmapping', array('model'=>$mapping, 'form'=> $form)),
                    ];
                }
                echo Tabs::widget(
                [
                    'items' => $items,
                    'navType' => 'nav-pills',
                    'itemOptions' => [
                        'style' => 'margin:15px',
                    ]
                ]);
            }

            ?>
            </fieldset>
            <fieldset>
            <legend>Admin</legend>
            <?= $form->field($model, 'emaildomain_id')->dropDownList(['' => '(nicht gesetzt)']+[0 => 'Globale Adressen']+ArrayHelper::map(Emaildomain::find()->ownerScope()->orderBy('name')->all(),'id','name')) ?>
            <?= '' // $form->field($model, 'owner_id')->textInput() ?>
            </fieldset>
        </div>
    </div>
</div>

<?php 
    ActiveForm::end();
    if ($pjax) {
        Pjax::end();
    }
?>
