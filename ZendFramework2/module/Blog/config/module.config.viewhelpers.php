<?php
return array(
    'invokables' => array(
        'Markdown'      => 'Blog\View\Helper\Markdown',
        'Truncate'      => 'Blog\View\Helper\Truncate',
        'TimeAgo'       => 'Blog\View\Helper\TimeAgo',
    ),
    'factories' => array(
        'messenger' => 'Blog\Factory\MessengerWidgetFactory',
    )
);