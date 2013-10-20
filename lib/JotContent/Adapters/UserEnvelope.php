<?php

namespace JotContent\Adapters;

use JotContent\ModelAdapter;

class UserEnvelope extends ModelAdapter {

    protected $_user;
    protected $_decorators = array();


    public function __construct($user=NULL) {
        if (!empty($user)) {
            $this->setUser($user);
        }

    }


    public function setUser($user) {
        $this->_user = $user;
    }


    public function decorate($name, $value) {
        if (!empty($name) && is_string($name) && !empty($value)) {
            $this->_decorators[$name] = $value;
        }
    }


    public function __call($method, $args) {
        $response = NULL;

        if (method_exists($this->_user, $method)) {
            $response = $this->_user->$method($args);

        }

        return $response;
    }

    public function __isset($property) {
        $isProperty = 
               isset($this->_user->{$property})
            || array_key_exists($property, $this->_decorators)
            || false;

        # See if there's a getter method for that property
        # Allows us clean property names in Twig
        if (!$isProperty) {
            $method = 'get' . ucfirst($property);
            $isProperty = 
                method_exists($this->_user, $method)
            ||  false;
        }

        return $isProperty;
    }


    public function __get($property) {
        $value = NULL;

        if (isset($this->_user->{$property})) {
            $value = $this->_user->{$property};

        } elseif (array_key_exists($property, $this->_decorators)) {
            $value = $this->_decorators[$property];

        } else {
            // Look for a getter method for that property
            $method = 'get' . ucfirst($property);
            if (method_exists($this->_user, $method)) {
                $value = $this->_user->{$method}();

            }

        }

        return $value;
    }

}

?>
