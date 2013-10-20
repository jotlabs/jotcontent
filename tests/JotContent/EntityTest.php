<?php

use JotContent\Entity;

class ExampleEntity extends Entity {

    protected static $models = array();

    public function getSchema() {
        return $this->_getSchema();
    }
}


class EntityTest extends PHPUnit_Framework_TestCase {
    protected $entity;

    public function setUp() {
        $this->entity = ExampleEntity::getInstance();
    }

    public function testEntityClassExists() {
        $this->assertTrue(class_exists('JotContent\Entity'));
    }


    public function testEntitySchemaExists() {
        $schema = $this->entity->getSchema();
        //print_r($schema);
    }

}


?>
