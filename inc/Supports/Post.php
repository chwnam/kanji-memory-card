<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\Template\Template;
use WP_Post;

class Post implements Support
{
    public function __construct(private Template $tmpl)
    {
    }

    public function customEditUI(WP_Post $post): void
    {
        $filtered = html_entity_decode($post->post_content_filtered);
        $content  = json_decode($filtered, true) ?: [];

        echo $this->tmpl->template(
            'admin-custom-edit-ui',
            [
                ...$content,
            ],
        );
    }

    public function savePost(WP_Post $post): void
    {
        if (!wp_verify_nonce(wp_unslash($_REQUEST['_kmc_admin_custom_edit_ui'] ?? ''), 'kmc_admin_custom_edit_ui')) {
            return;
        }

        $kanji    = sanitize_text_field($_REQUEST['kanji'] ?? '');
        $hiragana = sanitize_text_field($_REQUEST['hiragana'] ?? '');
        $korean   = sanitize_text_field($_REQUEST['korean'] ?? '');
        $levels   = array_unique(array_filter(array_map('absint', (array)$_REQUEST['kmc_kanji_level'] ?? [])));

        $filtered = wp_slash(
            json_encode(
                compact('kanji', 'hiragana', 'korean'),
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
            ),
        );

        wp_update_post([
            'ID'                    => $post->ID,
            'post_content'          => '',
            'post_content_filtered' => $filtered,
            'post_name'             => "$kanji-$korean",
            'post_status'           => 'publish',
            'post_type'             => KMC_CPT_CARD,
        ]);

        if ($levels) {
            wp_set_post_terms($post->ID, $levels, KMC_TAX_LEVEL);
        }
    }
}
