<?php

namespace Chwnam\KMC\Objects;

use Bojaghi\Helper\Facades;
use Chwnam\KMC\Modules\PostMeta;
use WP_Post;

class Card
{
    public function __construct(
        public int    $id = 0,
        public string $question = '',
        public string $questionHint = '',
        public string $answer = '',
        public string $answerSupplement = '',
        public string $course = '',
    )
    {
    }

    public static function get(string|int|WP_Post $postId): ?self
    {
        $post = get_post($postId);
        if (!$post || KMC_CPT_CARD !== $post->post_type) {
            return null;
        }

        $course = wp_get_object_terms($post->ID, KMC_TAX_COURSE, 'fields=slugs');
        if ($course) {
            $course = array_shift($course);
        } else {
            $course = '';
        }

        $postMeta = Facades::get(PostMeta::class);

        return new self(
            $post->ID,
            $post->post_title,
            $post->post_excerpt,
            $postMeta->cardAnswer->get($post->ID),
            $postMeta->cardAnswerSupplement->get($post->ID),
            $course,
        );
    }
}
