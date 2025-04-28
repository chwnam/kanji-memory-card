<?php

// No direct access
if (!defined('ABSPATH')) {
    exit;
}

return [
    /**
     * We are not going to use 'Content-Type: application/json', so that we can safely disable this feature.
     */
    'checkContentType' => false,
];
