<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Emailentity */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => "<b>{$model->emaildomain->getResolvedDomainname()}</b>mailwitch.com", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'emailentity-view';

?>
<div class="emailentity-view">

	<?= $this->render('_view', [
		'model' => $model,
		'pjax' => FALSE,
	]) ?>

</div>
