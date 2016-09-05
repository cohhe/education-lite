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
	$wp_customize->get_section( 'colors' )->description           = esc_html__( 'Background may only be visible on wide screens.', 'education-lite' );
	$wp_customize->get_section( 'background_image' )->description = esc_html__( 'Background may only be visible on wide screens.', 'education-lite' );

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'education-lite' );

	// Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
	$wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'education-lite' );

	// Add General setting panel and configure settings inside it
	$wp_customize->add_panel( 'education_general_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'General settings' , 'education-lite'),
		'description'    => esc_html__( 'You can configure your general theme settings here' , 'education-lite')
	) );

	// Add Header setting panel and configure settings inside it
	$wp_customize->add_panel( 'education_header_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Header settings' , 'education-lite'),
		'description'    => esc_html__( 'You can configure your theme header settings here.' , 'education-lite')
	) );

	// Website logo
	$wp_customize->add_section( 'education_general_logo', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Website logo' , 'education-lite'),
		'description'    => esc_html__( 'Please upload your logo, recommended logo size should be between 262x80' , 'education-lite'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_logo', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'education_logo', array(
		'label'    => esc_html__( 'Website logo', 'education-lite' ),
		'section'  => 'education_general_logo',
		'settings' => 'education_logo',
	) ) );

	// Website footer logo
	$wp_customize->add_section( 'education_general_footerlogo', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Website footer logo' , 'education-lite'),
		'description'    => esc_html__( 'Please upload your footer logo, recommended logo size should be between 262x80' , 'education-lite'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_footerlogo', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'education_footerlogo', array(
		'label'    => esc_html__( 'Website footer logo', 'education-lite' ),
		'section'  => 'education_general_footerlogo',
		'settings' => 'education_footerlogo',
	) ) );

	// Scroll to top
	$wp_customize->add_section( 'education_general_scrolltotop', array(
		'priority'       => 30,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Scroll to top' , 'education-lite'),
		'description'    => esc_html__( 'Do you want to enable "Scroll to Top" button?' , 'education-lite'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_scrolltotop', array( 'sanitize_callback' => 'education_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'education_scrolltotop',
		array(
			'label'      => esc_html__('Scroll to top', 'education-lite'),
			'section'    => 'education_general_scrolltotop',
			'type'       => 'checkbox',
		)
	);

	// Favicon
	$wp_customize->add_section( 'education_general_favicon', array(
		'priority'       => 40,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Favicon' , 'education-lite'),
		'description'    => esc_html__( 'Do you have favicon? You can upload it here.' , 'education-lite'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_favicon', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'education_favicon', array(
		'label'    => esc_html__( 'Favicon', 'education-lite' ),
		'section'  => 'education_general_favicon',
		'settings' => 'education_favicon',
	) ) );

	// Page layout
	$wp_customize->add_section( 'education_general_layout', array(
		'priority'       => 50,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Layout' , 'education-lite'),
		'description'    => esc_html__( 'Choose a layout for your theme pages. Note that a widget has to be inside widget are, or the layout won\'t change.' , 'education-lite'),
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
				'full' => esc_html__('Full', 'education-lite'),
				'right' => esc_html__('Right', 'education-lite')
			)
		)
	);

	// Header text
	$wp_customize->add_section( 'education_header_text', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Header text' , 'education-lite'),
		'description'    => esc_html__( 'An text for your header.' , 'education-lite'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headertext', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headertext',
		array(
			'label'      => esc_html__('Header text', 'education-lite'),
			'section'    => 'education_header_text',
			'type'       => 'text',
		)
	);

	// Header email
	$wp_customize->add_section( 'education_header_email', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Email' , 'education-lite'),
		'description'    => esc_html__( 'An email address for your theme header.' , 'education-lite'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headeremail', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headeremail',
		array(
			'label'      => esc_html__('Email', 'education-lite'),
			'section'    => 'education_header_email',
			'type'       => 'text',
		)
	);

	// Header phone
	$wp_customize->add_section( 'education_header_phone', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Phone' , 'education-lite'),
		'description'    => esc_html__( 'An Phone number for your theme header.' , 'education-lite'),
		'panel'          => 'education_header_panel'
	) );

	$wp_customize->add_setting( 'education_headerphone', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_headerphone',
		array(
			'label'      => esc_html__('Phone', 'education-lite'),
			'section'    => 'education_header_phone',
			'type'       => 'text',
		)
	);

	// Google maps key
	$wp_customize->add_section( 'education_google_maps_key', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Google maps key' , 'education-lite'),
		'description'    => esc_html__( 'Google maps API key so theme can use Google maps API.' , 'education-lite'),
		'panel'          => 'education_general_panel'
	) );

	$wp_customize->add_setting( 'education_gmap_key', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'education_gmap_key',
		array(
			'label'      => esc_html__('Google maps key', 'education-lite'),
			'section'    => 'education_google_maps_key',
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
					<li class="documentation"><a href="http://documentation.cohhe.com/education" class="button button-primary button-hero" target="_blank"><?php _e( 'Documentation', 'education-lite' ); ?></a></li>
					<li class="social-twitter"><i class="twitter"></i><a href="https://twitter.com/Cohhe_Themes" target="_blank"><?php _e( 'Follow us on Twitter', 'education-lite' ); ?></a></li>
					<li class="social-facebook"><i class="facebook"></i><a href="https://www.facebook.com/cohhethemes" target="_blank"><?php _e( 'Join us on Facebook', 'education-lite' ); ?></a></li>
					<li class="social-googleplus"><i class="googleplus"></i><a href="https://plus.google.com/+Cohhe_Themes/posts" target="_blank"><?php _e( 'Join us on Google+', 'education-lite' ); ?></a></li>
					<li class="social-cohhe"><i class="cohhe_logo"></i><a href="http://cohhe.com/" target="_blank"><?php _e( 'Cohhe.com', 'education-lite' ); ?></a></li>
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
		'id'      => 'education-lite',
		'title'   => esc_html__( 'Education 1.0', 'education-lite' ),
		'content' =>
			'<ul>' .
				'<li>' . sprintf( esc_html__( 'The home page features your choice of up to 6 posts prominently displayed in a grid or slider, controlled by the <a href="%1$s">featured</a> tag; you can change the tag and layout in <a href="%2$s">Appearance &rarr; Customize</a>. If no posts match the tag, <a href="%3$s">sticky posts</a> will be displayed instead.', 'education-lite' ), admin_url( '/edit.php?tag=featured' ), admin_url( 'customize.php' ), admin_url( '/edit.php?show_sticky=1' ) ) . '</li>' .
				'<li>' . sprintf( esc_html__( 'Enhance your site design by using <a href="%s">Featured Images</a> for posts you&rsquo;d like to stand out (also known as post thumbnails). This allows you to associate an image with your post without inserting it. Education 1.0 uses featured images for posts and pages&mdash;above the title&mdash;and in the Featured Content area on the home page.', 'education-lite' ), 'http://codex.wordpress.org/Post_Thumbnails#Setting_a_Post_Thumbnail' ) . '</li>' .
				'<li>' . sprintf( esc_html__( 'For an in-depth tutorial, and more tips and tricks, visit the <a href="%s">Education 1.0 documentation</a>.', 'education-lite' ), 'http://codex.wordpress.org/Education' ) . '</li>' .
			'</ul>',
	) );
}
add_action( 'admin_head-themes.php', 'education_contextual_help' );
add_action( 'admin_head-edit.php',   'education_contextual_help' );
