<?php

use yii\db\Migration;

/**
 * Class m180317_125716_alter_table_user_drop_index_unique_on_username
 */
class m180317_125716_alter_table_user_drop_index_unique_on_username extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('username', 'user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createIndex('username', 'user', 'username', $unique = true);
    }

}
