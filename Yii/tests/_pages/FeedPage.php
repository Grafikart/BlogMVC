<?php

/**
 * Represents one of the feed pages: index (main blog feed), category and author
 * feed.
 *
 * @version    0.1.1
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class FeedPage extends \ContentPage
{
    /**
     * Template for 'edit post' CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    static $postEditLinkTemplate
        = 'article:nth-child(<number>) a[role="edit-post-link"]';
    /**
     * Template for post category link CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    static $postCategoryLinkTemplate
        = 'article:nth-child(<number>) a[role="category-link"]';
    /**
     * Template for post author link CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    static $postAuthorLinkTemplate
        = 'article:nth-child(<number>) a[role="user-link"]';
    /**
     * CSS selector template for a category link located in sidebar.
     *
     * @type string
     * @since 0.1.1
     */
    static $sidebarCategoryLinkTemplate = '.sidebar .categories .item-<number>';
    /**
     * CSS selector template for a post link located in sidebar.
     *
     * @type string
     * @since 0.1.1
     */
    static $sidebarPostLinkTemplate = '.sidebar .posts .item-<number>';
    /**
     * Constant for specifying post category link output.
     *
     * @type string
     * @since 0.1.0
     */
    const POST_CATEGORY_LINK = 'postCategory';
    /**
     * Constant for specifying 'edit post' link output.
     *
     * @type string
     * @since 0.1.0
     */
    const POST_EDIT_LINK = 'postEdit';
    /**
     * Constant for specifying post author link output.
     *
     * @type string
     * @since 0.1.0
     */
    const POST_AUTHOR_LINK = 'postAuthor';
    /**
     * Constant for specifying sidebar post link output.
     *
     * @type string
     * @since 0.1.1
     */
    const SIDEBAR_POST_LINK = 'sidebarPost';
    /**
     * Constant for specifying sidebar category link output.
     *
     * @type string
     * @since 0.1.1
     */
    const SIDEBAR_CATEGORY_LINK = 'sidebarCategory';

    /**
     * Returns link CSS selector
     *
     * @param int|string $itemNumber Post number as it appears on page.
     * @param string     $linkType   Link type.
     *
     * @return string Resulting selector.
     * @since 0.1.0
     */
    public static function getLink($itemNumber, $linkType)
    {
        switch ($linkType) {
            case static::POST_CATEGORY_LINK:
                $template = static::$postCategoryLinkTemplate;
                $itemNumber = $itemNumber * 2 + 1;
                break;
            case static::POST_EDIT_LINK:
                $template = static::$postEditLinkTemplate;
                $itemNumber = $itemNumber * 2 + 1;
                break;
            case static::POST_AUTHOR_LINK:
                $template = static::$postAuthorLinkTemplate;
                $itemNumber = $itemNumber * 2 + 1;
                break;
            case static::SIDEBAR_CATEGORY_LINK:
                $template = static::$sidebarCategoryLinkTemplate;
                $itemNumber--;
                break;
            case static::SIDEBAR_POST_LINK:
                $template = static::$sidebarPostLinkTemplate;
                $itemNumber--;
                break;
            default:
                throw new \BadMethodCallException('Unknown link type');
        }
        return str_replace('<number>', $itemNumber, $template);
    }

    /**
     * Returns category link CSS selector.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return string Category link selector.
     * @since 0.1.0
     */
    public static function getPostCategoryLink($postNumber)
    {
        return static::getLink($postNumber, static::POST_CATEGORY_LINK);
    }

    /**
     * Returns 'edit post' link selector.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return string 'Edit post' link selector.
     * @since 0.1.0
     */
    public static function getPostEditLink($postNumber)
    {
        return static::getLink($postNumber, static::POST_EDIT_LINK);
    }

    /**
     * Returns post author link selector.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return string Author link selector.
     * @since 0.1.0
     */
    public static function getPostAuthorLink($postNumber)
    {
        return static::getLink($postNumber, static::POST_AUTHOR_LINK);
    }

    /**
     * Returns link CSS selector for specified post in sidebar.
     *
     * @param int|string $postNumber Number of post in sidebar feed.
     *
     * @return string Link CSS selector.
     * @since 0.1.0
     */
    public static function getSidebarPostLink($postNumber)
    {
        return static::getLink($postNumber, static::SIDEBAR_POST_LINK);
    }

    /**
     * Returns link CSS selector for specified category in sidebar.
     *
     * @param int|string $categoryNumber Number of category in sidebar feed.
     *
     * @return string Link CSS selector.
     * @since 0.1.0
     */
    public static function getSidebarCategoryLink($categoryNumber)
    {
        return static::getLink($categoryNumber, static::SIDEBAR_CATEGORY_LINK);
    }

    /**
     * Clicks 'edit post' link for selected post.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickPostEditLink($postNumber)
    {
        $this->guy->click(static::getPostEditLink($postNumber));
    }

    /**
     * Clicks author link in selected post.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickPostAuthorLink($postNumber)
    {
        $this->guy->click(static::getPostAuthorLink($postNumber));
    }

    /**
     * Clicks category link in selected post.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickPostCategoryLink($postNumber)
    {
        $this->guy->click(static::getPostCategoryLink($postNumber));
    }

    /**
     * Clicks selected post link in sidebar.
     *
     * @param int|string $postNumber Post number in sidebar feed.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickSidebarPostLink($postNumber)
    {
        $this->guy->click(static::getSidebarPostLink($postNumber));
    }

    /**
     * Clicks selected category link in sidebar.
     *
     * @param int|string $categoryNumber Category number in sidebar feed.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickSidebarCategoryLink($categoryNumber)
    {
        $this->guy->click(static::getSidebarCategoryLink($categoryNumber));
    }

    /**
     * Returns category title from sidebar by it's number.
     *
     * @param int|string $categoryNumber Number of category in sidebar feed.
     *
     * @return string Sidebar title.
     * @since 0.1.0
     */
    public function getSidebarCategoryTitle($categoryNumber)
    {
        $selector = static::getSidebarCategoryLink($categoryNumber);
        $rawText = $this->guy->grabTextFrom($selector);
        preg_match('~(\d+)\s+(\w.*)$~us', $rawText, $m);
        return $m[2];
    }
    /**
     * Grabs category data.
     *
     * @return array
     * @since 0.1.0
     */
    public function grabCategories()
    {
        $categories = array();
        for ($i = 1; $i <= 3; $i++) {
            $base = '.categories .item-'.$i;
            $categories[] = array(
                'name' => $this->grab($base.' a'),
                'amount' => $this->grab($base.' .badge'),
            );
        }
        return $categories;
    }
}