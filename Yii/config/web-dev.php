<?php
return CMap::mergeArray(
    include __DIR__.'/web.php',
    array(
        'components' => array(
            'request' => array(
                'baseUrl' => '',
            ),
            'errorHandler' => array(
                'errorAction' => null,
            ),
            'log' => array(
                'routes' => array(
                    'web' => array(
                        'class' => 'CWebLogRoute',
                    ),
                    'profile' => array(
                        'class' => 'CProfileLogRoute',
                    ),
                ),
            ),
        )
    )
);
