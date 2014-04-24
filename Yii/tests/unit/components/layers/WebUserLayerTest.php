<?php
/**
 * This test is designed to check correct functionality of {@link WebUserLayer}
 * class.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class WebUserLayerTest extends CTestCase
{
    /**
     * Test for messaging interface.
     * 
     * @covers WebUserLayer::sendMessage()
     * @covers WebUserLayer::getMessages()
     * @covers WebUserLayer::hasMessages()
     * 
     * @return void
     * @since 0.1.0
     */
    public function testMessages()
    {
        $nonsense = md5('nonsense');
        $nsMessage = array(
            'message' => $nonsense,
            'level' => \WebUserLayer::FLASH_NOTICE
        );
        /** @var WebUserLayer $user */
        $user = \Yii::app()->user;
        $user->setFlash('user.messages', null);
        $user->sendMessage($nonsense);
        $this->assertTrue($user->hasMessages());
        $user->getMessages(); // flushing
        foreach (array(1, 2, 10) as $rounds) {
            $expectation = array();
            for ($i = 0; $i < $rounds; $i++) {
                $user->sendMessage($nonsense);
                $expectation[] = $nsMessage;
            }
            $this->assertSame($expectation, $user->getMessages());
        }
        $expectation = array();
        // pushing first message decade
        for ($i = 0; $i < 10; $i++) {
            $user->sendMessage($nonsense.$nonsense);
        }
        // pushing second message decade - the first one should be completely
        // erased after this
        for ($i = 0; $i < 10; $i++) {
            $expectation[] = $nsMessage;
            $user->sendMessage($nonsense);
        }
        $this->assertSame($expectation, $user->getMessages());
        // testing automatic deletion & message presence checking
        $user->sendMessage($nonsense);
        $this->assertTrue($user->hasMessages());
        $this->assertSame(array($nsMessage), $user->getMessages(false));
        $this->assertTrue($user->hasMessages());
        $this->assertSame(array($nsMessage), $user->getMessages());
        $this->assertFalse($user->hasMessages());
        $this->assertSame(array(), $user->getMessages());
    }
    /**
     * A simple test for data saving functions.
     * 
     * @covers WebUserLayer::saveData()
     * @covers WebUserLayer::getData()
     * @covers WebUserLayer::hasData()
     * 
     * @return void
     * @since 0.1.0
     */
    public function testData()
    {
        $key = 'superdata';
        $fullKey = 'data.'.$key;
        $data = array('key' => $key);
        /** @var WebUserLayer $user */
        $user = \Yii::app()->user;
        $this->assertFalse($user->hasFlash($fullKey));
        $user->saveData($key, $data);
        $this->assertTrue($user->hasData($key));
        $this->assertSame($user->getData($key, false), $data);
        $this->assertTrue($user->hasData($key));
        $this->assertSame($user->getData($key), $data);
        $this->assertFalse($user->hasData($key));
        $this->assertSame($user->getData($key), null);
    }
}
