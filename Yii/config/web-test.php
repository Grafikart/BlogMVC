<?php
$config = \CMap::mergeArray(
    require __DIR__.'/testing.php',
    array(
        'components' => array(
            'request' => array(
                'baseUrl' => '',
            ),
            'db' => include __DIR__.'/db-test.php',
        )
    )
);
$config['components']['log']['routes'] = array();
$useDefaultLanguage = isset($_REQUEST['useDefaultLanguage'])
    || isset($_COOKIE['useDefaultLanguage']);
if (!$useDefaultLanguage) {
    if (isset($_REQUEST['language'])) {
        $config['language'] = $_REQUEST['language'];
    } elseif (isset($_COOKIE['language'])) {
        $config['language'] = $_COOKIE['language'];
    } else {
        $config['language'] = 'testing';
    }
}
return $config;