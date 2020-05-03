<?php

use yii\db\Migration;

/**
 * Class m200503_174853_delete_old_dot_all_mapping
 */
class m200503_174853_delete_old_dot_all_mapping extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('tbl_emailarea',['id' => 256]); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200503_174853_delete_old_dot_all_mapping cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200503_174853_delete_old_dot_all_mapping cannot be reverted.\n";

        return false;
    }
    */
}
