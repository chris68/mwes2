<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Assist;

$this->title = 'Hilfe';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    /*
        Otherwise when navigating to an anchor the heading is hidden behind the navbar 
        See http://stackoverflow.com/questions/4086107/html-positionfixed-page-header-and-in-page-anchors
    */
    .site-about a[name]:before {
      content:"";
      display:block;
      height:50px; /* fixed header height*/
      margin:-50px 5px 0; /* negative fixed header height; it should be just a line so it does not overlap content and makes it unclickable */
    }
</style>

<div class="site-about">
<h1><?= $this->title ?></h1>

<h2><a name="base-priciple">Grundprinzip von Mailwitch</a></h2>
<p>Das Grundprinzip von Mailwitch ist ganz einfach:</p>
<ul>
    <li>Holen Sie sich eine Mailwitch-Emailadresse (z.B. markus.meier@mailwitch.com)</li>
    <li>Geben Sie dann eine oder mehrere <a href='#emailtarget'>Zieladressen</a> an, wohin die Emails tatsächlich gehen sollen (z.B. m.meier@web.de, meier@freenet.de)</li>
    <li>Alle an die Mailwitch-Adresse geschriebenen Emails werden von Mailwitch dann automatisch an die entsprechenden Zieladressen weitergeleitet - Mailwitch selbst speichert nie Mails!</li>
</ul>

<p>Mailwitch ist damit kein Email-Provider im eigentlichen Sinne, denn Sie werden nie Mails direkt in Mailwitch schreiben, sondern immer aus anderen Emailkonten (web.de, gmail.com, etc.) heraus. Doch selbst dann werden die Absenderadressen durch die <a href='#sender-replacement'>Absenderadressenersetzung</a> in Mailwitch korrekt auf die von Ihnen gewählte Mailwitch-Emailadresse umgesetzt (d.h. aus der Absenderadresse m.meier@web.de wird markus.meier@mailwitch.com).</p>

<p>Wenn Sie ein geschäftliches und einen privates Emailkonto haben, dann nutzen Sie einfach das Konzept der <a href='#emailarea'>Kontenarten</a> mit markus.meier+home@mailwitch.com für das private Emailkonto und markus.meier+work@mailwitch.com für das geschäftliche Emailkonto.</p>

<h3>Nutzen</h3>
<h4>Ihre echten Emailkonten bleiben verborgen</h4>

<p>Nach außen geben Sie immer nur die Mailwitch-Emailadresse bekannt und nie ihre echten Emailkonten, weshalb keiner die echten Emailkonten kennt.</p>

<p>Damit können Sie das echte Emailkonto leicht wechseln, ohne dass Sie dies allen Leuten bekannt geben müssen. Dies ist insbesondere bei wechselnden Arbeitgebern (Geschäftsadresse) nicht schlecht, denn auch dort können Sie diese Adresse hinter einer Mailwitch-Emailadresse verbergen.</p>

<p>Jeder der einmal den Emailprovider gewechselt hat, wird sich daran erinneren, wie lange man noch Freunde benachrichten musste, bis endlich alle ihre Adressbücher auf die neue Emailadresse umgestellt haben. Und bei Mailinglisten von Vereinen dauert es meist noch länger!</p>

<p>Hier liegt die wahre Stärke von Mailwitch-Emailadressen: Einmal geholt - nie wechseln!</p>
<h4>Eine Adresse - mehrere Empfänger</h4>

<p>Über eine Mailwitch-Adresse können Sie auch mehrere Emailkonten ansprechen.</p>

<p>Dies ist für Gemeinschaftsadressen hilfreich (z.B. familie.meier@mailwitch.com), bei denen jede Email dann an mehrere Personen weitergeleitet wird.</p>

<p>Sie können aber auch beliebig große Emailverteiler, zum Beispiel für Vereine, aufbauen (z.B. fc-woeschbach@mailwitch.com).</p>
<h4>Pseudoadressen zur Spamabwehr</h4>

<p>Zudem können Sie sich ganz leicht immer neue Pseudoadressen holen, was insbesondere bei Online-Registrierungen sehr hilfreich ist - werden Sie später mit Spam überhäuft, dann löschen oder blocken Sie die entsprechende Mailwitch-Adresse einfach.</p>
<h4>Privatmail auch bei der Arbeit</h4>

