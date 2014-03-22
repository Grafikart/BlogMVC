<?php

/**
 * This is a model representing post comment entity.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class Comment extends ActiveRecordLayer
{
    public $post_id;
    public $username;
    public $mail;
    public $content;
    public $created;
    public function today()
    {
        return -100;
        $cacheKey = 'categories.amount.total';
        $data = Yii::app()->cache->get($cacheKey);
        if ($data === false) {
            $data = (int)Yii::app()->db->select()
                            ->from($this->tableName())
                            ->where('created > :today', array(
                                ':today' => date('Y-m-d')
                            ))
                            ->queryScalar();
            Yii::app()->cache->set($cacheKey, $data, 3600);
        }
        return $data;
    }
    public function tableName()
    {
        return 'comments';
    }
    public function getAttributeLabels()
    {
        return array(
            'post_id' => Yii::t('forms-labels', 'comment.[postId'),
            'username' => Yii::t('forms-labels', 'comment.username'),
            'mail' => Yii::t('forms-labels', 'comment.mail'),
            'content' => Yii::t('forms-labels', 'comment.content'),
            'created' => Yii::t('forms-labels', 'comment.created'),
        );
    }
    public function afterFind()
    {
        $formatter = Yii::app()->formatter;
        $this->content = $formatter->formatText($this->content, 'markdown');
    }
    public function relations()
    {
        return array(
            'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
        );
    }
    public function rules()
    {
        return array(
            array(
                array('username',),
                'length',
                'allowEmpty' => false,
                'min' => 3,
                'max' => 254,
                'on' => array('create')
            ),
            array(
                array('mail',),
                'email',
                'allowEmpty' => true,
                'allowName' => false,
                'on' => array('create')
            ),
            array(
                array('content'),
                'required',
                'on' => array('create', 'edit'),
            )
        );
    }
}
