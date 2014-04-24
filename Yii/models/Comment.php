<?php

/**
 * This is a model representing post comment entity.
 *
 * @method static Comment model() Gets comment model.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class Comment extends ActiveRecordLayer
{
    /**
     * Parent post ID.
     * 
     * @var int
     * @since 0.1.0
     */
    public $post_id;
    /**
     * Commenter's username.
     * 
     * @var string
     * @since 0.1.0
     */
    public $username;
    /**
     * Commenter's email.
     * 
     * @var string
     * @since 0.1.0
     */
    public $mail;
    /**
     * Comment content.
     * 
     * @var string
     * @since 0.1.0
     */
    public $content;
    /**
     * Submit date.
     * 
     * @var string
     */
    public $created;
    /**
     * Virtual attribute which is populated in {@link afterFind()} with
     * gravatar url.
     *
     * @var string
     * @since 0.1.0
     */
    public $gravatar;
    /**
     * Date formatted as 'N units ago' (e.g. 11 days ago).
     *
     * @var string
     * @since 0.1.0
     */
    public $timeAgo;
    /**
     * Current comment author (if he or she is a registered user). Accessed
     * through getter.
     *
     * @var \User
     * @since 0.1.0
     */
    protected $author;

    /**
     * Returns amount of today comments.
     * 
     * @return int Number of today comments.
     * @since 0.1.0
     */
    public function today()
    {
        $token = 'comment.today';
        \Yii::beginProfile($token);
        $dateTime = new \DateTime;
        $dateTime->sub(new \DateInterval('P1D'));
        $amount = (int) $this->count(
            'created >= :today',
            //array(':today' => \DatabaseService::getCurDateExpression(),)
            array(':today' => $dateTime->format(\DateTime::ISO8601),)
        );
        \Yii::endProfile($token);
        return $amount;
    }
    /**
     * Returns associated table name.
     * 
     * @return string
     * @since 0.1.0
     */
    public function tableName()
    {
        return 'comments';
    }
    /**
     * After-search callback.
     * 
     * @return void
     * @since 0.1.0
     */
    public function afterFind()
    {
        parent::afterFind();
        /** @var DataFormatter $formatter */
        $formatter = \Yii::app()->formatter;
        $this->content = $formatter->renderMarkdown($this->content);
        $this->created = date('Y-m-d H:i:s', strtotime($this->created));
        $this->timeAgo = $formatter->formatDateTime(
            $this->created,
            'interval'
        );
        if (!empty($this->mail)) {
            $this->gravatar = 'http://www.gravatar.com/avatar/'.md5($this->mail);
        } else {
            $this->gravatar = 'http://www.gravatar.com/avatar/'.
                              str_repeat('0', 32);
        }
    }

    /**
     * Sanitizes user mail before validation.
     *
     * @return boolean True if parent beforeValidate() fails, true otherwise.
     * @since 0.1.0
     */
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        $this->mail = trim(strtolower($this->mail));
        $this->content = strip_tags($this->content);
        if (!\Yii::app()->user->getIsGuest()) {
            $this->username = '@'.\Yii::app()->user->username;
        }
        return true;
    }

    /**
     * Before-save callback, used to strip tags from content.
     *
     * @return boolean False if parent beforeSave() failed, true otherwise.
     * @since 0.1.0
     */
    public function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }
        return true;
    }

    /**
     * Returns comment author.
     *
     * @missingOptimization Searching through lots of users by unindexed text
     * field is a bad idea.
     *
     * @return \User Current comment author (if he or she is registered).
     * @since 0.1.0
     */
    public function getAuthor()
    {
        if (!$this->username || $this->username[0] !== '@') {
            return false;
        } else {
            if ($this->author === null) {
                $username = substr($this->username, 1);
                $this->author = \User::findByUsername($username);
            }
            return $this->author;
        }
    }
    /**
     * Returns keys for attribute labels localization.
     *
     * @return string[]
     * @since 0.1.0
     */
    public function getAttributeLabels()
    {
        return array(
            'post_id' => 'comment.postId',
            'username' => 'comment.username',
            'mail' => 'comment.mail',
            'content' => 'comment.content',
            'created' => 'comment.created',
        );
    }
    /**
     * Returns relation definitions.
     * 
     * @return array Set of relations definitions
     * @since 0.1.0
     */
    public function relations()
    {
        return array(
            'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
        );
    }

    /**
     * Returns behavior definitions.
     *
     * @return array List of behaviors.
     * @since 0.1.0
     */
    public function behaviors()
    {
        return array(
            'DatetimeCreatedBehavior',
        );
    }
    /**
     * Returns validation rules.
     * 
     * @return array Set of validation rules.
     * @since 0.1.0
     */
    public function rules()
    {
        return array(
            array(
                array('username',),
                'length',
                'allowEmpty' => false,
                'min' => 3,
                'max' => 254,
            ),
            array(
                array('mail',),
                'email',
                'allowEmpty' => true,
                'allowName' => false,
            ),
            array(
                array('content'),
                'required',
            )
        );
    }
}
