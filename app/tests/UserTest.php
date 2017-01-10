<?php
require 'app/models/User.php';

class UserTests extends PHPUnit_Framework_TestCase
{
    private $user;

    protected function setUp()
    {
        $this->user = new User();
    }

    protected function tearDown()
    {
        $this->user = NULL;
    }

    public function testIsLoginLengthOk()
    {
        $result = $this->user->isLoginLengthOk("bob");
        $this->assertTrue($result);
    }

    public function testIsPasswordLengthOk()
    {
        $result = $this->user->isPasswordLengthOk("bob");
        $this->assertFalse($result);
    }
}

?>
