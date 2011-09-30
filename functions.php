<?php
/**
 * Infinitus functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, infinitus_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'infinitus_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * Infinitus HTML 5 theme is inspired by Wordpress Twenty_Eleven
 *
 * @package WordPress
 * @subpackage Infinitus
 * @since Infinitus 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 680;

/** Tell WordPress to run infinitus_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'infinitus_setup' );

if ( ! function_exists( 'infinitus_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override infinitus_setup() in a child theme, add your own infinitus_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Infinitus 1.0
 */
function infinitus_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	//add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote') );
	
	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'infinitus', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
			
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'infinitus' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();
	
	// this add postformat to page
	add_post_type_support( 'page', 'post-formats' );
	
	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to infinitus_header_image_width and infinitus_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'infinitus_header_image_width', 990 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'infinitus_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See infinitus_admin_header_style(), below.
	add_custom_image_header( '', 'infinitus_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'infinitus' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'infinitus' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'infinitus' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'infinitus' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'infinitus' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'infinitus' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'infinitus' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'infinitus' )
		)
	) );
	
	if (!is_admin() && get_option('infinitus_jquery') == 1) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js');
    }
	wp_enqueue_script( 'jquery' );
	
	if (!is_admin() && get_option('infinitus_html5js') == 1) {
        wp_deregister_script( 'html5js' );
        wp_register_script( 'html5js', content_url().'/themes/infinitus/js/ie_add_html5_elements_to_dom.js');
    }
    wp_enqueue_script( 'html5js' );
	
}
endif;

if ( ! function_exists( 'infinitus_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in infinitus_setup().
 *
 * @since Infinitus 1.0
 */
function infinitus_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 1px solid #000;
}
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Infinitus 1.0
 */
function infinitus_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'infinitus_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Infinitus 1.0
 * @return int
 */
function infinitus_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'infinitus_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Infinitus 1.0
 * @return string "Continue Reading" link
 */
function infinitus_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infinitus' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and infinitus_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Infinitus 1.0
 * @return string An ellipsis
 */
function infinitus_auto_excerpt_more( $more ) {
	return ' &hellip;' . infinitus_continue_reading_link();
}
add_filter( 'excerpt_more', 'infinitus_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Infinitus 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function infinitus_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= infinitus_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'infinitus_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Infinitus 1.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Infinitus 1.0
 * @deprecated Deprecated in Infinitus for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function infinitus_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'infinitus_remove_gallery_css' );

if ( ! function_exists( 'infinitus_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own infinitus_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Infinitus 1.0
 */
function infinitus_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'infinitus' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'infinitus' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'infinitus' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'infinitus' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'infinitus' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'infinitus' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override infinitus_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Infinitus 1.0
 * @uses register_sidebar
 */
function infinitus_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'infinitus' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'infinitus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'infinitus' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'infinitus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'infinitus' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'infinitus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'infinitus' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'infinitus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'infinitus' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'infinitus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'infinitus' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'infinitus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 7, located in the top of the page. Empty by default.
	register_sidebar( array(
		'name' => __( 'Top Page Widget Area', 'infinitus' ),
		'id' => 'top-page-widget-area',
		'description' => __( 'Top Page Widget Area', 'infinitus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	
	// Area 8, located in the bottom of the page. Empty by default.
	register_sidebar( array(
		'name' => __( 'Bottom Page Widget Area', 'infinitus' ),
		'id' => 'bottom-page-widget-area',
		'description' => __( 'Bottom Page Widget Area', 'infinitus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 9, located in the top of the index (home) page. Empty by default.
	register_sidebar( array(
		'name' => __( 'Home top Page Widget Area', 'infinitus' ),
		'id' => 'home-top-page-widget-area',
		'description' => __( 'Home top Page Widget Area', 'infinitus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Area 10, located in the top of the index (home) page. Empty by default.
	register_sidebar( array(
		'name' => __( 'Home top description Page Widget Area', 'infinitus' ),
		'id' => 'home-top-description-page-widget-area',
		'description' => __( 'Home top description Page Widget Area', 'infinitus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
}
/** Register sidebars by running infinitus_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'infinitus_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Infinitus in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Infinitus 1.0
 */
function infinitus_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'infinitus_remove_recent_comments_style' );


/**
 *
 * This function print infinitus credits
 *
 * @since Infinitus 1.0
 */
function infinitus_print_credits() {
	printf( __( '<div id="%1$s">Infinitus Theme</div>', 'infinitus' ),
		'infinitus_credits');
}
add_action( 'infinitus_credits', 'infinitus_print_credits' );


if ( ! function_exists( 'infinitus_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Infinitus 1.0
 */
function infinitus_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'infinitus' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'infinitus' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'infinitus_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Infinitus 1.0
 */
function infinitus_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'infinitus' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'infinitus' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'infinitus' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;


/**
 * add custom settings.
 *
 * @since Infinitus 1.0
 */
function infinitus_settings_api_init() {

	add_settings_section('infinitus_setting_section',
		__('Infinitus Advenced Settings'),
		'infinitus_setting_section_callback_function',
		'general');
		
	
	add_settings_field('infinitus_jquery',
		__('JavaScript Framework :'),
		'infinitus_jquery_setting_callback_function',
		'general',
		'infinitus_setting_section');
		
	
	register_setting('general','infinitus_jquery');
	
	add_settings_field('infinitus_html5js',
		__('Add Html5 tag to the DOM:'),
		'infinitus_html5js_setting_callback_function',
		'general',
		'infinitus_setting_section');
		
	register_setting('general','infinitus_html5js');

}

function infinitus_setting_section_callback_function() {
 	echo '<p>'.__('Infinitus Thèmes Advenced Settings').'</p>';
}

function infinitus_jquery_setting_callback_function() {
	echo '<input name="infinitus_jquery" id="infinitus_jquery" type="checkbox" value="1" class="code" ' . checked( 1, get_option('infinitus_jquery'), false ) . ' /> <a href="http://code.google.com/apis/libraries/devguide.html#jquery" target="_blank" title="Google CDN Jquery">'. __('Add Google CDN Jquery:').'1.6.1</a>';
}

function infinitus_html5js_setting_callback_function() {
	echo '<input name="infinitus_html5js" id="infinitus_html5js" type="checkbox" value="1" class="code" ' . checked( 1, get_option('infinitus_html5js'), false ) . ' /> '. __('for IE').'';
}


add_action('admin_init', 'infinitus_settings_api_init');


/**
 * add custom class for language.
 *
 * @since Infinitus 1.0
 */

function infinitus_body_class($classes) {
	// add 'class-name' to the $classes array
	$classes[] = get_locale();
	// return the $classes array
	return $classes;
}

add_filter('body_class','infinitus_body_class');