<?php

/**
 * Represents one of the feed pages: index (main blog feed), category and author
 * feed.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class FeedPage extends \GeneralPage
{
    /**
     * Template for 'edit post' CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    static $editPostLinkTemplate = 'article:nth-child(<number>) a[role="edit-post-link"]';
    /**
     * Template for post category link CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    static $categoryLinkTemplate = 'article:nth-child(<number>) a[role="category-link"]';
    /**
     * Template for post author link CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    static $userLinkTemplate = 'article:nth-child(<number>) a[role="user-link"]';
    /**
     * Constant for specifying category link output.
     *
     * @type string
     * @since 0.1.0
     */
    const CATEGORY_LINK = 'category';
    /**
     * Constant for specifying 'edit post' link output.
     *
     * @type string
     * @since 0.1.0
     */
    const EDIT_POST_LINK = 'editPost';
    /**
     * Constant for specifying author link output.
     *
     * @type string
     * @since 0.1.0
     */
    const USER_LINK = 'userLink';

    /**
     * Returns link CSS selector
     *
     * @param int|string $postNumber Post number as it appears on page.
     * @param string     $linkType   Link type.
     *
     * @return string Resulting selector.
     * @since 0.1.0
     */
    public static function getLink($postNumber, $linkType)
    {
        if ($linkType === static::CATEGORY_LINK) {
            $template = static::$categoryLinkTemplate;
        } else if ($linkType === static::EDIT_POST_LINK) {
            $template = static::$editPostLinkTemplate;
        } else {
            $template = static::$userLinkTemplate;
        }
        return str_replace('<number>', $postNumber * 2 + 1, $template);
    }

    /**
     * Returns category link CSS selector.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return string Category link selector.
     * @since 0.1.0
     */
    public static function getCategoryLink($postNumber)
    {
        return static::getLink($postNumber, static::CATEGORY_LINK);
    }

    /**
     * Returns 'edit post' link selector.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return string 'Edit post' link selector.
     * @since 0.1.0
     */
    public static function getEditPostLink($postNumber)
    {
        return static::getLink($postNumber, static::EDIT_POST_LINK);
    }

    /**
     * Returns post author link selector.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return string Author link selector.
     * @since 0.1.0
     */
    public static function getUserLink($postNumber)
    {
        return static::getLink($postNumber, static::USER_LINK);
    }

    /**
     * Clicks 'edit post' link for selected post.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickEditPostLink($postNumber)
    {
        $this->guy->click(static::getEditPostLink($postNumber));
    }

    /**
     * Clicks author link in selected post.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickUserLink($postNumber)
    {
        $this->guy->click(static::getUserLink($postNumber));
    }

    /**
     * Clicks category link in selected post.
     *
     * @param int|string $postNumber Post number as it appears on page.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickCategoryLink($postNumber)
    {
        $this->guy->click(static::getCategoryLink($postNumber));
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