<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model frontend\models\Foreignemailaccount */

$this->title = 'Neue Absenderadresse registrieren';
$this->params['breadcrumbs'][] = ['label' => 'Absenderadressen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foreignemailaccount-create">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emailaddress')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Registrieren', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
