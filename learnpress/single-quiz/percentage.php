<?php
if ( learn_press_get_current_user()->is( 'guest' ) ) return;
$course_id = learn_press_get_course_by_quiz( get_the_ID() );
$passed    = learn_press_user_has_passed_course( $course_id );
$result    = learn_press_get_quiz_result();
?>
	<div class="clearfix"></div>
<?php if ( $passed ): ?>
	<?php learn_press_message( sprintf( __( 'You have passed this course with %.2f%% of total', 'education-lite' ), $result['mark_percent'] * 100 ) ); ?>
<?php else: ?>
	<?php
	$passing_condition = learn_press_get_course_passing_condition( $course_id );
	?>
	<?php learn_press_message( sprintf( __( 'Sorry, you have not passed this course. This course required you pass %.2f%% but your result is only %.2f%%', 'education-lite' ), $passing_condition, $result['mark_percent'] * 100 ), 'error' ); ?>
<?php endif; ?>