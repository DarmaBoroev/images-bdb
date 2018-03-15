<?php

use yii\db\Migration;

/**
 * Class m180315_133527_alter_table_post_add_column_complaints
 */
class m180315_133527_alter_table_post_add_column_complaints extends Migration
{

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%post}}', 'complaints', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%post}}', 'complaints');
    }
    
}
