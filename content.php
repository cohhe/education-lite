<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Education
 * @since Education 1.0
 */

global $education_article_width;
if ( !is_single() ) {
	$post_class = 'not-single-post';
	$header_class = 'simple';
} else {
	$post_class = 'single-post';
	$header_class = '';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($education_article_width.$post_class); ?>>
	<header class="entry-header <?php echo $header_class; ?>">
		<?php
			if ( !is_single() && ( is_home() || is_archive() || is_search() ) ) {
				$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'education-medium-thumbnail' );
				$image_background = '';
				if ( !empty($img['0']) ) {
					$image_background = ' style="background: url('.$img['0'].') no-repeat;"';
				}
				echo '
				<div class="single-image-container"'.$image_background.'>
					<div class="post-image-meta">
						<span class="post-image-icon icon-picture"></span>
						<span class="post-image-date">'.get_the_time('F d, Y',get_the_ID()).'</span>
					</div>
				</div>';
				echo '</header><!-- .entry-header -->';
			} elseif ( is_single() && !is_home() ) {
				echo '</header><!-- .entry-header -->';
				$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'education-full-width' );
				echo '<div class="single-post-image-container">';
				if ( !empty($img) ) {
					echo '<img src="'.$img['0'].'" class="single-post-image" alt="'.__('Post with image', 'education-lite').'">';
				}
				echo '<div class="single-post-meta">';
					education_posted_on();
					echo '<span class="single-post-date icon-clock">'.get_the_time('F d, Y',get_the_ID()).'</span>';
					education_comment_count(get_the_ID());
					education_category_list();
					if( function_exists('the_views') ) {
						echo '<span class="single-post-views icon-eye">'.do_shortcode('[views]').'</span>';
					}
					echo education_like_button();
				echo '</div>';
				echo '</div>';
			}
		?>
	

	<?php if ( is_search() || is_home() || is_archive() ) : ?>
	<div class="post-side-content">
		<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<div class="entry-meta">
			<?php
			education_posted_on();
			education_comment_count(get_the_ID());
			?>
		</div><!-- .entry-meta -->
	</div>
	<div class="clearfix"></div>
	<?php else : ?>
	<div class="entry-content">
		<div id="entry-content-wrapper">
			<?php the_content( __( 'Continue reading', 'education-lite' ).' '.'<span class="meta-nav">&rarr;</span>' ); ?>
			<div class="single-post-bottom-meta">
			<?php
				education_tag_list();
				education_share_icons();
			?>
				<div class="clearfix"></div>
			</div>
			<div class="single-post-prev-next">
				<?php education_prev_next_links(); ?>
			</div>
		</div>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'education-lite' ) . '</span>',
				'after'       => '<div class="clearfix"></div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
</article>