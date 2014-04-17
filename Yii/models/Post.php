<?php
/**
 * Post ActiveRecord implementation.
 *
 * @method boolean slugExists() Behavior-inherited method which checks slug
 * existence.
 * @method static Post model() Gets post model.
 * @method string generateSlug() Generates post slug.
 * @property Category $category Related category.
 *
 * @todo Add profiling
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
     * Post slug.
     * 
     * @var string 
     * @since 0.1.0
     */
    public $slug;
    /**
     * Post text in markdown.
     * 
     * @var string
     * @since 0.1.0
     */
    public $content;
    /**
     * Post text converted from markdown to HTML.
     * 
     * @var string
     * @since 0.1.0
     */
    public $formattedContent;
    /**
     * Date of creation.
     * 
     * @var string|CDbExpression
     * @since 0.1.0
     */
    public $created;
    /**
     * Category cache. Since {@link afterSave()} can't tell if category is
     * changed, it has to be cached.
     *
     * @var int
     * @since 0.1.0
     */
    public $oldCategory;

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
     * @param int $postsPerPage Number of posts per page.
     * @return int Number of total pages.
     * @since 0.1.0
     */
    public function totalPages($postsPerPage=5)
    {
        if (($postsPerPage = (int)$postsPerPage) < 1) {
            $message = '$postsPerPage argument should be an integer bigger '.
                       'than 0';
            throw new \InvalidArgumentException($message);
        }
        return ceil($this->count()/$postsPerPage);
    }
    /**
     * Returns number of posts submitted today.
     * 
     * @todo Most probably the same effect may be achieved using
     * CDbExpression. Though that may be a bit slower, it would be more
     * correct.
     * 
     * @return int Number of today's posts.
     * @since 0.1.0
     */
    public function today()
    {
        return $this->count('created >= :today', array(
            ':today' => date('Y-m-d'),
        ));
    }
    /**
     * Slug validation method. Uses {@link slugExists()} ethod for checking.
     * 
     * @param string $attribute Attribute name (i guess it will be `slug`,
     * right?). Added for compatibility.
     * @return void
     * @since 0.1.0
     */
    public function validateSlug($attribute/*, array $params=null*/)
    {
        $slug = $this->$attribute;
        if (in_array($slug, $this->restrictedSlugs(), true)) {
            $error = Yii::t('validation-errors', 'post.restrictedSlug', array(
                '{slug}' => $slug,
            ));
            $this->addError($attribute, $error);
        }
        if ($this->slugExists($slug)) {
            $error = Yii::t('validation-errors', 'post.slugExists', array(
                '{slug}' => $slug,
            ));
            $this->addError($attribute, $error);
        }
    }
    /**
     * Retrieves current category ID.
     * 
     * @return int ID of current post category.
     * @since 0.1.0
     */
    public function getCurrentCategory()
    {
        Yii::beginProfile('post.getCurrentCategory');
        /** @var CDbConnection $db */
        $db = Yii::app()->db;
        $id = (int) $db->createCommand()
                       ->select('category_id')
                       ->from($this->tableName())
                       ->where('id = :id', array(':id' => $this->id))
                       ->queryScalar();
        Yii::endProfile('post.getCurrentCategory');
        return $id;
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
    public function paged($page=1, $perPage=5)
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
     * @return boolean Always returns true.
     * @since 0.1.0
     */
    public function afterFind() {
        parent::afterFind();
        /** @var DataFormatter $formatter */
        $formatter = Yii::app()->formatter;
        $this->formattedContent = $formatter->formatText($this->content, 'markdown');
        return true;
    }
    /**
     * A callback for automating category counter updates, timestamps and
     * ownership assignment.
     * Tricky part about ownership is that model shouldn't know anything about
     * current user, but easiest way to automate things is by adding it here
     * and not in controller (actually, controller itself should not alter
     * data in any way too). Adding author ID in beforeSave also breaks
     * validation a little (user_id should be required on post creation).
     * 
     * @return boolean False if parent beforeSave() failed, true otherwise.
     * @since 0.1.0
     */
    public function beforeSave() {
        if (!parent::beforeSave()) {
            return false;
        }
        if (empty($this->slug)) {
            $this->slug = $this->generateSlug($this->name);
        }
        if ($this->getIsNewRecord()) {
            $this->user_id = Yii::app()->user->id; // This is quite `tricky & ouch`. See PHPDoc.
        } else {
            $this->oldCategory = $this->getCurrentCategory();
        }
        return true;
    }
    /**
     * After save callback. Updates `lastPost` global state, which is required
     * for invalidating cache dependencies (e.g. sidebar).
     *
     * Not using `saveCounters()` because of Postgresql typecasting error.
     * 
     * @return boolean False if parent afterSave() failed, true otherwise.
     * @since 0.1.0
     */
    public function afterSave() {
        Yii::app()->setGlobalState('lastPostUpdate', time());
        if ($this->getIsNewRecord()) {
            $this->category->saveCounters(array('post_count' => '1'));
        } else if ($this->oldCategory !== (int) $this->category_id) {
            $oldCategory = \Category::model()->findByPk($this->oldCategory);
            $oldCategory->post_count--;
            $oldCategory->save(false, array('post_count'));
            $this->category->post_count++;
            $this->category->save(false, array('post_count'));
        }
        return true;
    }

    /**
     * After-delete callback, sets global state to invalidate cache.
     *
     * @return boolean
     * @since 0.1.0
     */
    public function afterDelete()
    {
        if (!parent::afterDelete()) {
            return false;
        }
        $this->category->post_count--;
        $this->category->save(false, array('post_count'));
        Yii::app()->setGlobalState('lastPostUpdate', time());
        return true;
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
            'category_id' => Yii::t('forms-labels', 'post.category'),
            'user_id' => Yii::t('forms-labels', 'post.author'),
            'name' => Yii::t('forms-labels', 'post.name'),
            'slug' => Yii::t('forms-labels', 'post.slug'),
            'content' => Yii::t('forms-labels', 'post.content'),
            'created' => Yii::t('forms-labels', 'post.created'),
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
            'comments' => array(
                self::HAS_MANY,
                'Comment',
                'post_id',
                'order' => 'comments.created DESC'
            ),
            'commentCount' => array(self::STAT, 'Comment', 'post_id'),
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
            array(
                array('name',),
                'length',
                'allowEmpty' => false,
                'min' => 3,
                'max' => 255,
                //'on' => array('insert', 'update'),
            ),
            array(
                array('slug',),
                'length',
                'allowEmpty' => true,
                'min' => 3,
                'max' => 255,
                //'on' => array('insert', 'update'),
            ),
            array(
                array('category_id',),
                'required',
                //'on' => array('insert', 'update'),
            ),
            array(
                array('content',),
                'length',
                'min' => 10,
                //'on' => array('insert', 'update'),
            ),
        );
    }
    /**
     * This method defines applied behaviors.
     * 
     * @return string[] List of behavior names.
     * @since 0.1.0
     */
    public function behaviors()
    {
        return array('DatetimeCreatedBehavior', 'SlugBehavior',);
    }
}
