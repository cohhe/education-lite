<?php
/**
 * Education 1.0 functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Education
 * @since Education 1.0
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see education_content_width()
 *
 * @since Education 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}

/**
 * Education 1.0 only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'education_setup' ) ) :
	/**
	 * Education 1.0 setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 * @since Education 1.0
	 */
	function education_setup() {
		require(get_template_directory() . '/inc/metaboxes/layouts.php');

		/**
		 * Required: include TGM.
		 */
		require_once( get_template_directory() . '/functions/tgm-activation/class-tgm-plugin-activation.php' );

		/*
		 * Make Education 1.0 available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Education 1.0, use a find and
		 * replace to change 'education-lite' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'education-lite', get_template_directory() . '/languages' );

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( array( 'css/editor-style.css' ) );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 672, 372, true );
		add_image_size( 'education-small-thumbnail', 70, 70, true );
		add_image_size( 'education-full-width', 1110, 831, true );
		add_image_size( 'education-thumbnail', 490, 318, true );
		add_image_size( 'education-thumbnail-large', 650, 411, true );
		add_image_size( 'education-medium-thumbnail', 350, 234, true );
		add_image_size( 'education-related-thumbnail', 255, 170, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   => __( 'Top primary menu', 'education-lite' ),
			'footer'    => __( 'Footer menu', 'education-lite' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list',
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'education_custom_background_args', array(
			'default-color' => 'f5f5f5',
		) ) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		add_theme_support( "title-tag" )
	}
endif; // education_setup
add_action( 'after_setup_theme', 'education_setup' );

// Admin CSS
function vh_admin_css() {
	wp_enqueue_style( 'vh-admin-css', get_template_directory_uri() . '/css/wp-admin.css' );
}
add_action('admin_head','vh_admin_css');

function education_is_blog() {
	return get_option('page_for_posts');
}

function education_get_social_icons() {
	$facebook = get_theme_mod('education_headerfacebook', '');
	$youtube = get_theme_mod('education_headeryoutube', '');
	$twitter = get_theme_mod('education_headertwitter', '');
	$gplus = get_theme_mod('education_headergplus', '');
	$output = '';
	$count = 1;
	$class = 'count-';

	if ( $facebook != '' || $youtube != '' || $twitter != '' || $gplus != '' ) {
		$output .= '
		<div class="header-share-icons">
			<a href="javascript:void(0)" class="header-share icon-share"></a>
			<div class="header-icon-wrapper">';
				if ( $facebook != '' ) {
					$output .= '<a href="' . $facebook . '" class="header-social ' . $class . $count . ' icon-facebook"></a>';
					$count++;
				}

				if ( $youtube != '' ) {
					$output .= '<a href="' . $youtube . '" class="header-social ' . $class . $count . ' icon-youtube-play"></a>';
					$count++;
				}

				if ( $twitter != '' ) {
					$output .= '<a href="' . $twitter . '" class="header-social ' . $class . $count . ' icon-twitter"></a>';
					$count++;
				}

				if ( $gplus != '' ) {
					$output .= '<a href="' . $gplus . '" class="header-social ' . $class . $count . ' icon-gplus"></a>';
					$count++;
				}
			
		$output .= '<div class="clearfix"></div></div></div>';
	}

	return $output;
}

function education_tag_list() {
	$tags_list = get_the_tag_list( '', '' );
	$entry_utility = '';
	if ( $tags_list ) {
		$entry_utility .= '
		<div class="tag-link">
		<span class="tag-title">'.__('Tags', 'education-lite').'</span>
		' . sprintf( __( '<span class="%1$s"></span> %2$s', 'education-lite' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
		$entry_utility .= '
		</div>';
	}

	echo $entry_utility;
}

function education_category_list() {
	$tags_list = get_the_category_list( ', ', '' );
	$entry_utility = '';
	if ( $tags_list ) {
		$entry_utility .= '
		<div class="category-link">
		<i class="entypo_icon icon-folder-open"></i>
		' . sprintf( __( '<span class="%1$s"></span> %2$s', 'education-lite' ), 'entry-utility-prep entry-utility-prep-category-links', $tags_list );
		$entry_utility .= '
		</div>';
	}

	echo $entry_utility;
}

function education_share_icons() {
	$output = '<div class="single-open-post-share">';
	$output .= '<a href="http://www.facebook.com/sharer.php?u=' . get_permalink() . '" class="social-icon icon-facebook" target="_blank"></a>';
	$output .= '<a href="http://twitter.com/share?url=' . get_permalink() . '&amp;text=' . urlencode( get_the_title() ) . '" class="social-icon icon-twitter" target="_blank"></a>';
	$output .= '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( get_the_title() ) . '" class="single-share-linkedin icon-linkedin"></a>';
	$output .= '<a href="http://tumblr.com/widgets/share/tool?canonicalUrl=' . urlencode( get_the_permalink() ) . '" class="single-share-tumblr icon-tumblr"></a>';
	$output .= '<a href="https://plus.google.com/share?url=' . get_permalink() . '" class="social-icon icon-gplus" target="_blank"></a>';
	$output .= "<a href=\"javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());\" class=\"social-icon icon-pinterest\" target=\"_blank\"></a>";
	$output .= '</div>';

	echo $output;
}

function education_prev_next_links() {
	$output = '<nav class="nav-single blog vc_col-sm-12">';
		$prev_post = get_previous_post();
		$next_post = get_next_post();

		if (!empty( $prev_post )) {
			$output .= '
			<div class="nav_button left">
				<h3 class="prev-post-text">'. __('Previous post', 'education-lite').'</h3>
				<div class="prev-post-link">
					<a href="'. get_permalink( $prev_post->ID ).'" class="prev_blog_post icon-left">'.get_the_title( $prev_post->ID ).'</a>
				</div>
			</div>';
		}

		if (!empty( $next_post )) {
			$output .= '
			<div class="nav_button right">
				<h3 class="next-post-text">'.__('Next post', 'education-lite').'</h3>
				<div class="next-post-link">
					<a href="'. get_permalink( $next_post->ID ).'" class="next_blog_post icon-right">'. get_the_title( $next_post->ID ).'</a>
				</div>
			</div>';
		}
		$output .= '
		<div class="clearfix"></div>
	</nav>';

	echo $output;
}

function education_comment_count( $post_id ) {
	$comments = wp_count_comments($post_id); 
	echo '<span class="comments icon-chat">' . $comments->approved . '</span>';
}

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Education 1.0
 *
 * @return void
 */
function education_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'education_content_width' );

