<?php
namespace JotContent;

use JotContent\Factories\EntityFactory;
use JotContent\DataSources\PdoDataSource;

class ApplicationBase extends \JotApp\ApplicationBase {
    protected $entityFactory;
    protected $entities;


    public function getEntityFactory() {
        $this->_initEntityFactory();
        return $this->entityFactory;
    }

    public function getDataSources() {
        $dataSources = array();
        
        foreach ($this->config->datasources as $dsName => $dsSpec) {
            $dataSources[$dsName] = new PdoDataSource($dsSpec);
        }

        return $dataSources;
    }


    protected function _injectController($controller) {
        $entityFactory = $this->getEntityFactory();
        $controller->setEntityFactory($entityFactory);
    }    


    protected function _initEntityFactory() {
        if (empty($this->entityFactory)) {
            $this->entityFactory = EntityFactory::getInstance();
            $this->entityFactory->setDataSources($this->getDataSources());

            foreach($this->entities as $entityName => $entitySpec) {
                $this->entityFactory->addEntity($entityName, $entitySpec);
            }
        }
    }
}

?>
