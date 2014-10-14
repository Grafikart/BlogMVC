<?php

/**
 * Represents category management dashboard.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class CategoryDashboardPage extends \GeneralPage
{
    /**
     * Page URL.
     *
     * @type string
     * @since 0.1.0
     */
    public static $url = '/admin/category';
    /**
     * Yii controller page route.
     *
     * @type string
     * @since 0.1.0
     */
    public static $route = 'category/dashboard';
    /**
     * 'Add new category' button selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $addNewButton = '[role="new-category-link"]';
    /**
     * CSS selector template for category edit button.
     *
     * @type string
     * @since 0.1.0
     */
    public static $editButtonTemplate
        = 'tr:nth-child(<number>) [role="edit-category-link"]';
    /**
     * CSS selector template for category feed link.
     *
     * @type string
     * @since 0.1.0
     */
    public static $categoryFeedLinkTemplate
        = 'tr:nth-child(<number>) [role="category-feed-link"]';

    /**
     * Returns CSS selector for particular category edit button.
     *
     * @param int|string $number Element number as it appears on page.
     *
     * @return string
     * @since 0.1.0
     */
    public static function getEditButtonSelector($number)
    {
        return str_replace('<number>', $number, static::$editButtonTemplate);
    }

    /**
     * Returns CSS selector for particular category feed link.
     *
     * @param int|string $number Element number as it appears on page.
     *
     * @return string
     * @since 0.1.0
     */
    public static function getCategoryFeedLinkSelector($number)
    {
        return str_replace(
            '<number>',
            $number,
            static::$categoryFeedLinkTemplate
        );
    }

    /**
     * Returns URL for particular page.
     *
     * @param int|string $page Page number.
     *
     * @return string
     * @since 0.1.0
     */
    public static function route($page)
    {
        return static::$url.'?page='.$page;
    }

    /**
     * Clicks link that will forward user to category edit form.
     *
     * @param int|string $categoryNumber Category number as it appears on page.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickEditButton($categoryNumber)
    {
        $this->guy->click(static::getEditButtonSelector($categoryNumber));
    }

    /**
     * Clicks link that will forward user to category feed.
     *
     * @param int|string $categoryNumber Category number as it appears on page.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickCategoryFeedLink($categoryNumber)
    {
        $this->guy->click(static::getCategoryFeedLinkSelector($categoryNumber));
    }
}