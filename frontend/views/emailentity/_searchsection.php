<?php

use yii\helpers\Html;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EmailentitySearch */
?>

<?=
	Collapse::widget([
		'items' => [
			[
				'label' =>  '<span class="glyphicon glyphicon-collapse-down"></span> Detailsuche/-filter <span class="badge">'.$searchModel->getFilterStatus().'</span>',
				'encode' => false,
				'content' => $this->render('_search', ['model' => $searchModel]),
			],
		],
		'options' => 
		[
			'style' => 'margin-bottom: 10px'
		],
   ]);
?>
