<?php

namespace Chwnam\KMC\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\ViteScripts\MountNode;
use Bojaghi\ViteScripts\ViteScript;
use Chwnam\KMC\Modules\ApiModule;
use Chwnam\KMC\Objects\Card;
use Chwnam\KMC\Supports\ApiParamFilter as F;
use WP_Error;

class CardSupport implements Support
{
    /**
     * Get a ranom card
     *
     * @param string|array $args
     *
     * @return Card|WP_Error
     *
     * @used-by ApiModule::getCard()
     */
    public function getCard(string|array $args = ''): Card|WP_Error
    {
        global $wpdb;

        $args = wp_parse_args($args, [
            'course'   => '', // Required.
            'excludes' => [],
            'tier'     => -1, // Required.
            'user_id'  => 0,
        ]);

        $course = F::sanitizeCourse($args['course']);
        $tier   = F::sanitizeTier($args['tier']);
        $userId = F::sanitizeUserId($args['user_id']);

        if (!$course) {
            return new WP_Error('course is required.');
        }

        if (!$tier) {
            return new WP_Error('Tier is required.');
        }

        $query = $wpdb->prepare(
            "SELECT p.ID FROM $wpdb->posts p" .
            " INNER JOIN $wpdb->term_relationships tr ON tr.object_id=p.ID" .
            " INNER JOIN $wpdb->term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id" .
            " INNER JOIN $wpdb->terms t ON t.term_id=tt.term_id" .
            " LEFT JOIN {$wpdb->prefix}kmc_user_scores s ON s.post_id=p.ID" .
            " WHERE p.post_type=%s AND p.post_status='publish' AND tt.taxonomy=%s AND t.slug=%s",
            KMC_CPT_CARD,
            KMC_TAX_COURSE,
            $course,
        );

        // Add exlcudes
        $excludes = F::sanitizeIntArray($args['excludes']);;
        if ($excludes) {
            $placeholder = implode(',', array_fill(0, count($excludes), '%d'));
            $query       .= $wpdb->prepare(" AND p.ID NOT IN ($placeholder)", $excludes);
        }

        // Add tier
        $query .= match ($tier) {
            // The lowest score
            1       => $wpdb->prepare(' AND ((s.score IS NULL AND s.user_id IS NULL) OR (s.score=0 AND s.user_id=%d))', $userId),
            2, 3, 4 => $wpdb->prepare(' AND s.score=%d AND s.user_id=%d', $tier - 1, $userId),
            5       => $wpdb->prepare(' AND s.score>=%d AND s.user_id=%d', $tier - 1, $userId),
        };

        // Add LIMIT, ORDER
        $query .= ' ORDER BY RAND() LIMIT 1';

        // Result came out.
        return Card::get((int)$wpdb->get_var($query)) ?:
            new WP_Error('error', sprintf(__('%1$d 티어에 있는 카드가 없습니다.', 'kanji-memory-card'), $tier));
    }

    /**
     * Get a number of cards in the speficied tier.
     *
     * @param string|array $args
     * @return int|WP_Error
     */
    public function getNumCards(string|array $args = ''): array|WP_Error
    {
        global $wpdb;

        $args = wp_parse_args($args, [
            'course'  => '',
            'tier'    => 0,
            'user_id' => 0,
        ]);

        $course = F::sanitizeCourse($args['course']);
        $tier   = F::sanitizeTier($args['tier']);
        $userId = F::sanitizeUserId($args['user_id']);

        if (!$course) {
            return new WP_Error('course is required.');
        }

        if (!$tier) {
            return new WP_Error('Tier is required.');
        }

        if (!$userId) {
            return new WP_Error('User ID is required.');
        }

        $query = $wpdb->prepare(
            "SELECT COUNT(p.ID) as num FROM $wpdb->posts p" .
            " INNER JOIN $wpdb->term_relationships tr ON tr.object_id=p.ID" .
            " INNER JOIN $wpdb->term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id" .
            " INNER JOIN $wpdb->terms t ON t.term_id=tt.term_id" .
            " LEFT JOIN {$wpdb->prefix}kmc_user_scores s ON s.post_id=p.ID" .
            " WHERE p.post_type=%s AND p.post_status='publish' AND tt.taxonomy=%s AND t.slug=%s",
            KMC_CPT_CARD,
            KMC_TAX_COURSE,
            $course,
        );

        // Add tier
        $query .= match ($tier) {
            // The lowest score
            1       => $wpdb->prepare(' AND ((s.score IS NULL AND s.user_id IS NULL) OR (s.score=0 AND s.user_id=%d))', $userId),
            2, 3, 4 => $wpdb->prepare(' AND s.score=%d AND s.user_id=%d', $tier - 1, $userId),
            5       => $wpdb->prepare(' AND s.score>=%d AND s.user_id=%d', $tier - 1, $userId),
        };

        // Add group clause
        $query .= " GROUP BY s.score";

        $cols = array_map(fn($c) => (int)$c, $wpdb->get_col($query));

        return [
            'course' => $course,
            'tier'   => $tier,
            'count'  => array_sum($cols),
        ];
    }

    /**
     * Save user's card judge
     *
     * @param string|array $args
     * @return array|WP_Error
     */
    public function judgeCard(string|array $args = ''): array|WP_Error
    {
        $args = wp_parse_args($args, [
            'card_id' => 0,
            'result'  => null,
            'user_id' => 0,
        ]);

        $cardId = F::sanitizeCardId($args['card_id']);
        $result = F::sanitizeResult($args['result']);
        $userId = F::sanitizeUserId($args['user_id']);

        if (!$cardId || !$userId) {
            return new WP_Error('Invalid card ID or user ID');
        }

        $score = kmcGet(Score::class);
        $score->setResult($userId, $cardId, $result);

        return [
            'card_id' => $cardId,
            'result'  => $result,
            'user_id' => $userId,
        ];
    }

    public function renderV2(ViteScript $vs): void
    {
        MountNode::render('id=kmc-card-root&class=kmc kmc-card-root&inner_content=Standby, run `dev`.');

        $vs
            ->add('kmc-kanji-memory-card-v2', 'src/v2/kanji-memory-card.tsx')
            ->vars('kmcMemoryCardV2', [
                'api'     => [
                    'baseUrl' => rest_url('kmc/v1'),
                    'nonce'   => wp_create_nonce('wp_rest'),
                ],
                'initial' => [
                    'siteMeta' => [
                        'courses'   => [
                            // TODO: this is hard-coded.
                            'basic-100-hiragana' => '히라가나 기본 단어 100',
                        ],
                        'pageTitle' => get_the_title(),
                    ],
                    'tier'     => 1,
                ],
            ])
        ;
    }

    public function renderV2Mockup(ViteScript $vs): void
    {
        MountNode::render('id=kmc-memory-card&class=kmc kmc-memory-card&inner_content=Standby, run `dev`.');

        $vs->add('kmc-kanji-memory-card-v2', 'src/v2/kanji-memory-card-mockup.tsx');
    }
}
