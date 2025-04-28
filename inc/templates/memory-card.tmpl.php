<?php
/**
 * @var Template $this
 *
 * Context:
 */

use Bojaghi\Template\Template;

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="kanji-memory-card">
    <div class="kanji-memory-card__buttons">
        <button class="button kanji-memory-card__answer-button-prev">
            <?php echo __('Previous', 'kanji-memory-card'); ?>
        </button>
        <button class="button kanji-memory-card__answer-button-show">
            <?php echo __('Show answer', 'kanji-memory-card'); ?>
        </button>
        <button class="button kanji-memory-card__answer-button-next">
            <?php echo __('Next', 'kanji-memory-card'); ?>
        </button>
    </div>
    <div class="kanji-memory-card__counter"></div>
    <div class="kanji-memory-card__question">
        <h3 class="kanji-memory-card__title">
            Question
        </h3>
    </div>
    <div class="kanji-memory-card__answer hidden">
        Answer
    </div>
</div>
