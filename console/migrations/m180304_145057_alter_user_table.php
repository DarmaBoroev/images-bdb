<?php

use yii\db\Migration;

/**
 * Class m180304_145057_alter_user_table
 */
class m180304_145057_alter_user_table extends Migration
{



    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('user', 'small_image', $this->string());
    }

    public function down()
    {
        $this->dropColumn('user', 'small_image');
    }

}
