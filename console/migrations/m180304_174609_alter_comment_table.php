<?php

use yii\db\Migration;

/**
 * Class m180304_174609_alter_comment_table
 */
class m180304_174609_alter_comment_table extends Migration
{


    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('comment', 'status', $this->integer()->defaultValue(1));
    }

    public function down()
    {
        $this->alterColumn('comment', 'status', $this->integer());
    }
    
}
