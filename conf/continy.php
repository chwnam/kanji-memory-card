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
        'init' => 0,
    ],
    'arguments' => [
        'bojaghi/adminAjax'    => fn(Continy $continy) => [
            dirname(KMC_MAIN) . '/conf/admin-ajax.php', // configuration
            $continy,                                   // container interface
        ],
        'bojaghi/adminPost'    => fn(Continy $continy) => [
            dirname(KMC_MAIN) . '/conf/admin-post.php', // configuration
            $continy,                                   // container interface
        ],
        'bojaghi/cleanPages'   => "$conf/clean-pages.php",
        'bojaghi/customPosts'  => "$conf/custom-posts.php",
        'bojaghi/customTables' => [
            'conf'      => [
                'version_name' => 'kmc_table_version',
                'version'      => '1.0.0',
                'main_file'    => KMC_MAIN,
                'activation'   => true,
            ],
            'tableConf' => dirname(KMC_MAIN) . '/conf/custom-tables.php',
        ],
        'bojaghi/customTax'    => "$conf/custom-tax.php",
        'bojaghi/template'     => [
            [
                'infix'  => 'tmpl',
                'scopes' => [dirname(KMC_MAIN) . '/inc/templates'],
            ]
        ],
        'bojaghi/vite'         => [[
            'distBaseUrl'  => plugin_dir_url(KMC_MAIN) . 'dist',
            'i18n'         => false,
            'isProd'       => 'production' === wp_get_environment_type(),
            'manifestPath' => plugin_dir_path(KMC_MAIN) . 'dist/.vite/manifest.json'
        ]],
    ],
    'bindings'  => [
        // Bojaghi
        'bojaghi/adminAjax'    => Bojaghi\AdminAjax\AdminAjax::class,
        'bojaghi/adminPost'    => Bojaghi\AdminAjax\AdminPost::class,
        'bojaghi/cleanPages'   => Bojaghi\CleanPages\CleanPages::class,
        'bojaghi/customPosts'  => Bojaghi\CustomPosts\CustomPosts::class,
        'bojaghi/customTables' => Bojaghi\CustomTables\CustomTables::class,
        'bojaghi/customTax'    => Bojaghi\Tax\CustomTaxonomies::class,
        'bojaghi/template'     => Bojaghi\Template\Template::class,
        'bojaghi/vite'         => Bojaghi\ViteScripts\ViteScript::class,
        // Plugin
        'kmc/adminMenu'        => Modules\AdminMenu::class,
        'kmc/activation'       => Modules\Activation::class,
        'kmc/ajax'             => Modules\AdminAjaxHandler::class,
        'kmc/adminEdit'        => Modules\AdminEdit::class,
        'kmc/post'             => Modules\AdminPostHandler::class,
        'kmc/shortcodes'       => Modules\ShortcodesHandler::class,
    ],
    'modules'   => [
        '_'    => [
            // Bojaghi-side
            'bojaghi/adminAjax',
            'bojaghi/adminPost',
            'bojaghi/cleanPages',
            'bojaghi/customTables',
            // Plugin-side
            'kmc/activation',
            'kmc/shortcodes',
        ],
        'init' => [
            Continy::PR_DEFAULT => [
                // Bojaghi-side
                'bojaghi/customPosts',
                'bojaghi/customTax',
                // Plugin-side
                'kmc/adminEdit',
                'kmc/adminMenu',
            ],
        ],
    ],
];
