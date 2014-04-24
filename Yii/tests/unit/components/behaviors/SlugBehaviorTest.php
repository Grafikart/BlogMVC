<?php
namespace components\behaviors;
use Codeception\Module\CacheHelper;
use Codeception\Module\MigrationHelper;

class SlugBehaviorTest extends \Codeception\TestCase\Test
{
   /**
    * Standard Codeception guy.
    *
    * @var \CodeGuy
    * @since 0.1.0
    */
    protected $codeGuy;

    public function postAttributesProvider()
    {
        return array(
            array(
                array(),
                'test-post-post-post',
            ),
            array(
                array(),
                'test-post-post-post-1',
            ),
            array(
                array(),
                'test-post-post-post-2',
            ),
        );
    }

    /**
     * Test initializer.
     *
     * @return void
     * @since 0.1.0
     */
    public static function setUpBeforeClass()
    {
        $module = MigrationHelper::getInstance();
        $module->revertMigrations();
        $module->applyMigrations();
        \Yii::app()->language = '00';
    }

    /**
     * Dispose method.
     *
     * @return void
     * @since
     */
    public static function tearDownAfterClass()
    {
        \Yii::app()->language = CacheHelper::$lang;
    }

    /**
     * Tests generation from valid slug source.
     *
     * @param array  $attributes   Additional set of attributes which override
     * original ones. Currently not used, but may be useful if test will be
     * extended.
     * @param string $expectedSlug Expected created slug.
     *
     * @dataProvider postAttributesProvider
     *
     * @return void
     * @since
     */
    public function testSlugBehavior($attributes, $expectedSlug)
    {
        $defaultAttributes = array(
            'name' => 'Test post post post',
            'content' => 'Long enough to conform validation',
            'user_id' => 1,
            'category_id' => 1,
        );
        $post = new \Post;
        $post->setAttributes(array_merge($defaultAttributes, $attributes), false);
        if (!$post->save()) {
            $this->markTestSkipped('Couldn\'t save post');
        }
        $this->assertSame($expectedSlug, $post->slug);
    }

    /**
     * Tests SlugBehavior validation.
     *
     * @return void
     * @since 0.1.0
     */
    public function testValidation()
    {
        $defaultAttributes = array(
            'name' => 'Test post post post',
            'content' => 'Long enough to conform validation',
            'user_id' => 1,
            'category_id' => 1,
            'slug' => 'admin',
        );
        $post = new \Post;
        $post->setAttributes($defaultAttributes, false);
        if ($post->save(false)) {
            $message = 'Restricted slug hasn\'t been detected by SlugBehavior '.
                       '(resulting slug: ['.$post->slug.'])';
            $this->fail($message);
        }
        $this->assertTrue(
            in_array(
                'slugBehavior.restrictedSlug',
                $post->getErrors('slug'),
                true
            )
        );

        $post->setAttributes(array('slug' => '', 'name' => '',), false);
        $post->validate(array());
        if ($post->save(false)) {
            $this->fail('Empty slug hasn\'t been detected by SlugBehavior');
        }
        $this->assertTrue(
            in_array(
                'slugBehavior.emptySlug',
                $post->getErrors('slug'),
                true
            )
        );
    }
}