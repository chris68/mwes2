<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Hallo <?=$user->username?>!

Bei der Webplattform mailwitch.com ist soeben die neue Release <?=Yii::$app->version?> veröffentlicht worden. Die Neuerungen finden Sie in der Releasehistorie (<?=Yii::$app->urlManager->createAbsoluteUrl(['site/releasehistory'])?>).

Wegen einer notwendigen technischen Umstellung müssen Sie ihr Passwort zurücksetzen. Dies können Sie über den Link <?=Yii::$app->urlManager->createAbsoluteUrl(['site/request-password-reset'])?> einleiten.

Auch sollten Sie sich danach in der Nutzerverwaltung <?=Yii::$app->urlManager->createAbsoluteUrl(['site/userdata'])?> einen einfacheren Nutzernamen holen, da Sie diesen nun dauerhaft für die Anmeldung brauchen.

Bitte beachten Sie auch die aktualisierten AGB (<?=Yii::$app->urlManager->createAbsoluteUrl(['site/terms'])?>) und Datenschutzbedingungen (<?=Yii::$app->urlManager->createAbsoluteUrl(['site/privacy'])?>). Die wichtigste Neuerung ist hier, dass Nutzer nach einem Jahr Untätigkeit gelöscht werden.

===================================================================================================

Sie bekommen diese Email, weil Sie bei mailwitch.com unter dem Nutzer <?=$user->username?> mit der Emailadresse <?=$user->email?> registriert sind. Wenn Sie mailwitch.com nicht mehr nutzen wollen, dann löschen Ihren Nutzer bitte in der Nutzerverwaltung.
