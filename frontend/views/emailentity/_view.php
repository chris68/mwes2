<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\helpers\ModelFormatter;

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
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id], ['title' => 'Editieren']) ?>
            &nbsp;
            <?= Html::a('<span class="glyphicon glyphicon-trash""></span>', ['delete', 'id' => $model->id], [
                'title' => 'Löschen',
                 'data' => [
                     'pjax' => '0', // see github.com/yiisoft/yii2/issues/2505
                     'confirm' => 'Wollen Sie den Eintrag wirklich löschen?',
                     'method' => 'post',
                 ],
            ]) ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-offset-1 col-xs-11">
            <fieldset>
            <legend class="small">Kommentare, Adressen, Telefonnummern</legend>
            <p><?=ModelFormatter::formatwithHtmlTelTags($model->emaildomain,$model->comment)?></p>
            </fieldset>
            <fieldset>
            <legend class="small">Definierte Adressen &amp; Umleitungen</legend>
            <dl>
                <?php foreach ($model->emailmappings as $mapping) : ?>
                <dt><?=$mapping->emailarea->name?><?=$mapping->locked?'&nbsp;<span class="glyphicon glyphicon-lock"></span>':($mapping->hasSaslaccounts()?'&nbsp;<span class="glyphicon glyphicon-send"></span>':'')?></dt>
                <dd><?=$mapping->target?></dd>
                <?php endforeach  ?>
            </dl>
            </fieldset>
        </div>
    </div>
</div>
<?php 
    if ($pjax) {
        Pjax::end();
    }
?>
