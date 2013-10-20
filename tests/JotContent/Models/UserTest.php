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
    }


}

?>
