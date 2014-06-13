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
class PostTest extends CTestCase
{
    /**
     * Cached model for tests. Used to prevent model recreation when unnecessary
     * and decrease test time.
     *
     * @var Post
     * @since 0.1.0
     */
    protected static $model;
    /**
     * Once-run setup method. Used to expand fixtures into database.
     * 
     * @return void
     * @since 0.1.0
     */
    public static function setUpBeforeClass()
    {
        static::$model = new Post;
    }
    /**
     * Once-run method for destroying fixtures.
     * 
     * @return void
     * @since 0.1.0
     */
    public static function tearDownAfterClass()
    {
        
    }
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
                'name' => str_repeat(' too long ', 26),
                'slug' => '',
                'content' => 'valid content',
                'category_id' => 1,
            ), false),
            array(array(
                'name' => 'too long slug',
                'slug' => str_repeat(' too long ', 26),
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
     * @dataProvider validationDataProvider
     *
     * @param array $attributes Attributes to check validation.
     * @param $expectedResult Expected validation result.
     * @since 0.1.0
     */
    public function testValidation(array $attributes, $expectedResult)
    {
        $this->assertSame(
            static::$model->setAndValidate($attributes),
            $expectedResult
        );
    }
}
