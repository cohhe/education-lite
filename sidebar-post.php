<?php
/**
 * The Content Sidebar
 *
 * @package WordPress
 * @subpackage Education
 * @since Education 1.0
 */

if ( ( LONGFORM_LAYOUT == 'sidebar-right' || LONGFORM_LAYOUT == 'sidebar-left' ) && is_active_sidebar( 'education-sidebar-1' ) ) {
?>
<div id="content-sidebar" class="content-sidebar widget-area col-sm-4 col-md-4 col-lg-4" role="complementary">
	<?php dynamic_sidebar( 'education-sidebar-1' ); ?>
</div><!-- #content-sidebar -->
<?php
}