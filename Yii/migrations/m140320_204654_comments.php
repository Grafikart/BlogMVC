<?php

class m140320_204654_comments extends CDbMigration
{
    public function up()
    {
        $this->createTable('comments', array(
            'id' => 'pk NOT NULL',
            'post_id' => 'int NOT NULL',
            'username' => 'string NOT NULL',
            'mail' => 'string NOT NULL',
            'content' => 'mediumtext NOT NULL',
            'created' => 'datetime NOT NULL',
            'CONSTRAINT fk_comments_posts FOREIGN KEY (post_id) REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE'
        ));
        /* Commented because of SQLite impossibility ot create foreign keys on-the-fly
        $this->addForeignKey(
            'fk_comments_posts',
            'comments',
            'post_id',
            'posts',
            'id',
            'CASCADE',
            'CASCADE'
        );
         */
    }

    public function down()
    {
        /* Commented because of SQLite impossibility ot create foreign keys on-the-fly
        $this->dropForeignKey('fk_comments_posts', 'comments');
         */
        $this->dropTable('comments');
    }
}