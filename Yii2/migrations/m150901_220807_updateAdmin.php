<?php

use yii\db\Migration;

class m150901_220807_updateAdmin extends Migration
{
    public function up()
    {
        $this->update('users', ['password' => \Yii::$app->getSecurity()->generatePasswordHash('admin')], 'id = 1');
    }

    public function down()
    {
        echo "m150901_220807_updateAdmin cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
