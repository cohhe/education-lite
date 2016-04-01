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

$facebook_link = get_theme_mod('education_footerfacebook', '');
$pinterest_link = get_theme_mod('education_footerpinterest', '');
$twitter_link = get_theme_mod('education_footertwitter', '');
$gplus_link = get_theme_mod('education_footergplus', '');

?>

		</div><!-- #main -->

		<div class="site-footer-wrapper">
			<?php
			$show_scroll_to_top = get_theme_mod('education_scrolltotop', false);

			if ( $show_scroll_to_top ) { ?>
				<a class="scroll-to-top" href="#"><?php _e( 'Up', 'education' ); ?></a>
			<?php } ?>
			<div class="site-footer-container">
				<footer id="colophon" class="site-footer" role="contentinfo">
					<?php get_sidebar( 'footer' ); ?>
				</footer><!-- #colophon -->
			</div>
			<div class="footer-bottom">
				<div class="copyright">&copy; 2016 <a href="https://cohhe.com" target="_blank">Cohhe Themes</a>. All rights reserved.</div>
				<div class="footer-social">
					<?php if ( $facebook_link ) { ?>
						<a href="<?php echo esc_url($facebook_link); ?>" class="footer-social-icon icon-facebook"></a>
					<?php } ?>
					<?php if ( $pinterest_link ) { ?>
						<a href="<?php echo esc_url($pinterest_link); ?>" class="footer-social-icon icon-pinterest"></a>
					<?php } ?>
					<?php if ( $twitter_link ) { ?>
						<a href="<?php echo esc_url($twitter_link); ?>" class="footer-social-icon icon-twitter"></a>
					<?php } ?>
					<?php if ( $gplus_link ) { ?>
						<a href="<?php echo esc_url($gplus_link); ?>" class="footer-social-icon icon-gplus"></a>
					<?php } ?>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>