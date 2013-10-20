<?php

namespace JotContent\Adapters;

use JotContent\ModelAdapter;

class ContentEnvelope extends ModelAdapter {

    protected $_envelope;
    protected $_content;
    protected $_contentType;
    protected $_decorators = array();


    public function __construct($envelope=NULL, $content=NULL) {
        if (!empty($envelope)) {
            $this->setEnvelope($envelope);
        }

        if (!empty($content)) {
            $this->setContent($content);
        }
    }


    public function setEnvelope($envelope) {
        $this->_envelope = $envelope;
    }


    public function setContent($content) {
        $this->_content = $content;
    }


    public function setContentType($contentType) {
        $this->_contentType = $contentType;
    }


    public function getContentType() {
        return $this->_contentType;
    }

    
    public function decorate($name, $value) {
        if (!empty($name) && is_string($name) && !empty($value)) {
            $this->_decorators[$name] = $value;
        }
    }


    public function __call($method, $args) {
        $response = NULL;

        if (method_exists($this->_content, $method)) {
            $response = $this->_content->$method($args);

        } elseif (method_exists($this->_envelope, $method)) {
            $response = $this->_envelope->$method($args);

        }

        return $response;
    }

    public function __isset($property) {
        $isProperty = 
               isset($this->_content->{$property})
            || isset($this->_envelope->{$property})
            || array_key_exists($property, $this->_decorators)
            || false;

        # See if there's a getter method for that property
        # Allows us clean property names in Twig
        if (!$isProperty) {
            $method = 'get' . ucfirst($property);
            $isProperty = 
                method_exists($this->_content, $method)
            ||  method_exists($this->_envelope, $method)
            ||  false;
        }

        return $isProperty;
    }


    public function __get($property) {
        $value = NULL;

        if (isset($this->_content->{$property})) {
            $value = $this->_content->{$property};

        } elseif (isset($this->_envelope->{$property})) {
            $value = $this->_envelope->{$property};

        } elseif (array_key_exists($property, $this->_decorators)) {
            $value = $this->_decorators[$property];

        } else {
            // Look for a getter method for that property
            $method = 'get' . ucfirst($property);
            if (method_exists($this->_content, $method)) {
                $value = $this->_content->{$method}();

            } elseif(method_exists($this->_envelope, $method)) {
                $value = $this->_envelope->{$method}();

            }

        }

        return $value;
    }

}

?>
