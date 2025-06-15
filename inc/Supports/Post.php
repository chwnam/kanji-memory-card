<?php

namespace Chwnam\KMC\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\Helper\Facades;
use Bojaghi\Template\Template;
use Chwnam\KMC\Modules\PostMeta;
use Chwnam\KMC\Objects\Card;
use Chwnam\KMC\Walkers\CourseWalker;
use WP_Error;
use WP_Post;
use WP_Query;

class Post implements Support
{
    public function __construct(private Template $tmpl)
    {
    }

    public function customEditUI(WP_Post $post): void
    {
        $card = Card::get($post);

        $termId = 0;

        if ($card->course) {
            $term = get_term_by('slug', $card->course, KMC_TAX_COURSE);
            if ($term) {
                $termId = $term->term_id;
            }
        }

        echo $this->tmpl->template(
            'admin-custom-edit-ui',
            [
                'card'    => $card,
                'courses' => get_terms(
                    [
                        'taxonomy'   => KMC_TAX_COURSE,
                        'hide_empty' => false,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    ],
                ),
                'term_id' => $termId,
                'walker'  => new CourseWalker(),
            ],
        );
    }

    public function importCsv(string $fileName): int|WP_Error
    {
        $fp = fopen($fileName, 'r');
        if (!$fp) {
            return new WP_Error('error', 'Cannot open file.');
        }

        $postMeta = Facades::get(PostMeta::class);
        $items    = [];

        // Discard the first row: it is a header.
        fgetcsv($fp);

        while (($row = fgetcsv($fp))) {
            if (!count($row)) {
                continue;
            }
            /**
             * - 5열
             *   - question: 필수
             *   - questionHint
             *   - answer: 필수
             *   - answerSupplement
             *   - course
             */
            if ($row[0] && $row[2]) {
                $items[] = $row;
            }
        }

        fclose($fp);

        $terms = [];

        foreach ($items as $item) {
            [$question, $questionHint, $answer, $answerSupplement, $course] = $item;

            $question         = sanitize_text_field($question);
            $questionHint     = sanitize_textarea_field($questionHint);
            $answer           = sanitize_text_field($answer);
            $answerSupplement = sanitize_textarea_field($answerSupplement);
            $course           = sanitize_key($course);

            if ($course && term_exists($course, KMC_TAX_COURSE)) {
                if (!isset($terms[$course])) {
                    $terms[$course] = get_term_by('slug', $course, KMC_TAX_COURSE);
                }
                $term = $terms[$course];
            } else {
                $term = null;
            }

            $args = [
                'post_type'        => KMC_CPT_CARD,
                'post_status'      => 'publish',
                'title'            => $question,
                'posts_per_page'   => 1,
                'no_found_rows'    => true,
                'suppress_filters' => true,
                'meta_query'       => [
                    [
                        'key'   => $postMeta->cardAnswer->getKey(),
                        'value' => $answer,
                    ],
                ],
                'tax_query'        => [],
            ];

            if ($course) {
                $args['tax_query'][] = [
                    'field'    => 'slug',
                    'taxonomy' => KMC_TAX_COURSE,
                    'terms'    => $course,
                ];
            }

            $query = new WP_Query($args);

            $post = [
                'post_excerpt' => $questionHint,
                'post_status'  => 'publish',
                'post_title'   => $question,
                'post_type'    => KMC_CPT_CARD,
                'meta_input'   => [
                    $postMeta->cardAnswer->getKey()           => $answer,
                    $postMeta->cardAnswerSupplement->getKey() => $answerSupplement,
                ],
            ];

            if (1 === $query->post_count) {
                // Update
                $post['ID'] = $query->posts[0]->ID;
                $postId     = wp_update_post($post);
            } else {
                // Insert
                $postId = wp_insert_post($post);
            }

            if (is_wp_error($postId)) {
                return $postId;
            }

            if ($course && $term) {
                wp_set_post_terms($postId, $term->term_id, KMC_TAX_COURSE);
            }
        }

        return count($items);
    }

    /**
     * @param WP_Post $post
     *
     * @return void
     *
     * @used-by AdminEdit::savePost()
     */
    public function savePost(WP_Post $post): void
    {
        if (!wp_verify_nonce(wp_unslash($_REQUEST['_kmc_admin_custom_edit_ui'] ?? ''), 'kmc_admin_custom_edit_ui')) {
            return;
        }

        $postMeta         = Facades::get(PostMeta::class);
        $question         = sanitize_text_field($_REQUEST['kmc_question'] ?? '');
        $questionHint     = sanitize_textarea_field($_REQUEST['kmc_question_hint'] ?? '');
        $answer           = sanitize_text_field($_REQUEST['kmc_answer'] ?? '');
        $answerSupplement = sanitize_textarea_field($_REQUEST['kmc_answer_supplement'] ?? 0);
        $course           = sanitize_key($_REQUEST['kmc_course'] ?? '');

        wp_update_post([
            'ID'                    => $post->ID,
            'post_content'          => '',
            'post_content_filtered' => '',
            'post_excerpt'          => $questionHint,
            'post_title'            => $question,
            'post_status'           => 'publish',
            'post_type'             => KMC_CPT_CARD,
            'meta_input'            => [
                $postMeta->cardAnswer->getKey()           => $answer,
                $postMeta->cardAnswerSupplement->getKey() => $answerSupplement,
            ],
        ]);

        if ($course) {
            wp_set_post_terms($post->ID, $course, KMC_TAX_COURSE);;
        }
    }
}
