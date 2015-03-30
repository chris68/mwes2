<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */
/* @var $pjax boolean Shall the page be rendered using pjax? */
?>

<?php 
    if ($pjax) {
        Pjax::begin(['id' => 'item_'.$model->id, 'enablePushState' => FALSE, ]);
    }
?>
<div style="min-height: 12vh">
    <div class="row">
        <div class="col-xs-12">
            <span class="lead"><?= Html::encode($model->sortname)?></span>
            <span style="font-weight: bold">&lt;<?= Html::encode($model->getCompleteEmailname())?>&gt;</span>
            <span class="pull-right">
                <?= Html::a('', ['emailentity/view', 'id' => $model->id], ['class' => 'btn btn-sm btn-default glyphicon glyphicon-remove']) ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-offset-1 col-xs-11">
            <div class="form-group">
                <?= Html::a('Löschen', ['delete', 'id' => $model->id, 'confirmed' => true, ], ['class' => 'btn btn-danger']) ?>
                <?= Html::a('Doch nicht löschen', ['emailentity/view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            </div>
            <div id ="pjax-notification-sending" style="display: none" class="alert alert-info">Die Änderungen werden zum Server geschickt. Das sollte nur kurze Zeit dauern. Wenn es Probleme gibt, dann kommt eine Fehlermeldung</div>
            <div id ="pjax-notification-error" style="display: none" class="alert alert-danger"></div>
        </div>
    </div>
</div>
<?php 
    if ($pjax) {
        Pjax::end();
    }
?>
