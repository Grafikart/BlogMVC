<?php

class m140320_204646_posts extends CDbMigration
{
    public function up()
    {
        $this->createTable('posts', array(
            'id' => 'pk',
            'category_id' => 'int NOT NULL',
            'user_id' => 'int NOT NULL',
            'name' => 'string NOT NULL',
            'slug' => 'string NOT NULL',
            'content' => 'LONGTEXT NOT NULL',
            'created' => 'datetime NOT NULL',
            'CONSTRAINT fk_posts_categories FOREIGN KEY (category_id) REFERENCES categories(id) ON UPDATE CASCADE ON DELETE RESTRICT',
            'CONSTRAINT fk_posts_users FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE'
        ));
        /* Commented because of SQLite impossibility ot create foreign keys on-the-fly
        $this->addForeignKey(
            'fk_posts_categories',
            'posts',
            'category_id',
            'categories',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_posts_users',
            'posts',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
        */
    }

    public function down()
    {
        /* Commented because of SQLite impossibility ot create foreign keys on-the-fly
        $this->dropForeignKey('fk_posts_categories', 'posts');
        $this->dropForeignKey('fk_posts_users', 'posts');
         */
        $this->dropTable('posts');
    }
}