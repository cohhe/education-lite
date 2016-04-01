<?php
/**
 * Education 1.0 Theme Customizer support
 *
 * @package WordPress
 * @subpackage Education
 * @since Education 1.0
 */

/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since Education 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function education_customize_register( $wp_customize ) {
	// Add custom description to Colors and Background sections.
	$wp_customize->get_section( 'colors' )->description           = __( 'Background may only be visible on wide screens.', 'education' );
	$wp_customize->get_section( 'background_image' )->description = __( 'Background may only be visible on wide screens.', 'education' );

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'education' );

	// Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
	$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title &amp; Tagline', 'education' );

	// Add General setting panel and configure settings inside it
	$wp_customize->add_panel( 'education_general_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'General settings' , 'education'),
		'description'    => __( 'You can configure your general theme settings here' , 'education')
	) );

	// Add Header setting panel and configure settings inside it
	$wp_customize->add_panel( 'education_header_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Header settings' , 'education'),
		'description'    => __( 'You can configure your theme header settings here.' , 'education')
	) );

	// Add Header setting panel and configure settings inside it
	$wp_customize->add_panel( 'education_footer_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Footer settings' , 'education'),
		'description'    => __( 'You can configure your theme footer settings here.' , 'education')
	) );

	// Website logo
	$wp_customize->add_section( 'education_general_logo', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Website logo' , 'education'),
		'description'    => __( 'Please upload your logo, recommended logo size should be between 262x80' , 'education'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_logo', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'education_logo', array(
		'label'    => __( 'Website logo', 'education' ),
		'section'  => 'education_general_logo',
		'settings' => 'education_logo',
	) ) );

	// Website footer logo
	$wp_customize->add_section( 'education_general_footerlogo', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Website footer logo' , 'education'),
		'description'    => __( 'Please upload your footer logo, recommended logo size should be between 262x80' , 'education'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_footerlogo', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'education_footerlogo', array(
		'label'    => __( 'Website footer logo', 'education' ),
		'section'  => 'education_general_footerlogo',
		'settings' => 'education_footerlogo',
	) ) );

	// Copyright
	$wp_customize->add_section( 'education_general_copyright', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Copyright' , 'education'),
		'description'    => __( 'Please provide short copyright text which will be shown in footer.' , 'education'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_copyright', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Copyright &copy; 2015 Education' ) );

	$wp_customize->add_control(
		'education_copyright',
		array(
			'label'      => 'Copyright',
			'section'    => 'education_general_copyright',
			'type'       => 'text',
		)
	);

	// Scroll to top
	$wp_customize->add_section( 'education_general_scrolltotop', array(
		'priority'       => 30,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Scroll to top' , 'education'),
		'description'    => __( 'Do you want to enable "Scroll to Top" button?' , 'education'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_scrolltotop', array( 'sanitize_callback' => 'education_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'education_scrolltotop',
		array(
			'label'      => 'Scroll to top',
			'section'    => 'education_general_scrolltotop',
			'type'       => 'checkbox',
		)
	);

	// Favicon
	$wp_customize->add_section( 'education_general_favicon', array(
		'priority'       => 40,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Favicon' , 'education'),
		'description'    => __( 'Do you have favicon? You can upload it here.' , 'education'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_favicon', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'education_favicon', array(
		'label'    => __( 'Favicon', 'education' ),
		'section'  => 'education_general_favicon',
		'settings' => 'education_favicon',
	) ) );

	// Page layout
	$wp_customize->add_section( 'education_general_layout', array(
		'priority'       => 50,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Layout' , 'education'),
		'description'    => __( 'Choose a layout for your theme pages. Note that a widget has to be inside widget are, or the layout won\'t change.' , 'education'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting(
		'education_layout',
		array(
			'default'           => 'full',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control(
		'education_layout',
		array(
			'type' => 'radio',
			'label' => 'Layout',
			'section' => 'education_general_layout',
			'choices' => array(
				'full' => 'Full',
				'right' => 'Right'
			)
		)
	);

	// Header text
	$wp_customize->add_section( 'education_header_text', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Header text' , 'education'),
		'description'    => __( 'An text for your header.' , 'education'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headertext', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headertext',
		array(
			'label'      => 'Header text',
			'section'    => 'education_header_text',
			'type'       => 'text',
		)
	);

	// Header email
	$wp_customize->add_section( 'education_header_email', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Email' , 'education'),
		'description'    => __( 'An email address for your theme header.' , 'education'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headeremail', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headeremail',
		array(
			'label'      => 'Email',
			'section'    => 'education_header_email',
			'type'       => 'text',
		)
	);

	// Header phone
	$wp_customize->add_section( 'education_header_phone', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Phone' , 'education'),
		'description'    => __( 'An Phone number for your theme header.' , 'education'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headerphone', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headerphone',
		array(
			'label'      => 'Phone',
			'section'    => 'education_header_phone',
			'type'       => 'text',
		)
	);

	// Header facebook
	$wp_customize->add_section( 'education_header_facebook', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Facebook URL' , 'education'),
		'description'    => __( 'Facebook URL for your header social icon.' , 'education'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headerfacebook', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headerfacebook',
		array(
			'label'      => 'Facebook URL',
			'section'    => 'education_header_facebook',
			'type'       => 'text',
		)
	);

	// Header youtube
	$wp_customize->add_section( 'education_header_youtube', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'YouTube URL' , 'education'),
		'description'    => __( 'YouTube URL for your header social icon.' , 'education'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headeryoutube', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headeryoutube',
		array(
			'label'      => 'YouTube URL',
			'section'    => 'education_header_youtube',
			'type'       => 'text',
		)
	);

	// Header twitter
	$wp_customize->add_section( 'education_header_twitter', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Twitter URL' , 'education'),
		'description'    => __( 'Twitter URL for your header social icon.' , 'education'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headertwitter', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headertwitter',
		array(
			'label'      => 'Twitter URL',
			'section'    => 'education_header_twitter',
			'type'       => 'text',
		)
	);

	// Header google plus
	$wp_customize->add_section( 'education_header_gplus', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Google+ URL' , 'education'),
		'description'    => __( 'Google+ URL for your header social icon.' , 'education'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headergplus', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headergplus',
		array(
			'label'      => 'Google+ URL',
			'section'    => 'education_header_gplus',
			'type'       => 'text',
		)
	);

	// Footer facebook
	$wp_customize->add_section( 'education_footer_facebook', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Facebook URL' , 'education'),
		'description'    => __( 'An URL to your facebook page.' , 'education'),
		'panel'          => 'education_footer_panel'
	) );

	$wp_customize->add_setting( 'education_footerfacebook', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_footerfacebook',
		array(
			'label'      => 'Facebook URL',
			'section'    => 'education_footer_facebook',
			'type'       => 'text',
		)
	);

	// Footer pinterest
	$wp_customize->add_section( 'education_footer_pinterest', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Pinterest URL' , 'education'),
		'description'    => __( 'An URL to your pinterest page.' , 'education'),
		'panel'          => 'education_footer_panel'
	) );

	$wp_customize->add_setting( 'education_footerpinterest', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_footerpinterest',
		array(
			'label'      => 'Pinterest URL',
			'section'    => 'education_footer_pinterest',
			'type'       => 'text',
		)
	);

	// Footer twitter
	$wp_customize->add_section( 'education_footer_twitter', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Twitter URL' , 'education'),
		'description'    => __( 'An URL to your twitter page.' , 'education'),
		'panel'          => 'education_footer_panel'
	) );

	$wp_customize->add_setting( 'education_footertwitter', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_footertwitter',
		array(
			'label'      => 'Twitter URL',
			'section'    => 'education_footer_twitter',
			'type'       => 'text',
		)
	);

	// Footer gplus
	$wp_customize->add_section( 'education_footer_gplus', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Google+ URL' , 'education'),
		'description'    => __( 'An URL to your gplus page.' , 'education'),
		'panel'          => 'education_footer_panel'
	) );

	$wp_customize->add_setting( 'education_footergplus', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_footergplus',
		array(
			'label'      => 'Google+ URL',
			'section'    => 'education_footer_gplus',
			'type'       => 'text',
		)
	);

	// Social links
	$wp_customize->add_section( new education_Customized_Section( $wp_customize, 'education_social_links', array(
		'priority'       => 300,
		'capability'     => 'edit_theme_options'
		) )
	);

	$wp_customize->add_setting( 'education_fake_field', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_fake_field',
		array(
			'label'      => '',
			'section'    => 'education_social_links',
			'type'       => 'text'
		)
	);
}
add_action( 'customize_register', 'education_customize_register' );

if ( class_exists( 'WP_Customize_Section' ) && !class_exists( 'education_Customized_Section' ) ) {
	class education_Customized_Section extends WP_Customize_Section {
		public function render() {
			$classes = 'accordion-section control-section control-section-' . $this->type;
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
				<style type="text/css">
					.cohhe-social-profiles {
						padding: 14px;
					}
					.cohhe-social-profiles li:last-child {
						display: none !important;
					}
					.cohhe-social-profiles li i {
						width: 20px;
						height: 20px;
						display: inline-block;
						background-size: cover !important;
						margin-right: 5px;
						float: left;
					}
					.cohhe-social-profiles li i.twitter {
						background: url(<?php echo get_template_directory_uri().'/images/icons/twitter.png'; ?>);
					}
					.cohhe-social-profiles li i.facebook {
						background: url(<?php echo get_template_directory_uri().'/images/icons/facebook.png'; ?>);
					}
					.cohhe-social-profiles li i.googleplus {
						background: url(<?php echo get_template_directory_uri().'/images/icons/googleplus.png'; ?>);
					}
					.cohhe-social-profiles li i.cohhe_logo {
						background: url(<?php echo get_template_directory_uri().'/images/icons/cohhe.png'; ?>);
					}
					.cohhe-social-profiles li a {
						height: 20px;
						line-height: 20px;
					}
					#customize-theme-controls>ul>#accordion-section-education_social_links {
						margin-top: 10px;
					}
					.cohhe-social-profiles li.documentation {
						text-align: right;
						margin-bottom: 60px;
					}
				</style>
				<ul class="cohhe-social-profiles">
					<li class="documentation"><a href="http://documentation.cohhe.com/education" class="button button-primary button-hero" target="_blank"><?php _e( 'Documentation', 'education' ); ?></a></li>
					<li class="social-twitter"><i class="twitter"></i><a href="https://twitter.com/Cohhe_Themes" target="_blank"><?php _e( 'Follow us on Twitter', 'education' ); ?></a></li>
					<li class="social-facebook"><i class="facebook"></i><a href="https://www.facebook.com/cohhethemes" target="_blank"><?php _e( 'Join us on Facebook', 'education' ); ?></a></li>
					<li class="social-googleplus"><i class="googleplus"></i><a href="https://plus.google.com/+Cohhe_Themes/posts" target="_blank"><?php _e( 'Join us on Google+', 'education' ); ?></a></li>
					<li class="social-cohhe"><i class="cohhe_logo"></i><a href="http://cohhe.com/" target="_blank"><?php _e( 'Cohhe.com', 'education' ); ?></a></li>
				</ul>
			</li>
			<?php
		}
	}
}

function education_sanitize_checkbox( $input ) {
	// Boolean check 
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

/**
 * Sanitize the Featured Content layout value.
 *
 * @since Education 1.0
 *
 * @param string $layout Layout type.
 * @return string Filtered layout type (grid|slider).
 */
function education_sanitize_layout( $layout ) {
	if ( ! in_array( $layout, array( 'slider' ) ) ) {
		$layout = 'slider';
	}

	return $layout;
}

/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Education 1.0
 */
function education_customize_preview_js() {
	wp_enqueue_script( 'education_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'education_customize_preview_js' );

/**
 * Add contextual help to the Themes and Post edit screens.
 *
 * @since Education 1.0
 *
 * @return void
 */
function education_contextual_help() {
	if ( 'admin_head-edit.php' === current_filter() && 'post' !== $GLOBALS['typenow'] ) {
		return;
	}

	get_current_screen()->add_help_tab( array(
		'id'      => 'education',
		'title'   => __( 'Education 1.0', 'education' ),
		'content' =>
			'<ul>' .
				'<li>' . sprintf( __( 'The home page features your choice of up to 6 posts prominently displayed in a grid or slider, controlled by the <a href="%1$s">featured</a> tag; you can change the tag and layout in <a href="%2$s">Appearance &rarr; Customize</a>. If no posts match the tag, <a href="%3$s">sticky posts</a> will be displayed instead.', 'education' ), admin_url( '/edit.php?tag=featured' ), admin_url( 'customize.php' ), admin_url( '/edit.php?show_sticky=1' ) ) . '</li>' .
				'<li>' . sprintf( __( 'Enhance your site design by using <a href="%s">Featured Images</a> for posts you&rsquo;d like to stand out (also known as post thumbnails). This allows you to associate an image with your post without inserting it. Education 1.0 uses featured images for posts and pages&mdash;above the title&mdash;and in the Featured Content area on the home page.', 'education' ), 'http://codex.wordpress.org/Post_Thumbnails#Setting_a_Post_Thumbnail' ) . '</li>' .
				'<li>' . sprintf( __( 'For an in-depth tutorial, and more tips and tricks, visit the <a href="%s">Education 1.0 documentation</a>.', 'education' ), 'http://codex.wordpress.org/Education' ) . '</li>' .
			'</ul>',
	) );
}
add_action( 'admin_head-themes.php', 'education_contextual_help' );
add_action( 'admin_head-edit.php',   'education_contextual_help' );
