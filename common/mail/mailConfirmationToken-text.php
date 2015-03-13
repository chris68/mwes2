<?php

/* @var $this yii\web\View */
/* @var $model frontend\models\Foreignemailaccount */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['foreignemailaccount/confirm', 'id' => $model->id, 'token' => $model->confirmation_token]);
?>
Hallo,

Klicken Sie bitte auf den Link unten, um die Emailadresse zu betätigen:

<?= $confirmLink ?>
