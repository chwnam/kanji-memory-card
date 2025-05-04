<?php

namespace Chwnam\KanjiMemoryCard\Objects;

use stdClass;
use WP_Post;

class Card extends stdClass
{
    public function __construct(
        public int    $id = 0,
        public string $kanji = '',
        public string $hiragana = '',
        public string $korean = '',
        public array  $levels = [],
    )
    {
    }

    /**
     * @param string $content
     *
     * @return array{
     *     kanji: string,
     *     hiragana: string,
     *     korean: string,
     * }
     */
    public static function decodeContent(string $content): array
    {
        $decoded = json_decode($content) ?: [];

        return [
            'kanji'    => $decoded[0] ?? '',
            'hiragana' => $decoded[1] ?? '',
            'korean'   => $decoded[2] ?? '',
        ];
    }

    public static function encodeContent(string $kanji, string $hiragana, string $korean): string
    {
        // Encode as a list for reducing total JSON size.
        return json_encode([$kanji, $hiragana, $korean], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
    }

    public static function get(string|int|WP_Post $postId): ?self
    {
        $post = get_post($postId);
        if (!$post) {
            return null;
        }

        $content = self::decodeContent($post->post_content_filtered);
        $levels  = wp_get_object_terms($post->ID, KMC_TAX_LEVEL, 'fields=names&orderby=name&order=ASC');
        if (!$content || !is_array($levels)) {
            return null;
        }

        return new self(
            $post->ID,
            $content['kanji'],
            $content['hiragana'],
            $content['korean'],
            $levels,
        );
    }
}
