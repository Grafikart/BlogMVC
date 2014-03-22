<?php

/**
 * Description of Post
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class Post extends ActiveRecordLayer
{
    /**
     * ID of the related category.
     * 
     * @var int
     * @since 0.1.0
     */
    public $category_id;
    /**
     * Post's author ID.
     * 
     * @var int
     * @since 0.1.0
     */
    public $user_id;
    /**
     * Post title.
     * 
     * @var string
     * @since 0.1.0
     */
    public $name;
    /**
     * Post slug
     * 
     * @var string 
     * @since 0.1.0
     */
    public $slug;
    /**
     * Post text.
     * 
     * @var string
     * @since 0.1.0
     */
    public $content;
    /**
     * Date of creation.
     * 
     * @var string|CDbExpression
     * @since 0.1.0
     */
    public $created;
    
    /**
     * Hard-coded DAO-access query for getting of total slug usages. Uses
     * <b>:slug</b> and <b>:slug_mask</b> placeholders.
     * Hard-coding is bad, but bindValues doesn't work with table/column name,
     * mmkay?
     * 
     * @var string
     * @since 0.1.0
     */
    const SQL_GET_SLUG_COUNT = 
        'SELECT COUNT(slug) AS slug_count
         FROM posts
         WHERE slug = :slug OR
            slug LIKE :slug_mask';
    /**
     * Standard Yii method for defining current model table name.
     * 
     * @return string Table name.
     * @since 0.1.0
     */
    public function tableName()
    {
        return 'posts';
    }
    /**
     * Returns list of inusable slugs.
     * 
     * @return string[] List of restricted slugs.
     * @since 0.1.0
     */
    public function restrictedSlugs()
    {
        return array(
            'html', 'rss', 'xml', 'json', 'category', 'author', 'admin',
        );
    }
    /**
     * Returns amount of posts pages.
     * 
     * @throws \InvalidArgumentException Thrown if <var>$postsPerPage</var>
     * equals to zero or less.
     * 
     * @param int $postsPerPage
     * @return type
     * @since 0.1.0
     */
    public function totalPages($postsPerPage=5)
    {
        if (($postsPerPage = (int)$postsPerPage) < 1) {
            $message = '$postsPerPage argument should be an integer bigger '.
                       'than 0';
            throw new \InvalidArgumentException($message);
        }
        return ceil($this->total()/$postsPerPage);
    }
    /** @todo CDbExpression **/
    public function today()
    {
        /*return -100;
        $cacheKey = 'posts.amount.total';
        $data = Yii::app()->cache->get($cacheKey);
        if ($data === false) {*/
            $data = (int)Yii::app()->db->createCommand()
                            ->select('COUNT(id)')
                            ->from($this->tableName())
                            ->where('created > :today', array(
                                ':today' => date('Y-m-d')
                            ))
                            ->queryScalar();
            /*Yii::app()->cache->set($cacheKey, $data, 3600);
        }*/
        return $data;
    }
    /**
     * Slug validation method. Uses direct db connection since AR would
     * probably generate a huge overhead.
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
    /**
     * Scope implementation. This method allows setting additional conditions
     * before performing search.
     * Note that parameters aren't checked, so erroneous parameters may
     * trigger error with trace pointing to Yii inner methods.
     * 
     * @param int $page Page that should be fetched.
     * @param int $perPage Amount of posts on page.
     * @return \Post Current model instance.
     * @since 0.1.0
     */
    public function recently($page=1, $perPage=5)
    {
        $this->getDbCriteria()->mergeWith(array(
            'order' => 'created DESC',
            'limit' => $perPage,
            'offset' => ($page - 1) * $perPage,
        ));
        return $this;
    }
    /**
     * Post Markdown-formatting callback.
     * 
     * @return void
     * @since 0.1.0
     */
    public function afterFind() {
        // @todo wouldn't it be great to create CMarkdown just once?
        $formatter = Yii::app()->formatter;
        $this->content = $formatter->formatText($this->content, 'markdown');
    }
    /**
     * Callback for automating timestamp creating process
     * 
     * @return void
     * @since 0.1.0
     */
    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created = new CDbExpression('NOW()');
            $category = Category::model()->findByPk($this->category_id);
            $category->post_count++;
            $category->save();
        } else {
            $currentCategory = $this->getCurrentCategory();
            if ($currentCategory !== $this->category_id) {
                $oldCategory = Category::model()->findByPk($currentCategory);
                $oldCategory->post_count--;
                $oldCategory->save();
                $newCategory = Category::model()->findByPk($this->category_id);
                $newCategory->post_count++;
                $newCategory->save();
            }
        }
    }
    /**
     * Method for getting internationalized labels. Since it is certanly not
     * the best idea to internationalize labels every time
     * {@link attributeLabels()} is called, this method is called only once
     * for caching internationalized labels, and {@link ActiveRecordLayer}
     * returns this cache for every {@link attributeLabels()} call.
     * 
     * @return string[] List of attribute labels in :attributeName =>
     * :attributeLabel form.
     * @since 0.1.0
     */
    protected function getAttributeLabels()
    {
        return array(
            'id' => 'ID',
            'category_id' => Yii::t('post.category'),
            'user_id' => Yii::t('post.author'),
            'name' => Yii::t('post.name'),
            'slug' => Yii::t('post.slug'),
            'content' => Yii::t('post.content'),
            'created' => Yii::t('post.created'),
        );
    }
    /**
     * Standard yii method for declaring model attributes.
     * 
     * @return string[] List of attribute names.
     * @since 0.1.0
     */
    public function attributeNames()
    {
        return array(
            'id',
            'category_id',
            'user_id',
            'name',
            'slug',
            'content',
            'created',
        );
    }
    /**
     * Standard Yii method for defining ActiveRecord relations.
     * 
     * @link http://www.yiiframework.com/doc/guide/1.1/en/database.arr
     * 
     * @return array List of relation definitions.
     * @since 0.1.0
     */
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'user_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'post_id'),
        );
    }
    /**
     * Standard Yii method for defining validation rules.
     * 
     * @link http://www.yiiframework.com/wiki/56/
     * @link http://www.yiiframework.com/wiki/168/create-your-own-validation-rule/
     * @link http://yiiframework.ru/doc/cookbook/ru/form.validation.reference
     * 
     * @return array Set of validation rules.
     * @since 0.1.0
     */
    public function rules()
    {
        return array(
        );
    }
}
