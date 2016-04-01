<?php
/**
 * Template for displaying the instructor of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $course;

printf('<div class="course-author">'.get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'education_author_bio_avatar_size', 40 ) ).
	'<span class="course-author" aria-hidden="true" itemprop="author">
		<span>%s</span><a href="%s">%s</a>%s
	</span></div>',
	apply_filters( 'before_instructor_link', __( 'Instructor: ', 'learnpress' ) ),
	apply_filters( 'learn_press_instructor_profile_link', get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )), null, $course->id ),
	get_the_author(),
	apply_filters( 'after_instructor_link', '' )
);