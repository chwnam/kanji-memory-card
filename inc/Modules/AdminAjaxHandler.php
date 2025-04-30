<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Bojaghi\Template\Template;
use WP_Query;

class AdminAjaxHandler implements Module
{
    public function getKanji(Template $tmpl): void
    {
        $q = new WP_Query(
            [
                'post_type'        => KMC_CPT_CARD,
                'post_status'      => 'publish',
                'orderby'          => 'rand',
                'no_found_rows'    => true,
                'posts_per_page '  => 1,
                'suppress_filters' => true,
            ],
        );

        if (!$q->post_count) {
            wp_send_json_error('No cards.');
        }

        $context = json_decode($q->posts[0]->post_content_filtered, true) ?: [];
        $content = $tmpl->template('card-content', $context);

        // random question
        // random answer
        $data = [
            'question' => $q->posts[0]->post_title,
            'answer'   => $content,
        ];

        wp_send_json_success($data);
    }
}