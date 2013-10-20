<?php

use JotContent\Model;

class ExampleModel extends Model {
    
    public $testDate;

    public function setPrimaryKey($key) {
        $this->_id = $key;
    }

    public function getFormattedTestDate() {
        return $this->formatDate($this->testDate);
    }

}

class ModelTest extends PHPUnit_Framework_TestCase {
    protected $model;

    public function setUp() {
        $this->model = new ExampleModel();
    }


    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Model'));
        $this->assertNotNull($this->model);
        $this->assertTrue(is_a($this->model, 'ExampleModel'));
        $this->assertTrue(is_a($this->model, 'JotContent\Model'));
    }


    public function testPrimaryKey() {
        $this->model->setPrimaryKey(17);
        $this->assertEquals(17, $this->model->getPrimaryKey());
    }

    
    public function testDefaultDateFormatting() {
        $dates = array(
            array('2013-09-04 07:30:17', '04 September 2013')
        );

        foreach($dates as $dateTest) {
            $this->model->testDate = $dateTest[0];
            $this->assertEquals($dateTest[1], $this->model->getFormattedTestDate());
        } 
    }

}


?>
