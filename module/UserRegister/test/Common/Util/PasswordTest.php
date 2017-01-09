<?php

namespace UserRegisterTest\Common\Util;

use UserRegister\Common\Util\Password;

class PasswordTest extends \PHPUnit_Framework_TestCase
{
    /**
     * テストケース初回時（1回のみ呼ばれる） 
     */    
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * テストケースメソッド開始時（メソッド毎に呼ばれる）
     */
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * テストケースメソッド終了時（メソッド毎に呼ばれる）
     */
    public function tearDown()
    {
        parent::tearDown();
    }
    
    public function testMakePassword()
    {
        // test1
        $password = "sample0001";
        $passwordHash = Password::makePasswordHash($password);
        $this->assertTrue(Password::isVerity($password, $passwordHash));

        // test2
        $password = "test+*@sample$$";
        $passwordHash = Password::makePasswordHash($password);
        $this->assertTrue(Password::isVerity($password, $passwordHash));
        
        // test3
        $password = "samplepassword";
        $passwordHash = Password::makePasswordHash($password);
        $this->assertFalse(Password::isVerity("falsepassword", $passwordHash));
    }
}
