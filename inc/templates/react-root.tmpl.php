<?php
/**
 * @var Template $this
 *
 * Context:
 * - id: string
 * - class: string
 * - inner_content: string
 */

use Bojaghi\Template\Template;

if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="<?php echo esc_attr($this->get('id', 'kmc-root')); ?>"
     class="<?php echo esc_attr($this->get('class', 'kmc kmc-root')); ?>"
     data-kmc-root="true"><?php echo esc_html($this->get('inner_content')); ?></div>
