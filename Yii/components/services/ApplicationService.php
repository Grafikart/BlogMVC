<?php

/**
 * This class holds all functionality regarding the service en masse: it
 * provides service-related information and (currently) serves as an
 * autoloader for Yii-incompatible classes.
 *
 * @todo 'Autoloading' means Twig should load automatically, not that some
 * ApplicationService takes files as input and includes them one by one.
 * 
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 */
class ApplicationService
{
    /**
     * List of files that needs to be autoloaded in Yii-alias form
     * (root.dir.dir.filename).
     * 
     * @var string[]
     * @since 0.1.0
     */
    public $files = array();
    /**
     * Standard initialization method.
     * 
     * @return void
     * @since 0.1.0
     */
    public function init() {
        foreach($this->files as $preloadedFileAlias) {
            $path = Yii::getPathOfAlias($preloadedFileAlias).'.php';
            include($path);
        }
    }
    /**
     * Returns basic service info, such as uptime, Yii version, etc. Uses
     * cache to store that information for a minute.
     * 
     * @return string[] Server and software information in :title => :value
     * format.
     * @since 0.1.0
     */
    public function getServiceInfo()
    {
        $cache = Yii::app()->cache->get('serviceStatus');
        if ($cache) {
            return $cache;
        }
        $data = array( // different names just to stop netbeans multiple assignment whining
            'Yii version' => Yii::getVersion(),
            'Twig version' => $this->getTwigVersion(),
            'PHP version' => PHP_VERSION,
            'Operating system' => php_uname(),
            'Uptime' => $this->getUptime(),
            'Server time' => date('Y-m-d H:i'),
        );
        Yii::app()->cache->set('serviceStatus', $data, 60);
        return $data;
    }
    /**
     * Returns server uptime (if /proc/uptime can be found and read).
     * 
     * @return string 'Days:hours:minutes' or 'unknown' on failure.
     * @since 0.1.0
     */
    protected function getUptime()
    {
        if (!file_exists('/proc/uptime') || !is_readable('/proc/uptime')) {
            return 'unknown';
        }
        $data = file_get_contents('/proc/uptime');
        if (!$data) {
            return 'unknown';
        }
        $seconds = (int) $data;
        return sprintf('%dd:%dh:%dm',
            floor($seconds/86400),
            $seconds/3600 % 24,
            $seconds/60 % 60
        );
    }
    /**
     * Returns twig version.
     * 
     * @return string Actual or supposed Twig version.
     * @since 0.1.0
     */
    protected function getTwigVersion()
    {
        $fallback = 'unknown (presumably 1.15)';
        $alias = 'application.vendor.twig.twig.composer';
        $filePath = Yii::getPathOfAlias($alias).'.json';
        if (!file_exists($filePath) || ($json = file_get_contents($filePath)) === false) {
            return $fallback;
        }
        $data = CJSON::decode($json, true);
        foreach (array('extra', 'branch-alias') as $key) {
            if (!isset($data[$key])) {
                return $fallback;
            }
            $data = reset($data[$key]);
        }
        return $data;
    }
}
