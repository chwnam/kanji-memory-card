<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\MetaBox;
use WP_Screen;

class AdminEdit implements Module
{
    public function __construct()
    {
        add_action('current_screen', [$this, 'currentScreen']);
    }

    public function currentScreen(WP_Screen $screen): void
    {
        if (KMC_CPT_CARD !== $screen->post_type) {
            return;
        }

//        if ('edit' === $screen->base) {
//        }

        if ('post' === $screen->base) {
            // Modify meta-boxes
            add_action("add_meta_boxes_$screen->post_type", [$this, 'modifyMetaBoxes']);
        }
    }

    public function modifyMetaBoxes(): void
    {
        kmcGet(MetaBox::class);
    }
}
