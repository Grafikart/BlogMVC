<?php
$config = \CMap::mergeArray(
    require __DIR__.'/testing.php',
    array(
        'components' => array(
            'request' => array(
                'baseUrl' => '',
            )
        )
    )
);
$config['components']['log']['routes'] = array();
if (!isset($_REQUEST['useDefaultLanguage'])) {
    if (isset($_REQUEST['language'])) {
        $config['language'] = $_REQUEST['language'];
    } elseif (isset($_COOKIE['language'])) {
        $config['language'] = $_COOKIE['language'];
    } else {
        $config['language'] = 'testing';
    }
}
return $config;