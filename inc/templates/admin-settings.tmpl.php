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

<div class="wrap">
    <hr class="wp-header-end">
    <div class="">
        <h2>단어 파일 업로드</h2>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
            <label for="csv_file">업로드할 CSV</label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv">
            <?php submit_button('Submit'); ?>
            <input type="hidden" name="action" value="kmc_import_cards">
            <?php wp_nonce_field('kmc_import_cards', '_kmc_nonce'); ?>
        </form>
    </div>
</div>
