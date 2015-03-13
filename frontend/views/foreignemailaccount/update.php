<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Emailmapping;

/* @var $this yii\web\View */
/* @var $model frontend\models\Foreignemailaccount */

$this->title = 'Absenderadresse &lt;'. Html::encode($model->emailaddress).'&gt; bearbeiten';
$this->params['breadcrumbs'][] = ['label' => 'Absenderadressen', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Absenderadresse bearbeiten';
?>
<div class="foreignemailaccount-update">

    <p class="lead"><?= $this->title ?></p>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'senderalias_id')->dropDownList(['' => '(nicht gesetzt)']+ArrayHelper::map(Emailmapping::find()->ownerScope(0)->orderBy('resolvedaddress')->all(),'id','resolvedaddress')) ?>

    <div class="form-group">
        <?= Html::submitButton('Aktualisieren', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
