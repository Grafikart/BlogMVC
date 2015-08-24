<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $username
 * @property string $mail
 * @property string $content
 * @property string $created
 *
 * @property Posts $post
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'username', 'mail', 'content', 'created'], 'required'],
            [['post_id'], 'integer'],
            [['content'], 'string'],
            [['created'], 'safe'],
            [['username', 'mail'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'username' => 'Username',
            'mail' => 'Mail',
            'content' => 'Content',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
