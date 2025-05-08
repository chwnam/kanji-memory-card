<?php

// No direct access
use Chwnam\KanjiMemoryCard\Supports\MemoryCard;

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'      => 'kanji-card-v2',
        'condition' => fn($name) => is_page($name),
        'before'    => function () {
            add_filter('language_attributes', function (string $output): string {
                return $output . ' data-theme="dark"';
            }, 10, 2);
        },
        'body'      => fn() => kmcCall(MemoryCard::class, 'renderV2'),
    ],
    'show_admin_bar' => false,
];
