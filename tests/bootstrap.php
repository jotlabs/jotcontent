<?php

use JotContent\DataSources\PdoDataSource;

# SQLite databases for testing 
define('UNITTEST_DB_PATH', dirname(dirname(__FILE__)) . '/var/unittest-db/');

# Use composer's autoloader
require 'vendor/autoload.php';


class UnitTestUtils {
    static $baseDsnPath = UNITTEST_DB_PATH;

    public static function getDatasource($name=NULL) {
        $dsnSource = 'sqlite:' . self::$baseDsnPath . 'entity-' . $name . '.db';

        $dataSource = new PdoDataSource($dsnSource);
        return $dataSource;
    }

}

?>
