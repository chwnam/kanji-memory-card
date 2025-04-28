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

<ul>
    <?php
    foreach ($this->get('levels') as $level) :
        /** @var WP_Term $level */
        ?>
        <li>
            <input
                id="<?php echo esc_attr(KMC_TAX_LEVEL . '-' . $level->term_id) ?>"
                name="<?php echo esc_attr(KMC_TAX_LEVEL) ?>"
                type="radio"
                <?php checked($level->term_id, $this->get('level')) ?>
            />
            <label for="<?php echo esc_attr(KMC_TAX_LEVEL . '-' . $level->term_id) ?>">
                <?php printf('%s', esc_html($level->name)); ?>
            </label>
        </li>
    <?php endforeach; ?>
</ul>
