<?php

use yii\db\Migration;

/**
 * Handles the creation of table `feed`.
 */
class m180306_122116_create_feed_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('feed', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('feed');
    }
}
