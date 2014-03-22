<?php

/**
 * Description of Category
 *
 * @todo Restricted slugs should be fetched from global config.
 * 
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package etki-tools
 * @subpackage <subpackage>
 */
class Category extends ActiveRecordLayer
{
    protected $_restrictedSlugs = array(
        'rss', 'html', 'xml', 'json', 'page',
    );
    /**
     * Category title. 
     * 
     * @var string
     * @since 0.1.0
     */
    public $name;
    /**
     * Category slug.
     * 
     * @var string
     * @since 0.1.0
     */
    public $slug;
    /**
     * Amount of posts in this particular category.
     * 
     * @var int
     * @since 0.1.0
     */
    public $post_count;
    /**
     * Returns current model table name.
     * 
     * @return string Current model table name.
     * @since 0.1.0
     */
    public function tableName()
    {
        return 'categories';
    }
    /**
     * Slug validation method. Uses direct db connection since AR would
     * probably generate a huge overhead.
     * Copied directly from {@link Post} :(
     * 
     * @param string $attribute Attribute name (i guess it will be `slug`,
     * right?). Added for compatibility.
     * @param array $params Additional validation params. Added for
     * compatibility.
     * @return void
     * @since 0.1.0
     */
    public function validateSlug($attribute, array $params=null)
    {
        $db = Yii::app()->db;
        $slug = $this->$attribute;
        if (in_array($slug, $this->restrictedSlugs(), true)) {
            $error = Yii::t('validation-errors', 'post.restrictedSlug', array(
                '{slug}' => $slug,
            ));
            $this->addError($attribute, $error);
        }
        $slugExists = $db->createCommand()
                         ->select('1')
                         ->from($this->tableName())
                         ->where('slug = :slug', array(':slug' => $slug))
                         ->queryScalar();
        if ($slugExists) {
            $error = Yii::t('validation-errors', 'post.slugExists', array(
                '{slug}' => $slug,
            ));
            $this->addError($attribute, $error);
        }
    }
    /**
     * Automatic slug generator. Looks up database for selected slug, and
     * returns updated version if slug has already been used; returns original
     * slug if it hasn't been used yet.
     * Copied directly from {@link Post} :(
     * 
     * @param string $slug Slug to be checked.
     * @return string New slug
     * @since 0.1.0
     */
    public function uniqifySlug($slug)
    {
        $db = Yii::app()->db;
        $uniqueSlug = $slug;
        $where = 'slug = :slug OR slug LIKE :slug_mask';
        $count = (int) $db->createCommand()
                          ->select('COUNT(slug) AS slug_count')
                          ->from($this->tableName())
                          ->where($where, array(
                              ':slug' => $slug,
                              ':slug_mask' => $slug.'-%',
                          ))->queryScalar();
        if (in_array($slug, $this->restrictedSlugs(), true)) {
            $count++;
        }
        if ($count !== 0) {
            $uniqueSlug = $slug.'-'.($count + 1);
        }
        Yii::trace('Uniqifying slug: '.$slug.' -> '.$uniqueSlug, 'models.post');
        return $uniqueSlug;
    }
    public function mostPopular($limit=5)
    {
        if (($limit = (int)$limit) < 1) {
            throw new \BadMethodCallException('Limit can\'t be less than one');
        }
        $this->getDbCriteria()->mergeWith(array(
            'order' => 'post_count DESC',
            'limit' => $limit,
        ));
        return $this;
    }
    public function relations()
    {
        return array(
            'posts' => array(self::HAS_MANY, 'Post', 'post_id'),
        );
    }
    public function getAttributeLabels()
    {
        return array(
            'name' => Yii::t('forms-labels', 'category.name'),
            'slug' => Yii::t('forms-labels', 'category.slug'),
            'post_count' => Yii::t('forms-labels', 'category.postCount'),
        );
    }
}
