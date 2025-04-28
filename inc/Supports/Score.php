<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;

class Score implements Support
{
    private string $history;
    private string $scores;

    public function __construct()
    {
        global $wpdb;

        $this->history = "{$wpdb->prefix}kmc_score_history";
        $this->scores  = "{$wpdb->prefix}kmc_user_scores";
    }

    public function setResult(int $userId, int $postId, bool $result, int $timestamp = 0): void
    {
        global $wpdb;

        // Add history
        $wpdb->insert(
            $this->history,
            [
                'user_id'   => $userId,
                'post_id'   => $postId,
                'result'    => $result,
                'timestamp' => $timestamp ?: time(),
            ],
            [
                'user_id'   => '%d',
                'post_id'   => '%d',
                'result'    => '%d',
                'timestamp' => '%d',
            ],
        );

        // Score
        $score     = $this->getScore($userId, $postId);
        $nextscore = $result ? $score + 1 : 0;

        $query = $wpdb->prepare(
            "INSERT INTO $this->scores (user_id, post_id, score) VALUES (%d, %d, %d)" .
            " ON DUPLICATE KEY UPDATE score = %d",
            $userId,
            $postId,
            $nextscore,
            $nextscore,
        );
        $wpdb->query($query);
    }

    public function getScore(int $userId, int $postId): int
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT score FROM $this->scores WHERE user_id = %d AND post_id = %d",
            $userId,
            $postId,
        );

        return (int)$wpdb->get_var($query);
    }

    public function reset(): void
    {
        global $wpdb;

        $wpdb->query("TRUNCATE TABLE $this->scores");
        $wpdb->query("TRUNCATE TABLE $this->history");
    }
}
