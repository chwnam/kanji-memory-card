<?php

namespace Chwnam\KMC\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KMC\Supports\SettingsPage;
use function Chwnam\KMC\getSetupMessage;

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
            __('기억 카드 설정 페이지', 'kanji-memory-card'),
            __('기억 카드', 'kanji-memory-card'),
            'manage_options',
            'kanji-memory-card',
            fn() => kmcGet(SettingsPage::class)->render(),
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
