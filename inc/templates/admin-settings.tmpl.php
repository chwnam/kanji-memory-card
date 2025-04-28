<?php
/**
 * @var Template $this
 *
 * Context:
 * WP_Term[]  $levels
 * int|string $level
 */

use Bojaghi\Template\Template;

if (!defined('ABSPATH')) {
    exit;
}
?>
<style>
    ol.description {
        margin: 2px 0 25px 2em;
        color: #646970;
    }
</style>
<div class="wrap">
    <hr class="wp-header-end">
    <div class="">
        <h2>
            <?php esc_html_e('기억 카드 업로드', 'kanji-memory-card'); ?>
        </h2>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
            <label for="csv_file"> <?php esc_html_e('업로드할 CSV', 'kanji-memory-card'); ?></label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv">
            <?php submit_button(__('업로드', 'kanji-memory-card')); ?>
            <input type="hidden" name="action" value="kmc_import_cards">
            <?php wp_nonce_field('kmc_import_cards', '_kmc_nonce'); ?>
            <p class="description">
                <?php esc_html_e('CSV는 5열로 되어 있고, 첫 행은 헤더입니다.', 'kanji-memory-card'); ?>
                <?php esc_html_e('헤더는 아래와 같습니다.', 'kanji-memory-card'); ?>
            </p>
            <ol class="description">
                <li><?php esc_html_e('question: 카드의 질문. 필수.', 'kanji-memory-card'); ?></li>
                <li><?php esc_html_e('qustionHint: 카드 질문의 힌트.', 'kanji-memory-card'); ?></li>
                <li><?php esc_html_e('answer: 정답. 필수.', 'kanji-memory-card'); ?></li>
                <li><?php esc_html_e('answerSupplement: 정답과 같이 보이는 부가 설명,', 'kanji-memory-card'); ?></li>
                <li><?php esc_html_e('course: 어떤 코드인지 나타내는 텀 슬러그.', 'kanji-memory-card'); ?></li>
            </ol>
        </form>
    </div>
    <div class="">
        <h2>
            <?php esc_html_e('위험 작업', 'kanji-memory-card'); ?>
        </h2>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
            <button
                class="button button-primary"
                onclick="return confirm('진짜로 삭제합니까? 되돌릴 수 없습니다!') || false;"
                type="submit"
            ><?php esc_html_e('단어 테이블 제거', 'kanji-memory-card'); ?>
            </button>
            <p class="description">
                <?php esc_html_e('모든 단어 카드를 삭제합니다!', 'kanji-memory-card'); ?>
            </p>
            <input type="hidden" name="action" value="kmc_purge_cards">
            <?php wp_nonce_field('kmc_purge_cards', '_kmc_nonce'); ?>
        </form>
    </div>
</div>
