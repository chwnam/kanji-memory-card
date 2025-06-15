<?php
/**
 * Plugin Name: 기억 카드
 * Plugin URI: https://github.com/chwnam/kanji-memory-card
 * Description: 학습과 기억을 위한 카드 시스템
 * Author: changwoo
 * Author URI: https://blog.changwoo.pe.kr
 * Requires PHP: 8.0
 * Version: 0.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

const KMC_MAIN       = __FILE__;
const KMC_VERSION    = '0.2.0';
const KMC_CPT_CARD   = 'kmc_card';
const KMC_TAX_COURSE = 'kmc_course';
const KMC_MESSAGE    = 'kmc_setup_message';

kmc();
