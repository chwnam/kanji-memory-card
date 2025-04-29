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
    <div class="kanji-memory-card__counter"></div>
    <div class="kanji-memory-card__question">
        <h3 class="kanji-memory-card__title">
            질문
        </h3>
    </div>
    <div class="kanji-memory-card__answer hidden">
        정답
    </div>
    <div class="kanji-memory-card__buttons">
        <button class="button kanji-memory-card__answer-button-prev">
            <?php echo __('이전', 'kanji-memory-card'); ?>
        </button>
        <button class="button kanji-memory-card__answer-button-show">
            <?php echo __('정답 토글', 'kanji-memory-card'); ?>
        </button>
        <button class="button kanji-memory-card__answer-button-next">
            <?php echo __('다음', 'kanji-memory-card'); ?>
        </button>
    </div>
</div>
