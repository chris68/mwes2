<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\helpers\Assist;

$this->title = 'Releasehistorie';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-releasehistory">
    <h1><?= $this->title ?></h1>
    <p>
        Die Plattform wird laufend weiterentwickelt und damit Sie schnell erkennen können, wann was neu hinzugekommen ist, haben wir hier die Releasehistorie veröffentlicht. Kleinere Änderungsrelease mit Fehlerkorrekturen werden hier jedoch nicht aufgeführt.
    </p>
    <h3>
        Version 2.0 (29.03.2015)
    </h3>
    <p>
        Umstellung auf das neue Webframwork Yii 2.0
    </p>
    <ul>
        <li>Die Applikation wurde auf das Framework Yii2 umgestellt (quasi Neuimplementierung).</li>
        <li>Folgende Sachen wurden mangels Nutzung <b>nicht</b> aus der Version 1 übernommen:
            <ul>
                <li>Das komplette Berechtigungskonzept: man sieht daher jetzt immer nur noch seine eigenen Adressen/Adressbücher</li>
                <li>Tags: Man kann diese einfach z.B. durch #&lt;tag&gt;-Einträge in dem Kommentarfeld emulieren (z.B. #freunde); das klappt dann auch bei der Suche</li>
                <li>Die Adresssuchhilfe/automatische Erweiterung beim Erstellen von Zieladressen (wird wahrscheinlich später in einer Folgerelease wieder implementert)</li>
                <li>Das automatische Errechnen von Zieladressen in dem Expertenfeld "Formel für Zieladresse"</li>
                <li>Die Absenderblindkope</li>
                <li>Mehrsprachigkeit: die Plattform gibt es nun nur noch in Deutsch</li>
            </ul>
        </li>
        <li>Das Plus-Zeichen (+) ist nun der Trenner für die Kontenarten
            <ul>
                <li>Die Arbeitsadresse von Markus Meier wäre dann z.B. markus.meier+work@mailwitch.com (anstatt markus.meier.work@mailwitch.com wie früher)</li>
                <li>Die alte Methode mit dem Punkt als Trenner wird ca. noch ein Jahr unterstützt und wird dann auslaufen</li>
            </ul>
        <li>Auf dem Mailserver selbst wurden Spamabwehrmethoden wie Blacklisting und Greylisting implementiert, um der Spamflut Herr zu werden</li>
    </ul>    
    <h3>
        Version 1 (von 2005 bis Anfang 2015)
    </h3>
    <p>
        Mailwitch gibt es bereits seit 2005. Diese Entwicklung basierte aber noch nicht auf dem Framework Yii und nutzte auch noch HTML4. 
    </p>
</div>
