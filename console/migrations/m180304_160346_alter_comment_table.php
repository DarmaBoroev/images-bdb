<?php

use yii\db\Migration;

/**
 * Class m180304_160346_alter_comment_table
 */
class m180304_160346_alter_comment_table extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('comment', 'status', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('comment', 'status');
    }
    
}
