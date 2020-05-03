<?php

use yii\db\Migration;

/**
 * Class m200503_175912_add_emailarea_mobile
 */
class m200503_175912_add_emailarea_mobile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('tbl_emailarea',['id' => 5]); 
        $this->update('tbl_emailarea',['id' => 5], 'id = 4'); 
        $this->update('tbl_emailarea',['id' => 4], 'id = 3'); 
        $this->insert('tbl_emailarea',['id' => 3, 'name'=>'mobile','resolvedname'=>'+mobile', 'description'=>'Mobile account']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200503_175912_add_emailarea_mobile cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200503_175912_add_emailarea_mobile cannot be reverted.\n";

        return false;
    }
    */
}
