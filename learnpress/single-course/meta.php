<?php
/**
 * Template for displaying the thumbnail of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $course;

?>
<div class="course-meta">
	<?php learn_press_get_template( 'single-course/instructor.php' ); ?>
	<?php learn_press_get_template( 'single-course/categories.php' ); ?>
	<div class="course-enroll">
		<?php if ( $course->is( 'viewing' ) != 'lesson' ) {
			learn_press_get_template( 'single-course/price.php' );
		} ?>
		<?php learn_press_get_template( 'single-course/enroll-button.php' ); ?>
	</div>
</div>