<?php
namespace components;


use Codeception\Util\Fixtures;

class UserIdentityTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $guy;

    // tests
    public function testAuthentication()
    {
        $username = Fixtures::get('data:users[0]:login');
        $password = Fixtures::get('data:users[0]:password');
        \Yii::app()->fixtureManager->prepare();

        // setting inexsiting username
        $identity = new \UserIdentity(md5(mt_rand(0, PHP_INT_MAX)), $password);
        $this->assertFalse($identity->authenticate());
        $this->assertSame(
            $identity->errorCode,
            \UserIdentity::ERROR_USERNAME_INVALID
        );

        // setting inexisting password
        $identity->password = $identity->username;
        $identity->username = $username;
        $this->assertFalse($identity->authenticate());
        $this->assertSame(
            $identity->errorCode,
            \UserIdentity::ERROR_PASSWORD_INVALID
        );

        $identity->password = $password;
        $this->assertTrue($identity->authenticate());
        $this->assertSame(
            $identity->errorCode,
            \UserIdentity::ERROR_NONE
        );
    }
}