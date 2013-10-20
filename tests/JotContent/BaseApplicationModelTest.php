<?php

use JotContent\BaseApplicationModel;

class BaseApplicationModelTest extends PHPUnit_Framework_TestCase {
    protected $baseModel;

    public function setUp() {
        $this->baseModel = new BaseApplicationModel();
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\BaseApplicationModel'));
        
        $this->assertTrue(is_a($this->baseModel, 'JotContent\BaseApplicationModel'));
        $this->assertTrue(is_a($this->baseModel, 'JotContent\ApplicationModelConstants'));

    }

    public function testAppModelConstantsExists() {
        $this->assertNotNull(BaseApplicationModel::CONTENT_ENVELOPE_ADAPTER);
        $this->assertNotNull(BaseApplicationModel::MODEL_CLASS);
        $this->assertNotNull(BaseApplicationModel::PRIMARY_MODEL);
        $this->assertNotNull(BaseApplicationModel::MODEL_ADAPTER);
    }
}

?>
