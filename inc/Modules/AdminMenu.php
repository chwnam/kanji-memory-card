<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\SettingsPage;
use function Chwnam\KanjiMemoryCard\getSetupMessage;

class AdminMenu implements Module
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'adminMenu']);

        $this->processSetupMessage();
    }

    public function adminMenu(): void
    {
        add_submenu_page(
            'options-general.php',
            '한자 카드 설정 페이지',
            '한자 카드',
            'manage_options',
            'kanji-memory-card',
            function () {
                kmcGet(SettingsPage::class)->render();
            },
        );
    }

    private function processSetupMessage(): void
    {
        $data = getSetupMessage();

        if (!$data) {
            return;
        }

        add_action('admin_notices', function () use ($data) {
            $success = (bool)$data['success'];
            $message = $data['message'];
            if ($message) {
                $class = $success ? 'notice-success' : 'notice-error';
                echo '<div class="notice ' . esc_attr($class) . ' is-dismissible"><p>';
                echo esc_html($message);
                echo '</p></div>';
            }
        });
    }
}
