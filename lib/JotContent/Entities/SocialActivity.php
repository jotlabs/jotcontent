<?php

namespace JotContent\Entities;

use JotContent\Entity;

class SocialActivity extends Entity {

    static $models = array(
        'links' => array(
            'byContentId' => 'SELECT * from `links` WHERE _content_id = :contentId;'
        ),

        'link_metrics' => array(
            'byLinkId' => 'SELECT link_metrics._id, _link_id, _source_id, lastUpdated, votesFor, votesAgainst, voteTotal, activityScore, slug, title FROM `link_metrics` LEFT JOIN `metric_sources` ON _source_id = metric_sources._id WHERE _link_id = :linkId;',
            'byContentId' => 'SELECT link_metrics._id, _link_id, _source_id, link_metrics.lastUpdated, votesFor, votesAgainst, voteTotal, activityScore, metric_sources.slug, metric_sources.title FROM `link_metrics` LEFT JOIN `metric_sources` ON _source_id = metric_sources._id LEFT JOIN `links` ON link_metrics._link_id = links._id WHERE _content_id = :contentId;'
        ),

        'metric_sources' => array(
            'all' => 'SELECT * from `source_metrics`;'
        )
    );

    public function getByContentId($contentId, $hydrate=true) {
        $links = $this->dataSource->findAll(
                        'links', 'byContentId',
                        'JotContent\Models\SocialActivity',
                        array('contentId' => $contentId)
                    );

        if ($hydrate) {
            $linkMetrics = $this->dataSource->findAll(
                        'link_metrics', 'byContentId',
                        NULL,
                        array('contentId' => $contentId)
                    );
            $links[0]->addMetrics($linkMetrics);
        }

        return $links;
    }

}

?>
