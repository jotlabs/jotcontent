<?php

namespace JotContent\Entities;

use JotContent\Entity;

class Content extends Entity {

    static $models = array(
        'content' => array(
            self::SQL_GET_BY_SLUG => 'SELECT * FROM `content` WHERE slug = :slug LIMIT 0,1;'
        ),

        'content_models' => array(
            self::SQL_GET_BY_ID => 'SELECT * from `content_models` WHERE _id = :typeId LIMIT 0,1;'
        )
    );


    public function getContentBySlug($slug, $hydrate=false) {
        $content = $this->dataSource->findOne(
                        'content', self::SQL_GET_BY_SLUG,
                        'JotContent\Models\Content',
                        array('slug' => $slug)
                    );

        if ($hydrate) {
            $content = $this->hydrateContent($content);
        }

        return $content;
    }


    public function hydrateContent($content) {
        //$contentModel = $this->getContentModelById($content->getContentModelId());

        return $content;
    }


    public function getContentModelById($contentModelId) {
        $contentModel = $this->dataSource->findOne(
                            'content_models', self::SQL_GET_BY_ID,
                            'JotContent\Models\ContentModel',
                            array('modelId' => $contentModelId)
                        );

        return $contentModel;
    }

}

?>
