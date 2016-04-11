<?php
/**
 * @author        ThimPress
 * @package       LearnPress/Templates
 * @version       1.0
 */

defined( 'ABSPATH' ) || exit();

global $course;
?>
<div class="course-item-meta">

	<?php do_action( 'learn_press_before_item_meta', $item );?>

	<span class="lp-label lp-label-viewing"><?php _e( 'Viewing', 'education-lite' );?></span>

	<span class="lp-label lp-label-completed"><?php _e( 'Completed', 'education-lite' );?></span>

	<?php if( $item->post_type == 'lp_quiz' ){ ?>

		<span class="lp-label lp-label-quiz"><?php _e( 'Quiz', 'education-lite' );?></span>

		<?php if( $course->final_quiz == $item->ID ){?>

			<span class="lp-label lp-label-final"><?php _e( 'Final', 'education-lite' );?></span>

		<?php }?>

	<?php }elseif( $item->post_type == 'lp_lesson' ){ ?>

		<span class="lp-label lp-label-lesson"><?php _e( 'Lesson', 'education-lite' );?></span>
		<?php if( get_post_meta( $item->ID, '_lp_is_previewable', true ) == 'yes' ){?>

			<span class="lp-label lp-label-preview"><?php _e( 'Preview', 'education-lite' );?></span>

		<?php }?>

	<?php } ?>

	<?php learn_press_item_meta_format( $item->ID );?>

	<?php do_action( 'learn_press_after_item_meta', $item );?>

</div>
