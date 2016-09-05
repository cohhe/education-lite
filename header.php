<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Education
 * @since Education 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php
		$favicon = get_theme_mod('education_favicon', array());

		if (!empty($favicon)) {
			echo '<link rel="shortcut icon" href="' . esc_url( $favicon ) . '" />';
		} else {
			echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/images/favicon.png" />';
		}
	?>
	
	<?php wp_head(); ?>
</head>
<?php
global $education_site_width, $education_layout_type;

$form_class    = '';
$class         = '';
$search_string = '';
$education_site_width    = 'col-sm-12 col-md-12 col-lg-12';
$layout_type   = get_post_meta(get_the_id(), 'layouts', true);

if ( is_archive() || is_search() || is_404() || is_home() ) {
	$layout_type = 'full';
} elseif (empty($layout_type)) {
	$layout_type = get_theme_mod('education_layout', 'full');
}

switch ($layout_type) {
	case 'right':
		define('LONGFORM_LAYOUT', 'sidebar-right');
		break;
	case 'full':
		define('LONGFORM_LAYOUT', 'sidebar-no');
		break;
	case 'left':
		define('LONGFORM_LAYOUT', 'sidebar-left');
		break;
}

$education_layout_type = $layout_type;

if ( ( is_active_sidebar( 'education-sidebar-1' ) || is_active_sidebar( 'education-sidebar-2' ) ) && LONGFORM_LAYOUT != 'sidebar-no' ) {
	$education_site_width = 'col-sm-8 col-md-8 col-lg-8';
}

$header_email = get_theme_mod('education_headeremail', '');
$header_phone = get_theme_mod('education_headerphone', '');
$header_text = get_theme_mod('education_headertext', '');

?>
<body <?php body_class(); ?>>
<?php do_action('ase_theme_body_inside_top'); ?>
<div id="page" class="hfeed site">
	<?php
		 $logo = get_theme_mod('education_logo', array());
	?>
	<header id="masthead" class="site-header" role="banner">
		<div class="header-content">
			<div class="header-top">
				<div class="header-top-inner">
					<?php if ( $header_text ) { ?>
						<span class="education-questions"><?php echo $header_text; ?></span>
					<?php } ?>
					<?php if ( $header_phone ) { ?>
						<a href="javascript:void(0)" class="header-phone icon-phone-1"><?php echo $header_phone; ?></a>
					<?php } ?>
					<?php if ( $header_email ) { ?>
						<a href="mail:<?php echo esc_url($header_email); ?>" class="header-mail icon-mail"><?php echo $header_email; ?></a>
					<?php } ?>
					<?php if ( function_exists('education_get_social_icons') ) { echo education_get_social_icons(); } ?>
				</div>
				
			</div>
			<div class="header-main">
				<div class="site-title">
					<?php
					if ( ! empty ( $logo ) ) { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo $logo; ?>" alt="<?php esc_html_e("Logo", "education-lite"); ?>"></a>
						<?php
					} else { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><?php bloginfo( 'name' ); ?></a>
						<?php
					}
					?>
				</div>
				<button type="button" class="navbar-toggle visible-xs" data-toggle="collapse" data-target=".site-navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="main-header-right-side col-xs-9 col-sm-8 col-md-9">
					<nav id="primary-navigation" class="site-navigation primary-navigation navbar-collapse collapse" role="navigation">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_class'     => 'nav-menu',
									'depth'          => 4,
									'walker'         => new Education_Header_Menu_Walker
								)
							);
						?>
					</nav>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</header><!-- #masthead -->
	<div id="loading-background"></div>
	<div id="main" class="site-main container">
