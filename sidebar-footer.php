<?php
/**
 * The Footer Sidebar
 *
 * @package WordPress
 * @subpackage Education
 * @since Education 1.0
 */

if ( ! is_active_sidebar( 'education-sidebar-3' ) ) {
	return;
}
?>

<div id="supplementary">
	<div id="footer-sidebar" class="footer-sidebar widget-area" role="complementary">
		<div class="footer-column-1 col-sm-4 col-md-4 col-lg-4"><?php dynamic_sidebar( 'education-sidebar-3' ); ?></div>
	</div><!-- #footer-sidebar -->
</div><!-- #supplementary -->
