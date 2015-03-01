<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\User;
use frontend\models\Emailentity;
use frontend\models\Emailmapping;

class m141211_022021_fill_from_mwes1 extends Migration
{
    public function safeUp()
    {
        // Establish connection before via port tunneling using: ssh -L 5433:localhost:5432 mailwitch@mailwitch.com
        $connection = new \yii\db\Connection([
            'dsn' => 'pgsql:host=localhost;port=5433;dbname=mailwitch',
            'username' => 'mailwitch',
            'password' => 'mailwitch',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ]);
        $connection->open();
        
        // Transfer the users using the model class
        $command = $connection->createCommand('SELECT * FROM Users where ID >= 100');
        $rs = $command->queryAll();
        //print_r($rs);
        foreach ($rs as $r) {
            $user = new User();
            $user->id = $r['id'];
            $user->username = $r['loginemail'];
            $user->email = $r['loginemail'];
            
            // Set the passwords to empty so each user needs to trigger the password reset process
            $user->password_hash = ''; // Blank entry denies all logins so it is safe to set it to blank
            $user->password_reset_token = '';  // Blank entry is never valid token so it is safe to set it to blank
            $user->generateAuthKey(); // Auth key needs to be generated since it just compared for equality AND blank values are accepted!
            
            $user->save();
        }
        
        // Transfer the email domains
        $command = $connection->createCommand('SELECT * FROM EmailDomains where ID >= 100');
        $rs = $command->queryAll();
        //print_r($rs);
        foreach ($rs as $r) {
            $this->insert('tbl_emaildomain', [
                'id' => $r['id'],
                'name' => $r['name'],
                'owner_id' => $r['owner_ref'],
                'stickyownership'=> $r['stickyownership'],
                'description' => $r['description'],
            ]);
            
        }

        // Transfer the email entities
        $command = $connection->createCommand('SELECT * FROM EmailEntities where ID >= 100');
        $rs = $command->queryAll();
        //print_r($rs);
        foreach ($rs as $r) {
            $this->insert('tbl_emailentity', [
                'id' => $r['id'],
                'emaildomain_id' => $r['emaildomain_ref'],
                'name' => $r['name'],
                'sortname' => $r['sortname'],
                'owner_id' => $r['owner_ref'],
                'comment' => $r['comment'],
            ]);
        }

        // Transfer the email mappings
        $command = $connection->createCommand(
            "SELECT
                EmailMappings.*,
                coalesce((SELECT concat_with_comma(ResolvedRecipientAlias) FROM RecipientAliases
                    WHERE RecipientAliases.EmailMapping_Ref = EmailMappings.ID),'') as resolvedtarget,
                coalesce((SELECT concat_with_comma(RecipientAlias) FROM RecipientAliases
                    WHERE RecipientAliases.EmailMapping_Ref = EmailMappings.ID),'') as target
                FROM EmailMappings where ID >= 100 and EmailArea_Ref < 255");
        $rs = $command->queryAll();
        //print_r($rs);
        foreach ($rs as $r) {
            $this->insert('tbl_emailmapping', [
                'id' => $r['id'],
                'emailentity_id' => $r['emailentity_ref'],
                'emailarea_id' => $r['emailarea_ref'],
                'resolvedaddress' => '',
                'target' => $r['target'].($r['isvirtual']?',':''),
                'resolvedtarget' => $r['resolvedtarget'].($r['isvirtual']?',':''),
                //'preferredemailaddress' => $r['preferredemailaddress'],
                //'targetformula' => $r['targetformula'],
                //'senderbcc' => $r['senderbcc'],
                'isvirtual' => $r['isvirtual'],
            ]);
        }

$sql = <<<'EOT'
  select
      setval('tbl_user_id_seq', (select max(id) from tbl_user)),
      setval('tbl_emaildomain_id_seq',(select max(id) from tbl_emaildomain)),
      setval('tbl_emailentity_id_seq',(select max(id) from tbl_emailentity)),
      setval('tbl_emailmapping_id_seq',(select max(id) from tbl_emailmapping)),
      '';
EOT;
$this->execute($sql);

        foreach (Emailentity::find()->where('id >= 100')->all() as $e) {
            if (!$e->saveDeep()) {
                $e->saveDeep(false);
                echo "\n\n ==== Validation failed for the following email entity:\n\n";
                var_dump($e);
                foreach ($e->emailmappings as $m) {
                    var_dump($m);
                }
                echo "\n\n ==== \n\n";
            }
        }
        // Transfer the foreign email acounts
        // Must be after the saving of the emailentities since ony then resolvedaddress is calculated!
        $command = $connection->createCommand(
            "SELECT
                ForeignEmailAccounts.*
                FROM ForeignEmailAccounts where ConfirmationLevel = 0");
        $rs = $command->queryAll();
        //print_r($rs);
        foreach ($rs as $r) {
            $alias = Emailmapping::findOne([
                'resolvedaddress' => $r['canonicalsenderalias'],
            ]);
            $this->insert('tbl_foreignemailaccount', [
                'id' => $r['id'],
                'emailaddress' => $r['emailaddress'],
                'confirmationlevel' =>  $r['confirmationlevel'],
                'owner_id' => $r['owner_ref'],
                'senderalias_id' => is_null($alias)?NULL:$alias->id,
                'confirmation_token' => NULL
            ]);
        }

$sql = <<<'EOT'
  select
      setval('tbl_foreignemailaccount_id_seq',(select max(id) from tbl_foreignemailaccount)),
      '';
EOT;
$this->execute($sql);
    }

    public function safeDown()
    {
        $this->execute("DELETE FROM tbl_user where id >= 100");
        $this->execute("DELETE FROM tbl_emailmapping where id >= 100");
        $this->execute("DELETE FROM tbl_emailentity where id >= 100");
        $this->execute("DELETE FROM tbl_emaildomain where id >= 100");
    }
}
