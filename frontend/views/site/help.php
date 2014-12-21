<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Assist;

$this->title = 'Hilfe';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    /* 
        Otherwise when navigating to an anchor the heading is hidden behind the navbar 
        See http://stackoverflow.com/questions/4086107/html-positionfixed-page-header-and-in-page-anchors
    */
    .site-about a[name]:before {
      content:"";
      display:block;
      height:50px; /* fixed header height*/
      margin:-50px 5px 0; /* negative fixed header height; it should be just a line so it does not overlap content and makes it unclickable */
    }
</style>
<div class="site-about">
    <h1><?= $this->title ?></h1>

    <p>
        Die Hilfefunktion ist kontextsensitiv. Wenn Sie in einer bestimmten Maske sind und dann oben auf Hilfe klicken, wird direkt zu dem entsprechenden Hilfetext navigiert.
        Daher wird die Hilfe auch immer in einem neuen Fenster/Reiter geöffnet, damit auf keinen Fall irgendwelche offenen Bearbeitungen verloren gehen.
    </p>

    <h2><a name="general">Generelles</a></h2>
    <h3><a name="markdown-syntax">Markdown Syntax</a></h3>
    <p>
        Bei Webapplikationen will man seine eingestellten Inhalte möglichst schön formatieren. Hier kann man mit HTML zwar alles machen, aber HTML ist meist zu kompliziert und es wäre zudem gefährlich, den Nutzer HTML direkt ein-/ausgeben zu lassen
    </p>
    <p>
        Und daher haben sich kluge Köpfe eine spezielle Syntax überlegt, mit der man solche Formatierungen machen kann: die <?=    Assist::extlink('Markdown Syntax', 'http://de.wikipedia.org/wiki/Markdown') ?>.
        Wenn Sie sich den <?=    Assist::extlink('Artikel in Wikipedia', 'http://de.wikipedia.org/wiki/Markdown') ?> durchlesen, dann werden Sie es schnell verstehen und leicht nutzen können.
    </p>
    <p>
        Und das beste ist: Sie haben sogar einen kleinen Editor, der Sie dabei unterstützt. Den Editor haben wir hierbei nicht selbst geschrieben, sondern <?=    Assist::extlink('Kartik Visweswaran', 'http://kartikv.krajee.com') ?> hat ihn freundlicherweise <?=    Assist::extlink('Public Domain', 'http://de.wikipedia.org/wiki/Gemeinfreiheit') ?> zur Verfügung gestellt.
    </p>
    
    <p style="height: 500px">
        
    </p>
</div>
