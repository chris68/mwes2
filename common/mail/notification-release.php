<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Hallo <?=$user->username?>!

Bei der Webplattform mailwitch.com ist soeben die neue Release <?=Yii::$app->version?> veröffentlicht worden. Die Neuerungen finden Sie in der Releasehistorie (https://mailwitch.com/site/releasehistory).

Die wichtigste Neuerungen ist jedoch, dass Mailwitch.com bald kein öffentlicher Service mehr sein wird und alle nicht persönlich bekannten Nutzer daher gelöscht werden.

Und damit wurden auch die Nutzungsbedingungen (https://mailwitch.com/site/terms) oder Datenschutzbedingungen (https://mailwitch.com/site/privacy) geändert. 


===================================================================================================

Sie bekommen diese Email, weil Sie bei mailwitch.com unter dem Nutzer <?=$user->username?> mit der Emailadresse <?=$user->email?> registriert sind. Wenn Sie mailwitch.com nicht mehr nutzen wollen, dann löschen Ihren Nutzer bitte in der Nutzerverwaltung.

Bitte antworten Sie nicht auf diese Mail, sondern nutzen Sie stattdessen bitte die Kontaktseite (https://mailwitch.com/site/contact)
