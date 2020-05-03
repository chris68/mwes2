<?php

use yii\db\Migration;

/**
 * Class m191231_161443_senderwithsasl
 */
class m191231_161443_senderwithsasl extends Migration
{
    public function safeUp()
    {
$sql = <<<'EOT'
CREATE EXTENSION pgcrypto; -- Extension for crypro functions
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE TABLE tbl_saslaccount
(
         id                                                    serial NOT NULL,
         senderalias_id                                        int, -- the sender (email mapping) the access is for
         accesshint                                            text NOT NULL, -- hint for the user about the access
         token_sha512                                          bytea NOT NULL, -- the sha512 hash of the token saved by the user
         token_unhashed                                        text, -- the unhashed token (only for entry, will not be saved but converted by a trigger)
         PRIMARY KEY (ID),
         FOREIGN KEY (senderalias_id) REFERENCES tbl_emailmapping (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITH OIDS;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE OR REPLACE FUNCTION tbl_saslaccount_hash_token()
  RETURNS trigger AS
$$
BEGIN
    IF NEW.token_unhashed IS NOT NULL THEN
        NEW.token_sha512 = digest(NEW.token_unhashed,'sha512');
        NEW.token_unhashed = NULL;
    END IF;
    RETURN NEW;
END;
$$
LANGUAGE 'plpgsql';
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE TRIGGER tbl_saslaccount_ins_token
  BEFORE INSERT
  ON tbl_saslaccount
  FOR EACH ROW
  EXECUTE PROCEDURE tbl_saslaccount_hash_token();
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE TRIGGER tbl_saslaccount_upd_token
  BEFORE UPDATE
  ON tbl_saslaccount
  FOR EACH ROW
  EXECUTE PROCEDURE tbl_saslaccount_hash_token();
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE OR REPLACE VIEW PostfixSenderWithSASL AS -- View needed for postfix (mapping )
  SELECT
    m.resolvedaddress Sender
  FROM tbl_emailmapping m
  WHERE 
    not locked and
    exists 
    (
        select 1 from tbl_emailentity 
        where 
            id = m.emailentity_id and
            emaildomain_id = 0 and -- only top level domains for the time being
            owner_id = 102 -- only ctoussa for the time being
    )
 ;        
EOT;
$this->execute($sql);



    }

    public function safeDown()
    {
$sql = <<<'EOT'
DROP VIEW PostfixSenderWithSASL ;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
DROP TABLE tbl_saslaccount;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
DROP EXTENSION pgcrypto ;
EOT;
$this->execute($sql);
    }
}
