<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\Foreignemailaccount */
?>

<div style="min-height: 12vh">
    <div class="row">
        <div class="col-xs-12">
            <span class="lead">
                <?php
                    echo Html::encode($model->emailaddress);
                    if($model->confirmation_level !== 0) {
                        echo ' <i>[Bestätigung steht noch aus!]</i>';
                    }
                 ?>
            </span>
            <span class="pull-right">
            <?php
                if ($model->confirmation_level !== 0) {
                    echo Html::a('<span class="glyphicon glyphicon-send"></span>', ['request-confirmation', 'id' => $model->id], ['title' => 'Bestätigungsmail nochmal versenden']);
                } else {
                    echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id], ['title' => 'Editieren']);
                }
            ?>
            &nbsp;
            <?= Html::a('<span class="glyphicon glyphicon-trash""></span>', ['delete', 'id' => $model->id], [
                'title' => 'Löschen',
                 'data' => [
                    'confirm' => 'Wollen Sie den Eintrag wirklich löschen?',
                    'method' => 'post',
                ],
            ]) ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-offset-1 col-xs-11">
            <?= ($model->senderalias === NULL)?'Keine Umleitung':('Umleitung auf '.Html::encode($model->senderalias->resolvedaddress)) ?>
        </div>
    </div>
</div>


