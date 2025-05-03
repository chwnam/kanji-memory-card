<?php
/**
 * @var Template $this
 *
 * Context:
 * WP_Term[]  $levels
 * int[]      $values
 */

use Bojaghi\Template\Template;

if (!defined('ABSPATH')) {
    exit;
}
?>

<ul>
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
