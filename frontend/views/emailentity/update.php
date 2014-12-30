<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */

$this->title = 'Adresse bearbeiten';
$this->params['breadcrumbs'][] = 'Adressen';
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'emailentity-update';
?>
<div class="emailentity-update">

    <?= $this->render('_form', [
        'model' => $model,
        'pjax' => FALSE,
    ]) ?>

</div>
