<?php
/**
 * Single course title
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course_info = education_get_info( get_the_ID() );
$duration = get_post_meta( get_the_ID(), '_lp_duration', true );
$students = get_post_meta( get_the_ID(), '_lp_students', true );
$results = get_post_meta( get_the_ID(), '_lp_course_result', true );
if ( $results == 'evaluate_lesson' ) {
	$assessment = 'Yes';
} else {
	$assessment = 'No';
}

?>

<h3 class="entry-title"><?php _e('Course features', 'learnpress'); ?></h3>
<ul class="course-info-list">
	<li class="course-info-item"><span class="info-item-label icon-docs">Lectures</span><span class="info-item-text"><?php echo $course_info['lessons']; ?></span></li>
	<li class="course-info-item"><span class="info-item-label icon-puzzle">Quizzes</span><span class="info-item-text"><?php echo $course_info['quizzes']; ?></span></li>
	<li class="course-info-item"><span class="info-item-label icon-clock">Duration</span><span class="info-item-text"><?php echo $duration.' weeks'; ?></span></li>
	<li class="course-info-item"><span class="info-item-label icon-users">Students</span><span class="info-item-text"><?php echo $students; ?></span></li>
	<li class="course-info-item"><span class="info-item-label icon-ok-circled2">Assessments</span><span class="info-item-text"><?php echo $assessment; ?></span></li>
</ul>