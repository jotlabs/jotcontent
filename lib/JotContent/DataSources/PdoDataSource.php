<?php

namespace JotContent\DataSources;

use PDO;

class PdoDataSource {
    protected $db;

    protected $models   = array();
    protected $stmCache = array();


    public function __construct($config) {
        if (is_a($config, 'PDO')) {
            $this->db = $config;
        } elseif (is_string($config)) {
            $this->db = new PDO($config);
        } elseif (is_array($config)) {
            $this->db = new PDO($config['datasource'], $config['username'], $config['password']);
        }

        // Mysql fix for prepare statements with LIMIT parameters
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    }


    public function addModel($modelName, $queries) {
        if (!array_key_exists($modelName, $this->models)) {
            $this->models[$modelName] = array();
        }
        $this->models[$modelName] = array_merge($this->models[$modelName], $queries);
    }


    /****
    public function getNow() {
        return date('c');
    }

    
    public function findOneRaw($model, $query, $params=NULL) {
        $stm = $this->_getStatement($model, $query);
        $stm->execute($params);

        $result = $stm->fetch(PDO::FETCH_OBJ);
        $stm->closeCursor();
        return $result;
    }
    ****/

    public function findOne($model, $query, $className, $params) {
        $result = NULL;
        $params = $this->_formatParams($params);

        //echo "findOne: $model, $query, $className\n"; print_r($params);
        $stm = $this->_getStatement($model, $query);

        if (!empty($stm)) {
            $stm->execute($params);
            $stm->setFetchMode(PDO::FETCH_CLASS, $className);

            $result = $stm->fetch();
            $stm->closeCursor();
        } else {
            print_r($this->db->errorInfo());
        }

        return $result;
    }

    /****
    public function findAllRaw($model, $query, $params=NULL) {
        //$sql = $this->models[$model][$query];
        //$stm = $this->db->prepare($sql);
        $stm = $this->_getStatement($model, $query);
        $stm->execute($params);
        $content = $stm->fetchAll(PDO::FETCH_OBJ);
        //print_r($content);
        return $content;
    }
    ****/
    
    public function findAll($model, $query, $className, $params=NULL) {
        $params = $this->_formatParams($params);
        $rows = array();

        $stm = $this->_getStatement($model, $query);
        if (!empty($stm)) {
            $stm->execute($params);

            if ($className && class_exists($className)) {
                $stm->setFetchMode(PDO::FETCH_CLASS, $className);
            } else {
                $stm->setFetchMode(PDO::FETCH_OBJ);
            }

            $rows = $stm->fetchAll();

        }

        return $rows;
    }

    /****
    public function findAllIds($model, $query, $params=NULL) {
        $stm = $this->_getStatement($model, $query);
        $stm->execute($params);
        $content = $stm->fetchAll(PDO::FETCH_OBJ);
        array_walk($content, function(&$row) { $row = $row->id; });
        return $content;
    }
    ****/ 
    
    public function add($model, $params, $ignoreDupe=false) {
        $stm = $this->_getStatement($model, 'insert');
        $success  = true;
        $stm->execute($params);
        $rowCount = $stm->rowCount();

        if ($stm->errorCode() != '00000' || !$rowCount) {
            $isDupe = false;
            $errorInfo = $stm->errorInfo();
            if (strpos($errorInfo[2], 'is not unique') !== false) {
                $isDupe = true;
            } elseif ($ignoreDupe && strpos($errorInfo[2], 'Duplicate entry') !== false) {
                $isDupe = true;
            } elseif (!empty($errorInfo[1])) {
    	        echo "ERROR: Model: $model: "; print_r($stm->errorInfo());
    	        echo "Params: "; print_r($params);
    	        echo "\n";			

    	    }
            
            if ($ignoreDupe && $isDupe) {
                // Don't alter success value
            } else {
                $success = false;
            }  
        } else {
  	        //echo "OK: $model: "; print_r($stm->errorInfo());
        }

        return $success;
    }

    /****
    public function delete($model, $query, $params) {
        $stm = $this->_getStatement($model, $query);
        $success  = $stm->execute($params);
        $rowCount = $stm->rowCount();

        if ($stm->errorCode() != '00000') {
            $errorInfo = $stm->errorInfo();
            if (!empty($errorInfo[1])) {
    	        echo "ERROR: Model: $model: "; print_r($stm->errorInfo());
    	        echo "Params: "; print_r($params);
    	        echo "\n";			
            }
            $success = false;
        } elseif ($rowCount === 0) {
            $success = true;
        }

        return $success;
    }
    ****/


    public function update($model, $query, $params=NULL) {
        if (empty($params)) {
            $params = $query;
            $query  = 'update';
        }

        $stm = $this->_getStatement($model, $query);
        $success  = $stm->execute($params);
        $rowCount = $stm->rowCount();

        if ($stm->errorCode() != '00000') {
            $errorInfo = $stm->errorInfo();
            if (!empty($errorInfo[1])) {
    	        echo "ERROR: Model: $model: "; print_r($stm->errorInfo());
    	        echo "Params: "; print_r($params);
    	        echo "\n";			
            }
            $success = false;
        } elseif ($rowCount === 0) {
            $success = true;
        }

        return $success;
    }


    protected function _getStatement($model, $stmName) {
        $key = "$model|$stmName";
        $stm = NULL;
        
        if (empty($this->stmCache[$key])) {
            $sql = $this->models[$model][$stmName];
            $stm = $this->db->prepare($sql);

            if (!empty($stm)) {
                $this->stmCache[$key] = $stm;
            } else {
                # TODO: Throw a DataSource exception here
                echo "PDO ERROR: getStatement($model, $stmName) failed: ";
                print_r($this->db->errorInfo());
            }
        }
        //print_r($this->db->errorInfo());
        return $this->stmCache[$key];
    }

    protected function _formatParams($params) {
        $newParams = array();

        if (!empty($params)) {
            foreach($params as $key => $value) {
                $newParams[':' . $key] = $value;
            }
        }

        return $newParams;
    }

}

?>
