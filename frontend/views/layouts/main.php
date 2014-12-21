<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use frontend\models\Emaildomain;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Plattform zum Verwalten von Adressbüchern und Emailumleitungen">
    <?= Html::csrfMetaTags() ?>
	<link rel="icon" type="image/x-icon" href="<?=Url::to('favicon.ico')?>">
	<title><?= $this->title ?></title>
	<?php $this->head() ?>
</head>
<body>
	<?php $this->beginBody() ?>
	<div class="wrap">
		<?php
			NavBar::begin([
				// Label should be small; otherwise on mobile phone the navbar blows up to two lines!
				'brandLabel' => '<small>Mailwitch Email Services</small>',
				'brandUrl' => Yii::$app->homeUrl,
				'options' => [
					'class' => 'navbar-inverse navbar-fixed-top',
				],
			]);
			$emaildomains = [];
			foreach (Emaildomain::find()->ownerScope()->orderby('name')->all() as $domain) {
				$emaildomains[] = ['label' =>  $domain->name, 'url' => ['/emailentity/index', 's[emaildomain_id]' => $domain->id ]];
			}
			$menuItems = [
				['label' => \Yii::t('base','Home'), 'url' => ['/site/index']],
				[
					'label' => 'Adressbücher', 
					'visible' => !Yii::$app->user->isGuest,
					'items' => $emaildomains,
				],
				[
					'label' => 'Verwalten', 
					'visible' => !Yii::$app->user->isGuest,
					'items' => [
						['label' => 'Globale Adressen', 'url' => ['/emailentity/index', 's[emaildomain_id]' => 0]],
						['label' => 'Adressbücher', 'url' => ['/emaildomain/index']],
						['label' => 'Absenderadressen', 'url' => ['/']],
					],
				],
				['linkOptions' => ['target' => '_blank'], 'label' => 'Hilfe', 'url' => ['/site/help'.(isset($this->params['help']) ? ('#'.$this->params['help']) : ''), ],],
				['label' => \Yii::t('base','About'), 'url' => ['/site/about']],
				['label' => \Yii::t('base','Contact'), 'url' => ['/site/contact']],
			];
			if (Yii::$app->user->isGuest) {
				$menuItems[] = ['label' => \Yii::t('base','Signup'), 'url' => ['/site/signup']];
				$menuItems[] = ['label' => \Yii::t('base','Login'), 'url' => ['/site/login']];
			} else {
                $menuItems[] = [
                    'label' => \Yii::t('base','Logout').' (' . Yii::$app->user->identity->username .')' ,
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
			}
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => $menuItems,
			]);
			NavBar::end();
		?>

		<div class="container">
		<?php if (isset($this->params['breadcrumbs'])) : ?>
		<ul class="breadcrumb">
			<?= Breadcrumbs::widget([
				'links' => $this->params['breadcrumbs'],
				'encodeLabels' => false,
				'tag' => 'span',
			]) ?>
			<li style="float:right"><?= Html::a('Hilfe', ['/site/help'.(isset($this->params['help']) ? ('#'.$this->params['help']) : ''), ], ['target' => '_blank'] ) ?> </li>
		</ul>
		<?php endif ?>
		<?= Alert::widget() ?>
		<?= $content ?>
		</div>
	</div>
	
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-6" style='font-size:x-small'>
					<?= Html::a('Nutzungsbedingungen',['site/terms']) ?> |
					<?= Html::a('§55 RStV',['site/impressum']) ?> |
					<?= Html::a('Datenschutz',['site/privacy']) ?>
				</div>
			</div>
		</div>
	</footer>

	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
