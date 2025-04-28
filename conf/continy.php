<?php
/**
 * Continy configuration
 */

use Bojaghi\Continy\Continy;
use Chwnam\KanjiMemoryCard\Modules;

if (!defined('ABSPATH')) {
    exit;
}

$conf = __DIR__;

return [
    'main_file' => KMC_MAIN,
    'version'   => KMC_VERSION,
    'hooks'     => [
        'init'          => 0,
        'rest_api_init' => 1,
    ],
    'arguments' => [
        // 'bojaghi/adminAjax'        => fn(Continy $continy) => [
        //     dirname(KMC_MAIN) . '/conf/admin-ajax.php', // configuration
        //     $continy,                                   // container interface
        // ],
        'bojaghi/adminPost'        => fn(Continy $continy) => [
            dirname(KMC_MAIN) . '/conf/admin-post.php', // configuration
            $continy,                                   // container interface
        ],
        'bojaghi/cleanPages'       => "$conf/clean-pages.php",
        'bojaghi/customFields'     => "$conf/custom-fields.php",
        'bojaghi/customPosts'      => "$conf/custom-posts.php",
        'bojaghi/customTables'     => [
            'conf'      => [
                'version_name' => 'kmc_table_version',
                'version'      => '1.0.0',
                'main_file'    => KMC_MAIN,
                'activation'   => true,
            ],
            'tableConf' => dirname(KMC_MAIN) . '/conf/custom-tables.php',
        ],
        'bojaghi/customTaxonomies' => "$conf/custom-taxonomies.php",
        'bojaghi/template'         => [
            [
                'infix'  => 'tmpl',
                'scopes' => [dirname(KMC_MAIN) . '/inc/templates'],
            ],
        ],
        'bojaghi/vite'             => [[
            'distBaseUrl'  => plugin_dir_url(KMC_MAIN) . 'dist',
            'i18n'         => false,
            'isProd'       => 'production' === wp_get_environment_type(),
            'manifestPath' => plugin_dir_path(KMC_MAIN) . 'dist/.vite/manifest.json',
        ]],
    ],
    'bindings'  => [
        // Bojaghi
        // 'bojaghi/adminAjax'        => Bojaghi\AdminAjax\AdminAjax::class,
        'bojaghi/adminPost'        => Bojaghi\AdminAjax\AdminPost::class,
        'bojaghi/cleanPages'       => Bojaghi\CleanPages\CleanPages::class,
        'bojaghi/customFields'     => Bojaghi\Fields\Modules\CustomFields::class,
        'bojaghi/customPosts'      => Bojaghi\CustomPosts\CustomPosts::class,
        'bojaghi/customTables'     => Bojaghi\CustomTables\CustomTables::class,
        'bojaghi/customTaxonomies' => Bojaghi\Tax\CustomTaxonomies::class,
        'bojaghi/template'         => Bojaghi\Template\Template::class,
        'bojaghi/vite'             => Bojaghi\ViteScripts\ViteScript::class,
        // Plugin
        'kmc/adminAjax'            => Modules\AdminAjaxHandler::class,
        'kmc/adminEdit'            => Modules\AdminEdit::class,
        'kmc/adminMenu'            => Modules\AdminMenu::class,
        'kmc/adminPost'            => Modules\AdminPostHandler::class,
        'kmc/api'                  => Modules\ApiModule::class,
    ],
    'modules'   => [
        '_'             => [
            // Bojaghi-side
            // 'bojaghi/adminAjax',
            'bojaghi/adminPost',
            'bojaghi/cleanPages',
            'bojaghi/customTables',
            // Plugin-side
        ],
        'init'          => [
            Continy::PR_DEFAULT => [
                // Bojaghi-side
                'bojaghi/customPosts',
                'bojaghi/customTaxonomies',
                // Plugin-side
                'kmc/adminEdit',
                'kmc/adminMenu',
            ],
        ],
        'rest_api_init' => [
            Continy::PR_DEFAULT => [
                'kmc/api',
            ],
        ],
    ],
];
