<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */
?>

<span class="lead"><?= Html::encode(Html::encode($model->sortname))?></span>
<span style="font-weight: bold">&lt;<?= Html::encode(Html::encode($model->getCompleteEmailname()))?>&gt;</span>
<p><?= nl2br(Html::encode(Html::encode($model->comment)))?></p>
<p>
    <?php foreach ($model->emailmappings as $mapping) : ?>
    <b><?=$mapping->emailarea->name?><?=$mapping->locked?' (gesperrt): ':': '?></b>
    <?=$mapping->target?>
    <?php endforeach  ?>
</p>
