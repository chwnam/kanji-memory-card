<?php

// No direct access
if (!defined('ABSPATH')) {
    exit;
}

return [
    // begin: kmc_course
    [
        // Taxonomy name. Maximum 32 characters.
        KMC_TAX_COURSE,

        // Object types. Required.
        [KMC_CPT_CARD],

        // Arguments.
        [
            'labels'               => [
                'name'                       => _x('단어 코스', 'kmc_course label', 'kanji-memory-card'),
                'singular_name'              => _x('단어 코스', 'kmc_course label', 'kanji-memory-card'),
                'search_items'               => _x('단어 코스 검색', 'kmc_course label', 'kanji-memory-card'),
                'popular_items'              => _x('인기 단어 코스', 'kmc_course label', 'kanji-memory-card'),
                'all_items'                  => _x('모든 단어 코스', 'kmc_course label', 'kanji-memory-card'),
                'parent_item'                => _x('상위 단어 코스', 'kmc_course label', 'kanji-memory-card'),
                'parent_item_colon'          => _x('상위 단어 코스:', 'kmc_course label', 'kanji-memory-card'),
                'name_field_description'     => _x('단어 코스 이름이며 사람이 알아보기 쉬운 문자열입닌다.', 'kmc_course label', 'kanji-memory-card'),
                'slug_field_description'     => _x('단어 코스의 슬러그는 영소문자와 숫자, 그리고 하이픈만을 입력할 수 있습니다.', 'kmc_course label', 'kanji-memory-card'),
                'edit_item'                  => _x('단어 코스 편집', 'kmc_course label', 'kanji-memory-card'),
                'view_item'                  => _x('단어 코스 보기', 'kmc_course label', 'kanji-memory-card'),
                'update_item'                => _x('단어 코스 갱신', 'kmc_course label', 'kanji-memory-card'),
                'add_new_item'               => _x('새 단어 코스 추가', 'kmc_course label', 'kanji-memory-card'),
                'new_item_name'              => _x('새 단어 코스 이름', 'kmc_course label', 'kanji-memory-card'),
                'separate_items_with_commas' => _x('단어 코스를 콤마로 구분', 'kmc_course label', 'kanji-memory-card'),
                'add_or_remove_items'        => _x('단어 코스를 추가하거나 제거', 'kmc_course label', 'kanji-memory-card'),
                'choose_from_most_used'      => _x('가장 많이 사용한 단어 코스에서 선택', 'kmc_course label', 'kanji-memory-card'),
                'not_found'                  => _x('찾을 수 없음', 'kmc_course label', 'kanji-memory-card'),
                'no_terms'                   => _x('단어 코스 없음', 'kmc_course label', 'kanji-memory-card'),
                'filter_by_item'             => _x('단어 코스로 필터', 'kmc_course label', 'kanji-memory-card'),
                'items_list_navigation'      => _x('단어 코스 목록 네비게이션', 'kmc_course label', 'kanji-memory-card'),
                'items_list'                 => _x('단어 코스 목록', 'kmc_course label', 'kanji-memory-card'),
                'most_used'                  => _x('가장 많이 사용된', 'kmc_course label', 'kanji-memory-card'),
                'back_to_items'              => _x('단어 코스 목록으로 돌아가기', 'kmc_course label', 'kanji-memory-card'),
                'item_link'                  => _x('단어 코스 링크', 'kmc_course label', 'kanji-memory-card'),
            ],
            'description'          => '단어 학습 코스를 구분하기 위한 택소노미입니다.',
            'public'               => false,
            'publicly_queryable'   => false,
            'hierarchical'         => true,
            'show_ui'              => true,
            'show_in_menu'         => true,
            'show_in_nav_menus'    => false,
            'show_in_rest'         => false,
            'show_tagcloud'        => false,
            'show_in_quick_edit'   => true,
            'show_admin_column'    => true,
            'meta_box_cb'          => null,
            'meta_box_sanitize_cb' => null,
            'rewrite'              => [
                'slug'         => KMC_TAX_COURSE,
                'with_front'   => false,
                'hierarchical' => false,
                'ep_mask'      => EP_NONE,
            ],
            'query_var'            => true,
        ],
    ],
    // end: kmc_course
];
