<?php
/**
 * @var Template $this
 *
 * Context:
 * - hirigana: string
 * - kanji:    string
 * - korean:   string
 * - levels:   WP_Term[]
 * - values:   int[]
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
    <tr>
        <th scope="row">
            <label for="korean">레벨</label>
        </th>
        <td>
            <ul style="margin: 0;">
                <?php
                foreach ($this->get('levels') as $level) :
                    /** @var WP_Term $level */
                    ?>
                    <li>
                        <input
                            id="<?php echo esc_attr(KMC_TAX_LEVEL . '-' . $level->term_id) ?>"
                            name="<?php echo esc_attr(KMC_TAX_LEVEL) ?>[]"
                            type="checkbox"
                            value="<?php echo esc_attr($level->term_id) ?>"
                            <?php checked(in_array($level->term_id, $this->get('values', []), true)); ?>
                        />
                        <label for="<?php echo esc_attr(KMC_TAX_LEVEL . '-' . $level->term_id) ?>">
                            <?php printf('%s', esc_html($level->name)); ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </td>
    </tr>
    </tbody>
</table>
<?php wp_nonce_field('kmc_admin_custom_edit_ui', '_kmc_admin_custom_edit_ui', false); ?>
