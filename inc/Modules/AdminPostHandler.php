<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\MemoryCard;
use JetBrains\PhpStorm\NoReturn;
use function Chwnam\KanjiMemoryCard\setSetupMessage;

class AdminPostHandler implements Module
{
    /**
     * @return void
     *
     * @uses Memorycard::importCards()
     */
    #[NoReturn]
    public function importCards(): void
    {
        if (!isset($_FILES['csv_file'])) {
            wp_die('No file uploaded.');
        }

        $result = kmcCall(Memorycard::class, 'importCards', [$_FILES['csv_file']['tmp_name']]);

        if (is_wp_error($result)) {
            wp_die($result);
        }

        setSetupMessage([
            'success' => 1,
            'message' => sprintf('Successfuly imported %d cards.', (int)$result),
        ]);

        wp_redirect(wp_get_referer());
        exit;
    }
}