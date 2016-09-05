<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Education
 * @since Education 1.0
 */

?>

		</div><!-- #main -->

		<div class="site-footer-wrapper">
			<?php
			$show_scroll_to_top = get_theme_mod('education_scrolltotop', false);

			if ( $show_scroll_to_top ) { ?>
				<a class="scroll-to-top" href="#"><?php esc_html_e( 'Up', 'education-lite' ); ?></a>
			<?php } ?>
			<div class="site-footer-container">
				<footer id="colophon" class="site-footer" role="contentinfo">
					<?php get_sidebar( 'footer' ); ?>
				</footer><!-- #colophon -->
			</div>
			<div class="footer-bottom">
				<div class="copyright">&copy; 2016 <a href="https://cohhe.com" target="_blank">Cohhe Themes</a>. <?php esc_html_e('All rights reserved.', 'education-lite'); ?></div>
				<?php if ( function_exists('education_get_footer_social') ) { education_get_footer_social(); } ?>
				
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>