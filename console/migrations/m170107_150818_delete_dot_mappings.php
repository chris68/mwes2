<?php

use yii\db\Migration;

class m170107_150818_delete_dot_mappings extends Migration
{
    public function safeUp()
    {
        $this->delete('tbl_emailarea',['id' => 256+1]);
        $this->delete('tbl_emailarea',['id' => 256+2]);
        $this->delete('tbl_emailarea',['id' => 256+3]);
        $this->delete('tbl_emailarea',['id' => 256+4]);
        $this->delete('tbl_emailarea',['id' => 256+5]);

    }

    public function safeDown()
    {
        echo "m170107_150818_delete_dot_mappings cannot be reverted.\n";

        return false;
    }

}
