<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\MemoryCard;

class AdminAjaxHandler implements Module
{
    /**
     * @return void
     * @uses MemoryCard::getCard()
     *
     */
    public function getCard(): void
    {
        kmcCall(MemoryCard::class, 'getCard');
    }
}