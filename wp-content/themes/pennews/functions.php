<?php

/**
 * PenNews functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PenNews
 */

define( 'PENCI_PENNEWS_VERSION', '6.0');

if ( ! function_exists( 'penci_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 */
	function penci_setup() {

		load_theme_textdomain( 'pennews', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'penci-thumb-480-645', 480, 645, true ); // 1 - 1.3448
		add_image_size( 'penci-thumb-480-480', 480, 480, true ); // 1
		add_image_size( 'penci-thumb-480-320', 480, 320, true ); // 1.5

		add_image_size( 'penci-thumb-280-376', 280, 376, true ); // 1 - 1.3448
		add_image_size( 'penci-thumb-280-186', 280, 186, true ); // 1.5
		add_image_size( 'penci-thumb-280-280', 280, 280, true ); // 1.1

		add_image_size( 'penci-thumb-760-570', 760, 570, true ); // 1.3
		add_image_size( 'penci-thumb-1920-auto', 1920, 999999, false );
		add_image_size( 'penci-thumb-960-auto', 960, 999999, false );
		add_image_size( 'penci-thumb-auto-400', 999999, 400, false );
		add_image_size( 'penci-masonry-thumb', 585, 99999, false );

		add_theme_support( 'post-formats', array( 'gallery', 'audio', 'video' ) );

		add_editor_style( array( penci_fonts_url(), get_template_directory_uri() . '/css/font-awesome.min.css', 'css/editor-style.css', ) );

		register_nav_menus( array(
				'menu-1' => esc_html__( 'Primary', 'pennews' ),
				'menu-2' => esc_html__( 'Footer', 'pennews' ),
				'menu-3' => esc_html__( 'Topbar', 'pennews' ),
			)
		);

		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );
		add_theme_support( 'custom-background', apply_filters( 'penci_custom_background_args', array( 'default-color' => '', 'default-image' => '', ) ) );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'yoast-seo-breadcrumbs' );
	}
endif;
add_action( 'after_setup_theme', 'penci_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function penci_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'penci_content_width', 1400 );
}

add_action( 'after_setup_theme', 'penci_content_width', 0 );

require get_template_directory() . '/inc/default.php';
require get_template_directory() . '/inc/transition-default.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/fonts.php';
require get_template_directory() . '/inc/self-fonts.php';
require get_template_directory() . '/inc/media.php';
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/excerpt.php';
require get_template_directory() . '/inc/jetpack.php';
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/social-media.php';
require get_template_directory() . '/inc/social-share.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/post-format/post-format.php';
require get_template_directory() . '/inc/custom-css/custom-css.php';
require get_template_directory() . '/inc/max-mega-menu/max-mega-menu.php';
require get_template_directory() . '/inc/login-popup.php';
require get_template_directory() . '/inc/woocommerce.php';
require get_template_directory() . '/inc/single-loadmore.php';
require get_template_directory() . '/inc/ajaxified-search.php';
require get_template_directory() . '/inc/json-schema-validar.php';
require get_template_directory() . '/inc/multiple-comments.php';

require get_template_directory() . '/inc/custom-sidebar.php';
Penci_Custom_Sidebar::initialize();

/**
 * Load dashboard
 */
require get_template_directory() . '/inc/dashboard/class-penci-dashboard.php';
$dashboard = new Penci_Dashboard();

if ( is_admin() ) {
	require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
	require_once get_template_directory() . '/inc/admin/plugins.php';
}
remove_action( 'wp_head', 'rest_output_link_wp_head' );

require_once('wp-updates-theme.php');
new WPUpdatesThemeUpdater_2239( 'http://wp-updates.com/api/2/theme', basename( get_template_directory() ) );

/**
 * Disable VC check license whenever update
 *
 * @see js_composer\include\classes\updaters\class-vc-updater.php
 * @see js_composer\include\classes\updaters\class-vc-updating-manager.php
 */
if ( ! function_exists( 'penci_fix_update_vc' ) ):
	function penci_fix_update_vc() {
		if ( function_exists( 'vc_license' ) && function_exists( 'vc_updater' ) && ! vc_license()->isActivated() ) {

			remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10 );
			remove_filter( 'pre_set_site_transient_update_plugins', array( vc_updater()->updateManager(), 'check_update' ) );

			if ( function_exists( 'vc_plugin_name' ) ) {
				remove_filter( 'in_plugin_update_message-' . vc_plugin_name(), array( vc_updater()->updateManager(), 'addUpgradeMessageLink', ) );
			}
		}
	}

	add_action( 'admin_init', 'penci_fix_update_vc', 9 );
endif;

function exclude_widget_categories($args){
    $exclude = "24,40";
    $args["exclude"] = $exclude;
    return $args;
}
add_filter("widget_categories_args","exclude_widget_categories");
function exclude_posts_from_recentPostWidget_by_cat() {
    $exclude = array( 'cat' => '-35,-40' );
    return $exclude;
}
add_filter('widget_posts_args','exclude_posts_from_recentPostWidget_by_cat');

function my_edit_per_page( $result, $option, $user ) {
    if ( (int)$result < 1 )
        return 20; // or whatever you want
}
add_filter( 'get_user_option_edit_page_per_page', 'my_edit_per_page', 10, 3 );  // for pages
add_filter( 'get_user_option_edit_post_per_page', 'my_edit_per_page', 10, 3 );  // for posts


//custom login 
function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
	}
	add_action('login_head', 'my_custom_login');
function login_checked_remember_me() {
add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );
		
function rememberme_checked() {
echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
function my_login_logo_url() {
	return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'my_login_logo_url' );
	
	function my_login_logo_url_title() {
	return 'Vũ Võ Bình Định';
	}
	add_filter( 'login_headertitle', 'my_login_logo_url_title' );
	function custom_login_logo() {
		echo '<style type ="text/css">.login h1 a { display:none!important; }  p#nav { display:none!important; }</style>';
	}
	
	add_action('login_head', 'custom_login_logo');
//custom footer admin
function remove_footer_admin () 
{
    echo '<span id="footer-thankyou">Phát triển bởi <a href="http://www.itajsc.com" target="_blank">ITAJSC</a></span>';
}
 
add_filter('admin_footer_text', 'remove_footer_admin');
function my_footer_shh() {
    remove_filter( 'update_footer', 'core_update_footer' ); 
}

add_action( 'admin_menu', 'my_footer_shh' );

//----------------hide information about wordpress----------------
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');
// Hide WordPress Version Info
function hide_wordpress_version() {
	return '';
}
add_filter('the_generator', 'hide_wordpress_version');

// Remove WordPress Version Number In URL Parameters From JS/CSS
function hide_wordpress_version_in_script($src, $handle) {
    $src = remove_query_arg('ver', $src);
	return $src;
}
add_filter( 'style_loader_src', 'hide_wordpress_version_in_script', 10, 2 );
add_filter( 'script_loader_src', 'hide_wordpress_version_in_script', 10, 2 );
// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

function wpb_disable_feed() {
	wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
	}
	 
	add_action('do_feed', 'wpb_disable_feed', 1);
	add_action('do_feed_rdf', 'wpb_disable_feed', 1);
	add_action('do_feed_rss', 'wpb_disable_feed', 1);
	add_action('do_feed_rss2', 'wpb_disable_feed', 1);
	add_action('do_feed_atom', 'wpb_disable_feed', 1);
	add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
	add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);

//-------------------------------------------------------------------------
