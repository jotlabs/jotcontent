<?php

namespace JotContent;

use JotContent\Utilities\Formatting;

class Model {
    private $config = array(
        'dateFormat' => 'd F Y'
    );

    protected $_id;

    public function getPrimaryKey() {
        return $this->_id;
    }


    public function formatDate($date, $toFormat=NULL, $fromFormat='Y-m-d H:i:s') {
        if (empty($toFormat)) {
            $toFormat = $this->config['dateFormat'];
        }

        return Formatting::formatDate($date, $toFormat, $fromFormat);
    }


    public function formatTimeDuration($duration) {
        return Formatting::formatTimeDuration($duration);
    }


}

?>
