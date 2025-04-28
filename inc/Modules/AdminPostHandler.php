<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\SettingsPage;
use JetBrains\PhpStorm\NoReturn;

class AdminPostHandler implements Module
{
    /**
     * @return void
     *
     * @uses SettingsPage::importCards()
     */
    #[NoReturn]
    public function importCards(): void
    {
        kmcCall(SettingsPage::class, 'importCards');
        exit;
    }
}