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

        <div id="w2-error-0" class="alert-danger alert fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>
                Am 02.08.2004 wurde die Domäne Mailwitch.com registriert, kurz darauf ging der Service live. Nun fast 18 Jahre später wird das Kind bald erwachsen und geht nun seine eigenen Wege. 
            </p>
            <p>
                Und es will kein öffentlicher Service  mehr sein, sondern wird ein privater Dienst für Freunde und die Familie. Neue Nutzer werden nicht mehr akzeptiert, 
                alle andere ziehen sich bitte zurück. 
            </p>
            <p>
                Lösche daher bitte bis zum <b>02.08.2022</b> den Account, sonst wirst du zwangsgelöscht.
            </p>
        </div>

        <p><small><a href="<?= Url::to(['site/about']) ?>">Hintergrundsinfos</a> &ndash; <a href="<?= Url::to(['site/help']) ?>">Hilfe</a></small></p>

    </div>

</div>
