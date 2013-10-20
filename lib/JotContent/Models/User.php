<?php

namespace JotContent\Models;

use JotContent\Model;

class User extends Model {

    protected $_id;

    public $name;
    public $email;
    public $avatar;
    public $passwordHash;
    public $status;
    public $dateAdded;

    protected $_sessions = array();
    protected $_roles    = array();

    public function addSessions($sessions) {
        $this->_sessions = $sessions;
    }

    public function getSessions() {
        return $this->_sessions;
    }
}

class UserSession extends Model {

    protected $_user_id;

    public $sessionId;
    public $dateAdded;
    public $lastActivity;
    public $source;

}

?>
