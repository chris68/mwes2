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
		Version 2.0 (??.??.2015)
	</h3>
	<p>
		Umstellung auf das neue Webframwork Yii 2.0 
	</p>
	<ul>
		<li>Die Applikation wurde auf das Framework Yii2 umgestellt</li>
	</ul>	
	<h3>
		Version 1 (von 2005 bis Anfang 2015)
	</h3>
	<p>
		Mailwitch gibt es bereits seit 2005. Diese Entwicklung basierte aber noch nicht auf dem Framework Yii und nutzte auch noch HTML4. 
	</p>
</div>