<p>Es gibt einige Leute, die sagen: Mailwitch brauche ich nicht, denn ich habe immer nur ein Emailkonto (z.B. bei Google Mail), mit dem ich Privatmail schreibe. Nur da habe ich dann auch mein Adressbuch gepflegt und damit keine Probleme mit Doppelpflege. Das ist schön, wenn es so klappt.</p>

<p>Doch viele Arbeitgeber sperren am Arbeitsplatz den Zugang zu diesen Emailprovidern im Web - zum Teil auch aus guten Grund. Trotzdem wäre es häufig nicht schlecht, wenn man auch bei der Arbeit erreichbar wäre.</p>

<p>Mit Mailwitch kein Problem: Leiten Sie einfach die geschäftliche Mailwitch-Emailadresse (z.B. markus.meier+work@mailwitch.com) auf Ihr geschäftliches Emailkonto um und teilen Sie Ihren Freunden dies mit. Dann können Sie weiterhin Emails bei der Arbeit lesen.</p>

<p>Wenn Sie zusätzlich auf ihr privates Emailkonto umleiten, dann können Sie auch von zu Hause solche Mails lesen, die eigentlich an die Arbeit gerichtet waren. Zudem sollten Sie während des Urlaubs die Umleitung auf den geschäftliches Emailkonto wegnehmen, sodass nicht etwa Vertreter ihre private Email lesen.</p>

<h2><a name="emaildomain">Adressbücher in eigenen Emaildomänen</a></h2>

<p>Da jedermann Mailwitch-Emailadressen definieren kann, würden Sie bald nur noch kryptische Adressen bekommen. Hier bietet Mailwitch Adressbücher in Emaildomänen als Lösung an:</p>
<ul>
    <li>Holen Sie sich eine Emaildomäne als Unterdomäne zu mailwitch.com (z.B. @meier.mailwitch.com)</li>
    <li>Nur Sie haben dann das Recht, unter dieser Unterdomäne Mailwitch-Emailadressen zu definieren (z.B. keinspam@meier.mailwitch.com)</li>
</ul>

<p>Sie können damit beliebig viele Mailwitch-Emailadressen definieren, ohne dass ihnen jemand in die Quere kommt.</p>
<h3>Nutzen</h3>
<h4>Privates Adressbuch</h4>

<p>Wenn Sie sich unter einer solchen Emaildomäne alle Ihre Bekannten und Freunde als sprechende Emailadressen (z.B. immer vorname.nachname) mit Weiterleitung auf die echten Emailkonten definieren, haben Sie sich quasi ein virtuelles Adressbuch aufgebaut. Sie können nämlich von überall Emails an diese leicht merkbaren Adressen schreiben und Mailwitch leitet diese dann automatisch an den entspechenden Empfänger weiter - ohne dass dies jemand merkt!</p>

<p>Zu jeder Emailadresse können Sie auch weitere Details hinterlegen (Telefon, Wohnadresse, Geburtstage, etc.) und sich dann die so definierten Adressdaten als PDF-File ausgeben lassen - ein idealer Ersatz für Ihr gutes altes Adressbuch! Auch der Export der Daten in die meisten Mailprogramme (insbesondere Google Mail) wird unterstützt.</p>
<p>Telefonnummern werden hierbei speziell erkannt und dann im Internet als klickbare Telefonnummer angezeigt, wenn man ein <b>tel:</b> vor die Telefonnummer setzt. Wenn man die Art der Telefonnummer sogar mit <b>tel-main:</b> (Festnetz), <b>tel-mobile:</b> (Mobile),  <b>tel-work:</b> (Geschäftlich) oder <b>tel-private:</b> (Privat) angibt, dann wird diese Info angezeigt. Zudem wird in diesem Falle in dem Export die Telefonnummer herausgezogen und in dem dafür vorgesehenen Feld eingetragen. Damit kann man auch beim Smartphone telefonieren.</p>
<p>Man muss hierbei nicht immer die komplette Vorwahl angeben, sondern über das Tag <b>tel-access:</b> kann man in der Adressbuchbeschreibung eine Standardvorwahl (z.B. +49-721) angeben und dann wird es automatisch dort angefügt, wo es fehlt</p>
<p>Es ist also wesentlich vielseitiger und einfacher, die Adressen einmal in Mailwitch zu pflegen, als dies in vielen Emailprogrammen einzeln zu tun und dann meistens nochmal auf irgendeinem Adresszettel.</p>
<h4>Adresslisten für Vereine, etc.</h4>

