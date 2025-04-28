<?php

// No direct access
if (!defined('ABSPATH')) {
    exit;
}

return [
    // Begin: kmc_card
    [
        // post_type
        KMC_CPT_CARD,
        // arguments
        [
            'labels'                          => [
                'name'                     => _x('단어 카드', 'kmc_card label', 'kanji-memory-card'),
                'singular_name'            => _x('단어 카드', 'kmc_card label', 'kanji-memory-card'),
                'add_new'                  => _x('새로 추가', 'kmc_card label', 'kanji-memory-card'),
                'add_new_item'             => _x('새 딘어 카드 추가', 'kmc_card label', 'kanji-memory-card'),
                'edit_item'                => _x('딘어 카드 편집', 'kmc_card label', 'kanji-memory-card'),
                'new_item'                 => _x('새 딘어 카드', 'kmc_card label', 'kanji-memory-card'),
                'view_item'                => _x('딘어 카드 보기', 'kmc_card label', 'kanji-memory-card'),
                'view_items'               => _x('딘어 카드 보기', 'kmc_card label', 'kanji-memory-card'),
                'search_items'             => _x('카드 검색', 'kmc_card label', 'kanji-memory-card'),
                'not_found'                => _x('찾을 수 없음', 'kmc_card label', 'kanji-memory-card'),
                'not_found_in_trash'       => _x('휴지통에서 찾을 수 없음', 'kmc_card label', 'kanji-memory-card'),
                'parent_item_colon'        => _x('부모 딘어 카드:', 'kmc_card label', 'kanji-memory-card'),
                'all_items'                => _x('모든 딘어 카드', 'kmc_card label', 'kanji-memory-card'),
                'archives'                 => _x('딘어 카드 아카이브', 'kmc_card label', 'kanji-memory-card'),
                'attributes'               => _x('속성', 'kmc_card label', 'kanji-memory-card'),
                'insert_into_item'         => _x('딘어 카드로 삽입', 'kmc_card label', 'kanji-memory-card'),
                'uploaded_to_this_item'    => _x('이 카드로 업로드', 'kmc_card label', 'kanji-memory-card'),
                'featured_image'           => _x('대표 이미지', 'kmc_card label', 'kanji-memory-card'),
                'set_featured_image'       => _x('대표 이미지로 설정', 'kmc_card label', 'kanji-memory-card'),
                'remove_featured_image'    => _x('대표 이미지 삭제', 'kmc_card label', 'kanji-memory-card'),
                'use_featured_image'       => _x('대표 이미지로 사용', 'kmc_card label', 'kanji-memory-card'),
                'menu_name'                => _x('단어 카드', 'kmc_card label', 'kanji-memory-card'),
                'filter_items_list'        => _x('카드 목록 필터', 'kmc_card label', 'kanji-memory-card'),
                'filter_by_date'           => _x('날짜로 필터', 'kmc_card label', 'kanji-memory-card'),
                'items_list_navigation'    => _x('딘어 카드 목록 네비게이션', 'kmc_card label', 'kanji-memory-card'),
                'items_list'               => _x('딘어 카드 목록', 'kmc_card label', 'kanji-memory-card'),
                'item_published'           => _x('딘어 카드 발행됨', 'kmc_card label', 'kanji-memory-card'),
                'item_published_privately' => _x('딘어 카드 비공개로 발행됨', 'kmc_card label', 'kanji-memory-card'),
                'item_reverted_to_draft'   => _x('딘어 카드 초안으로 돌아감', 'kmc_card label', 'kanji-memory-card'),
                'item_trashed'             => _x('딘어 카드 삭제됨', 'kmc_card label', 'kanji-memory-card'),
                'item_scheduled'           => _x('딘어 카드 예약됨', 'kmc_card label', 'kanji-memory-card'),
                'item_updated'             => _x('딘어 카드 갱신됨', 'kmc_card label', 'kanji-memory-card'),
                'item_link'                => _x('딘어 카드 링크', 'kmc_card label', 'kanji-memory-card'),
            ],
            'description'                     => _x('단어 카드', 'Description of kmc_card', 'kanji-memory-card'),
            'public'                          => false,
            'hierarchical'                    => false,
            'exclude_from_search'             => true,
            'publicly_queryable'              => false,
            'show_ui'                         => true,
            'show_in_menu'                    => true,
            'show_in_nav_menus'               => false,
            'show_in_admin_bar'               => false,
            'show_in_rest'                    => false,
            'rest_base'                       => KMC_CPT_CARD,
            'menu_position'                   => null,
            'menu_icon'                       => null,
            'capability_type'                 => 'post',
            'capabilities'                    => [],
            'map_meta_cap'                    => true,
            'supports'                        => false,
            'register_meta_box_cb'            => null,
            'taxonomies'                      => [],
            'has_archive'                     => false,
            'rewrite'                         => [
                'slug'       => KMC_CPT_CARD,
                'with_front' => false,
                'feeds'      => false,
                'pages'      => false,
                'ep_mask'    => EP_PERMALINK,
            ],
            'query_var'                       => false,
            'can_export'                      => true,
            'delete_with_user'                => null,
            'template'                        => [],
            'template_lock'                   => false,
        ],
    ],
    // End: kms_kanji_card
];
