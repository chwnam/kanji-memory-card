<?php

use Bojaghi\AdminAjax\SubmitBase;

// No direct access
if (!defined('ABSPATH')) {
    exit;
}

return [
    /**
     * We are not going to use 'Content-Type: application/json', so that we can safely disable this feature.
     */
    'checkContentType' => false,

    /**
     * Action tester
     *
     * @uses AdminPostHandler::importCards()
     */
    [
        'kmc_import_cards',          // action
        'kmc/adminPost@importCards', // callback
        SubmitBase::ONLY_PRIV,       // logged-in user only
        '_kmc_nonce',                // automatic nonce check
        // default priority
    ],

    /**
     * Purge cards
     *
     * @uses AdminPostHandler::purgeCards()
     */
    [
        'kmc_purge_cards',     // action
        'kmc/adminPost@purgeCards', // callback
        SubmitBase::ONLY_PRIV,  // logged-in user only
        '_kmc_nonce',           // automatic nonce check
        // default priority
    ],
];
