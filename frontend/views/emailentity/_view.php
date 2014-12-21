<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

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
            <span class="lead"><?= Html::encode(Html::encode($model->sortname))?></span>
            <span style="font-weight: bold">&lt;<?= Html::encode(Html::encode($model->getCompleteEmailname()))?>&gt;</span>
            <span class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id], ['title' => 'Editieren']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                'title' => 'Löschen',
                // todo data attribute currently does not play nice with pjax (see github.com/yiisoft/yii2/issues/2505)
                // 'data' => [
                    // 'confirm' => 'Wollen Sie den Eintrag wirklich löschen?',
                    // 'method' => 'post',
                // ],
            ]) ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-offset-1 col-xs-11">
            <fieldset>
            <legend class="small">Kommentare, Adressen, Telefonnummern</legend>
            <p><?= nl2br(Html::encode(Html::encode($model->comment)))?></p>
            </fieldset>
            <fieldset>
            <legend class="small">Adressumleitungen</legend>
            <dl>
              <dt>default</dt>
              <dd>christoph.toussaint@gmail.com</dd>
              <dt>work</dt>
              <dd>christoph.toussaint@daimler.com</dd>
              <dt>home</dt>
              <dd>christoph.toussaint@daimler.com, christoph.toussaint@daimler.com, christoph.toussaint@daimler.com, christoph.toussaint@daimler.com, christoph.toussaint@daimler.com, </dd>
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
