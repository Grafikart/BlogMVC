<?php

/**
 * Covers new category/edit category pages.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class CategoryFormPage extends \GeneralPage
{
    /**
     * URL for 'new category' form.
     *
     * @type string
     * @since 0.1.0
     */
    public static $newCategoryUrl = '/admin/category/new';
    /**
     * URL template for 'edit category' form.
     *
     * @type string
     * @since 0.1.0
     */
    public static $editCategoryUrlTemplate = '/admin/category/<slug>/edit';
    /**
     * CSS selector for category form.
     *
     * @type string
     * @since 0.1.0
     */
    public static $categoryFormSelector = '[role="category-form"]';
    /**
     * Name attribute for name field.
     *
     * @type string
     * @since 0.1.0
     */
    public static $nameFieldName = 'Category[name]';
    /**
     * Name attribute for slug field.
     *
     * @type string
     * @since 0.1.0
     */
    public static $slugFieldName = 'Category[slug]';
    /**
     * CSS selector for form submit button.
     *
     * @type string
     * @since 0.1.0
     */
    public static $categoryFormSubmitButton = '[role="save-category"]';

    /**
     * Returns edit form url for particular category.
     *
     * @param string $slug Category slug.
     *
     * @return string Full-formed category edit page URL.
     * @since 0.1.0
     */
    public static function route($slug)
    {
        return str_replace('<slug>', $slug, static::$editCategoryUrlTemplate);
    }
}