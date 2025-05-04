<?php

namespace Chwnam\KanjiMemoryCard\Objects;

use stdClass;

class Card extends stdClass
{
    public function __construct(
        public string $kanji = '',
        public string $hiragana = '',
        public string $korean = '',
        public string $level = '',
    )
    {
    }

    public static function encodeContent(string $kanji, string $hiragana, string $korean): string
    {
        // Encode as a list for reducing total JSON size.
        return json_encode([$kanji, $hiragana, $korean], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
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
}
