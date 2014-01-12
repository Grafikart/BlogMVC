<?php

return array(
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => include 'module.config.templatemap.php',
        /**
         * We can add this for an automatic template path resolving but it's not the best for performance
         *
         * 'template_path_stack' => array(
         *      __DIR__ . '/../view',
         *  ),
         */
    ),
    // Controller
    'controllers' => include 'module.config.controllers.php',
    // Controller Plugin
    'controller_plugins' => include 'module.config.plugins.php',
    // View Helper
    'view_helpers' => include 'module.config.viewhelpers.php',
    // Service manager
    'service_manager' => include 'module.config.servicemanager.php',
    // Form element manager
    'form_elements' => include 'module.config.formelements.php',
    // Doctrine config
    'doctrine' => include 'module.config.doctrine.php',
    // Translator
    'translator' => array(
        'locale' => 'en_EN',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    // Routes
    'router' => include 'module.config.routes.php',
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(),
        ),
    ),
);
