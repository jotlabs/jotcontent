<?php

namespace JotContent\Models;

use JotContent\Model;

class Content extends Model {
    const MODEL_CONTENT      = 'content';
    const MODEL_CONTENT_TYPE = 'content_types';

    protected   $_id;

    // Content type model properties
    protected   $_content_type_id;
    protected   $_content_id;

    // Standard content envelope properties
    public      $slug;
    public      $title;
    public      $summary;

    public      $dateAdded;
    public      $lastUpdated;
    // TODO: rename active to content_status
    public      $active;

    public function getContentTypeId() {
        return $this->_content_type_id;
    }

    
    public function getContentId() {
        return $this->_content_id;
    }
}

?>
