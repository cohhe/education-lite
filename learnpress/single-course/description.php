<?php
/**
 * Displaying the description of single course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $course;

if( $course->is( 'viewing' ) != 'course' ){
	return;
}

$description_heading = apply_filters( 'learn_press_single_course_description_heading', __( 'Course Description', 'learnpress' ), $course );
?>

<div id="learn-press-course-lesson"></div>
<div class="course-description" id="learn-press-course-description">
	
	<?php do_action( 'learn_press_begin_single_course_description' ); ?>

	<?php the_content(); ?>

	<?php do_action( 'learn_press_end_single_course_description' ); ?>

</div>
<div class="course-info">
	<?php learn_press_get_template( 'single-course/info.php' ); ?>
</div>