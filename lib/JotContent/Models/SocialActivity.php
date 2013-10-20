<?php

namespace JotContent\Models;

use JotContent\Model;
use JotContent\Adapters\ContentDecorator;

class SocialActivity extends Model implements ContentDecorator {

    protected $_id;
    protected $_content_id;

    public $link;
    public $dateCreated;
    public $score;
    public $activity;
    public $lastUpdate;

    protected $_metrics = array();

    public function getDecoratorKey() {
        return 'links';
    }

    public function getMetrics() {
        return $this->_metrics;
    }

    public function addMetrics($metrics) {
        if (is_array($metrics)) {
            $this->_metrics = array_merge($this->_metrics, $metrics);
        }
    }
}


?>
