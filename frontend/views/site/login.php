<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = \Yii::t('base','Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= $this->title ?></h1>

    <p><?= \Yii::t('base','Please fill out the following fields to login:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                    <?= \Yii::t('base','If you forgot your password you can') ?> <?= Html::a(\Yii::t('base','reset it'), ['site/request-password-reset']) ?>.
                </div>
                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('base','Login'), ['class' => 'btn btn-primary']) ?>
                </div>
                <p>Oder melden Sie sich über ein vorher verbundenes Konto bei einem der externen OAuth-Provider an:</p>
                <?= yii\authclient\widgets\AuthChoice::widget([
                     'baseAuthUrl' => ['site/auth'],
                     'popupMode' => false,
                ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
