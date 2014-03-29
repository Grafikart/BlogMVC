<?php

/**
 * Description of MysqlMigrationTest
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package etki-tools
 * @subpackage <subpackage>
 */
class MysqlMigrationTest extends BaseMigrationTest
{
    public static function getDbProviderName() {
        return 'mysql';
    }
}
