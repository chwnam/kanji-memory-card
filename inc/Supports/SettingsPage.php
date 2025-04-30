<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Template\Template;
use WP_Query;

class SettingsPage
{
    public function __construct(private Template $tmpl)
    {
    }

    public function render(): void
    {
        echo $this->tmpl->template('admin-settings');
    }

    public function importCards(): void
    {
        if (!isset($_FILES['csv_file'])) {
            wp_die('No file uploaded.');
        }

        $items = [];
        $fp    = fopen($_FILES['csv_file']['tmp_name'], 'r');
        if (!$fp) {
            wp_die('Cannot open file.');
        }
        while (($row = fgetcsv($fp))) {
            if (3 !== count($row)) {
                continue;
            }
            $row = array_map('trim', $row);
            if ($row[0] && $row[1] && $row[2]) {
                $items[] = $row;
            }
        }
        fclose($fp);

        if (!$items) {
            wp_die('No items found.');
        }

        foreach ($items as $item) {
            $query = new WP_Query([
                'post_type'        => KMC_CPT_CARD,
                'post_status'      => 'publish',
                'name'             => implode('-', $item),
                'posts_per_page'   => 1,
                'no_found_rows'    => true,
                'suppress_filters' => true,
            ]);

            [$kanji, $hiragana, $korean] = $item;

            $filtered = wp_slash(
                json_encode(
                    compact('kanji', 'hiragana', 'korean'),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
                ),
            );

            $post = [
                'post_content'          => '',
                'post_content_filtered' => $filtered,
                'post_name'             => implode('-', $item),
                'post_status'           => 'publish',
                'post_type'             => KMC_CPT_CARD,
                'post_title'            => $korean,
            ];

            if (1 === $query->post_count) {
                // Update
                $post['ID'] = $query->post[0]->ID;
                wp_update_post($post);
            } else {
                // Insert
                wp_insert_post($post);
            }
        }

        wp_redirect(wp_get_referer());
    }
}