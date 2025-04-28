<?php
/**
 * Plugin Name: Kanji Memory Card
 * Description: Memorize kanji in your WordPress. Add shortcode 'kanji_memory_card'.
 * Author: changwoo
 * Author URI: https://blog.changwoo.pe.kr
 * Requires PHP: 8.0
 * Version: 0.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

const KMC_MAIN      = __FILE__;
const KMC_VERSION   = '0.0.0';
const KMC_CPT_CARD  = 'kms_kanji_card';
const KMC_TAX_LEVEL = 'kms_kanji_level';

kmc();
