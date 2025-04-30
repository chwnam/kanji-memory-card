<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\ViteScripts\ViteScript;

class MemoryCard implements Support
{
    public function __construct()
    {
    }

    public function render(ViteScript $vs): string
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

        $output = kmcTmpl()->template('memory-card', $context);

        // Vite-based output
        $output .= kmcTmpl()->template(
            'react-root',
            [
                'id'            => 'kmc-memory-card',
                'class'         => 'kmc kmc-memory-card',
                'inner_content' => '이 텍스트가 보인다면 리액트 코드가 제대로 실행되지 않았기 때문입니다.',
            ],
        );

        $vs->add('kmc-kanji-memory-card', 'src/kanji-memory-card.tsx')
           ->vars('kmcKanjiMemoryCard', [
               'varName' => 'value',
           ])
        ;

        return $output;
    }
}
