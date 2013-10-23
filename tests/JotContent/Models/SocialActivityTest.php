<?php

use JotContent\Models\SocialActivity;

class SocialActivityTest extends PHPUnit_Framework_TestCase {
    protected $socialActivity;

    public function setUp() {
        $this->socialActivity = new SocialActivity();
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Models\SocialActivity'));
        $this->assertTrue(is_a($this->socialActivity, 'JotContent\Models\SocialActivity')); 
        $this->assertTrue(is_a($this->socialActivity, 'JotContent\Model')); 

        $this->assertTrue(property_exists($this->socialActivity, '_id'));
        $this->assertTrue(property_exists($this->socialActivity, '_content_id'));
        $this->assertTrue(property_exists($this->socialActivity, 'link'));
        $this->assertTrue(property_exists($this->socialActivity, 'dateCreated'));
        $this->assertTrue(property_exists($this->socialActivity, 'score'));
        $this->assertTrue(property_exists($this->socialActivity, 'activity'));
        $this->assertTrue(property_exists($this->socialActivity, 'lastUpdate'));
        $this->assertTrue(property_exists($this->socialActivity, '_metrics'));
    }

    public function testMetrics() {
        $this->assertTrue(is_array($this->socialActivity->getMetrics()));
        $this->assertEquals(0, count($this->socialActivity->getMetrics()));

        $this->socialActivity->addMetrics(array(1,2,3,4));
        $this->assertEquals(4, count($this->socialActivity->getMetrics()));

    }

}

?>
