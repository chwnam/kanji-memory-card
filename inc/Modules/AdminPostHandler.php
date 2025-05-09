<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KanjiMemoryCard\Supports\MemoryCard;
use Chwnam\KanjiMemoryCard\Supports\Score;
use JetBrains\PhpStorm\NoReturn;
use WP_Query;
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
        if (empty($_FILES['csv_file']['tmp_name'])) {
            wp_die('No file uploaded.', 'Error', ['back_link' => true]);
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

    public function purgeCards(): void
    {
        if (!current_user_can('administrator')) {
            return;
        }

        $query = new WP_Query([
            'fields'           => 'ids',
            'nopaging'         => true,
            'no_found_rows'    => true,
            'post_type'        => KMC_CPT_CARD,
            'suppress_filters' => true,
        ]);

        foreach ($query->posts as $id) {
            wp_delete_post($id, true);
        }

        $score = kmcGet(Score::class);
        $score->reset();

        setSetupMessage([
            'success' => 1,
            'message' => '모든 카드를 제거했습니다.',
        ]);

        wp_redirect(wp_get_referer());
        exit;
    }
}
