<?php

namespace JotContent;

class EntityAccessor {
    static $INSTANCE;

    public static function getInstance() {
        if (empty(self::$INSTANCE)) {
            $className = get_called_class();
            self::$INSTANCE = new $className();
        }
        
        return self::$INSTANCE;
    }

    public function get($entity, $params) {

    }

}

?>
