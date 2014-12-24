<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Emailmapping;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailmapping */
/* @var $form ActiveForm */
?>
<div class="tab-formmapping">
    <?php
        if (isset($model->emailentity_id)) {
            $index = "[{$model->emailentity_id}][{$model->emailarea_id}]";
        } else {
            $index = "[new][{$model->emailarea_id}]";
        }
    ?>
    <?= $form->field($model, "[{$model->emailarea_id}]target") ?>
    <?= $form->field($model, "[{$model->emailarea_id}]locked")->checkbox() ?>
    <?= ''//$form->field($model, "[{$model->emailentity_id}][{$model->emailarea_id}]resolvedtarget") ?>
    <?= ''//$form->field($model, "[{$model->emailentity_id}][{$model->emailarea_id}]preferredemailaddress") ?>
    <?= ''//$form->field($model, "[{$model->emailentity_id}][{$model->emailarea_id}]targetformula") ?>
    <?= ''//$form->field($model, "[{$model->emailentity_id}][{$model->emailarea_id}]senderbcc") ?>
</div>
