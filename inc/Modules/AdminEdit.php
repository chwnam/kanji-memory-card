<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\MetaBox;
use Chwnam\KanjiMemoryCard\Supports\Post;
use WP_Post;
use WP_Screen;

class AdminEdit implements Module
{
    public function __construct()
    {
        add_action('current_screen', [$this, 'currentScreen']);
        add_action('save_post_' . KMC_CPT_CARD, [$this, 'savePost'], 10, 3);
    }

    public function currentScreen(WP_Screen $screen): void
    {
        if (KMC_CPT_CARD !== $screen->post_type) {
            return;
        }

//        if ('edit' === $screen->base) {
//        }

        if ('post' === $screen->base) {
            // Add custom edit UI
            add_action('edit_form_before_permalink', [$this, 'customEditUI']);

            // Modify meta-boxes
            add_action("add_meta_boxes_$screen->post_type", [$this, 'modifyMetaBoxes']);
        }
    }

    /**
     * @param WP_Post $post
     *
     * @return void
     *
     * @uses Post::customEditUI()
     */
    public function customEditUI(WP_Post $post): void
    {
        kmcCall(Post::class, 'customEditUI', [$post]);
    }

    public function modifyMetaBoxes(): void
    {
        kmcGet(MetaBox::class);
    }

    public function savePost(int $postId, WP_Post $post, bool $update): void
    {
        if (!$postId || !$update) {
            return;
        }

        remove_action('save_post_' . KMC_CPT_CARD, [$this, 'savePost']);

        kmcCall(Post::class, 'savePost', [$post]);

        add_action('save_post_' . KMC_CPT_CARD, [$this, 'savePost'], 10, 3);
    }
}
