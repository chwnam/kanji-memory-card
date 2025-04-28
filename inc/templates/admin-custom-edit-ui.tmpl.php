<?php
/**
 * @var Template $this
 *
 * Context:
 * - card:  Object
 * - courses: WP_Term[]
 * - walker: CourseWalker
 */

use Bojaghi\Template\Template;
use Chwnam\KanjiMemoryCard\Walkers\CourseWalker;

if (!defined('ABSPATH')) {
    exit;
}
?>
<style>
    .courses {
        line-height: 1.5;
    }

    .courses ul.course-has-children {
        margin-top: 4px;
    }
</style>
<table id="kmc-post-edit" class="form-table" role="presentation">
    <tbody>
    <tr>
        <th scope="row">
            <label for="kmc_question">질문</label>
        </th>
        <td>
            <input
                id="kmc_question"
                type="text"
                name="kmc_question"
                value="<?php echo esc_attr($this->get('card')->question); ?>"
                class="text regular-text"
            >
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="kmc_question_hint">질문 힌트</label>
        </th>
        <td>
            <textarea
                id="kmc_question_hint"
                type="text"
                name="kmc_question_hint"
                cols="40"
                rows="5"
            ><?php echo esc_textarea($this->get('card')->questionHint); ?></textarea>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="kmc_answer">정답</label>
        </th>
        <td>
            <input
                id="kmc_answer"
                type="text"
                name="kmc_answer"
                value="<?php echo esc_attr($this->get('card')->answer); ?>"
                class="text regular-text"
            >
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="kmc_answer_supplement">정답 보충</label>
        </th>
        <td>
            <textarea
                id="kmc_answer_supplement"
                name="kmc_answer_supplement"
                cols="40"
                rows="5"
            ><?php echo esc_textarea($this->get('card')->answerSupplement); ?></textarea>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="kmc_course">코스</label>
        </th>
        <td>
            <?php
            if ($this->get('courses') && $this->get('walker')) {
                /** @var CourseWalker $walker */
                $walker  = $this->get('walker');
                $courses = $this->get('courses');
                $term_id = $this->get('term_id');
                echo '<ul class="courses">' .
                    $walker->walk($courses, 0, [], $term_id) .
                    '</li>';
            }
            ?>
        </td>
    </tr>
    </tbody>
</table>
<?php wp_nonce_field('kmc_admin_custom_edit_ui', '_kmc_admin_custom_edit_ui', false); ?>
