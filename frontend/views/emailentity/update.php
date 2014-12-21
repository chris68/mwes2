<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */

$this->title = 'Adresse bearbeiten: ' . ' ' . $model->getCompleteEmailname();
$this->params['breadcrumbs'][] = ['label' => "<b>{$model->emaildomain->getResolvedDomainname()}</b>mailwitch.com", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Bearbeiten';
$this->params['help'] = 'emailentity-update';
?>
<div class="emailentity-update">

    <?= $this->render('_form', [
        'model' => $model,
		'pjax' => FALSE,
    ]) ?>

</div>
