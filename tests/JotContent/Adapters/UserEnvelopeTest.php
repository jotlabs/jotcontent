<?php

use JotContent\Adapters\UserEnvelope;
use JotContent\Adapters\ContentDecorator;
use JotContent\Models\User;


class TestUserDecorator implements ContentDecorator {
    public function say() {
        return "Hello";
    }

    public function getDecoratorKey() {
        return 'testDecorator';
    }
}

class UserEnvelopeTest extends PHPUnit_Framework_TestCase {

    protected $user;


    public function setUp() {
        $user = new User();
        $user->name      = 'Unit test';
        $user->email     = 'unittest@example.com';
        $user->avatar    = 'http://example.com/avatar/unittest.jpg';
        $user->passwordHash = md5('passwordHash');
        $user->status    = 'A';
        $user->dateAdded = '2013-09-23 07:26:17'; 

        $this->user = new UserEnvelope($user);

    }    


    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Adapters\UserEnvelope'));

        $this->assertNotNull($this->user);
        $this->assertTrue(is_a($this->user, 'JotContent\Adapters\UserEnvelope'));
    }

    public function testPropertiesSet() {
        $this->assertTrue(isset($this->user->name));
        $this->assertTrue(isset($this->user->email));
        $this->assertTrue(isset($this->user->avatar));
        $this->assertTrue(isset($this->user->passwordHash));
        $this->assertTrue(isset($this->user->status));
        $this->assertTrue(isset($this->user->dateAdded));

    }

    public function testSurfacedMethods() {
        $this->assertTrue(is_callable(array($this->user, 'getSessions')));
        $this->assertTrue(is_array($this->user->getSessions()));

    }

    public function testSurfacedMethodsFindAnActualMethod() {
        $this->assertNull($this->user->undefinedMethod());
    }

    public function testSurfacedPropertyGetterMethods() {
        $this->assertTrue(isset($this->user->sessions));
        $this->assertTrue(is_array($this->user->sessions));
        
    }

    public function testPropertiesNotSet() {
        $this->assertFalse(isset($this->user->noSuchProperty));
    }

    public function testPrimitiveTypes() {
        $this->assertEquals('Unit test', $this->user->name);
        $this->assertEquals('unittest@example.com', $this->user->email);
        $this->assertEquals('http://example.com/avatar/unittest.jpg', $this->user->avatar);
        $this->assertEquals(md5('passwordHash'), $this->user->passwordHash);
        $this->assertEquals('A', $this->user->status);
        $this->assertEquals('2013-09-23 07:26:17', $this->user->dateAdded);
    }

    public function testDecoratorRecognised() {
        $this->user->decorate('testDecorator', true);
        $this->assertTrue(isset($this->user->testDecorator));
        $this->assertFalse(isset($this->user->testNoDecorator));

        $testDecorator = $this->user->testDecorator;
        $this->assertTrue(is_bool($testDecorator));
        $this->assertTrue($testDecorator);
    }

    
    public function testDecoratorObjectRecognised() {
        $this->user->decorate('testDecorator', new TestUserDecorator());

        $this->assertNotNull($this->user->testDecorator);
        $this->assertTrue(is_a($this->user->testDecorator, 'TestUserDecorator'));
        $this->assertTrue(is_a($this->user->testDecorator, 'JotContent\Adapters\ContentDecorator'));
        $message = $this->user->testDecorator->say();
        $this->assertNotNull($message);
        $this->assertEquals('Hello', $message);

    }
    
}


?>
