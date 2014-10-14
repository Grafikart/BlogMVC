<?php
namespace components\behaviors;
use Codeception\Util\Stub;

/**
 * Verifies {@link \DateTimeCreatedBehavior} correctness.
 *
 * @version Release: 0.1.0
 * @since   0.1.0
 * @package BlogMVC
 * @subpackage YiiTests
 * @author  Fike Etki <etki@etki.name>
 */
class DateTimeCreatedBehaviorTest extends \Codeception\TestCase\Test
{
    /**
     * Tests correct date/time setting.
     *
     * @return void
     * @since 0.1.0
     */
    public function testBehavior()
    {
        // mocking failed :(
        /*$post = Stub::Make(
            'Post',
            array(
                'insert' => function () {
                    return true;
                },
                'update' => function () {
                    return true;
                },
                'name' => 'Dummy name',
                'content' => 'Dummiest content',
                'user_id' => 1,
                'category_id' => 1,
            )
        );*/
        $post = new \Post;
        $post->setAttributes(
            array(
                'name' => 'Dummy name',
                'content' => 'Dummiest content',
                'user_id' => 1,
                'category_id' => 1,
            ),
            false
        );
        $this->assertNull($post->created);
        $post->save();
        $dt = new \DateTime();
        $this->assertSame($dt->format(\DateTime::ISO8601), $post->created);
        usleep(1.1 * 1000 * 1000);
        $post->save();
        $this->assertSame($dt->format(\DateTime::ISO8601), $post->created);
    }
}