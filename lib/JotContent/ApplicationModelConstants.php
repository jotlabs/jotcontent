<?php

namespace JotContent;

interface ApplicationModelConstants {

    // Model dependencies
    const MODEL_CLASS    = '__MODEL_CLASS__';
    const MODEL_ADAPTER  = '__MODEL_ADAPTER__';


    // Model definition
    const PRIMARY_MODEL      = '__PRIMARY_MODEL__';


    // Model Adapters
    const CONTENT_ENVELOPE_ADAPTER = 'JotContent\Adapters\ContentEnvelope';

    // Default Entities
    const ENTITY_CONTENT    = 'content';
    const ENTITY_USERS      = 'users';
    const ENTITY_TAGS       = 'tags';
    const ENTITY_CATEGORIES = 'categories';


    // Statement constructs
    const SQL_GET_BY_SLUG   = 'getBySlug';
    const SQL_GET_BY_ID     = 'getById';
}

?>
