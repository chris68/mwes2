<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\User;

class m141209_011946_email_tables extends Migration
{
    public function safeUp()
    {
        $user = new User();
        $user->id = 0;
        $user->username = 'root';
        $user->email = 'root@mailwitch.com';
        $user->generateSystemPassword();
        $user->save();

        $user = new User();
        $user->id = 1;
        $user->username = 'postmaster';
        $user->email = 'postmaster@mailwitch.com';
        $user->generateSystemPassword();
        $user->save();

        $user = new User();
        $user->id = 2;
        $user->username = 'webmaster';
        $user->email = 'webmaster@mailwitch.com';
        $user->generateSystemPassword();
        $user->save();

        $user = new User();
        $user->id = 3;
        $user->username = 'hostmaster';
        $user->email = 'hostmaster@mailwitch.com';
        $user->generateSystemPassword();
        $user->save();

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
$this->insert('tbl_emaildomain',['id' => 0, 'name'=>'main','description'=>'The global domain', 'owner_id' => 0]);
$this->insert('tbl_emaildomain',['id' => 1, 'name'=>'guests','description'=>'Temporary guest acccounts', 'owner_id' => 0]);
$this->insert('tbl_emaildomain',['id' => 2, 'name'=>'root','description'=>'Special email addresses', 'owner_id' => 0]);

$sql = <<<'EOT'
CREATE TABLE tbl_emailarea
(
    id                                                    int NOT NULL,
    name                                                  text NOT NULL check ((name)=lower(name)),
    resolvedname                                          text NOT NULL check ((resolvedname)=lower(resolvedname)),
    description                                           text NOT NULL DEFAULT '',
    PRIMARY KEY (id),
    UNIQUE (name),
    UNIQUE (resolvedname)
) WITH OIDS;
EOT;
$this->execute($sql);

$this->insert('tbl_emailarea',['id' => 0, 'name'=>'main','resolvedname'=>'', 'description'=>'Main account']);
$this->insert('tbl_emailarea',['id' => 1, 'name'=>'work','resolvedname'=>'+work', 'description'=>'Work account']);
$this->insert('tbl_emailarea',['id' => 2, 'name'=>'home','resolvedname'=>'+home', 'description'=>'Home account']);
$this->insert('tbl_emailarea',['id' => 3, 'name'=>'extra1','resolvedname'=>'+extra1', 'description'=>'Extra account 1']);
$this->insert('tbl_emailarea',['id' => 4, 'name'=>'extra2','resolvedname'=>'+extra2', 'description'=>'Extra account 2']);
$this->insert('tbl_emailarea',['id' => 5, 'name'=>'extra3','resolvedname'=>'+extra3', 'description'=>'Extra account 3']);
$this->insert('tbl_emailarea',['id' => 255, 'name'=>'all','resolvedname'=>'+all', 'description'=>'All accounts']);
$this->insert('tbl_emailarea',['id' => 256, 'name'=>'all-dot','resolvedname'=>'.all', 'description'=>'All accounts (dot style)']);
$this->insert('tbl_emailarea',['id' => 256+1, 'name'=>'work-dot','resolvedname'=>'.work', 'description'=>'Work account (dot style)']);
$this->insert('tbl_emailarea',['id' => 256+2, 'name'=>'home-dot','resolvedname'=>'.home', 'description'=>'Home account (dot style)']);
$this->insert('tbl_emailarea',['id' => 256+3, 'name'=>'extra1-dot','resolvedname'=>'.extra1', 'description'=>'Extra account 1 (dot style)']);
$this->insert('tbl_emailarea',['id' => 256+4, 'name'=>'extra2-dot','resolvedname'=>'.extra2', 'description'=>'Extra account 2 (dot style)']);
$this->insert('tbl_emailarea',['id' => 256+5, 'name'=>'extra3-dot','resolvedname'=>'.extra3', 'description'=>'Extra account 3 (dot style)']);


$sql = <<<'EOT'
CREATE TABLE tbl_emailentity
(
    id                                                    serial NOT NULL
      CONSTRAINT SystemIDsOnlyForRootInSystemDomains CHECK (id<100 AND owner_id = 0 AND emaildomain_id <100 OR id>=100),
    emaildomain_id                                        int NOT NULL,
    name                                                  text NOT NULL check ((name)=lower(name)),
    sortname                                              text NOT NULL DEFAULT '',
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
    resolvedaddress                                       text NOT NULL check ((resolvedaddress)=lower(resolvedaddress)),
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

$this->execute("DELETE FROM tbl_user");
    }
}
