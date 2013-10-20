<?php

namespace JotContent\Entities;

use JotContent\Entity;

class Content extends Entity {

    static $models = array(
        'content' => array(
            'getBySlug' => 'SELECT * FROM `content` WHERE slug = :slug LIMIT 0,1;'
        ),

        'content_types' => array(
            'getById' => 'SELECT * from `content_types` WHERE _id = :typeId LIMIT 0,1;'
        )
    );

    public function getContentBySlug($slug, $hydrate=false) {
        $content = $this->dataSource->findOne(
                        'content',
                        'getBySlug',
                        'JotContent\Models\Content',
                        array('slug' => $slug)
                    );

        if ($hydrate) {
            $content = $this->hydrateContent($content);
        }

        return $content;
    }


    public function hydrateContent($content) {
        //$contentType = $this->getContentTypeById($content->getContentTypeId());

        return $content;
    }


    public function getContentTypeById($contentTypeId) {
        $contentType = $this->dataSource->findOne(
                            'content_types',
                            'getById',
                            'JotContent\Models\ContentType',
                            array('typeId' => $contentTypeId)
                        );

        return $contentType;
    }

}

?>
