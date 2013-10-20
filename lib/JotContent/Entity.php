<?php

namespace JotContent;

use JotContent\EntityAccessor;

class Entity implements ApplicationModelConstants {
    protected static $INSTANCES = array();

    static $schemaDescription = array(
                self::PRIMARY_MODEL => array()
            );
    protected static $schema;

    protected $dataSource;

    protected function __construct() {}


    public static function getInstance() {
        $className = get_called_class();
        if (!array_key_exists($className, self::$INSTANCES)) {
            self::$INSTANCES[$className] = new $className();
        }

        return self::$INSTANCES[$className];
    }    

    public function setDataSource($dataSource) {
        if (!empty($dataSource)) {
            $className = get_called_class();
            $models    = $className::$models;

            foreach ($models as $model => $queries) { 
                $dataSource->addModel($model, $queries);
            }

            $this->dataSource = $dataSource;
        }
    }


    protected function _getSchema() {
        if (empty(self::$schema)) {
            self::$schema = self::_createSchema();
        }
        return self::$schema;
    }

    protected function _getEntity($entityName, $params) {
        return $this->dataSource->get(
            $entityName, $params
        );
    }

    protected static function _createSchema() {
        // TODO: Replace with a Schema object instance
        return self::$schemaDescription;
    }
}

?>
