<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Objects\Card;
use Chwnam\KanjiMemoryCard\Supports\MetaBox;
use Chwnam\KanjiMemoryCard\Supports\Post;
use WP_Post;
use WP_Screen;

class AdminEdit implements Module
{
    public function __construct()
    {
        add_filter('the_title', [$this, 'correctTitle'], 10, 2);
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
            add_action('edit_form_after_title', [$this, 'customEditUI']);

            // Modify meta-boxes
            add_action("add_meta_boxes_$screen->post_type", [$this, 'modifyMetaBoxes']);
        }
    }

    /**
     * Correct card title
     *
     * Memory cards do not have post_title, so fix them here.
     *
     *
     * @param string $title
     * @param int    $postId
     *
     * @return string
     */
    public function correctTitle(string $title, int $postId): string
    {
        if (KMC_CPT_CARD === get_post_type($postId)) {
            $filtered = get_post_field('post_content_filtered', $postId);
            $content  = Card::decodeContent($filtered);
            $title    = sprintf('%s (%s)', $content['korean'], $content['kanji']);
        }

        return $title;
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

    /**
     * @param int     $postId
     * @param WP_Post $post
     * @param bool    $update
     *
     * @return void
     *
     * @uses Post::savePost()
     */
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
