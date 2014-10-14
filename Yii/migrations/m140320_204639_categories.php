<?php

class m140320_204639_categories extends CDbMigration
{
    public function up()
    {
        $this->createTable('categories', array(
            'id' => 'pk',
            'name' => 'VARCHAR(50) NOT NULL',
            'slug' => 'VARCHAR(50) NOT NULL',
            'post_count' => 'INTEGER NOT NULL DEFAULT 0',
            // well, dump.sql was specifying it that way
            //'post_count' => 'VARCHAR(50) NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable('categories');
    }
}
