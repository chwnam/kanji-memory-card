<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;
use WP_Post;

class MetaBox implements Support
{
    public function __construct()
    {
        // Remove current metaboxes.
        remove_meta_box('tagsdiv-' . KMC_TAX_LEVEL, null, 'side');

        // Add our metaboxes.
        add_meta_box('kmc-tag-' . KMC_TAX_LEVEL, 'Level', [$this, 'levelMetaBox'], null, 'side');
    }

    public function levelMetaBox(WP_Post $post): void
    {
        echo kmcTmpl()->template(
            'admin-meta-level',
            [
                'levels' => get_terms(
                    [
                        'taxonomy'   => KMC_TAX_LEVEL,
                        'hide_empty' => false,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    ],
                ),
                'values' => wp_get_object_terms(
                    $post->ID,
                    KMC_TAX_LEVEL,
                    ['fields' => 'ids'],
                ),
            ],
        );
    }
}
