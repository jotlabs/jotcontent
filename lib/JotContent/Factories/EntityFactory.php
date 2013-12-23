<?php
namespace JotContent\Factories;

class EntityFactory {
    const DEFAULT_DATASOURCE = '__DEFAULT__';

    protected static $INSTANCE;

    protected $_dataSources = array();
    protected $_entities    = array();
    protected $_entityCache = array();

    protected function __construct() {

    }


    public static function getInstance() {
        if (empty(self::$INSTANCE)) {
            $className = get_called_class();
            self::$INSTANCE = new $className();
        }

        return self::$INSTANCE;
    }


    public function addEntity($entityName, $class=NULL) {
        if (is_string($entityName) && !empty($class)) {
            $this->_entities[$entityName] = $class;
            unset($this->_entityCache[$entityName]);

        }
    }


    public function getEntity($entityName) {
        $entity = NULL;

        if (!array_key_exists($entityName, $this->_entityCache)) {

            if (array_key_exists($entityName, $this->_entities)) {
                $entity = $this->_initEntity($this->_entities[$entityName]);

                if (!empty($entity)) {
                    $this->_entityCache[$entityName] = $entity;
                }
            }

        } else {
            $entity = $this->_entityCache[$entityName];

        }

        return $entity;
    }


    public function addDataSource($dsName, $dataSource) {
        if (is_string($dsName)) {
            $this->_dataSources[$dsName] = $dataSource;
        }
    }


    public function getDataSource($dsName) {
        $dataSource = NULL;

        if (array_key_exists($dsName, $this->_dataSources)) {
            $dataSource = $this->_dataSources[$dsName];

        } elseif (array_key_exists(self::DEFAULT_DATASOURCE, $this->_dataSources)) {
            $dataSource = $this->_dataSources[self::DEFAULT_DATASOURCE];

        } else {
            echo "ERROR: No default data source configured!";
        }

        return $dataSource;
    }


    public function _initEntity($entitySpec) {
        $entity = NULL;

        if (is_string($entitySpec)) {
            // Just the classname: getInstance and assign default datasource
            $entity = $entitySpec::getInstance();
            $dataSource = $this->getDataSource(self::DEFAULT_DATASOURCE);
            $entity->setDataSource($dataSource);
        } elseif (is_array($entitySpec)) {
            // Entity + datasource: getInstance and assign requested datasource
            $entityName = $entitySpec['class'];
            $entity = $entityName::getInstance();

            $dsName = self::DEFAULT_DATASOURCE;
            if (!empty($entitySpec['datasource'])) {
                $dsName = $entitySpec['datasource'];
            }

            $dataSource = $this->getDataSource($dsName);
            $entity->setDataSource($dataSource);
            
        } elseif (is_a($entitySpec, 'JotContent\Entity')) {
            // Entity instance, just use it
            $entity = $entitySpec;
        } else {
            echo "Don't understand Entity spec: "; print_r($entitySpec);
        }

        return $entity;
    }
}

?>