<p>Sie können über das Emaildomänenkonzept jedoch nicht nur private Adressbücher aufbauen, sondern auch begrenzt öffentliche Adresslisten für Vereine, Verbände, Freundeskreise, Selbsthilfegruppen, etc. pflegen. Die eigentlichen Adressen und die Umleitung auf die eigentlichen Emailkonten pflegen Sie hierbei genauso wie in einem privaten Adressbuch.</p>

<p>Der Aufbau von Emailverteilern basierend auf diesen Adressen ist dann ein Kinderspiel und wesentlich robuster, als wenn Sie in den Verteilern die echten Emailkonten der Mitglieder verwenden würden. Dann müssten Sie nämlich Änderungen von Emailkonten immer an sehr vielen Stellen nachtragen!</p>
<h4>Pseudoadressbuch für Zugang zu Onlineshops/Websites</h4>

<p>Es wurde oben bereits erwähnt, dass Sie mit Mailwitch leicht Pseudoadressen für den Zugang zu Onlineshops oder Websites (www.bahn.de, etc.) definieren können, damit Sie später nicht mit Spam überschüttet werden.</p>

<p>Wenn Sie für diese Zwecke eine eigene Emaildomäne definieren (z.B. meier-spam.mailwitch.com), dann können Sie als Emailname einfach die URL des Onlineangebots nehmen (also www.bahn.de@meier-spam.mailwitch.com).</p>

<p>In dem entsprechenden Adresseintrag können Sie dann zudem Kommentare zu dem Online-Angebot speichern.</p>

<p>Und wenn Sie dann später erkennen, dass eine konkrete Website Sie doch mit Spam überschüttet, dann können Sie diese Adresse leicht blocken.</p>

<h2><a name="globaldomain">Globaler Adressraum</a></h2>
<p>In dem globalen Adressraum <i>mailwitch.com</i> kann im Gegensatz zu einem <a href="#emaildomain" title="Emaildomäne">Adressbuch in einer Emaildomäne</a> jeder Nutzer frei Mailwitch-Emailadressen Adressen anlegen. Normalerweise werden Sie hier vor allem Ihre globalen Adressen anlegen (z.b. markus.meier@mailwitch.com), die Sie dann anstatt Ihrer eigentlichen Emailkonten (wie z.B. m.meier@web.de) verwenden.
</p>

<h2><a name="emailarea">Kontenart</a></h2>

<p>Meist hat eine Person mehrere Emailadressen, z.B. ein privates und ein geschäftliches. Damit Sie dies auch in Mailwitch abbilden können, wurden mehrere Kontenarten vordefiniert:<p>
<ul>
    <li><b>main:</b> Die Standardemailadresse</li>
    <li><b>work:</b> Geschäftliches Emailkonto</li>
    <li><b>home:</b> Privates Emailkonto</li>
    <li><b>extra1:</b> Erstes weiteres Emailkonto</li>
    <li><b>extra2:</b> Zweites weiteres Emailkonto</li>
    <li><b>extra3:</b> Drittes weiteres Emailkonto</li>
    <li><b>all:</b> Spezielle, automatisch erzeugte Kontoart (siehe unten)</li>
</ul>

<p>Die Kontenart <i>main</i> beschreibt die Hauptemailadresse, also markus.meier@mailwitch.com. Die anderen Kontenarten folgen durch einen + getrennt direkt hinter dem Emailnamen, also markus.meier+work@mailwitch.com, markus.meier+home@mailwitch.com, markus.meier+all@mailwitch.com, etc.</p>
<p>Dieses Verfahren entspricht dem Sub-adressing im Emailverkehr (siehe <?= Assist::extlink('http://en.wikipedia.org/wiki/Email_address#Sub-addressing', 'http://en.wikipedia.org/wiki/Email_address#Sub-addressing')?>). Mailwitch unterstützt dieses Sub-Adressing uneingeschränkt (sprich: auch markus.meier+2015@mailwitch.com ginge) und leitet alles einfach auf die Hauptadresse (ohne das +work, etc.) weiter, wenn keine entsprechende Kontenart explizit definiert ist.</p>
<p>Der große Vorteil ist damit, dass Mails auch dann korrekt ankommen, wenn die entsprechende Kontenart gar nicht definiert ist, weil es in diesem Falle immer automatisch an die Hauptadresse geht.</p>
<p>Die Kontoart <i>all</i> wird immer automatisch erzeugt und verweist auf alle von Ihnen definierten Kontenarten. Sie können also mit z.B. markus.meier+all@mailwitch.com den Herren auf allen seinen Konten erreichen!</p>
<p class="alert alert-danger">
    <b>Alte Adressierungsmethode mit .work, .home, etc.</b><br><br>
    Früher war in Mailwitch der Trenner hinter der Kontenart ein Punkt und die Adressen dann z.B. markus.meier.work@mailwitch.com. Diese alte Konvention wird nicht mehr unterstützt, sondern es gibt automatisierte Relocated-Bounce-Mails, die die neue Adressierungsmethode beschreiben und damit sollte nichts verloren gehen.<br><br>
    Zudem wird es für sehr lange Zeit weiterhin nicht erlaubt sein, Adressen mit den alten Endungen .work, etc. zu definieren.
