<?php
namespace Codeception\Module;

use \Codeception\Util\Fixtures;

/**
 * Resets settings on demand.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package _support\helpers
 * @author  Fike Etki <etki@etki.name>
 */
class SettingsHelper extends \Codeception\Module
{
    /**
     * Resets application settings.
     *
     * @return void
     * @since 0.1.0
     */
    public function resetApplicationSettings()
    {
        $appModel = new \ApplicationModel;
        $appModel->language = Fixtures::get('defaults:app:language');
        $appModel->name = Fixtures::get('defaults:app:name');
        $appModel->theme = Fixtures::get('defaults:app:theme');
        $appModel->save();
    }
}
 