<?php
/*
Plugin Name: Penci PenNews Slider
Plugin URI: http://pencidesign.com/
Description: Add new 2 styles slider for Pennews theme.
Version: 2.0
Author: PenciDesign
Author URI: http://themeforest.net/user/pencidesign?ref=pencidesign
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Penci_PenNew_Slider' ) ):
class Penci_PenNew_Slider{
	public function __construct() {

		define( 'PENCI_PENNEWS_DIR', plugin_dir_path( __FILE__ ) );
		define( 'PENCI_PENNEWS_URL', plugin_dir_url( __FILE__ ) );

		// Register Post Type
		add_action( 'init', array( $this, 'register_slider' ) );
		//add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu') , 9999 );
		add_filter( 'single_template', array( $this, 'fix_single_template' ) );
		add_action( 'admin_footer', array(  $this, 'add_script' ) );

		// add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

		$this->load_files();
	}


    public function register_scripts() {
        wp_register_script('jarallax', PENCI_PENNEWS_URL . 'js/jarallax.min.js', array('jquery'), '1.9.0');
        wp_register_script('jarallax-video', PENCI_PENNEWS_URL . 'js/jarallax-video.min.js', array('jarallax'), '1.9.0');
    }


	public function fix_single_template( $single_template ) {
		global $post;

		if ( $post->post_type == 'penci_slider' ) {

			$single_template = dirname(__FILE__) . '/inc/single-slider.php';

		}

		return $single_template;

	}

	/**
	 * Load all file
	 */
	public function load_files() {

		if( is_admin() ){
			require_once dirname( __FILE__ ) . '/inc/metabox.php';
			new Penci_PenNew_Slider_MetaBox();

			require_once dirname( __FILE__ ) . '/inc/vc-shortcode.php';
			new Penci_PenNew_Slider_VC_Shortcode();
		}


		require_once dirname( __FILE__ ) . '/inc/shortcode.php';
		new Penci_PenNew_Slider_Shortcode();


	}

	public function register_slider() {
		
		$labels = array(
			'name'          => esc_html__( 'Slides', 'taxonomy general name', 'penci-framework' ),
			'singular_name' => esc_html__( 'Slide', 'penci-framework' ),
			'search_items'  => esc_html__( 'Search Slides', 'penci-framework' ),
			'all_items'     => esc_html__( 'All Slides', 'penci-framework' ),
			'parent_item'   => esc_html__( 'Parent Slide', 'penci-framework' ),
			'edit_item'     => esc_html__( 'Edit Slide', 'penci-framework' ),
			'update_item'   => esc_html__( 'Update Slide', 'penci-framework' ),
			'add_new_item'  => esc_html__( 'Add New Slide', 'penci-framework' ),
			'menu_name'     => esc_html__( 'Penci Slider', 'penci-framework' )
		);

		$args = array(
			'labels'              => $labels,
			'singular_label'      => esc_html__( 'Penci Slider', 'penci-framework' ),
			'public'              => true,
			'show_ui'             => true,
			'hierarchical'        => false,
			'menu_position'       => 10,
			'menu_icon'           => 'dashicons-images-alt2',
			'exclude_from_search' => true,
			'supports'            => array( 'title' )
		);

		register_post_type( 'penci_slider', $args );
		
	}

	/**
	 * Add admin bar menu
	 * @global      $menu , $submenu, $wp_admin_bar
	 * @return      void
	 */
	public function admin_bar_menu() {
		global $menu, $submenu, $wp_admin_bar;

		if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
			return;
		}
		$args = array(
			'id'    => 'penci-slider',
			'title' =>  esc_html( 'Penci Slider', 'penci-framework' ),
			'href'  => admin_url( 'edit.php?post_type=penci_slider' ),
			'meta'  => array( 'class' => 'penci-slider' )
		);
		$wp_admin_bar->add_node( $args );
	}

	public function show_slider_preview( $slider_id ){
		wp_enqueue_media();
	?>
		<div class="media-modal wp-core-ui hidden slider_preview-<?php echo $slider_id; ?>" style="top:50px;">
			<a class="media-modal-close" href="#"><span class="media-modal-icon"></span></a>
			<div class="media-modal-content">
				<div class="media-frame hide-menu hide-router">
					<div class="media-frame-title">
						<h1>Preview slider</h1>
					</div>
					<div class="media-frame-content">
						<iframe style="width: 100%;height:100%;" src="<?php the_permalink(); ?>"></iframe>
					</div>
					<!-- .media-frame-content -->
					<div class="media-frame-toolbar">
						<div class="media-toolbar">
							<div class="media-toolbar-primary">
								<div class="button media-button button-primary button-large media-button-select">Shortcode of slider: [penci_custom_slider id="<?php echo $slider_id; ?>"]</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	<?php
	}


	public function add_script() {
		?>
		<script>
		jQuery( function ( $ )
		{
			'use strict';
			
			$( '.penci_slider-preview' ).on( 'click', function ( e )
			{
				e.preventDefault();
				var $id_slider = $( this ).attr("data-slider_id");

				$( '.slider_preview-' + $id_slider ).removeClass( 'hidden' );
			} );

			$( 'body' ).on( 'click', '.media-modal-close', function ()
			{
				$( this ).parent().addClass( 'hidden' );
			} );
		} );
			
		</script>
		<?php
	}


}

endif;	

new Penci_PenNew_Slider();