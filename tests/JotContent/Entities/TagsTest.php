<?php

use JotContent\DataSources\PdoDataSource;
use JotContent\Entities\Tags;

class TagsTest extends PHPUnit_Framework_TestCase {
    protected $tags;

    public function setUp() {
        $dsn = UnitTestUtils::getDatasource('videos');
        $this->tags = Tags::getInstance();
        $this->tags->setDataSource(new PdoDataSource($dsn));
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Entities\Tags'));
        $this->assertTrue(is_a($this->tags, 'JotContent\Entities\Tags'));
    }

    
    public function testGetByContentId() {
        $tags = $this->tags->getByContentId(1, true);
        $this->assertNotNull($tags);

        $this->assertTrue(is_array($tags));
        $this->assertEquals(2, count($tags));

        $tag = $tags[0];
        $this->assertTrue(is_a($tag, 'JotContent\Model'));
        $this->assertTrue(is_a($tag, 'JotContent\Models\Tag'));
        $this->assertEquals('jillian-michaels', $tag->slug);
        $this->assertEquals('Jillian Michaels', $tag->name);

        $tag = $tags[1];
        $this->assertTrue(is_a($tag, 'JotContent\Model'));
        $this->assertTrue(is_a($tag, 'JotContent\Models\Tag'));
        $this->assertEquals('befit', $tag->slug);
        $this->assertEquals('BeFit', $tag->name);

    }

}


?>

