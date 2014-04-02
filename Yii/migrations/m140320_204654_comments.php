<?php

class m140320_204654_comments extends CDbMigration
{
    public function up()
    {
        $comments = array(
            'id' => 'pk NOT NULL',
            'post_id' => 'int NOT NULL',
            'username' => 'string NOT NULL',
            'mail' => 'string NOT NULL',
            'content' => 'MEDIUMTEXT NOT NULL',
            'created' => 'DATETIME NOT NULL',
            'CONSTRAINT fk_comments_posts FOREIGN KEY (post_id) REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE'
        );
       if ($this->getDbConnection()->getDriverName() === 'pgsql') {
           $comments['content'] = 'TEXT NOT NULL';
           $comments['created'] = 'TIMESTAMP NOT NULL';
       }
        $this->createTable('comments', $comments);
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