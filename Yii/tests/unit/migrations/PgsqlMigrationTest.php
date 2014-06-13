<?php

/**
 * A simpel test to ensure migrations are safely applied on PostgreSQL
 * installations.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class PgsqlMigrationTest extends BaseMigrationTest
{
    /**
     * Database provider name.
     *
     * @type string
     * @since 0.1.0
     */
    public static $provider = 'pgsql';
}
