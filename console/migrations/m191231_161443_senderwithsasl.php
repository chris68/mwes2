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
         owner_id                                              int NOT NULL
           CONSTRAINT NoSaslAccountsForRoot CHECK (owner_id<>0),
         senderalias_id                                        int, -- the sender (email mapping) the access is for
         accesshint                                            text NOT NULL, -- hint for the user about the access
         token_sha512                                          bytea NOT NULL, -- the sha512 hash of the tokem saved by the user
         PRIMARY KEY (ID),
         FOREIGN KEY (owner_id) REFERENCES tbl_user (id) ON UPDATE CASCADE ON DELETE CASCADE,
         FOREIGN KEY (senderalias_id) REFERENCES tbl_emailmapping (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITH OIDS;
EOT;
$this->execute($sql);

        
$sql = <<<'EOT'
CREATE OR REPLACE VIEW PostfixSenderWithSASL AS -- View needed for postfix (mapping )
  SELECT
    m.resolvedaddress Sender
  FROM tbl_emailmapping m
  WHERE 
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
DROP TABLE tbl_saslaccount;
DROP EXTENSION pgcrypto ;
EOT;

$this->execute($sql);
    }
}