</p>

<h2><a name="emailtarget">Zieladresse</a></h2>
<p>Zieladressen geben an, wohin die an Mailwitch-Emailadressen gerichteten Emails tatsächlich gehen sollen. Man kann eine oder mehrere Zieladressen angeben, wobei es ein großer Unterschied ist, ob Sie nur eine Zieladresse (Adressumwandlung) oder mehrere Zieladressen (Verteilerliste, Emailverteiler) angeben.
</p><p>Wenn Sie nur eine einzige Zieladresse angeben, dann wird die Email nur an diese eine Adresse weitergeleitet und die Mailwitch-Emailadresse wird in dieser weitergeleiteten Email durch die Zieladresse textuell ersetzt.
</p>
<pre>Definition der Mailwitch-Emailadresse

  markus.meier@mailwitch.com  =&gt; m.meier@web.de

Originale Email

  An: markus.meier@mailwitch.com
  ...

Weitergeleitete Email (an m.meier@web.de)

  An: m.meier@web.de
  ...
</pre>
<p>Wenn Sie mehrere Zieladressen angeben, dann wird die Email an mehrere unterschiedliche Adressen weitergeleitet und die Mailwitch-Emailadresse wird nicht ersetzt, sondern bleibt unverändert.
</p>
<pre>Definition der Mailwitch-Emailadresse

  markus.meier@mailwitch.com  =&gt; m.meier@web.de, meier@freenet.de

Originale Email

  An: markus.meier@mailwitch.com
  ...

1. weitergeleitete Email (an m.meier@web.de)

  An: markus.meier@mailwitch.com
  ...

2. weitergeleitete Email (an meier@freenet.de)

  An: markus.meier@mailwitch.com
  ...
</pre>
<p>Wenn Sie zwar nur an eine Person weiterleiten wollen, aber die Mailwitch-Emailadresse trotzdem unverändert beibehalten wollen, dann <b>fügen Sie einfach ein Komma</b> hinter der einen Zieladresse ein. Damit drücken Sie aus, dass Sie eine Verteilerliste mit nur einem Eintrag definieren wollen.
</p>
<pre>Definition der Mailwitch-Emailadresse

  markus.meier@mailwitch.com  =&gt; m.meier@web.de,

Originale Email

  An: markus.meier@mailwitch.com
  ...

Weitergeleitete Email

  An: markus.meier@mailwitch.com
  ...
</pre>
<p>Bei der Definition von Zieladressen innerhalb eines <a href="#emaildomain">Adressbuchs in einer Emaildomäne</a> können Sie Zieladressen aus der <b>gleichen</b> Email-Domäne abkürzen, indem Sie den Teil hinter dem @ einfach weglassen. Mailwitch nimmt dann implizit an, dass die Adresse in der gleichen Domäne als Mailwitch-Emailadresse definiert wurde.
</p>
<pre> In der Domäne <i>meier</i> seien folgende Mailwitch-Emailadressen definiert

   claudia.mueller@meier.mailwitch.com
   gert.beck@meier.mailwitch.com
   markus.meier@meier.mailwitch.com

 Die Definition von <i>skatrunde@meier.mailwitch.com</i> wäre dann

   skatrunde@meier.mailwitch.com  =&gt; claudia.mueller, gert.beck, markus.meier