/**
 * Prevent page scroll when clicking the More link
 *
 * @since Education 1.0
 *
 * @return void
 */
function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Education 1.0
 *
 * @return array An array of WP_Post objects.
 */
function education_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Education 1.0.
	 *
	 * @since Education 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'education_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Education 1.0
 *
 * @return bool Whether there are featured posts.
 */
function education_has_featured_posts() {
	return ! is_paged() && (bool) education_get_featured_posts();
}

/**
 * Register three Education 1.0 widget areas.
 *
 * @since Education 1.0
 *
 * @return void
 */
function education_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Post Sidebar', 'education-lite' ),
		'id'            => 'education-sidebar-1',
		'class'			=> 'col-sm-4 col-md-4 col-lg-4',
		'description'   => __( 'Additional sidebar that appears on the right or left.', 'education-lite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'education-lite' ),
		'id'            => 'education-sidebar-2',
		'class'			=> 'col-sm-4 col-md-4 col-lg-4',
		'description'   => __( 'Additional sidebar that appears on the right or left.', 'education-lite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 1', 'education-lite' ),
		'id'            => 'education-sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'education-lite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'education_widgets_init' );

/**
 * Register Lato Google font for Education 1.0.
 *
 * @since Education 1.0
 *
 * @return string
 */
function education_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	$font_url = add_query_arg( 'family', urlencode( 'Roboto:400,100,300' ), "//fonts.googleapis.com/css" );

	return $font_url;
}

function education_like_button() {
	$post_id = get_the_ID();
	if ( function_exists('ldc_like_counter_p') ) {
		$vote_count = get_post_ul_meta($post_id,"like");
		if ( intval($vote_count) == 0 ) {
			$output = "<span class='single-post-like icon-heart-empty' onclick=\"alter_ul_post_values(this,'$post_id','like')\" ><span>".get_post_ul_meta($post_id,"like")."</span></span>";;
		} else {
			$output = "<span class='single-post-like icon-heart-1' onclick=\"alter_ul_post_values(this,'$post_id','like')\" ><span>".get_post_ul_meta($post_id,"like")."</span></span>";;
		}
	} else {
		$output = '';
	}

	return $output;
}

function education_excerpt_length( $length ) {
	return 70;
}
add_filter( 'excerpt_length', 'education_excerpt_length', 999 );

