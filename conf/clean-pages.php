<?php

use Chwnam\KMC\Supports\CardSupport;

// No direct access
if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'           => 'memory-card-v2',
        'condition'      => fn($name) => is_page($name),
        'before'         => function () {
            add_filter('language_attributes', function (string $output): string {
                return $output . ' data-theme="cupcake"';
            }, 10, 2);
        },
        /**
         * @uses CardSupport::renderV2()
         * @uses CardSupport::renderV2Mockup()
         */
        'body'           => function () {
            if (isset($_GET['mockup']) && '1' === $_GET['mockup']) {
                kmcCall(CardSupport::class, 'renderV2Mockup');
            } else {
                kmcCall(CardSupport::class, 'renderV2');
            }
        },
        'login_required' => true,
    ],
    'show_admin_bar' => false,
];
