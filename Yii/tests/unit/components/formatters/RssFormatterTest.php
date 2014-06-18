<?php
namespace components\formatters;


use Codeception\Util\Fixtures;

class RssFormatterTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $guy;

    protected function _before()
    {
        $_SERVER['SERVER_NAME'] = 'fake.blogmvc.yii';
    }

    protected function _after()
    {
        $defaultServerName = Fixtures::get('defaultServerName');
        if ($defaultServerName) {
            $_SERVER['SERVER_NAME'] = $defaultServerName;
        } else {
            unset($_SERVER['SERVER_NAME']);
        }
    }

    /**
     * Provides models for RSS feed.
     *
     * @return array|\CActiveRecord|\CActiveRecord[]|mixed|null
     * @since
     */
    public function modelProvider()
    {
        \Yii::app()->fixtureManager->prepare();
        return \Post::model()->findAll(array('limit' => 10));
    }
    // tests
    public function testMe()
    {
        $formatter = new \RssFormatter;
        $models = $this->modelProvider();
        $rss = $formatter->format($models);
        $reader = new \SimpleXMLElement($rss);
        $this->assertSame('rss', $reader->getName());
        $children = (array) $reader->children();
        $channel = (array) $children['channel'];
        foreach (array('title', 'link', 'description') as $key) {
            $this->assertArrayHasKey($key, $channel);
        }
        $posts = $channel['item'];
        $keys = array('title', 'link', 'description', 'pubDate');
        foreach ($posts as $post) {
            $post = (array) $post;
            foreach ($keys as $key) {
                $this->assertNotEmpty($post[$key]);
            }
        }
        $this->assertTrue(sizeof($posts) === sizeof($models));
    }
}