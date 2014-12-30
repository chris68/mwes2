<?php

use yii\db\Schema;
use yii\db\Migration;

class m141209_011946_email_tables extends Migration
{
    public function safeUp()
    {
$sql = <<<'EOT'
CREATE TABLE tbl_emaildomain
(
    id                                                    serial NOT NULL
      CONSTRAINT SystemIDsOnlyForRoot CHECK (id<100 AND owner_id=0 OR id>=100),
    name                                                  text NOT NULL check ((name)=lower(name)),
    owner_id                                              int NOT NULL,
    stickyownership                                       boolean NOT NULL DEFAULT false
       CONSTRAINT MainDomainNeverSticky CHECK (id<>0 OR  NOT stickyownership),
    description                                           text NOT NULL DEFAULT '',
    PRIMARY KEY (id),
    UNIQUE (name), -- Name must be unique
    FOREIGN KEY (owner_id) REFERENCES tbl_user (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITH OIDS;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE TABLE tbl_emailarea
(
    id                                                    int NOT NULL,
    name                                                  text NOT NULL check ((name)=lower(name)),
    description                                           text NOT NULL DEFAULT '',
    PRIMARY KEY (id),
    UNIQUE (name) -- Name must be unique
) WITH OIDS;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
CREATE TABLE tbl_emailentity
(
    id                                                    serial NOT NULL
      CONSTRAINT SystemIDsOnlyForRootInSystemDomains CHECK (id<100 AND owner_id = 0 AND emaildomain_id <100 OR id>=100),
    emaildomain_id                                        int NOT NULL,
    name                                                  text NOT NULL check ((name)=lower(name)),
    sortname                                              text NOT NULL,
    comment                                               text NOT NULL DEFAULT '',
    owner_id                                              int NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (emaildomain_id, name), -- actual key
    FOREIGN KEY (emaildomain_id) REFERENCES tbl_emaildomain (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (owner_id) REFERENCES tbl_user (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITH OIDS;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE TABLE tbl_emailmapping
(
    id                                                    serial NOT NULL
      CONSTRAINT NoSystemIDsAllowedForRealMappings CHECK (id>=100  or emailarea_id = 255),
    emailentity_id                                        int NOT NULL
      CONSTRAINT NoRealMappingsForSystemEmailEntities CHECK (emailentity_id>=100 or emailarea_id = 255),
    emailarea_id                                          int NOT NULL,
    target                                                text NOT NULL,
    resolvedtarget                                        text NOT NULL,
    preferredemailaddress                                 text,
    targetformula                                         text
      check (trim(targetformula) = targetformula and targetformula <> ''), -- garantueed to be not empty and trimmed
    senderbcc                                             text,
    isvirtual                                             boolean NOT NULL DEFAULT TRUE,
    locked                                                boolean NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    UNIQUE (emailentity_id, emailarea_id), -- actual key
    FOREIGN KEY (emailentity_id) REFERENCES tbl_emailentity (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (emailarea_id) REFERENCES tbl_emailarea (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITH OIDS;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
  select 
      setval('tbl_user_id_seq',99), 
      setval('tbl_emaildomain_id_seq',99),
      setval('tbl_emailentity_id_seq',99),
      setval('tbl_emailmapping_id_seq',99),
      '';
EOT;
$this->execute($sql);

  
    }

    public function safeDown()
    {
$sql = <<<'EOT'
DROP TABLE tbl_emailmapping CASCADE;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
DROP TABLE tbl_emailentity CASCADE;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
DROP TABLE tbl_emailarea CASCADE;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
DROP TABLE tbl_emaildomain CASCADE;
EOT;
$this->execute($sql);
    }
}