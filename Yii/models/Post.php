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
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class Post extends \ActiveRecordLayer
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
    public $rendered;
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
     * Returns amount of posts pages.
     *
     * @param int    $postsPerPage Number of posts per page.
     * @param string $condition    Additional SQL condition.
     * @param array  $params       Set of parameters to be applied to condition.
     *
     * @throws \InvalidArgumentException Thrown if <var>$postsPerPage</var>
     * equals to zero or less.
     *
     * @return int Number of total pages.
     * @since 0.1.0
     */
    public function totalPages($postsPerPage=5, $condition='', $params=array())
    {
        if (($postsPerPage = (int)$postsPerPage) < 1) {
            $message = '$postsPerPage argument should be an integer bigger '.
                       'than 0';
            throw new \InvalidArgumentException($message);
        }
        return (int) ceil($this->count($condition, $params)/$postsPerPage);
    }
    /**
     * Returns number of posts submitted today.
     *
     * @return int Number of today's posts.
     * @since 0.1.0
     */
    public function today()
    {
        $token = 'post.today';
        \Yii::beginProfile($token);
        $amount = (int) $this->count(
            'created >= :today',
            //array(':today' => \DatabaseService::getCurDateExpression(),)
            array(':today' => date('Y-m-d'))
        );
        \Yii::endProfile($token);
        return $amount;
    }
    /**
     * Retrieves current category ID.
     *
     * @return int ID of current post category.
     * @since 0.1.0
     */
    public function getCurrentCategory()
    {
        \Yii::beginProfile('post.getCurrentCategory');
        /** @var CDbConnection $db */
        $db = \Yii::app()->db;
        $id = (int) $db->createCommand()
            ->select('category_id')
            ->from($this->tableName())
            ->where('id = :id', array(':id' => $this->id))
            ->queryScalar();
        \Yii::endProfile('post.getCurrentCategory');
        return $id;
    }

    /**
     * Decreases old category counter and increases new category counter. Will
     * fail silently if one of categories can't be fetched.
     *
     * @param int $oldCategory Old category ID.
     * @param int $newCategory New category ID.
     *
     * @return void
     * @since 0.1.0
     */
    protected function switchCategory($oldCategory, $newCategory)
    {
        if ($oldCategory == $newCategory || !$oldCategory || !$newCategory) {
            return;
        }
        $oldCategory = \Category::model()->findByPk($oldCategory);
        $newCategory = \Category::model()->findByPk($newCategory);
        if (isset($oldCategory, $newCategory)) {
            $oldCategory->updateCounter(-1);
            $newCategory->updateCounter(1);
        }
    }
    /**
     * Scope implementation. This method allows setting additional conditions
     * before performing search.
     * Note that parameters aren't checked, so erroneous parameters may
     * trigger error with trace pointing to Yii inner methods.
     *
     * @param int $page    Page that should be fetched.
     * @param int $perPage Amount of posts on page.
     *
     * @return \Post Current model instance.
     * @since 0.1.0
     */
    public function paged($page=1, $perPage=5)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'order' => 'created DESC',
                'limit' => $perPage,
                'offset' => ($page - 1) * $perPage,
            )
        );
        return $this;
    }

    /**
     * Updates CDbCriteria to select posts only by supplied user.
     *
     * @param int $userId Author's id.
     *
     * @return $this Current model instance.
     * @since 0.1.0
     */
    public function by($userId)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'user_id = :user_id',
                'params' => array(
                    ':user_id' => (int) $userId,
                )
            )
        );
        return $this;
    }
    /**
     * Post Markdown-formatting callback.
     *
     * @return boolean Always returns true.
     * @since 0.1.0
     */
    public function afterFind()
    {
        parent::afterFind();
        /** @var DataFormatter $formatter */
        $formatter = \Yii::app()->formatter;
        $this->rendered = $formatter->renderMarkdown($this->content);
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
    public function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }
        if ($this->getIsNewRecord()) {
            // This is quite tricky. See PHPDoc.
            if (!isset($this->user_id)) {
                if (empty(\Yii::app()->user->id)) {
                    throw new \RuntimeException('Couldn\'t determine user ID');
                }
                $this->user_id = \Yii::app()->user->id;
            }
        } else {
            $this->oldCategory = $this->getCurrentCategory();
        }
        return true;
    }

    /**
     * Before validation callback.
     *
     * @return bool
     * @since 0.1.0
     */
    public function beforeValidate()
    {
        if (empty($this->slug)) {
            $this->slug = $this->name;
        }
        $this->slug = \Yii::app()->formatter->slugify($this->slug);
        $this->name = trim($this->name);
        $this->content = trim($this->content);
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
    public function afterSave()
    {
        \Yii::app()->cacheHelper->invalidatePostsCache();
        //\Yii::beginProfile('post.afterSave');
        if ($this->getIsNewRecord()) {
            $this->category->updateCounter();
            \Yii::log('Post successfully created');
        } else if ($this->oldCategory !== (int) $this->category_id) {
            $this->switchCategory($this->oldCategory, $this->category_id);
            \Yii::log('Post successfully updated');
        }
        //\Yii::endProfile('post.afterSave');
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
        $sign = md5(mt_rand());
        \Yii::log('updated global state ('.$sign.')');
        $this->category->post_count--;
        $this->category->save(false, array('post_count'));
        \Yii::app()->cacheHelper->invalidatePostsCache();
        \Yii::log('Post successfully deleted');
        return true;
    }

    /**
     * Returns all public attributes of
     *
     * @return array
     * @since
     */
    public function getPublicAttributes()
    {
        $attrs = $this->getAttributes();
        $attrs['content'] = $this->rendered;
        return $attrs;
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
            'category_id' => 'post.category',
            'user_id' => 'post.author',
            'name' => 'post.name',
            'slug' => 'post.slug',
            'content' => 'post.content',
            'created' => 'post.created',
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
                'allowEmpty' => false,
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
                'allowEmpty' => false,
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