</pre>
<p>Wenn Sie innerhalb einer Emailadresse auf unterschiedliche <a href="#emailarea" title="Kontenart">Kontenarten</a> verweisen wollen, dann geben Sie einfach <i>+Kontenart</i> als Zieladresse an, also <i>+work</i> für die Geschäftsadresse und <i>+home</i> für die Privatadresse.
</p>
<pre> Definition einer typischen globalen Mailwitch-Emailadresse (mit Kommentaren)

   markus.meier@mailwitch.com       =&gt; +home,
   (Die Standardemailadresse ist damit die private Adresse)
   markus.meier+home@mailwitch.com  =&gt; m.meier@web.de,
   (Weiterleitung an die Privatadresse)
   markus.meier+work@mailwitch.com  =&gt; meier@verkehrsbetriebe-freiburg.de, +home
   (Weiterleitung an die Geschäftsadresse und Kopie an die Privatadresse)
</pre>

<h2><a name="sender-replacement">Absenderadressenersetzung</a></h2>
<p>Wenn Sie Mailwitch richtig nutzen, dann werden Sie sich eine Mailwitchadresse wie <i>markus.meier</i>@mailwitch.com als globale Adresse definieren, die Sie dann auf ihre eigentliches Emailkonto bei ihrem Emailprovider (z.B. gmail.com, web.de, yahoo.com, gmx.de, etc.) umleiten. Wenn ihnen jemand an diese Adresse <i>markus.meier</i>@mailwitch.com schreibt, erhalten Sie die Email dann in ihrem Emailkonto(z.B. m.meier@web.de)
</p><p>Genauso werden Sie Emails nie direkt von Mailwitch aus schreiben, sondern immer von Ihrem eigentlichen Emailprovider. Trotzdem wollen Sie, dass alle Leute die Emails unter Ihrer Mailwitchadresse <i>markus.meier</i>@mailwitch.com erhalten.
</p><p>Bei vielen Emailprovidern ist es nun möglich, sich weitere Absenderadressen registrieren zu lassen. Hierzu wird ein Freischaltcode an die gewünschte Adresse geschickt und dadurch geprüft, dass einem die Adresse wirklich gehört. Nach der Freischaltung kann man die registrierte Adresse dann als Absenderadressen verwenden. Auf diese Weise können Sie sich beliebig viele Mailwitchadressen als Absenderadressen bei Ihrem Emailprovider freischalten lassen und dann nutzen. Wenn Ihr Emailprovider dieses Verfahren unterstützt (z.B. Google Mail bis zum Rollout des SMTP-Versandverfahren), dann sollten Sie diese nutzen, denn es ist am einfachsten und flexibelsten.
</p><p>Leider geht dieses Verfahren jedoch nicht bei allen Providern - insbesondere nicht bei der Arbeit. Daher hat Mailwitch ein zweites Verfahren, um Absenderadressen während des Durchschleusens durch Mailwitch zu verändern. Sie registrieren hierzu in Mailwitch eine Emailadresse als Absenderadresse. Hierzu müssen Sie auch über Freischaltcodes nachweisen, dass Ihnen die Adresse wirklich gehört. Für jede solche registrierte Absenderadresse können Sie dann eine Mailwitchadresse (jedoch nur globale Adressen!) wählen und Mailwitch wird automatisch die originale Absenderadresse in jeder Mail durch die Mailwitchadresse ersetzen.
</p><p>Sie können beliebig viele Absenderadressen registrieren und entsprechend umleiten. Folgendes Beispiel für eine typische Nutzung mit einer Arbeits- und einer Heimadresse:
</p>
<pre>  m.meier@web.de                       =&gt; markus.meier@mailwitch.com
  meier@verkehrsbetriebe-freiburg.de   =&gt; markus.meier+work@mailwitch.com
