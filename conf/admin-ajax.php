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
     * Get the next card
     *
     * @uses AdminAjaxHandler::getCard()
     */
    [
        'kmc_get_card',          // action
        'kmc/ajax@getCard',      // callback
        SubmitBase::ONLY_PRIV,   // logged-in user only
        'nonce',                 // automatic nonce check: it is a param name, using the same action.
        // default priority
    ],

    /**
     * Report single card quiz result
     *
     * @uses AdminAjaxHandler::setQuizResult()
     */
    [
        'kmc_set_quiz_result',    // action
        'kmc/ajax@setQuizResult', // callback
        SubmitBase::ONLY_PRIV,    // logged-in user only
        'nonce',                  // automatic nonce check: it is a param name, using the same action.
        // default priority
    ]
];
