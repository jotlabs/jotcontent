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
    }


}

?>
