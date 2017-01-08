<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Emailmapping;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailmapping */
/* @var $form ActiveForm */
?>
<div class="tab-formmapping">
    <?= $form->field($model, "[{$model->emailarea_id}]target")->textarea() ?>
    <?= $form->field($model, "[{$model->emailarea_id}]locked")->checkbox() ?>
    <div class="form-group">
        <label class="control-label">Zieladressen</label>
        <p class="form-control-static"><?=Html::encode($model->resolvedtarget)?></p>
    </div>
    <?= ''//$form->field($model, "[{$model->emailarea_id}]preferredemailaddress") ?>
    <?= ''//$form->field($model, "[{$model->emailarea_id}]targetformula") ?>
    <?= ''//$form->field($model, "[{$model->emailarea_id}]senderbcc") ?>
</div>

