<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\MemoryCard;

class ShortcodesHandler implements Module
{
    public function __construct()
    {
        add_shortcode('kanji_memory_card', [$this, 'handleKanjiMemoryCard']);
    }

    public function handleKanjiMemoryCard(): string
    {
        return kmcCall(MemoryCard::class, 'render');
    }
}