</pre>
<p>Dieses Verfahren funktioniert aber nur, wenn sie konsequent alle Mail über Mailwitch senden. Und daher sollte man vor allem den SMTP-Versand nutzen.
</p>
<p class="alert alert-danger">
    <b>Absenderadressersetzung ein Muss bei Empfängeradressersetzung</b><br><br>
    Bei allen Emailprovidern, die <?= Assist::extlink('DMARC', 'http://de.wikipedia.org/wiki/DMARC')?> (z.B. gmail.com und vor allem yahoo.com) nutzen,
    ist bei Nutzung von Adressumwandlungen der Empfängeradresse auch eine Absenderadressersetzung ein Muss. Eine Adressumwandlung der Empfängeradresse liegt in Mailwitch immer dann vor, wenn bei der <a href="#emailtarget">Zieladresse</a> nur <b>genau eine Adresse <u>ohne</u> Komma</b> angegeben wurde.<br><br>

    Sprich: wenn Sie von z.B. einem Yahoo-Account eine Mail an eine Mailwitch-Empfängeradresse
    schreiben, wo dann gemäß der Adressbuchidee die Mailwitch-Adresse durch die echte Adresse ersetzt wird (und nicht nur weitergeleitet wird), dann müssen Sie auch ihre Absenderadresse auf einen Mailwitch-Adresse umschießen,
    indem Sie eine entsprechende Absenderadressersetzung registrieren.<br><br>

    Der Hintergrund ist, dass durch das Verändern der Zieladresse im Emailheader die DKIM-Signatur gebrochen wird und man dann auf keinen Fall den Anschein erwecken, dass die Mail von gmail,yahoo, etc. verschickt wurde. Und dazu muss man halt auch die Absenderadresse anpassen.
    Wenn jedoch eine Mail an eine normale Weiterleitung geschickt wird, dann ist das unproblematisch, weil die Emailheader nicht verändert werden und damit die Signatur nicht gebrochen wird.<br><br>

    Im Umkehrschluss heißt das: geben Sie nie im großen Stil Mailwitch-Adressen nach außen, wo in der Zieladresse eine Adressumwandlung hinterlegt ist, denn spätestens, wenn z.B. ein Yahoo-Nutzer an diese eine Mail schreibt, wird die Mail wahrscheinlich nicht mehr akzeptiert, sondern wegen der gebrochenen DKIM-Signatur als Fälschung klassifiziert.<br><br>

    Und genau das ist auch die Kritik an DMARC: Emailweiterleitungen werden deutlich erschwert und die Dominanz der großen Mailprovider soll zementiert werden. Aber vor allem Yahoo steckt dafür derzeit gerade so viel Kritik ein, dass das Pendel eventuell demnächst wieder zurückschlägt.

</p>
<h2><a name="sender-">SMTP-Mailversand (mit Authentifizierung)</a></h2>
<p>Seit Mai 2020 bietet Mailwitch die Möglichkeit, den Versand von Mails über eine gesicherte Verbindung mit Anmeldung durchzuführen. Gerade im Zusammenspiel mit Gmail funktioniert dies hervorragend. Falls Sie Mailwitch richtig nutzen, dann sollten Sie auf jeden Fall diese Möglichkeit einsetzen, denn dies garantiert einen problemlosen Versand der Mails.
</p><p>Hierzu muss man in Gmail (oder bei einem anderen Emailprovider, der sowas kann; web.de kann es Stand 2020 nicht...) eine neue Absenderadresse registrieren. 
</p><p>Zur Vorbereitung holen Sie sich für die Adresse in Mailwitch eine Senderfreigabe, was nichts anderes ist als die Emailadresse (z.B. markus.meier@mailwitch.com) als Nutzername und ein Zugangstoken quasi als Passwort für diese Emailadresse. Wichtig ist: der Zugang muss in Mailwitch registriert sein bevor dieser genutzt werden kann und das sichtbare Token ist nur bei der Registrierung sichtbar. Im Zweifel muss man daher ein Neues erzeugen!
</p><p>Diese Daten müssen dann bei dem Emailprovider eingetragen werden (bei Gmail: Sender als Alias registrieren!), wobei der Nutzername die komplette Absenderadresse ist und das Passwort eben der Zugangstoken. Die Verbindung muss über <strong>Port 25</strong> laufen und man sollte TLS nutzen. Während der Registrierung wird der Emailprovider den Zugang prüfen und diesen freigeben, wenn alles geklappt hat. Danach kann man unter dem Absender Emails verschicken.
</p><p>Man kann sich auch mehrere Zugänge für die gleiche Absenderadresse registrieren, was zum Beispiel für Sammel/Familienaccounts ganz nett ist, denn dann können mehrere Personen unter den gleichen Absender senden.
</p>

<h2><a name="access-management">Berechtigungskonzept</a></h2>
<p>Das Berechtigungskonzept von Mailwitch ist ganz einfach:</p>
<ul>
    <li>Wenn Sie eine globale Adresse in dem <a href="#globaldomain">globalen Adressraum</a> anlegen, dann gehört diese Ihnen bis Sie diese löschen</li>
    <li>Wenn Sie eine <a href="#emaildomain">Adressbuch in einer Emaildomäne</a> anlegen, dann gehört diese Ihnen bis Sie diese löschen; nur Sie können dann hier Mailwitch-Emailadressen anlegen</li>
    <li>Alles was Sie anlegen, können nur Sie bearbeiten und sehen</li>
</ul>


    <p style="height: 500px">
        
    </p>