function education_breadcrumbs() {
	$delimiter = get_option('vh_breadcrumb_delimiter') ? get_option('vh_breadcrumb_delimiter') : '<span class="delimiter">/</span>';

	$home   = __('Home', 'education-lite'); // text for the 'Home' link
	$before = '<span class="current">'; // tag before the current crumb
	$after  = '</span>'; // tag after the current crumb

	if (!is_home() && !is_front_page()) {
		global $post;
		$homeLink = home_url();

		$output = '<div class="breadcrumb">';
		$output .= '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

		if (is_category()) {
			global $wp_query;
			$cat_obj   = $wp_query->get_queried_object();
			$thisCat   = $cat_obj->term_id;
			$thisCat   = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0)
				$output .= get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
			$output .= $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
		} elseif (is_day()) {
			$output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			$output .= '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			$output .= $before . get_the_time('d') . $after;
		} elseif (is_month()) {
			$output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			$output .= $before . get_the_time('F') . $after;
		} elseif (is_year()) {
			$output .= $before . get_the_time('Y') . $after;
		} elseif (is_single() && !is_attachment()) {
			if (get_post_type() != 'post') {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				$output .= '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
				$output .= $before . get_the_title() . $after;
			} else {
				$cat = get_the_category();
				$cat = $cat[0];
				$output .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				$output .= $before . get_the_title() . $after;
			}
		} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
			$post_type = get_post_type_object(get_post_type());
			if ( isset($post_type) ) {
				$output .= $before . $post_type->labels->singular_name . $after;
			}
		} elseif (is_attachment()) {
			$parent = get_post($post->post_parent);
			$cat    = get_the_category($parent->ID);
			if ( isset($cat[0]) ) {
				$cat = $cat[0];
			}
			$output .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			$output .= $before . get_the_title() . $after;
		} elseif (is_page() && !$post->post_parent) {
			$output .= $before . get_the_title() . $after;
		} elseif (is_page() && $post->post_parent) {
			$parent_id   = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page          = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id     = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) {
				$output .= $crumb . ' ' . $delimiter . ' ';
			}
			$output .= $before . get_the_title() . $after;
		} elseif (is_search()) {
			$output .= $before . 'Search results for "' . get_search_query() . '"' . $after;
		} elseif (is_tag()) {
			$output .= $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
		} elseif (is_author()) {
			global $vh_author;
			$userdata = get_userdata($vh_author);
			$output .= $before . 'Articles posted by ' . get_the_author() . $after;
		} elseif (is_404()) {
			$output .= $before . 'Error 404' . $after;
		}

		if (get_query_var('paged')) {
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
				$output .= ' (';
			$output .= __('Page', 'education-lite') . ' ' . get_query_var('paged');
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
				$output .= ')';
		}

		$output .= '</div>';

		return $output;
	}
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Education 1.0
 *
 * @return void
 */
function education_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array() );

	// Add Google fonts
	wp_register_style('googleFonts', '//fonts.googleapis.com/css?family=Roboto:400,600,300,700|Roboto+Slab:400,600,300,700&subset=latin');
	wp_enqueue_style( 'googleFonts');

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'education-style', get_stylesheet_uri(), array( 'genericons' ) );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'education-ie', get_template_directory_uri() . '/css/ie.css', array( 'education-style', 'genericons' ), '20131205' );
	wp_style_add_data( 'education-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'education-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20131209', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '20131209', true );

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array() );

	wp_enqueue_script( 'jquery.bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'jquery.jcarousel', get_template_directory_uri() . '/js/jquery.jcarousel.pack.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'jquery.isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'jquery-ui-draggable' );

	wp_enqueue_script( 'jquery-ui-tabs' );

	wp_enqueue_script('googlemap', '//maps.googleapis.com/maps/api/js?sensor=false', array(), '3', false);
}
add_action( 'wp_enqueue_scripts', 'education_scripts' );

// Admin Javascript
add_action( 'admin_enqueue_scripts', 'education_admin_scripts' );
function education_admin_scripts() {
	wp_register_script('master', get_template_directory_uri() . '/inc/js/admin-master.js', array('jquery'));
	wp_enqueue_script('master');
}

