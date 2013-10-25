<?php

namespace JotContent\Testing;

use JotContent\DataSources\PdoDataSource;

class UnitTestUtils {
    static $baseDsnPath = UNITTEST_DB_PATH;

    public static function getDatasource($name=NULL) {
        $dsnSource = 'sqlite:' . self::$baseDsnPath . 'entity-' . $name . '.db';

        $dataSource = new PdoDataSource($dsnSource);
        return $dataSource;
    }

}

?>
