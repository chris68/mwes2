<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Impressum';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-impressum">
    <h1><?= $this->title ?></h1>

    <h4>Betreiber</h4>
    <p>
        Diese Seite als technische Plattform wird von Christoph Toussaint, Am Knittelberg 71, 76229 Karlsruhe, Deutschland als Betreiber bereitgestellt. Sie können mich <?= Html::a('hier','site/contact')?> kontaktieren.
    </p>

    <h4>Verantwortlichkeit für Inhalte</h4>
    <p>
        Die dynamischen Inhalte der Seite (Adressbücher, etc.) wurden von den Nutzern der Seite eingestellt und werden von dem Betreiber der Seite nicht verantwortet. Der Betreiber der Seite verantwortet nur die Inhalte, die im Rahmen der Seite statisch klar als Erläuterungen, etc. erstellt wurden.
    </p>
</div>
