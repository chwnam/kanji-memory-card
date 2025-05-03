<?php
/**
 * @var Template $this
 *
 * Context:
 * - hirigana: string
 * - kanji: string
 * - korean: string
 */

use Bojaghi\Template\Template;

if (!defined('ABSPATH')) {
    exit;
}
?>

<table id="kmc-post-edit" class="form-table" role="presentation">
    <tbody>
    <tr>
        <th scope="row">
            <label for="kanji">한자</label>
        </th>
        <td>
            <input
                id="kanji"
                type="text"
                name="kanji"
                value="<?php echo esc_attr($this->get('kanji')); ?>"
                class="text regular-text">
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="hiragana">히라가나</label>
        </th>
        <td>
            <input
                id="hiragana"
                type="text"
                name="hiragana"
                value="<?php echo esc_attr($this->get('hiragana')); ?>"
                class="text regular-text">
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="korean">한국어</label>
        </th>
        <td>
            <input
                id="korean"
                type="text"
                name="korean"
                value="<?php echo esc_attr($this->get('korean')); ?>"
                class="text regular-text">
        </td>
    </tr>
    </tbody>
</table>
<?php wp_nonce_field('kmc_admin_custom_edit_ui', '_kmc_admin_custom_edit_ui', false); ?>
