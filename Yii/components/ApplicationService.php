<?php

/**
 * Description of ApplicationService
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class ApplicationService
{
    public $files = array();
    public function init() {
        foreach($this->files as $preloadedFileAlias) {
            $path = Yii::getPathOfAlias($preloadedFileAlias).'.php';
            include($path);
        }
    }
    public function getData()
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
    protected function getUptime()
    {
        if (!file_exists('/proc/uptime')) {
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
    protected function getTwigVersion()
    {
        $fallback = 'unknown (presumably 1.15)';
        $alias = 'application.vendor.twig.twig.composer';
        $filePath = Yii::getPathOfAlias($alias).'.json';
        if (!file_exists($filePath) || ($json = file_get_contents($filePath)) === false) {
            return $fallback;
        }
        $data = CJSON::decode($json, true);
        foreach (array('extra', 'branch-alias', 'dev-master') as $key) {
            if (!isset($data[$key])) {
                return $fallback;
            }
            $data = $data[$key];
        }
        return $data;
    }
}
