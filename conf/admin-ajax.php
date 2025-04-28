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
     * @uses AdminAjaxHandler::getKanji()
     */
    [
        'kmc_get_kanji',         // action
        'kmc/ajax@getKanji',     // callback
        SubmitBase::ALL_GRANTED, // logged-in user only
        'nonce',                 // automatic nonce check
        // default priority
    ],
];
