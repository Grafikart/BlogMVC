<?php
namespace Codeception\Module;

/**
 * This helper applies and reverts migrations.
 *
 * @version Release: 0.1.0
 * @since   0.1.0
 * @author  Fike Etki <etki@etki.name>
 */
class MigrationHelper extends \Codeception\Module
{
    /**
     * Migration command instance.
     *
     * @var \MigrateCommand
     * @since 0.1.0
     */
    protected $_command;
    /**
     * Whether to hide or show migration output.
     *
     * @var bool
     * @since 0.1.0
     */
    public $_hideOutput = true;
    /**
     * Current instance.
     *
     * @var static
     * @since 0.1.0
     */
    protected static $_instance;

    /**
     * {@inheritdoc}
     */
    public function __construct($config=null)
    {
        parent::__construct($config);
        \Yii::import('system.cli.commands.MigrateCommand');
        $configFile = \Yii::getPathOfAlias('application.config.console').'.php';
        $config = include $configFile;
        $this->_command = new \MigrateCommand(null, null);
        foreach ($config['commandMap']['migrate'] as $option => $value) {
            if ($option === 'class') {
                continue;
            } else if ($option === 'migrationPath') {
                $this->_command->$option = \Yii::getPathOfAlias($value);
            } else {
                $this->_command->$option = $value;
            }
        }
        $this->_command->interactive = false;
        static::$_instance = $this;
    }

    /**
     * Typical getter.
     *
     * @param null $config
     *
     * @return static
     * @since
     */
    public static function getInstance($config=null)
    {
        if (!isset(static::$_instance)) {
            static::$_instance = new static($config);
        }
        return static::$_instance;
    }

    /**
     * Migrate up.
     *
     * @param null|int $amount Number of applied migrations, set to null to
     * apply all.
     *
     * @return void
     * @since 0.1.0
     */
    public function applyMigrations($amount=null)
    {
        $this->_mute();
        $this->_command->actionUp(array($amount));
        $this->_unmute();
    }

    /**
     * Migrate down.
     *
     * @param int $amount Number of reverted migrations.
     *
     * @return void
     * @since 0.1.0
     */
    public function revertMigrations($amount=1)
    {
        $this->_mute();
        $this->_command->actionDown(array($amount));
        $this->_unmute();
    }

    /**
     *
     *
     * @param bool $force
     *
     * @return void
     * @since
     */
    protected function _mute($force=false)
    {
        if ($this->_hideOutput || $force) {
            ob_start();
        }
    }

    /**
     *
     *
     * @param bool $force
     *
     * @return void
     * @since
     */
    protected function _unmute($force=false)
    {
        if ($this->_hideOutput || $force) {
            ob_end_clean();
        }
    }
}