<?php
use Codeception\Util\Fixtures;

class UserTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $guy;

    protected function _before()
    {
        \Yii::app()->fixtureManager->prepare();
    }

    protected function _after()
    {
    }

    // tests
    /**
     * Tests added fetching methods.
     *
     * @return void
     * @since 0.1.0
     */
    public function testFetching()
    {
        $username = Fixtures::get('data:users[0]:login');
        $user = \User::model()->findByUsername($username);
        $this->assertTrue($user instanceof \User);
        $this->assertTrue($user->username === $username);
        $nonexistingUsername = Fixtures::get('data:random:string');
        $this->assertNull(\User::model()->findByUsername($nonexistingUsername));
    }

    /**
     * Tests validation rules.
     *
     * @depends testFetching
     *
     * @return void
     * @since 0.1.0
     */
    public function testValidation()
    {
        $username = Fixtures::get('data:users[0]:login');
        // duplicate username
        $user = new \User;
        $user->username = $username;
        $user->password = 'empty';
        $this->assertFalse($user->validate());

        $user = \User::model()->findByUsername($username);
        $user->scenario = 'usernameUpdate';
        $this->assertTrue($user->validate());
        $user->username = Fixtures::get('data:users[1]:login');
        $this->assertFalse($user->validate());
        // too short
        $user->username = 'q';
        $this->assertFalse($user->validate());
        // ok now
        $user->username = 'Underquokka';
        $this->assertTrue($user->validate());

        // wrong password
        $user->scenario = 'passwordUpdate';
        $user->password = 'wrongpass';
        $user->newPassword = 'passpasspass';
        $user->newPasswordRepeat = 'passpasspass';
        $this->assertFalse($user->validate());

        $user->password = Fixtures::get('data:users[0]:password');
        $user->newPassword = 'pass';
        // short new password
        $this->assertFalse($user->validate());

        //different from second confirmation password
        $user->newPassword = 'passpasspass1';
        $this->assertFalse($user->validate());

        //ok now
        $user->newPasswordRepeat = 'passpasspass1';
        $this->assertTrue($user->validate());
    }
}