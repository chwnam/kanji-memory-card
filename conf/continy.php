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
        'bojaghi/adminAjax'   => fn(Continy $continy) => [
            dirname(KMC_MAIN) . '/conf/admin-ajax.php', // configuration
            $continy,                                   // container interface
        ],
        'bojaghi/customPosts' => "$conf/custom-posts.php",
        'bojaghi/customTax'   => "$conf/custom-tax.php",
        'bojaghi/template'    => [
            [
                'infix'  => 'tmpl',
                'scopes' => [dirname(KMC_MAIN) . '/inc/templates'],
            ]
        ],
    ],
    'bindings'  => [
        // Bojaghi
        'bojaghi/adminAjax'   => Bojaghi\AdminAjax\AdminAjax::class,
        'bojaghi/customPosts' => Bojaghi\CustomPosts\CustomPosts::class,
        'bojaghi/customTax'   => Bojaghi\Tax\CustomTaxonomies::class,
        'bojaghi/template'    => Bojaghi\Template\Template::class,
        // Plugin
        'kmc/activation'      => Modules\Activation::class,
        'kmc/ajax'            => Modules\AdminAjaxHandler::class,
        'kmc/adminEdit'       => Modules\AdminEdit::class,
        'kmc/shortcodes'      => Modules\ShortcodesHandler::class,
    ],
    'modules'   => [
        '_'    => [
            'bojaghi/adminAjax',
            'kmc/activation',
            'kmc/shortcodes',
        ],
        'init' => [
            Continy::PR_DEFAULT => [
                // Bojaghi-side
                'bojaghi/customPosts',
                'bojaghi/customTax',
                // Plugin-side
                'kmc/adminEdit'
            ],
        ],
    ],
];
