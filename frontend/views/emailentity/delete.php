<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */

$this->title = 'Adresse löschen';
$this->params['breadcrumbs'][] = 'Adressen';
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'emailentity-delete';

?>
<div class="emailentity-delete">

    <?= $this->render('_delete', [
        'model' => $model,
        'pjax' => FALSE,
    ]) ?>

</div>
