<?php

/**
 * This is a model representing post comment entity.
 *
 * @method static Comment model() Gets comment model.
 *
 * @todo Add profiling
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
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
     * Returns amount of today comments.
     * 
     * @todo Try to use CDbExpression.
     * 
     * @return int Number of today comments.
     * @since 0.1.0
     */
    public function today()
    {
        return $this->count('created >= :today', array(
            ':today' => date('Y-m-d'),
        ));
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
     * Returns localized attribute labels.
     * 
     * @return string[]
     * @since 0.1.0
     */
    public function getAttributeLabels()
    {
        return array(
            'post_id' => \Yii::t('forms-labels', 'comment.[postId'),
            'username' => \Yii::t('forms-labels', 'comment.username'),
            'mail' => \Yii::t('forms-labels', 'comment.mail'),
            'content' => \Yii::t('forms-labels', 'comment.content'),
            'created' => \Yii::t('forms-labels', 'comment.created'),
        );
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
        $this->content = $formatter->formatText($this->content, 'markdown');
        $this->created = date('Y-m-d H:i:s', strtotime($this->created));
        $this->timeAgo = $formatter->formatDateTime(
            $this->created,
            'interval'
        );
        $this->gravatar = 'http://www.gravatar.com/avatar/'.md5($this->mail);
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
        $this->content = strip_tags($this->content);
        return true;
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
