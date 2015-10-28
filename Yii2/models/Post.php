<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $user_id
 * @property string $name
 * @property string $slug
 * @property string $content
 * @property string $created
 *
 * @property Comments[] $comments
 * @property Categories $category
 * @property Users $user
 */
class Post extends \yii\db\ActiveRecord
{
    public $category_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    public function scenarios()
    {
        return [
            'create' => ['category_name', 'name', 'content'],
            'update' => ['category_name', 'name', 'content'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'name', 'content'], 'required'],
            [['category_id', 'user_id'], 'integer'],
            [['content'], 'string'],
            [['created'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'content' => 'Content',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
