<?php

use yii\db\Schema;
use yii\db\Migration;

class m141230_020155_postfix_views extends Migration
{
    public function safeUp()
    {
$sql = <<<'EOT'
CREATE OR REPLACE VIEW PostfixRecipientAliases AS
  SELECT
    m.resolvedaddress Source,
    m.resolvedtarget as Target,
    m.IsVirtual as IsVirtual
  FROM tbl_emailmapping m;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE OR REPLACE VIEW PostfixSenderAliases AS
  SELECT
    f.emailaddress as source,
    e.resolvedaddress as target
  FROM tbl_foreignemailaccount f join tbl_emailmapping e on f.senderalias_id = e.id
  WHERE confirmationlevel = 0;
EOT;
$this->execute($sql);



    }

    public function safeDown()
    {
$sql = <<<'EOT'
DROP VIEW PostfixRecipientAliases;
EOT;

$this->execute($sql);
$sql = <<<'EOT'
DROP VIEW PostfixSenderAliases;
EOT;
$this->execute($sql);
    }
}
