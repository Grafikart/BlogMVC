<?php

/**
 * Category representation.
 *
 * @method static Category model() Gets category model.
 * @property \Post[] $posts Child posts.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class Category extends ActiveRecordLayer
{
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
    public $post_count = 0;
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
     * Scope method for retrieving categories in paged manner.
     * 
     * @param int $page    Current page.
     * @param int $perPage Number of categories per page.
     *
     * @return \Category current instance.
     * @since 0.1.0
     */
    public function paged($page=1, $perPage=5)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'order' => 'id ASC',
                'limit' => $perPage,
                'offset' => ($page - 1) * $perPage,
            )
        );
        return $this;
    }
    /**
     * Returns plain list of existing categories in :category_id =>
     * :category_name form.
     * 
     * @return string[] List of existing categories.
     * @since 0.1.0
     */
    public function getList()
    {
        /** @var CDbConnection $db */
        $db = \Yii::app()->db;
        $categories = $db->createCommand()
            ->select(array('id', 'name'))
            ->from($this->tableName())
            ->queryAll();
        $list = array();
        foreach ($categories as $category) {
            $list[(int)$category['id']] = $category['name'];
        }
        return $list;
    }

    /**
     * Recalculates post count for all categories.
     *
     * Just coz i'm lazy enough to not to try it with builder.
     *
     * @return void
     * @since 0.1.0
     */
    public function recalculateCounters()
    {
        \Yii::app()->db->createCommand(
            'UPDATE categories AS c '.
            'SET post_count = '.
            '(SELECT COUNT(category_id) FROM posts WHERE category_id = c.id)'
        )->execute();
    }
    /**
     * Scope method for filtering most popular categories.
     * 
     * @param int $limit            How many top categories should be fetched.
     * @param int $minimumPostCount Minimum amount of posts in category to be
     * shown.
     *
     * @throws \BadMethodCallException Thrown if limit is set less than 1.
     *
     * @return \Category Current instance.
     * @since 0.1.0
     */
    public function popular($limit=5, $minimumPostCount=1)
    {
        if (($limit = (int)$limit) < 1) {
            throw new \BadMethodCallException('Limit can\'t be less than one');
        }
        $this->getDbCriteria()->mergeWith(
            array(
                'order' => 'post_count DESC',
                'limit' => $limit,
                'condition' => 'post_count >= :minimum',
                'params' => array(':minimum' => $minimumPostCount),
            )
        );
        return $this;
    }

    /**
     * Before-validation callback to automate slug generation even if it wasn't
     * handled on frontend.
     *
     * @return bool Operation success.
     * @since 0.1.0
     */
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        if (!empty($this->slug)) {
            $this->slug = \Yii::app()->formatter->slugify($this->slug);
        } else if (!empty($this->name)) {
            $this->slug = \Yii::app()->formatter->slugify($this->name);
        }
        return true;
    }

    /**
     * Default counters in sqldump were saved as strings, and that made
     * impossible using standard updateCounters() because of type inconsistency.
     *
     * @param int $increment Counter increment.
     *
     * @return void
     * @since 0.1.0
     */
    public function updateCounter($increment=1)
    {
        $this->post_count += $increment;
        $this->save(false, array('post_count'));
    }

    /**
     * A shortcut method for getting new model instance or model instance with
     * specified ID.
     *
     * @param null|string $slug Category slug which will be used to perform a
     * search. If nothing is specified, new instance will be returned.
     *
     * @return self|null Model instance or null if model with specified slug
     * doesn't exist.
     * @since 0.1.0
     */
    public function findBySlugOrCreate($slug=null)
    {
        if ($slug) {
            return $this->find('slug = :slug', array(':slug' => $slug));
        } else {
            $class = get_class($this);
            $instance = new $class();
            $instance->post_count = 0;
            return $instance;
        }
    }

    /**
     * Standard Yii method which returns array of relation definitions.
     * 
     * @return array Set of relation definitions
     * @since 0.1.0
     */
    public function relations()
    {
        return array(
            'posts' => array(self::HAS_MANY, 'Post', 'category_id'),
            'postCount' => array(self::STAT, 'Post', 'category_id'),
        );
    }
    /**
     * Returns set of internationalized attribute labels.
     * 
     * @return string[] Attribute labels.
     * @since 0.1.0
     */
    public function getAttributeLabels()
    {
        return array(
            'name' => 'category.name',
            'slug' => 'category.slug',
            'post_count' => 'category.postCount',
        );
    }

    /**
     * Standard method defining validation rules.
     *
     * @return array Set of validation rules.
     * @since 0.1.0
     */
    public function rules()
    {
        return array(
            array(
                array('name', 'slug',),
                'length',
                'allowEmpty' => false,
                'min' => 3,
                'max' => 50,
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
        return array('SlugBehavior');
    }
}
