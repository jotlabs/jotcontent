<?php

namespace JotContent\Models;

use JotContent\Model;

class Content extends Model {

    protected   $_id;

    // Content model type properties
    protected   $_content_model_id; // reference to the content model
    protected   $_content_id;       // id of the content within the model

    // Standard content envelope properties
    public      $slug;
    public      $title;
    public      $summary;

    // Content metadata
    public      $contentType;
    public      $dateAdded;
    public      $lastUpdated;
    // TODO: rename active to content_status
    public      $active;

    public function getContentModelId() {
        return $this->_content_model_id;
    }

    
    public function getContentId() {
        return $this->_content_id;
    }
}

?>
