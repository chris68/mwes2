<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EmaildomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adressbuchverwaltung';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emaildomain-index">

    <p>
        <?= Html::a('Neues Adressbuch anlegen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]) ?>

</div>
