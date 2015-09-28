<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = \Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Mailwitch Email Services</h1>

        <p class="lead">Ein intelligenter Emailumleitungsservice.</p>
        <p><small><a href="<?= Url::to(['site/about']) ?>">Hintergrundsinfos</a> &ndash; <a href="<?= Url::to(['site/help']) ?>">Hilfe</a></small></p>

    </div>

</div>
