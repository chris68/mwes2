<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emaildomain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emaildomain-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>
    
    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->hint('Hier können sie mit <b>tel-access:</b> die Standardvorwahl mit internationalem Zugangscode (via +<i>Ländervorwahl</i>) und ihren gewohnten Trennzeichen definieren.<br/>Erlaubte Trennzeichen sind "-", "/" oder " ", also z.B. tel-access:+49-721- oder tel-access:+49 721/<br/>Sie können es übrigens hier gleich mit Telefonnummer ausprobieren, weil der Mecahnismus auch hier implementiert ist.') ?>

    <?= '' // $form->field($model, 'owner_id')->textInput() ?>

    <?= '' // $form->field($model, 'stickyownership')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
