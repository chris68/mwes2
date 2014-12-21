<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emaildomain */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Adressbuchverwaltung', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emaildomain-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::encode($model->description) ?>
    </p>

    <p>
        <?= Html::a('Verwalten', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Löschen', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Sind sie sich wirklich sicher, dass Sie das Adressbuch löschen wollen?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
