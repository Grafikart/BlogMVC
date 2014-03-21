<?php

/**
 * Description of Category
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package etki-tools
 * @subpackage <subpackage>
 */
class Category extends CActiveRecord
{
    protected $_restrictedSlugs = array('rss', 'html', 'xml', 'json', 'page');
    public $id;
    public $name;
    public $slug;
    public $post_count;
}
