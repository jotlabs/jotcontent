<?php

use JotContent\Adapters\ContentEnvelope;
use JotContent\Adapters\ContentDecorator;

class TestEnvelope {
    public $slug               = 'test-content';
    public $nullProperty       = NULL;
    public $overriddenProperty = false;
}

class TestContent {
    public $source             = 'unit-test';
    public $overriddenProperty = true;
    public $emptyString        = '';
    public $emptyArray         = array();
    public $singleItemArray    = array('singleItem');
    public $zeroInt            = 0;
    public $positiveInt        = 6;
    public $negativeInt        = -7;
    public $booleanTrue        = true;
    public $booleanFalse       = false;

    public function getArrayItem() {
        return $this->singleItemArray[0];
    }

    public function getFormattedBoolean() {
        return $this->booleanTrue?'true':'false';
    }
}

class TestDecorator implements ContentDecorator {
    public function say() {
        return "Hello";
    }

    public function getDecoratorKey() {
        return 'testDecorator';
    }
}

class ContentEnvelopeTest extends PHPUnit_Framework_TestCase {

    protected $content;


    public function setUp() {
        $this->content = new ContentEnvelope(
                            new TestEnvelope(),
                            new TestContent()
                        );

    }    


    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Adapters\ContentEnvelope'));

        $content = new ContentEnvelope();
        $this->assertNotNull($content);
        $this->assertTrue(is_a($content, 'JotContent\Adapters\ContentEnvelope'));
    }

    public function testPropertiesSet() {
        $this->assertTrue(isset($this->content->slug));
        $this->assertTrue(isset($this->content->source));
        $this->assertTrue(isset($this->content->overriddenProperty));
        $this->assertTrue(isset($this->content->emptyString));
        $this->assertTrue(isset($this->content->emptyArray));
        $this->assertTrue(isset($this->content->singleItemArray));
        $this->assertTrue(isset($this->content->zeroInt));
        $this->assertTrue(isset($this->content->positiveInt));
        $this->assertTrue(isset($this->content->negativeInt));
        $this->assertTrue(isset($this->content->booleanTrue));
        $this->assertTrue(isset($this->content->booleanFalse));

        $this->assertFalse(isset($this->content->nullProperty));

    }

    public function testSurfacedMethods() {
        $this->assertTrue(is_callable(array($this->content, 'getArrayItem')));
        $this->assertEquals('singleItem', $this->content->getArrayItem());

    }

    public function testSurfacedMethodsActuallyExist() {
        $this->assertNull($this->content->undefinedMethod());

    }

    public function testSurfacedPropertyGetterMethods() {
        $this->assertTrue(isset($this->content->booleanTrue));
        $this->assertTrue(isset($this->content->formattedBoolean));
        $this->assertTrue(is_string($this->content->formattedBoolean));
        $this->assertEquals('true', $this->content->formattedBoolean);
        
    }

    public function testPropertiesNotSet() {
        $this->assertFalse(isset($this->content->noSource));
    }

    public function testPrimitiveTypes() {
        $this->assertTrue($this->content->booleanTrue);
        $this->assertFalse($this->content->booleanFalse);
        $this->assertEquals('test-content', $this->content->slug);
        $this->assertEquals('unit-test', $this->content->source);
        $this->assertEquals('', $this->content->emptyString);
        $this->assertEquals(0, $this->content->zeroInt);
        $this->assertEquals(6, $this->content->positiveInt);
        $this->assertEquals(-7, $this->content->negativeInt);
        $this->assertEquals(NULL, $this->content->nullProperty);
    }

    public function testArrays() {
        $this->assertFalse(is_array($this->content->zeroInt));
        $this->assertTrue(is_array($this->content->emptyArray));
        $this->assertTrue(is_array($this->content->singleItemArray));

        $this->assertEquals(0, count($this->content->emptyArray));
        $this->assertEquals(1, count($this->content->singleItemArray));
    }

    public function testOverriddenProperties() {
        $this->assertTrue($this->content->overriddenProperty);
    }


    public function testDecoratorRecognised() {
        $this->content->decorate('testDecorator', true);
        $this->assertTrue(isset($this->content->testDecorator));
        $this->assertFalse(isset($this->content->testNoDecorator));

        $testDecorator = $this->content->testDecorator;
        $this->assertTrue(is_bool($testDecorator));
        $this->assertTrue($testDecorator);
    }

    
    public function testDecoratorObjectRecognised() {
        $this->content->decorate('testDecorator', new TestDecorator());

        $this->assertTrue(is_a($this->content->testDecorator, 'TestDecorator'));
        $this->assertTrue(is_a($this->content->testDecorator, 'JotContent\Adapters\ContentDecorator'));
        $message = $this->content->testDecorator->say();
        $this->assertNotNull($message);
        $this->assertEquals('Hello', $message);

    }

    
}


?>
