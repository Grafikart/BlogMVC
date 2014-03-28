<?php

/**
 * Description of WebUserLayerTest
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
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
        $user = Yii::app()->user;
        $user->setFlash('user.messages', null);
        $user->sendMessage($nonsense);
        $this->assertTrue($user->hasMessages());
        $user->getMessages(); // flushing
        foreach (array(1, 2, 10) as $rounds) {
            $expectation = array();
            for ($i = 0; $i < $rounds; $i++) {
                $user->sendMessage($nonsense);
                $expectation[] = $nonsense;
            }
            $this->assertSame($user->getMessages(), $expectation);
        }
        $expectation = array();
        // pushing first message decade
        for ($i = 0; $i < 10; $i++) {
            $user->sendMessage($nonsense.$nonsense);
        }
        // pushing second message decade - the first one should be completely
        // erased after this
        for ($i = 0; $i < 10; $i++) {
            $expectation[] = $nonsense;
            $user->sendMessage($nonsense);
        }
        $this->assertSame($user->getMessages(), $expectation);
        // testing automatic deletion & message presence checking
        $user->sendMessage($nonsense);
        $this->assertTrue($user->hasMessages());
        $this->assertSame(array($nonsense), $user->getMessages(false));
        $this->assertTrue($user->hasMessages());
        $this->assertSame(array($nonsense), $user->getMessages());
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
        $user = Yii::app()->user;
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
