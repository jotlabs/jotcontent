<?php

use JotContent\Models\Content;

class ContentTest extends PHPUnit_Framework_TestCase {
    protected $content;

    public function setUp() {
        $this->content = new Content();
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Models\Content'));
        $this->assertTrue(is_a($this->content, 'JotContent\Models\Content'));
        $this->assertTrue(is_a($this->content, 'JotContent\Model'));

        $this->assertTrue(property_exists($this->content, '_id'));

        $this->assertTrue(property_exists($this->content, '_content_model_id'));
        $this->assertTrue(property_exists($this->content, '_content_id'));

        $this->assertTrue(property_exists($this->content, 'slug'));
        $this->assertTrue(property_exists($this->content, 'title'));
        $this->assertTrue(property_exists($this->content, 'summary'));
        $this->assertTrue(property_exists($this->content, 'thumbnail'));

        $this->assertTrue(property_exists($this->content, 'contentType'));
        $this->assertTrue(property_exists($this->content, 'dateAdded'));
        $this->assertTrue(property_exists($this->content, 'lastUpdated'));
        $this->assertTrue(property_exists($this->content, 'status'));
    }


}

?>
