<?php
namespace JotContent;

use JotApp\Controller;

class BaseController extends Controller {
    protected $entityFactory;

    public function setEntityFactory($entityFactory) {
        $this->entityFactory = $entityFactory;
    }

    public function getEntity($entityName) {
        return $this->entityFactory->getEntity($entityName);
    }

}

?>
