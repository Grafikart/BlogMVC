<?php

/**
 * This class represents both 'New post' and 'Edit post' pages.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class PostFormPage extends \GeneralPage
{
    /**
     * 'New post' page URL.
     *
     * @var string
     * @since 0.1.0
     */
    public static $newPostUrl = '/admin/posts/new';
    /**
     * Internal Yii controller route of 'new post' page.
     *
     * @var string
     * @since 0.1.0
     */
    public static $newPostRoute = 'post/new';
    /**
     * 'Edit post' page route.
     *
     * @var string
     * @since 0.1.0
     */
    public static $editPostUrl = '/admin/posts/<id>';
    /**
     * Internal Yii controller route of `edit post` page.
     *
     * @var string
     * @since 0.1.0
     */
    public static $editPostRoute = 'post/edit';
    /**
     * Post title field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $titleField = 'Post[name]';
    /**
     * Slug field name.
     *
     * @var string
     * @since
     */
    public static $slugField = 'Post[slug]';
    /**
     * Category select list name.
     *
     * @var string
     * @since
     */
    public static $categoryList = 'Post[category_id]';
    /**
     * Content textarea element name.
     *
     * @var string
     * @since
     */
    public static $textArea = 'Post[content]';
    /**
     * Category menu toggle button selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $categoryMenuToggleButton = '[role="toggle-category-menu"]';
    /**
     * Submit button selector.
     *
     * @var string
     * @since
     */
    public static $submitButton = 'input[role="submit-post"]';
    /**
     * Save edits submit button name. Should point to the same submit button as
     * {@link self::$submitButton}.
     *
     * @var string
     * @since
     */
    public static $editSubmitButton = 'Edit';
    /**
     * Publish submit button name. Should point to the same submit button as
     * {@link self::$submitButton}.
     *
     * @var string
     * @since 0.1.0
     */
    public static $publishSubmitButton = 'Publish';
    /**
     * Error box css selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $errorBox = 'form .alert.alert-danger';

    /**
     * Returns URL for particular post edit page.
     *
     * @param int|string $id Post ID in string or integer form.
     *
     * @return string Page URL.
     * @since 0.1.0
     */
    public static function route($id)
    {
        return str_replace('<id>', $id, static::$editPostUrl);
    }

    /**
     * Checks if page's error box is shown.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasErrors()
    {
        $this->guy->seeElement(static::$errorBox);
    }

    /**
     * Checks if page error box isn't shown.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasNoErrors()
    {
        $this->guy->dontSeeElement(static::$errorBox);
    }

    /**
     * Toggles category menu. Adds timeout for animation completion.
     *
     * @return void
     * @since 0.1.0
     */
    public function toggleCategoryMenu()
    {
        $this->guy->click(static::$categoryMenuToggleButton);
        $this->guy->wait(1000);
    }
}