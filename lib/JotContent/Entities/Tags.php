<?php

namespace JotContent\Entities;

use JotContent\Entity;

class Tags extends Entity {

    static $models = array(
        'tags' => array(
            'all' => 'SELECT * FROM `tags`;',
            'byContentId' => 'SELECT tags._id, tags.slug, tags.name, tags.description, tags.dateCreated, content_tags.dateAdded FROM `tags` LEFT JOIN `content_tags` ON tags._id = content_tags._tag_id WHERE _content_id = :contentId;'
        )
    );

    public function getByContentId($contentId, $hydrate=false) {

        $tags = $this->dataSource->findAll(
                        'tags', 'byContentId',
                        'JotContent\Models\Tag',
                        array('contentId' => $contentId)
                    );

        if ($hydrate) {
            
        }

        return $tags;
    }

}

?>
