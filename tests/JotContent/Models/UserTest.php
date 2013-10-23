<?php

use JotContent\Models\User;

class UserTest extends PHPUnit_Framework_TestCase {
    protected $user;

    public function setUp() {
        $this->user = new User();
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Models\User'));
        $this->assertTrue(is_a($this->user, 'JotContent\Models\User')); 
        $this->assertTrue(is_a($this->user, 'JotContent\Model')); 

        $this->assertTrue(property_exists($this->user, '_id'));
        $this->assertTrue(property_exists($this->user, 'name'));
        $this->assertTrue(property_exists($this->user, 'email'));
        $this->assertTrue(property_exists($this->user, 'avatar'));
        $this->assertTrue(property_exists($this->user, 'passwordHash'));
        $this->assertTrue(property_exists($this->user, 'status'));
        $this->assertTrue(property_exists($this->user, 'dateAdded'));
        $this->assertTrue(property_exists($this->user, '_sessions'));
        $this->assertTrue(property_exists($this->user, '_roles'));
    }


}

?>
