<?php
// No direct access
if (!defined('ABSPATH')) {
    exit;
}

return [
    // begin: kms_kanji_level
    [
        // Taxonomy name. Maximum 32 characters.
        KMC_TAX_LEVEL,

        // Object types. Required.
        [KMC_CPT_CARD],

        // Arguments.
        [
//        'labels'                => [
//            'name'                       => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'singular_name'              => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'search_items'               => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'popular_items'              => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'all_items'                  => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'parent_item'                => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'parent_item_colon'          => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'name_field_description'     => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'slug_field_description'     => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'parent_field_description'   => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'desc_field_description'     => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'edit_item'                  => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'view_item'                  => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'update_item'                => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'add_new_item'               => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'new_item_name'              => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'template_name'              => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'separate_items_with_commas' => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'add_or_remove_items'        => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'choose_from_most_used'      => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'not_found'                  => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'no_terms'                   => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'filter_by_item'             => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'items_list_navigation'      => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'items_list'                 => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'most_used'                  => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'back_to_items'              => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'item_link'                  => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//            'item_link_description'      => _x('', 'kms_kanji_level label', 'kanji-memory-card'),
//        ],
//        'description'           => '',
'public'                => false,
'publicly_queryable'    => false,
'hierarchical'          => false,
'show_ui'               => true,
'show_in_menu'          => true,
'show_in_nav_menus'     => false,
'show_in_rest'          => false,
'rest_base'             => 'kms_kanji_level',
'rest_namespace'        => 'wp/v2',
'rest_controller_class' => WP_REST_Terms_Controller::class,
'show_tagcloud'         => false,
'show_in_quick_edit'    => true,
'show_admin_column'     => true,
'meta_box_cb'           => null,
'meta_box_sanitize_cb'  => null,
//        'capabilities'          => [
//            'manage_terms' => 'manage_categories',
//            'edit_terms'   => 'manage_categories',
//            'delete_terms' => 'manage_categories',
//            'assign_terms' => 'edit_posts',
//        ],
'rewrite'               => [
    'slug'         => 'kms-kanji-level',
    'with_front'   => false,
    'hierarchical' => false,
    'ep_mask'      => EP_NONE,
],
'query_var'             => false,
'update_count_callback' => null,
//        'default_term'          => [
//            'name'        => '',
//            'slug'        => '',
//            'description' => _x('', 'kms_kanji_level default term description', 'kanji-memory-card'),
//        ],
'sort'                  => false,
'args'                  => [],
        ],
    ]
    // end: kms_kanji_level
];

