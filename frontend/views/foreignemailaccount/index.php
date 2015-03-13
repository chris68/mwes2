<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Absenderaddressen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foreignemailaccount-index">

    <p>
        <?= Html::a('Neue Absenderadresse registrieren', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'layout' => "{summary}\n{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_view', ['model' => $model, ]);
        },
    ]) ?>

</div>
