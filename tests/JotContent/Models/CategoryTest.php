<?php

use JotContent\Models\Category;

class CategoryTest extends PHPUnit_Framework_TestCase {
    protected $category;

    public function setUp() {
        $this->category = new Category();
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Models\Category'));
        $this->assertTrue(is_a($this->category, 'JotContent\Models\Category')); 
        $this->assertTrue(is_a($this->category, 'JotContent\Model')); 

        $this->assertTrue(property_exists($this->category, '_id'));
        $this->assertTrue(property_exists($this->category, '_content_id'));
        $this->assertTrue(property_exists($this->category, 'slug'));
        $this->assertTrue(property_exists($this->category, 'title'));
        $this->assertTrue(property_exists($this->category, 'description'));
        $this->assertTrue(property_exists($this->category, 'image'));
        $this->assertTrue(property_exists($this->category, 'dateAdded'));
        $this->assertTrue(property_exists($this->category, '_items'));
    }


}

?>
