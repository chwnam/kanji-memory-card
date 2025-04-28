<?php

// No direct access
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;

return [
    [
        'table_name' => "{$wpdb->prefix}kmc_score_history",
        'field'      => [
            'id bigint(20) unsigned NOT NULL AUTO_INCREMENT',
            'user_id bigint(20) unsigned NOT NULL',
            'post_id bigint(20) unsigned NOT NULL',
            'timestamp int(11) unsigned NOT NULL',
            'result bool NOT NULL',
        ],
        'index'      => [
            'PRIMARY KEY  (id desc)',
            'KEY idx_user_id (user_id)',
            'KEY idx_post_id (post_id)',
            'KEY idx_timestamp (timestamp desc)',
        ],
    ],
    [
        'table_name' => "{$wpdb->prefix}kmc_user_scores",
        'field'      => [
            'user_id bigint(20) unsigned NOT NULL',
            'post_id bigint(20) unsigned NOT NULL',
            'score int unsigned NOT NULL',
        ],
        'index'      => [
            'UNIQUE KEY unique_user_post (user_id, post_id)',
            'KEY idx_score (score)',
        ],
    ],
];