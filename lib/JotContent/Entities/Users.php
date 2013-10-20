<?php

namespace JotContent\Entities;

use JotContent\Entity;

class Users extends Entity {
    
    static $models = array(
        'users' => array(
            'bySessionId' => 'SELECT users._id, users.name, users.email, users.avatar, users.status, users.dateAdded FROM `users` LEFT JOIN `user_sessions` ON users._id = user_sessions._user_id WHERE sessionId = :sessionId;'
        ),
        'user_sessions' => array(
            'byUserId' => 'SELECT * from `user_sessions` WHERE _user_id = :userId;'
        )
    );


    public function getUserBySessionId($sessionId, $hydrate=true) {
        $user = $this->dataSource->findOne(
                    'users', 'bySessionId',
                    'JotContent\Models\User',
                    array('sessionId' => $sessionId)
                );

        if ($hydrate) {
            $this->hydrateUser($user);
        }

        return $user;
    }


    public function hydrateUser($user) {
        $userId = $user->getPrimaryKey();
        
        if ($userId) {
            $sessions = $this->dataSource->findAll(
                            'user_sessions', 'byUserId',
                            'JotContent\Models\UserSession',
                            array('userId' => $userId)
                        );
            $user->addSessions($sessions);
        }

    }
}


?>
