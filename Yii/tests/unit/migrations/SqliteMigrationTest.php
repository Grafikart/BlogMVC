<?php

/**
 * Tests migration applying against sqlite database.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class SqliteMigrationTest extends BaseMigrationTest
{
    /**
     * Database provider name.
     *
     * @type string
     * @since 0.1.0
     */
    public static $provider = 'sqlite';
}
