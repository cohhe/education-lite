<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Education
 * @since Education 1.0
 */

get_header();

global $education_site_width;
?>

<div id="main-content" class="main-content row">
	<div id="primary" class="content-area <?php echo esc_attr($education_site_width); ?>">
		<?php if ( !is_front_page() ) {
			echo '<header class="entry-header">';
			echo '<h1 class="entry-title">' . get_the_title($GLOBALS['wp_query']->queried_object->ID) . '</h1>';
			echo '<div class="breadcrumb"><a href="'.home_url( '/' ).'">'.__('Home', 'education-lite').'</a><span class="delimiter">/</span><a href="'.get_permalink($GLOBALS['wp_query']->queried_object->ID).'">'.get_the_title($GLOBALS['wp_query']->queried_object->ID).'</a></div>';
			echo '</header><!-- .entry-header -->';
		} ?>
		<div id="content" class="site-content" role="main">

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;
				?>  <?php

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		?>

		</div><!-- #content -->
		<?php
			// Previous/next post navigation.
			education_paging_nav();
		?>
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
