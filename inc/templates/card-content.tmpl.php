<?php
/**
 * @var Template $this
 *
 * Context:
 * $kanji    string
 * $hiragana string
 * $korean   string
 */
use Bojaghi\Template\Template;

if (!defined('ABSPATH')) {
    exit;
}
?>
<article class="kanji-memory-card__answer__content">
    <dl class="kanji-memory-card-word">
        <dt>
            <span class="kanji-memory-card-word__kanji"><?php echo esc_html($this->get('kanji')); ?></span>
        </dt>
        <dd>
            <span class="kanji-memory-card-word__hiragana"><?php echo esc_html($this->get('hiragana')); ?></span>
            <span class="kanji-memory-card-word__korean"><?php echo esc_html($this->get('korean')); ?></span>
        </dd>
    </dl>
</article>