<?php
/**
 * Template for displaying content of learning course
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $course;
?>

<?php do_action( 'learn_press_before_content_learning' );?>

<div class="course-learning-summary">

	<?php do_action( 'learn_press_content_learning_summary' ); ?>

	<div class="course-main-content">
		<ul>
			<li><a href="#description" class="icon-doc-text-inv"><?php _e('Description', 'education'); ?></a></li>
			<li><a href="#cirriculum" class="icon-book"><?php _e('Cirriculum', 'education'); ?></a></li>
			<li><a href="#instructors" class="icon-user"><?php _e('Instructor', 'education'); ?></a></li>
			<li><a href="#reviews" class="icon-star"><?php _e('Reviews', 'education'); ?></a></li>
		</ul>
		<div id="description">
			<?php if ( $course->is( 'viewing' ) == 'lesson' ) {
				learn_press_get_template( 'single-course/content-lesson.php' );
			} else {
				learn_press_get_template( 'single-course/description.php' );
			} ?>
			<div class="clearfix"></div>
		</div>
		<div id="cirriculum">
			<?php learn_press_get_template( 'single-course/curriculum.php' ); ?>
		</div>
		<div id="instructors">
			<div class="instructor-container">
				<?php
				$author_avatar = get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'education_author_bio_avatar_size', 110 ) );
				$author_link = apply_filters( 'learn_press_instructor_profile_link', get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )), null, $course->id );
				?>
				<div class="instructor-img"><?php echo $author_avatar; ?></div>
				<div class="instructor-side">
					<a href="<?php echo $author_link; ?>" class="instructor-url"><?php echo get_the_author_meta( 'user_nicename' ); ?></a>
					<p class="instructor-description"><?php echo get_the_author_meta( 'description' ); ?></p>
				</div>
			</div>
		</div>
		<div id="reviews">
			...
		</div>
	</div>

</div>

<?php do_action( 'learn_press_after_content_learning' );?>
