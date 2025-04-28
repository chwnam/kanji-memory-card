<?php

if (!defined('ABSPATH')) {
    exit;
}

return [
    'post' => [
        // 단어 문제: 포스트 제목
        // 단어 문제의 힌트: 포스트 발췌문
        '_kmc_card_answer'             => [
            'object_subtype'    => KMC_CPT_CARD,
            'type'              => 'string',
            'description'       => '제안된 단어의 뜻',
            'single'            => true,
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => null,
            'show_in_rest'      => false,
            'revisions_enabled' => false,
            'get_filter'        => null,
        ],
        '_kmc_card_answer_supplement' => [
            'object_subtype'    => KMC_CPT_CARD,
            'type'              => 'string',
            'description'       => '제안된 단어의 추가 설명',
            'single'            => true,
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => null,
            'show_in_rest'      => false,
            'revisions_enabled' => false,
            'get_filter'        => null,
        ],
    ],
];