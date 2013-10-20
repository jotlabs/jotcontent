<?php

namespace JotContent;

use JotContent\DataSources\PdoDataSource;
use JotContent\Adapters\ContentEnvelope;
use JotContent\Adapters\UserEnvelope;


class BaseApplicationModel implements ApplicationModelConstants {
    const DEFAULT_DATASOURCE = '__DEFAULT__';


    protected static $INSTANCE = NULL;

    protected $_dataSources = array();
    
    protected $_entityMap   = array();
    protected $_entityCache = array();
    protected $entities     = array();
    protected $baseEntities = array(
        self::ENTITY_CONTENT    => 'JotContent\Entities\Content',
        self::ENTITY_USERS      => 'JotContent\Entities\Users'
        //self::ENTITY_TAGS       => '',
        //self::ENTITY_CATEGORIES => ''
    );
    protected $contentDecorators = array();


    // TODO: Remove this, talk to the Entity objects instead
    protected $baseModels = array(
        self::CONTENT_ENVELOPE_ADAPTER => array(
            self::MODEL_CLASS => 'JotContent\Adapters\ContentEnvelope'
        )
    );


    public function __construct() {
        $this->_initEntityMap();

    }


    public static function getInstance() {
        if (empty(self::$INSTANCE)) {
            $className = get_called_class();
            self::$INSTANCE = new $className();
        }

        return self::$INSTANCE;
    }


    public function addDataSource($dsName, $dataSource=NULL) {
        $success = false;

        if (empty($dataSource)) {
            $dataSource = $dsName;
            $dsName     = self::DEFAULT_DATASOURCE;
        }

        if (is_string($dataSource)) {
            $dataSource = new PdoDataSource($dataSource);
        } elseif (is_array($dataSource)) {
            $dataSource = new PdoDataSource($dataSource);
        }

        if (is_string($dsName) && is_a($dataSource, 'JotContent\DataSources\PdoDataSource')) {
            $this->_dataSources[$dsName] = $dataSource;
            $success = true;
        }

        return $success;
    }


    public function getDataSource($dsName=NULL) {
        $dataSource = NULL;

        if (empty($dsName)) {
            $dsName = self::DEFAULT_DATASOURCE;
        }

        if (array_key_exists($dsName, $this->_dataSources)) {
            $dataSource = $this->_dataSources[$dsName];
        }

        return $dataSource;
    }


    public function __get($entityName) {
        //echo "BaseApplicationModel->__get: $entityName\n";
        $entity = $this->_getEntity($entityName);
        return $entity;
    }


    /****
    public function __call($method, $args) {
        echo "BaseApplicationModel->__call: $method\n";
    }
    ****/

    public function getUserBySessionId($sessionId, $hydrate=false) {
        $envelope = new UserEnvelope();

        $userEntity = $this->_getEntity('users');
        $user       = $userEntity->getUserBySessionId($sessionId, $hydrate);

        if (!empty($user)) {
            $envelope->setUser($user);
        }

        return $envelope;
    }


    public function getContentBySlug($slug, $hydrate=false) {
        $envelope = new ContentEnvelope();

        // 1. Get content envelope
        $contentEntity = $this->_getEntity('content');
        $content       = $contentEntity->getContentBySlug($slug, $hydrate);

        if (!empty($content)) {
            $envelope->setEnvelope($content);

            $contentType = $contentEntity->getContentTypeById($content->getContentTypeId());
            $envelope->setContentType($contentType);

            // 2. Decide what the content type is
            $entityName = $contentType->entity;
            $entity     = $this->_getEntity($entityName);

            // 3. Get the actual content
            $entityModel = $entity->getById($content->getContentId(), $hydrate);

            // 4. Put this into a ContentEnvelope adapter
            $envelope->setContent($entityModel);

            // 5. Grab any decorators
            foreach($this->contentDecorators as $decoratorName) {
                $decorator   = $this->_getEntity($decoratorName);
                $decorations = $decorator->getByContentId($content->getContentId());
                //echo "Content decorations ($decoratorName): "; print_r($decorations);
                $envelope->decorate($decoratorName, $decorations);
            }

        }

        return $envelope;
    }




    protected function _getEntity($entityName, $cache=true) {
        $entity = NULL;

        if ($cache && array_key_exists($entityName, $this->_entityCache)) {
            $entity = $this->_entityCache[$entityName];

        } elseif (array_key_exists($entityName, $this->_entityMap)) {
            $entityClass = $this->_entityMap[$entityName];

            if (class_exists($entityClass)) {
                $entityInstance = $entityClass::getInstance();

                if (is_a($entityInstance, 'JotContent\Entity')) {
                    $entity = $entityInstance;
                    $entity->setDataSource($this->_dataSources[self::DEFAULT_DATASOURCE]);

                    if ($cache) {
                        $this->_entityCache[$entityName] = $entityInstance;
                    }
                }
            }
        }

        if (empty($entity)) {
            // TODO: Throw an EntityNotFoundException
        }

        return $entity;
    }


    protected function _initEntityMap() {
        $entities = array_merge($this->baseEntities, $this->entities);

        foreach($entities as $entityName => $entityClass) {
            if (class_exists($entityClass)) {
                //echo "ENTITY: $entityName => $entityClass\n";
                $this->_entityMap[$entityName] = $entityClass;
            }
        }
    }

}

?>
