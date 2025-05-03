<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\ViteScripts\ViteScript;
use WP_Error;
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
            $row = array_map('trim', $row);
            if ($row[0] && $row[1] && $row[2] && $row[3]) {
                $items[] = $row;
            }
        }

        fclose($fp);

        foreach ($items as $item) {
            [$kanji, $hiragana, $korean, $level] = $item;

            $name = "$kanji-$korean";

            $query = new WP_Query([
                'post_type'        => KMC_CPT_CARD,
                'post_status'      => 'publish',
                'name'             => $name,
                'posts_per_page'   => 1,
                'no_found_rows'    => true,
                'suppress_filters' => true,
            ]);

            $filtered = wp_slash(
                json_encode(
                    compact('kanji', 'hiragana', 'korean'),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
                ),
            );

            $post = [
                'post_content'          => '',
                'post_content_filtered' => $filtered,
                'post_name'             => $name,
                'post_status'           => 'publish',
                'post_type'             => KMC_CPT_CARD,
                'post_title'            => $korean,
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
