<?php

use JotContent\Entities\Users;

class UsersTest extends PHPUnit_Framework_TestCase {
    protected $users;

    public function setUp() {
        $dataSource = UnitTestUtils::getDatasource('users');
        $this->users = Users::getInstance();
        $this->users->setDataSource($dataSource);
    }

    public function testClassExists() {
        $this->assertTrue(class_exists('JotContent\Entities\Users'));
        $this->assertTrue(is_a($this->users, 'JotContent\Entities\Users'));
    }

    
    public function testGetUserBySessionId() {
        $sessionId = '409df6afb2516f7ff0ad9b24520b21e1';
        $user = $this->users->getUserBySessionId($sessionId, true);
        $this->assertNotNull($user);
        //print_r($user);

        $this->assertTrue(is_a($user, 'JotContent\Model'));
        $this->assertTrue(is_a($user, 'JotContent\Models\User'));

        $this->assertEquals('joebloggs.mail@googlemail.com', $user->email);

        $userSessions = $user->getSessions();
        $this->assertNotNull($userSessions);
        $this->assertTrue(is_array($userSessions));
        $this->assertEquals(2, count($userSessions));

        $foundSession = false;
        foreach($userSessions as $session) {
            if ($session->sessionId === $sessionId) {
                $foundSession = true;
            }
        }

        $this->assertTrue($foundSession);
    }

}


?>
