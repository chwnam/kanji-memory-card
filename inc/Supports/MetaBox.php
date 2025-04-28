<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;

class MetaBox implements Support
{
    public function __construct()
    {
        // Remove current metaboxes.
        remove_meta_box('tagsdiv-' . KMC_TAX_LEVEL, null, 'side');

        // Add our metaboxes.
        add_meta_box('kmc-tag-' . KMC_TAX_LEVEL, 'Level', [$this, 'levelMetaBox'], null, 'side');
    }

    public function levelMetaBox(): void
    {
        $levels = get_terms(
            [
                'taxonomy'   => KMC_TAX_LEVEL,
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ],
        );

        echo kmcTmpl()->template('admin-meta-level', ['levels' => $levels]);
    }
}
