<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\SettingsPage;

class AdminMenu implements Module
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'adminMenu']);
    }

    public function adminMenu(): void
    {
        add_submenu_page(
            'options-general.php',
            'Kanji Memory Card Settings',
            'Kanji Memory Card',
            'manage_options',
            'kanji-memory-card',
            function () {
                kmcGet(SettingsPage::class)->render();
            },
        );
    }
}