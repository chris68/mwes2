<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */

$this->title = 'Adresse anlegen';
$this->params['breadcrumbs'][] = ['label' => 'Adressen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emailentity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pjax' => FALSE,
    ]) ?>

</div>
