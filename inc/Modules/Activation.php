<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Continy\Continy;
use Bojaghi\Contract\Module;

class Activation implements Module
{
    public function __construct(Continy $continy)
    {
        register_activation_hook($continy->getMain(), [$this, 'activate']);
        register_deactivation_hook($continy->getMain(), [$this, 'deactivate']);
    }

    public function activate(): void
    {
        $this->addLevelTags();
    }

    public function deactivate(): void
    {
    }

    public static function addLevelTags(): void
    {
        if (!taxonomy_exists(KMC_TAX_LEVEL)) {
            kmcGet('bojaghi/customTax');
        }

        $levelTags = [
            [
                'name'        => 'N1',
                'slug'        => 'n1',
                'description' => '',
            ],
            [
                'name'        => 'N2',
                'slug'        => 'n2',
                'description' => '',
            ],
            [
                'name'        => 'N3',
                'slug'        => 'n3',
                'description' => '',
            ],
            [
                'name'        => 'N4',
                'slug'        => 'n4',
                'description' => '',
            ],
            [
                'name'        => 'N5',
                'slug'        => 'n5',
                'description' => '',
            ],
        ];

        foreach ($levelTags as $tag) {
            if (!term_exists($tag['name'], KMC_TAX_LEVEL)) {
                wp_insert_term(
                    $tag['name'],
                    KMC_TAX_LEVEL,
                    [
                        'slug'        => $tag['slug'],
                        'description' => $tag['description'],
                    ],
                );
            }
        }
    }
}
