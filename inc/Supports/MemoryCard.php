<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\ViteScripts\ViteScript;
use WP_Query;

class MemoryCard implements Support
{
    public function __construct()
    {
    }

    public function getCard(): void
    {
        $exclude = array_unique(array_filter(array_map(
            'absint',
            explode(',', $_REQUEST['exclude'] ?? ''),
        )));

        $q = new WP_Query(
            [
                'post_type'        => KMC_CPT_CARD,
                'post_status'      => 'publish',
                'post__not_in'     => $exclude,
                'orderby'          => 'rand',
                'no_found_rows'    => true,
                'posts_per_page '  => 1,
                'suppress_filters' => true,
            ],
        );

        if (!$q->post_count) {
            wp_send_json_error('No cards.');
        }

        $content = json_decode($q->posts[0]->post_content_filtered, true) ?: [];

        // random question
        // random answer
        $data = [
            'id'       => $q->posts[0]->ID,
            'question' => $q->posts[0]->post_title,
            'kanji'    => $content['kanji'] ?? '',
            'hiragana' => $content['hiragana'] ?? '',
            'korean'   => $content['korean'] ?? '',
        ];

        wp_send_json_success($data);
    }

    public function render(ViteScript $vs): string
    {
        // Vite-based output
        $output = kmcTmpl()->template(
            'react-root',
            [
                'id'            => 'kmc-memory-card',
                'class'         => 'kmc kmc-memory-card',
                'inner_content' => '이 텍스트가 보인다면 리액트 코드가 제대로 실행되지 않았기 때문입니다.',
            ],
        );

        $vs->add('kmc-kanji-memory-card', 'src/kanji-memory-card.tsx')
           ->vars('kmcMemoryCard', [
               'ajaxUrl' => admin_url('admin-ajax.php'),
               'actions' => [
                   'getCard'       => [
                       'action' => 'kmc_get_card',
                       'nonce'  => wp_create_nonce('kmc_get_card')
                   ],
                   'setQuizResult' => [
                       'action' => 'kmc_set_quiz_result',
                       'nonce'  => wp_create_nonce('kmc_set_quiz_result'),
                   ]
               ],
               'initial' => [
                   'cards'   => [],
                   'results' => [],
               ]
           ])
        ;

        return $output;
    }

    public function setQuizResult(): void
    {
        $id     = absint($_REQUEST['id'] ?? 0);
        $result = filter_var($_REQUEST['result'], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);;

        wp_send_json_success([$id, $result]);
    }
}
