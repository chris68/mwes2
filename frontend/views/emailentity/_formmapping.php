<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Emailmapping;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailmapping */
/* @var $form ActiveForm */
?>
<div class="tab-formmapping">
    <div class="form-group">
        <label class="control-label">Adresse</label>
        <p class="form-control-static"><?=Html::encode($model->resolvedaddress)?></p>
    </div>
    <?= $form->field($model, "[{$model->emailarea_id}]target")->textarea() ?>
    <?= $form->field($model, "[{$model->emailarea_id}]locked")->checkbox() ?>
    <div class="form-group">
        <label class="control-label">Zieladressen</label>
        <p class="form-control-static"><?=Html::encode($model->resolvedtarget)?></p>
    </div>
    <div class="form-group">
        <label class="control-label">Senderfreigaben</label>
        <?php
            $items = [];
            foreach ($model->saslaccounts as $account) {
                $items[$account->id] = [
                    'label' => $account->isNewRecord?'(neuer Zugriff)':$account->accesshint,
                    'encode' => true,
                    'content' => $this->render('_formaccount', array('model'=>$account, 'form'=> $form)),
                ];
            }
            echo Tabs::widget(
            [
                'items' => $items,
                'navType' => 'nav-tabs',
                'itemOptions' => [
                    'style' => 'margin:15px',
                ]
            ]);
        ?>
    </div>
    <?= ''//$form->field($model, "[{$model->emailarea_id}]preferredemailaddress") ?>
    <?= ''//$form->field($model, "[{$model->emailarea_id}]targetformula") ?>
    <?= ''//$form->field($model, "[{$model->emailarea_id}]senderbcc") ?>
</div>

