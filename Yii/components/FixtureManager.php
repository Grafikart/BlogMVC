<?php

/**
 * This is an overridden version of CDbFixtureManager that allows to avoid
 * RI_ConstraintTrigger error on PostgreSQL databases by disabling integrity
 * checks.
 *
 * @see http://www.yiiframework.com/forum/index.php/topic/11135-postgres-fixtures-bug-ri-constrainttrigger/
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class FixtureManager extends CDbFixtureManager
{
    /**
     * {@inheritdoc}
     *
     * @return void
     * @since 0.1.0
     */
    public function prepare()
    {
        $initFile = $this->basePath . DIRECTORY_SEPARATOR . $this->initScript;

        //$this->checkIntegrity(false);

        if (is_file($initFile)) {
            include $initFile;
        } else {
            foreach (array_keys($this->getFixtures()) as $tableName) {
                $this->resetTable($tableName);
                $this->loadFixture($tableName);
            }
        }
        //$this->checkIntegrity(true);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $fixtures fixtures to be loaded. The array keys are fixture
     * names, and the array values are either AR class names or table names. If
     * table names, they must begin with a colon character (e.g. 'Post' means
     * an AR class, while ':Post' means a table name).
     *
     * @return void
     * @since 0.1.0
     */
    public function load($fixtures)
    {
        //$schema = $this->getDbConnection()->getSchema();
        //$schema->checkIntegrity(false);

        $this->_rows = array();
        $this->_records = array();
        foreach ($fixtures as $fixtureName => $tableName) {
            if ($tableName[0] === ':') {
                $tableName = substr($tableName, 1);
                unset($modelClass);
            } else {
                $modelClass = \Yii::import($tableName, true);
                $tableName = CActiveRecord::model($modelClass)->tableName();
            }
            if (($prefix = $this->getDbConnection()->tablePrefix) !== null) {
                $tableName = preg_replace(
                    '/{{(.*?)}}/',
                    $prefix . '\1',
                    $tableName
                );
            }
            $this->resetTable($tableName);
            $rows = $this->loadFixture($tableName);
            if (is_array($rows) && is_string($fixtureName)) {
                $this->_rows[$fixtureName] = $rows;
                if (isset($modelClass)) {
                    foreach (array_keys($rows) as $alias) {
                        $this->_records[$fixtureName][$alias] = $modelClass;
                    }
                }
            }
        }

        //$schema->checkIntegrity(true);
    }
}
