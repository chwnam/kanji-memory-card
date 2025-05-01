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
        if (is_admin()) {
            return '';
        }

        if (!is_user_logged_in()) {
            $loginUrl = wp_login_url(get_permalink());
            return "<script>window.location.href = '$loginUrl';</script>";
        }

        return kmcCall(MemoryCard::class, 'render');
    }
}
