<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\ViteScripts\ViteScript;
use Chwnam\KanjiMemoryCard\Objects\Card;
use WP_Error;
use WP_Query;

class MemoryCard implements Support
{
    public function __construct()
    {
    }

    public function getCard(): void
    {
        global $wpdb;

        $userId = get_current_user_id();
        if (!$userId) {
            wp_send_json_error(new WP_Error('error', 'Not logged in.'));;
        }

        $query = $wpdb->prepare(
            "SELECT p.ID FROM $wpdb->posts p" .
            " INNER JOIN $wpdb->term_relationships tr ON tr.object_id=p.ID" .
            " INNER JOIN $wpdb->term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id" .
            " INNER JOIN $wpdb->terms t ON t.term_id=tt.term_id" .
            " LEFT JOIN {$wpdb->prefix}kmc_user_scores s ON s.post_id=p.ID" .
            " WHERE p.post_type=%s AND p.post_status='publish'",
            KMC_CPT_CARD,
        );

        // Add exlcude
        $exclude = array_unique(array_filter(array_map(
            'absint',
            explode(',', $_REQUEST['exclude'] ?? ''),
        )));
        if ($exclude) {
            $placeholder = implode(',', array_fill(0, count($exclude), '%d'));
            $query       .= $wpdb->prepare(" AND p.ID NOT IN ($placeholder)", $exclude);
        }

        // Add level
        $level = sanitize_key($_REQUEST['level'] ?? '');
        if ($level) {
            $query .= $wpdb->prepare(" AND t.slug=%s", $level);
        }

        // Add tier
        $tier = absint($_REQUEST['tier'] ?? '0');
        switch ($tier) {
            // The lowest
            default:
                $query .= $wpdb->prepare(
                    ' AND ((s.score IS NULL AND s.user_id IS NULL) OR (s.score=0 AND s.user_id=%d))',
                    $userId,
                );
                break;

            case 4:
            case 3:
            case 2:
                $query .= $wpdb->prepare(' AND s.score=%d AND s.user_id=%d', $tier, $userId);
                break;

            // The heighst
            case 1:
                $query .= $wpdb->prepare(' AND s.score>=%d AND s.user_id=%d', $tier, $userId);
                break;
        }

        // Add LIMIT, ORDER
        $query .= ' ORDER BY RAND() LIMIT 1';

        // Result came out.
        $data = Card::get((int)$wpdb->get_var($query));
        if (!$data) {
            wp_send_json_error('Cannot get card data.');
        }

        wp_send_json_success($data);
    }

    /**
     * Import kanji card from CSV file
     *
     * @param string $fileName
     *
     * @return int|WP_Error Read count or WP_Error object.
     */
    public function importCards(string $fileName): int|WP_Error
    {
        $fp = fopen($fileName, 'r');
        if (!$fp) {
            return new WP_Error('error', 'Cannot open file.');
        }

        $items = [];

        while (($row = fgetcsv($fp))) {
            if (!count($row)) {
                continue;
            }
            $row = array_map('sanitize_text_field', $row);
            if ($row[0] && $row[1] && $row[2] && $row[3]) {
                $items[] = $row;
            }
        }

        fclose($fp);

        foreach ($items as $item) {
            [$kanji, $hiragana, $korean, $level] = $item;

            $name = $kanji;

            $query = new WP_Query([
                'post_type'        => KMC_CPT_CARD,
                'post_status'      => 'publish',
                'name'             => $name,
                'posts_per_page'   => 1,
                'no_found_rows'    => true,
                'suppress_filters' => true,
            ]);

            // Add plain text for searching in the dashboard.
            $content  = "$kanji $hiragana $korean";
            $filtered = wp_slash(Card::encodeContent($kanji, $hiragana, $korean));

            $post = [
                'post_content'          => $content,
                'post_content_filtered' => $filtered,
                'post_name'             => $name,
                'post_status'           => 'publish',
                'post_type'             => KMC_CPT_CARD,
                'post_title'            => '',
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

            if (term_exists($level, KMC_TAX_LEVEL)) {
                wp_set_post_terms($postId, $level, KMC_TAX_LEVEL, true);
            }
        }

        return count($items);
    }

    public function render(ViteScript $vs): string
    {
        // Vite-based output
        $output = kmcTmpl()->template(
            'react-root',
            [
                'id'            => 'kmc-memory-card',
                'class'         => 'kmc kmc-memory-card',
                'inner_content' => '',
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
                   'level'   => '',
                   'tier'    => 0,
               ],
           ])
        ;

        return $output;
    }

    public function renderV2(ViteScript $vs): void
    {
        $vs->add('kmc-kanji-memory-card-v2', 'src/kanji-memory-card-v2.tsx')
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
                   'level'   => '',
                   'tier'    => 0,
               ],
           ])
        ;

        $output = kmcTmpl()->template(
            'react-root',
            [
                'id'            => 'kmc-memory-card',
                'class'         => 'kmc kmc-memory-card',
                'inner_content' => 'production' === wp_get_environment_type() ? '' : 'Standby, run `dev`.',
            ],
        );

        echo wp_kses($output, [
            'div' => [
                'id'            => true,
                'class'         => true,
                'data-kmc-root' => true,
            ]
        ]);
    }

    public function setQuizResult(Score $score): void
    {
        $userId = get_current_user_id();
        $postId = absint($_REQUEST['id'] ?? 0);
        $result = filter_var($_REQUEST['result'], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);

        if (!$userId || !$postId || is_null($result)) {
            wp_send_json_error('Invalid parameters.');
        }

        $score->setResult($userId, $postId, $result);
        wp_send_json_success();
    }
}
