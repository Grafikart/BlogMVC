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
    $config['language'] = isset($_REQUEST['language']) ? $_REQUEST['language'] : 'testing';
}
return $config;