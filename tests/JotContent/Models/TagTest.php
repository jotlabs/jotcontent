<?php

use JotContent\Models\Tag;

class TagTest extends PHPUnit_Framework_TestCase {
    protected $tag;

    public function setUp() {
        $this->tag = new Tag();
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Models\Tag'));
        $this->assertTrue(is_a($this->tag, 'JotContent\Models\Tag')); 
        $this->assertTrue(is_a($this->tag, 'JotContent\Model')); 

        $this->assertTrue(property_exists($this->tag, '_id'));
        $this->assertTrue(property_exists($this->tag, 'slug'));
        $this->assertTrue(property_exists($this->tag, 'name'));
        $this->assertTrue(property_exists($this->tag, 'description'));
        $this->assertTrue(property_exists($this->tag, 'dateCreated'));
        $this->assertTrue(property_exists($this->tag, 'dateAdded'));
        $this->assertTrue(property_exists($this->tag, 'dateAdded'));
        $this->assertTrue(property_exists($this->tag, '_items'));
    }


}

?>
