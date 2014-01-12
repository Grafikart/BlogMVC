<?php
return array(
    'invokables' => array(
        'Markdown'      => 'Blog\View\Helper\Markdown',
        'Truncate'      => 'Blog\View\Helper\Truncate',
        'Gravatar'      => 'Blog\View\Helper\Gravatar',
        'TimeAgo'       => 'Blog\View\Helper\TimeAgo',
    ),
    'factories' => array(
        'messenger' => 'Blog\Factory\MessengerWidgetFactory',
    )
);