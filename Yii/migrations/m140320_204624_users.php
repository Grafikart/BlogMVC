<?php

class m140320_204624_users extends CDbMigration
{
    public function up()
    {
        $this->createTable('users', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'password' => 'string NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable('users');
    }
}