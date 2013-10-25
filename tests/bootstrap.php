<?php
# SQLite databases for testing 
define('UNITTEST_DB_PATH', dirname(dirname(__FILE__)) . '/var/unittest-db/');

# Use composer's autoloader
require 'vendor/autoload.php';

class UnitTestUtils {
    static $baseDsnPath = UNITTEST_DB_PATH;

    public static function getDatasource($name=NULL) {
        $dsn = 'sqlite:' . self::$baseDsnPath . 'entity-' . $name . '.db';

        return $dsn;
    }

}

?>
