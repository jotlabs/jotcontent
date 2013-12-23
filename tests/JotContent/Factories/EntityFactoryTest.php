<?php

use JotContent\Factories\EntityFactory;
use JotContent\Entity;

class UnitTestEntity extends Entity {

}

class EntityFactoryTest extends PHPUnit_Framework_TestCase {
    protected $factory;

    public function setUp() {
        $this->factory = EntityFactory::getInstance();
        $this->factory->addDataSource('__DEFAULT__', array());
        $this->factory->addEntity('unittest', 'UnitTestEntity');
        $this->factory->addEntity('unittest-spec', array('class' => 'UnitTestEntity'));
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Factories\EntityFactory'));
        $this->assertNotNull($this->factory);
        $this->assertTrue(is_a($this->factory, 'JotContent\Factories\EntityFactory'));

        $this->assertTrue(method_exists($this->factory, 'getInstance'));
    }

    public function testGetEntityReturnsEntity() {
        $entity = $this->factory->getEntity('unittest');

        $this->assertNotNull($entity);
        $this->assertTrue(is_a($entity, 'UnitTestEntity'));
        $this->assertTrue(is_a($entity, 'JotContent\Entity'));

    }

    public function testGetEntityOnEntitySpecReturnsEntity() {
        $entity = $this->factory->getEntity('unittest-spec');

        $this->assertNotNull($entity);
        $this->assertTrue(is_a($entity, 'UnitTestEntity'));
        $this->assertTrue(is_a($entity, 'JotContent\Entity'));

    }

}


?>
