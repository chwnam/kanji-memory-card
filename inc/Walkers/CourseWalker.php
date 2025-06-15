<?php

namespace Chwnam\KMC\Walkers;

use Walker;

class CourseWalker extends Walker
{
    public $tree_type = 'term';

    public $db_fields = [
        'parent' => 'parent',
        'id'     => 'term_id',
    ];

    public function start_lvl(&$output, $depth = 0, $args = []): void
    {
        $output .= '<ul class="course-has-children course-children-lv-' . ($depth + 1) . '">';
    }

    public function end_lvl(&$output, $depth = 0, $args = []): void
    {
        $output .= '</ul>';
    }

    public function start_el(&$output, $data_object, $depth = 0, $args = [], $current_object_id = 0): void
    {
        if (0 === $depth) {
            $output .= '<li>' . esc_html( $data_object->name );
        } else {
            $output .= sprintf(
                '<li><input id="%1$s" name="kmc_course" type="radio" value="%2$s" %3$s /><label for="%1$s">%4$s%5$s</label>',
                esc_attr(KMC_TAX_COURSE . '-' . $data_object->slug),
                esc_attr($data_object->term_id),
                checked($data_object->term_id, $current_object_id, false),
                str_repeat( '&#8212; ', max( 0, $depth ) ),
                esc_html($data_object->name),
            );
        }
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = []): void
    {
        $output .= '</li>';
    }
}
