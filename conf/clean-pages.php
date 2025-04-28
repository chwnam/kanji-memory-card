<?php

use Chwnam\KanjiMemoryCard\Supports\CardSupport;

// No direct access
if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'      => 'kanji-card-v2',
        'condition' => fn($name) => is_page($name),
        'before'    => function () {
            add_filter('language_attributes', function (string $output): string {
                return $output . ' data-theme="cupcake"';
            }, 10, 2);
        },
        /**
         * @uses CardSupport::renderV2()
         * @uses CardSupport::renderV2Mockup()
         */
        'body'      => function () {
            if (isset($_GET['mockup']) && '1' === $_GET['mockup']) {
                kmcCall(CardSupport::class, 'renderV2Mockup');
            } else {
                kmcCall(CardSupport::class, 'renderV2');
            }
        },
    ],
    'show_admin_bar' => false,
];
