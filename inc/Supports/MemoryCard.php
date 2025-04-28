<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;

class MemoryCard implements Support
{
    public function __construct()
    {
    }

    public function render(): string
    {
        wp_enqueue_script(
            'kmc-memory-card',
            plugins_url('assets/memory-card.js', KMC_MAIN),
            ['jquery'],
            defined('WP_DEBUG') && WP_DEBUG ? time() : KMC_VERSION,
            [
                'strategy'  => 'defer',
                'in_footer' => true,
            ],
        );

        wp_localize_script(
            'kmc-memory-card',
            'kmcMemoryCard',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'actions'  => [
                    'kmc_get_kanji' => [
                        'action' => 'kmc_get_kanji',
                        'nonce'  => wp_create_nonce('kmc_get_kanji')
                    ],
                ]
            ],
        );

        wp_enqueue_style(
            'kmc-memory-card',
            plugins_url('assets/memory-card.css', KMC_MAIN),
            [],
            defined('WP_DEBUG') && WP_DEBUG ? time() : KMC_VERSION,
        );

        $context = [
            'question' => 'question',
            'answer'   => 'answer',
        ];

        return kmcTmpl()->template('memory-card', $context);
    }
}