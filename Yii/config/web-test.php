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
if (!isset($_GET['useDefaultLanguage'])) {
    $config['language'] = isset($_GET['language']) ? $_GET['language'] : 'testing';
}
return $config;