if ( ! function_exists( 'education_the_attached_image' ) ) :
	/**
	 * Print the attached image with a link to the next attached image.
	 *
	 * @since Education 1.0
	 *
	 * @return void
	 */
	function education_the_attached_image() {
		$post                = get_post();
		/**
		 * Filter the default Education 1.0 attachment size.
		 *
		 * @since Education 1.0
		 *
		 * @param array $dimensions {
		 *     An array of height and width dimensions.
		 *
		 *     @type int $height Height of the image in pixels. Default 810.
		 *     @type int $width  Width of the image in pixels. Default 810.
		 * }
		 */
		$attachment_size     = apply_filters( 'education_attachment_size', array( 810, 810 ) );
		$next_attachment_url = wp_get_attachment_url();

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id ) {
				$next_attachment_url = get_attachment_link( $next_id );
			}

			// or get the URL of the first image attachment.
			else {
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
			}
		}

		printf( '<a href="%1$s" rel="attachment">%2$s</a>',
			esc_url( $next_attachment_url ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Education 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function education_body_classes( $classes ) {
	global $post;
	$education_layout = '';

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( is_active_sidebar( 'education-sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	$education_layout = LONGFORM_LAYOUT;
	if ( !empty($education_layout) ) {
		$classes[] = $education_layout;
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	if( isset($post->post_content) && has_shortcode( $post->post_content, 'education_main_slider' ) ) {
		$classes[] = 'education-main-slider';
	}

	return $classes;
}
add_filter( 'body_class', 'education_body_classes' );

/* Related posts */
function education_the_related_posts() {
	global $post;
	$tags = wp_get_post_tags($post->ID);
	  
	if ($tags) {
		$tag_ids = array();

		foreach($tags as $individual_tag) {
			$tag_ids[] = $individual_tag->term_id;
		}

		$args = array(
			'tag__in'             => $tag_ids,
			'post__not_in'        => array($post->ID),
			'posts_per_page'      => 3, // Number of related posts to display.
			'ignore_sticky_posts' => 1
		);

		$my_query = new wp_query( $args ); ?>

		<h3 class="related-articles-title"><?php _e( 'Related posts', 'education-lite' ); ?></h3>
		<div class="related-articles">
			<?php
			if ( $my_query->have_posts() ) {
				while( $my_query->have_posts() ) {
					$my_query->the_post(); ?>

					<div class="related-thumb col-sm-4 col-md-4 col-lg-4">
						<a rel="external" href="<?php the_permalink(); ?>">
							<div class="related-image">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail('education-medium-thumbnail');
								} else {
									echo '<img src="'.get_template_directory_uri().'/images/no-post-img.png" class="related-post-image" alt="'.__('Post without image', 'education-lite').'">';
								}
								?>
								<span class="single-open-post-date"><?php echo human_time_diff(get_the_time('U',get_the_ID()),current_time('timestamp')) .  ' '.__('ago', 'education-lite'); ?></span>
							</div>
						</a>
						<a href="<?php the_permalink(); ?>" class="related-title"><?php the_title(); ?></a>
					</div>
				<?php }
			} else { ?>
				<h3 class="no-related-posts"><?php _e('There\'s no related posts!', 'education-lite'); ?></h3>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
    <?php
	}
	wp_reset_postdata();
	wp_reset_query();
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Education 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function education_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'education-lite' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'education_wp_title', 10, 2 );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker, using the description.
 *
 * @see    http://wordpress.stackexchange.com/q/14037/
 * @author toscho, http://toscho.de
 */
class Education_Header_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes         = empty ( $item->classes ) ? array () : (array) $item->classes;
		$has_description = '';

		$class_names = join(
			' '
		,   apply_filters(
				'nav_menu_css_class'
			,   array_filter( $classes ), $item
			)
		);

		// insert description for top level elements only
		// you may change this
		$description = ( ! empty ( $item->description ) )
			? '<small>' . esc_attr( $item->description ) . '</small>' : '';

		$has_description = ( ! empty ( $item->description ) )
			? 'has-description ' : '';

		! empty ( $class_names )
			and $class_names = ' class="' . $has_description . esc_attr( $class_names ) . ' depth-' . $depth . '"';

		$output .= "<li id='menu-item-$item->ID' $class_names>";

		$attributes  = '';

		if ( !isset($item->target) ) {
			$item->target = '';
		}

		if ( !isset($item->attr_title) ) {
			$item->attr_title = '';
		}

		if ( !isset($item->xfn) ) {
			$item->xfn = '';
		}

		if ( !isset($item->url) ) {
			$item->url = '';
		}

		if ( !isset($item->title) ) {
			$item->title = '';
		}

		if ( !isset($item->ID) ) {
			$item->ID = '';
		}

		if ( !isset($args->link_before) ) {
			$args = new stdClass();
			$args->link_before = '';
		}

		if ( !isset($args->before) ) {
			$args->before = '';
		}

		if ( !isset($args->link_after) ) {
			$args->link_after = '';
		}

		if ( !isset($args->after) ) {
			$args->after = '';
		}

		! empty( $item->attr_title )
			and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
		! empty( $item->target )
			and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
		! empty( $item->xfn )
			and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
		! empty( $item->url )
			and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$item_output = $args->before
			. "<a $attributes>"
			. $args->link_before
			. '<span>' . $title . '</span>'
			. $description
			. '</a> '
			. $args->link_after
			. $args->after;

		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
		,   $item_output
		,   $item
		,   $depth
		,   $args
		);
	}
}

function get_depth($postid) {
$depth = ($postid==get_option('page_on_front')) ? -1 : 0;
while ($postid > 0) {
$postid = get_post_ancestors($postid);
$postid = $postid[0];
$depth++;
}
return $depth;
}

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function vh_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     				=> 'Bootstrap 3 Shortcodes', // The plugin name
			'slug'     				=> 'bootstrap-3-shortcodes', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '3.3.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		// array(
		// 	'name'     				=> 'Contact Form 7', // The plugin name
		// 	'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
		// 	'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		// 	'version' 				=> '4.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		// ),
		// array(
		// 	'name'     				=> 'Easy Social Icons', // The plugin name
		// 	'slug'     				=> 'easy-social-icons', // The plugin slug (typically the folder name)
		// 	'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		// 	'version' 				=> '1.2.4.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		// ),
		array(
			'name'     				=> 'Easy Testimonials', // The plugin name
			'slug'     				=> 'easy-testimonials', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.31.11', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Functionality for Education theme', // The plugin name
			'slug'     				=> 'functionality-for-education-theme', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		// array(
		// 	'name'     				=> 'Like Dislike counter', // The plugin name
		// 	'slug'     				=> 'like-dislike-counter-for-posts-pages-and-comments', // The plugin slug (typically the folder name)
		// 	'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		// 	'version' 				=> '1.3.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		// ),
		// array(
		// 	'name'     				=> 'Newsletter', // The plugin name
		// 	'slug'     				=> 'newsletter', // The plugin slug (typically the folder name)
		// 	'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		// 	'version' 				=> '3.9.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		// ),
		// array(
		// 	'name'     				=> 'WP-PostViews', // The plugin name
		// 	'slug'     				=> 'wp-postviews', // The plugin slug (typically the folder name)
		// 	'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		// 	'version' 				=> '1.71', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		// )
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'education-lite',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'education-lite' ),
			'menu_title'                       			=> __( 'Install Plugins', 'education-lite' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'education-lite' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'education-lite' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'education-lite' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'education-lite' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'education-lite' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'education-lite' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'education-lite' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'education-lite' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'education-lite' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'education-lite' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'education-lite' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'education-lite' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'education-lite' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'education-lite' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'education-lite' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'vh_register_required_plugins' );

function education_allowed_tags() {
	global $allowedposttags;
	$allowedposttags['script'] = array(
		'type' => true,
		'src' => true
	);
}
add_action( 'init', 'education_allowed_tags' );

/* Remove learnpress actions */
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_title', 10 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_price', 25 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_students', 30 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_single_course_content_lesson', 40 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_enroll_button', 45 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_single_course_description', 55 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_progress', 60 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_curriculum', 65 );

remove_action( 'learn_press_content_learning_summary', 'learn_press_course_status', 15 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_instructor', 20 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_students', 25 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_single_course_description', 35 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_single_course_content_lesson', 40 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_progress', 45 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_finish_button', 50 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_curriculum', 55 );

// /* Add learnpress actions */
add_action( 'learn_press_content_landing_summary', 'learn_press_course_title', 4 );
add_action( 'learn_press_content_landing_summary', 'education_course_meta', 4 );

add_action( 'learn_press_content_learning_summary', 'learn_press_course_title', 4 );
add_action( 'learn_press_content_learning_summary', 'education_course_meta', 4 );

function education_course_meta() {
	learn_press_get_template( 'single-course/meta.php' );
}

function education_get_info( $course_id ) {
	$cirriculum = get_post_meta($course_id, '_lp_curriculum', true);
	$lessons = 0;
	$quizzes = 0;
	
	if ( !empty($cirriculum) ) {
		foreach ($cirriculum as $cir_value) {
			foreach ($cir_value['items'] as $cir_values) {
				if ( $cir_values['post_type'] == 'lp_lesson' && $cir_values['item_id'] != '' ) {
					$lessons++;
				} elseif ( $cir_values['post_type'] == 'lp_quiz' && $cir_values['item_id'] != '' ) {
					$quizzes++;
				}
			}
		}
	}

	return array('lessons' => $lessons, 'quizzes' => $quizzes );
}