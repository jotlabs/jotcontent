<?php

namespace JotContent\Models;

use JotContent\Model;
use JotContent\Adapters\ContentDecorator;

class Tag extends Model implements ContentDecorator {

    protected $_id;

    // Pure tag specific data
    public $slug;
    public $name;
    public $description;
    public $dateCreated;

    // derived from a getTagsByContentId
    protected $_content_id;
    public $dateAdded;

    // TODO: abstract this into a pattern / envelope
    //       It is a form of deferred hydration.
    protected $_items = array();

    public function getDecoratorKey() {
        return 'tags';
    }

}


?>
