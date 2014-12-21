<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Emaildomain */

$this->title = 'Anlegen eines neuen Adressbuchs';
$this->params['breadcrumbs'][] = ['label' => 'Adressbuchverwaltung', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emaildomain-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
