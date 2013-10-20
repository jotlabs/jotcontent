<?php

namespace JotContent\Entities;

use JotContent\Entity;

class Categories extends Entity {

    static $models = array(
        'category_items' => array(
            'byContentId' => 'SELECT * FROM `category_items` WHERE _content_id = :contentId;'
        ),

        'categories' => array(
            'all' => 'SELECT * FROM `categories`;',
            'byContentId' => 'SELECT categories._id, categories.slug, categories.title, categories.description, categories.image, categories.dateAdded FROM `categories` LEFT JOIN `category_items` ON categories._id = category_items._category_id WHERE _content_id = :contentId;'
        )
    );

    public function getByContentId($contentId, $hydrate=false) {
        $categories = $this->dataSource->findAll(
                        'categories', 'byContentId',
                        'JotContent\Models\Category',
                        array('contentId' => $contentId)
                    );

        if ($hydrate) {
            
        }

        return $categories;
    }

}

?>
