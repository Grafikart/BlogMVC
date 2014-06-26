<?php

/**
 * Standard test class for Post model.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 */
class PostTest extends \Codeception\TestCase\Test
{
    /**
     * Updates fixtures before every test.
     *
     * @return void
     * @since 0.1.0
     */
    public function _before()
    {
        \Yii::app()->fixtureManager->prepare();
    }

    /**
     * Simple data provider with sets of attributes for validation.
     *
     * @return array
     * @since 0.1.0
     */
    public function validationDataProvider()
    {
        return array(
            array(array(
                'name' => 'valid name',
                'slug' => '',
                'content' => 'tooshort',
                'category_id' => 1,
            ), false),
            array(array(
                'name' => '', //too short
                'slug' => '',
                'content' => 'valid content',
                'category_id' => 1,
            ), false),
            array(array(
                'name' => 'no category',
                'slug' => '',
                'content' => 'valid content',
            ), false),
            array(array(
                'name' => str_repeat('c', 256),
                'slug' => '',
                'content' => 'valid content',
                'category_id' => 1,
            ), false),
            array(array(
                'name' => 'too long slug',
                'slug' => str_repeat('c', 256),
                'content' => 'valid content',
                'category_id' => 1,
            ), false),
            array(array(
                'name' => 'too short slug',
                'slug' => '1',
                'content' => 'valid content',
                'category_id' => 1,
            ), false),
            array(array(
                'name' => 'Solid Post',
                'slug' => 'solid-post',
                'content' => 'Let\'s talk about Single Responsibility principle.',
                'category_id' => 1,
            ), true),
        );
    }

    /**
     * Tests validation rules.
     *
     * @param array   $attributes     Attributes to check validation.
     * @param boolean $expectedResult Expected validation result.
     *
     * @dataProvider validationDataProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testValidation(array $attributes, $expectedResult)
    {
        $model = new \Post;
        $this->assertSame(
            $model->setAndValidate($attributes),
            $expectedResult
        );
    }

    /**
     * Verifies that main cache key resets every time post is edited.
     *
     * @return void
     * @since 0.1.0
     */
    public function testCacheInvalidation()
    {
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $value = $app->getGlobalState('lastPostUpdate');
        $post = new \Post;
        $attrs = array(
            'name' => 'just a name',
            'slug' => 'just-a-name',
            'content' => 'Dummy content',
            'created' => '2010-05-05 12:12:12',
            'user_id' => 1,
            'category_id' => 1,
        );
        $post->setAttributes($attrs, false);
        $post->save();
        $this->assertNotSame(
            $value,
            $value = $app->getGlobalState('lastPostUpdate')
        );
        $post->delete();
        $this->assertNotSame(
            $value,
            $value = $app->getGlobalState('lastPostUpdate')
        );
    }

    /**
     * Tests category counters update after category switching.
     *
     * @return void
     * @since 0.1.0
     */
    public function testCategorySwitching()
    {
        /** @type \Post $post $post */
        $post = \Post::model()->findByAttributes(
            array('slug' => 'first-post',)
        );
        $categoryId = $post->category_id;
        $newCategoryId = $categoryId - 1 > 0 ? $categoryId - 1 : $categoryId + 1;
        /** @type \Category $category */
        $category = \Category::model()->findByPk($categoryId);
        /** @type \Category $newCategory */
        $newCategory = \Category::model()->findByPk($newCategoryId);
        $counters = array($category->post_count, $newCategory->post_count);
        $post->category_id = $newCategoryId;
        $post->save();
        /** @type \Category $category */
        $category = \Category::model()->findByPk($categoryId);
        /** @type \Category $newCategory */
        $newCategory = \Category::model()->findByPk($newCategoryId);
        $this->assertEquals($counters[0] - 1, $category->post_count);
        $this->assertEquals($counters[1] + 1, $newCategory->post_count);
    }
}
