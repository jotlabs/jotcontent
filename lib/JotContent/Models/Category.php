<?php

namespace JotContent\Models;

use JotContent\Model;
use JotContent\Adapters\ContentDecorator;

class Category extends Model implements ContentDecorator {

    protected $_id;
    protected $_content_id;

    public $slug;
    public $title;
    public $description;
    public $image;
    public $dateAdded;

    // TODO: abstract this into a pattern / envelope
    // It is a form of hydration.
    protected $_items = array();

    public function getDecoratorKey() {
        return 'categories';
    }

}


?>
