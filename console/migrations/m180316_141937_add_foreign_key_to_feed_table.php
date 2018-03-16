<?php

use yii\db\Migration;

/**
 * Class m180316_141937_add_foreign_key_to_feed_table
 */
class m180316_141937_add_foreign_key_to_feed_table extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createIndex('FK_post_feed', '{{%feed}}', 'post_id');
        $this->addForeignKey('FK_post_feed', '{{%feed}}', 'post_id', '{{%post}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropIndex('FK_post_feed', '{{%feed}}');
        $this->dropForeignKey('FK_post_feed', '{{%feed}}');
    }
    
}
