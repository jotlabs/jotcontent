<?php

use JotContent\Models\ContentModel;

class ContentModelTest extends PHPUnit_Framework_TestCase {
    protected $contentModel;

    public function setUp() {
        $this->contentModel = new ContentModel();
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Models\ContentModel'));
        $this->assertTrue(is_a($this->contentModel, 'JotContent\Models\ContentModel'));
        $this->assertTrue(is_a($this->contentModel, 'JotContent\Model'));

        $this->assertTrue(property_exists($this->contentModel, '_id'));
        $this->assertTrue(property_exists($this->contentModel, 'entity'));
        $this->assertTrue(property_exists($this->contentModel, 'slug'));
        $this->assertTrue(property_exists($this->contentModel, 'title'));
    }


}

?>
