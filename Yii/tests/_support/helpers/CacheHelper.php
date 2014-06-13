<?php
namespace Codeception\Module;

/**
 * Just a simple runtime cache registry for default application variables.
 *
 * @version Release: 0.1.0
 * @since   0.1.0
 * @package Codeception\Module
 * @author  Fike Etki <etki@etki.name>
 */
class CacheHelper
{
    /**
     * Default application title.
     *
     * @var string
     * @since 0.1.0
     */
    public static $title;
    /**
     * Default application language.
     *
     * @var string
     * @since 0.1.0
     */
    public static $lang;
    /**
     * Default application theme.
     *
     * @var string
     * @since 0.1.0
     */
    public static $theme;

    /**
     * Initializer method.
     *
     * @return void
     * @since 0.1.0
     */
    public static function init()
    {
        static::$title = \Yii::app()->name;
        static::$lang = \Yii::app()->language;
        static::$theme = \Yii::app()->theme->getName();
    }
}
 