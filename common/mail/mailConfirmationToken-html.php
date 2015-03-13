<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Foreignemailaccount */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['foreignemailaccount/confirm', 'id' => $model->id, 'token' => $model->confirmation_token]);
?>
<div class="confirm-email">
    Hallo,

    Klicken Sie bitte auf den Link unten, um die Emailadresse zu betätigen:

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
