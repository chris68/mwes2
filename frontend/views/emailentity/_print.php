<?php

use yii\helpers\Html;
use frontend\helpers\ModelFormatter;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */
?>

<span class="lead"><?= Html::encode($model->sortname)?></span>
<span style="font-weight: bold">&lt;<?= Html::encode($model->getCompleteEmailname())?>&gt;</span>
<p><?=ModelFormatter::formatwithHtmlTelTags($model->emaildomain,$model->comment)?></p>
<p>
    <?php foreach ($model->emailmappings as $mapping) : ?>
    <b><?=$mapping->emailarea->name?><?=$mapping->locked?' (gesperrt): ':': '?></b>
    <?=$mapping->target?>
    <?php endforeach  ?>
</p>
