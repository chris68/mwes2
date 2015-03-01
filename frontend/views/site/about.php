<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\helpers\Assist;

$this->title = \Yii::t('base','About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= $this->title ?></h1>

    <p>Mailwitch ist ein Email-Service, bei dem Sie neue Emailadressen als Weiterleitung auf existierende Zieladressen definieren können. Wenn Sie beispielsweise die neue Adresse 'markus.meier@mailwitch.com' definieren und auf 'm.meier@web.de' umleiten, dann wird alle an 'markus.meier@mailwitch.com' gerichtete Mail an 'm.meier@web.de' weitergeleitet.</p>

    <p>Damit können Sie sich eine dauerhafte Mailwitch-Emailaddresse definieren und diese dann anstatt der an den jeweiligen Emailanbieter gebundenen Adresse nutzen. Da Sie beliebig viele Adressen definieren können, können Sie diese auch als Antispam-Pseudoadressen mit befristeter Lebensdauer verwenden. Wenn Sie auf mehrere Adressen umleiten, können Sie zudem leicht Emailverteiler aufsetzen.</p>

    <p>Zusätzlich können Sie sich auch eine ganze Unterdomäne reservieren, in der nur Sie neue Emailadressen anlegen können. Wenn Sie sich beispielweise die Unterdomäne 'meier.mailwitch.com' reservieren, dann können Sie - und nur Sie - hier Emailadressen wie 'frank.futter@meier.mailwitch.com', 'maria.meier@meier.mailwitch.com', 'freunde@meier.mailwitch.com' usw. anlegen.

    <p>Dies ermöglicht Ihnen eine Art Online-Adressbuch im Internet zu pflegen, in dem Sie für alle Bekannten solche Adressen als Weiterleitung zu deren eigentlichen Emailadressen anlegen. Sie können dann von überall eine Mail an diese leicht zu merkenden Adressen schreiben und Mailwitch wird die Mail an die hinterlegten eigentlichen Empfänger weiterleiten.</p>

    <p>Damit brauchen Sie nie mehr lokale Adressbücher zu pflegen, sondern können ihre Mail einfach an die entsprechenden leicht zu merkenden Mailwitch-Weiterleitungsadressen schicken.</p>
    <h4>
        Die Plattform "Mailwitch Email Services"
    </h4>
    <p>
        Die Plattform ist eine Webapplikation (<?= Assist::linkNew('Releasehistorie',['site/releasehistory']) ?>), die voll auf HTML5 und den damit verbundenen Möglichkeiten setzt. Die Webseiten sind hierbei 
        speziell für den Einsatz auf mobilen Geräten optimiert. Ältere Browser (vor allem nicht ältere Internet Exlorer!) werden als Konsequenz 
        nicht unterstützt und es wird ausdrücklich empfohlen, einen aktuellen und HTML5-kompatiblen Browser einzusetzen.
    </p>
    <p>
        Sollte es Probleme mit <b>aktuellen</b> Browsern geben, dann melden Sie diese bitte über die Kontaktseite.
    </p>
    <?php if (!Yii::$app->user->isGuest) : ?>
    <div class="col-sm-12 col-md-12 alert alert-warning">
        Das System ist derzeit noch in Entwicklung und es wird daher noch gewisse Nutzungseinschränkungen geben!
    </div>
    <?php endif ?>
</div>


