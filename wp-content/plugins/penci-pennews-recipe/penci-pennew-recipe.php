<?php
/*
Plugin Name: Penci PenNews Recipe
Plugin URI: http://pencidesign.com/
Description: Recipe Shortcode Plugin for PenNews theme.
Version: 2.5
Author: PenciDesign
Author URI: http://themeforest.net/user/pencidesign?ref=pencidesign
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load plugin textdomain.
 *
 * @since 2.5
 */
add_action( 'plugins_loaded', 'penci_pennews_recipe_load_textdomain' );

if( !function_exists( 'penci_pennews_recipe_load_textdomain' ) ) {
	function penci_pennews_recipe_load_textdomain() {
		load_plugin_textdomain( 'pennews', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
}

/**
 * Include files
 */
require_once( dirname( __FILE__ ) . '/inc/shortcodes.php' );
require_once( dirname( __FILE__ ) . '/inc/customize.php' );

/**
 * Add admin meta box style
 */
if( ! function_exists( 'penci_pennews_load_admin_metabox_style' ) ) {
	function penci_pennews_load_admin_metabox_style() {
		$screen = get_current_screen();
		if ( $screen->id == 'post' ) {
			wp_enqueue_style( 'penci_meta_box_styles', plugin_dir_url( __FILE__ ) . 'css/admin-css.css' );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'penci_pennews_load_admin_metabox_style' );

/**
 * Add jquery print
 */
add_action( 'wp_enqueue_scripts', 'penci_pennews_register_recipe_print_scripts' );

if( ! function_exists( 'penci_pennews_register_recipe_print_scripts' ) ) {
	function penci_pennews_register_recipe_print_scripts() {
		wp_register_script( 'jquery-recipe-print', plugin_dir_url( __FILE__ ) . 'js/print.js', array( 'jquery' ), '2.5', true );

		wp_enqueue_script( 'jquery-recipe-rateyo', plugin_dir_url( __FILE__ ) . 'js/jquery.rateyo.min.js', array('jquery'), '2.3', true );

		if ( ! get_theme_mod( 'penci_recipe_rating' ) ) {
			wp_enqueue_script( 'penci_rateyo', plugin_dir_url( __FILE__ ) . 'js/rating_recipe.js', array( 'jquery' ), '2.3.2', true );

			$normal_fill = get_theme_mod( 'penci_review_rating_normalFill' );
			$rated_fill = get_theme_mod( 'penci_review_rating_ratedFill' );

			$localize_script = array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'ajax-nonce' ),
				'normalFill' => $normal_fill ? $normal_fill : '#b9b9b9',
				'ratedFill'  => $rated_fill ? $rated_fill : '#FFCA00'
			);
			wp_localize_script( 'penci_rateyo', 'PENCI', $localize_script );
		}
	}
}


/**
 * Functions callback when rating voted
 *
 * @since 1.0
 */
if ( ! function_exists( 'penci_pennews_rateyo' ) ) {
	add_action('wp_ajax_nopriv_penci_pennews_rateyo', 'penci_pennews_rateyo');
	add_action('wp_ajax_penci_pennews_rateyo', 'penci_pennews_rateyo');
	function penci_pennews_rateyo() {
		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
			die ( 'Nope!' );

		$postid = $_POST['postid'];
		$rating = $_POST['rating'];

		$update_rate_total = $update_rate_people = '';

		if ( !empty( $postid ) ) {
			$post = get_post( $postid );
			if ( $post ) {
				// Get rate meta in post
				$rate_total 	= get_post_meta( $post->ID, 'penci_recipe_rate_total', true );
				$rate_people 	= get_post_meta( $post->ID, 'penci_recipe_rate_people', true );

				// Update rate meta to post
				$update_rate_total = intval( $rating ) + intval( $rate_total );
				update_post_meta( $post->ID, 'penci_recipe_rate_total', $update_rate_total );
				$update_rate_people = intval( $rate_people ) + 1;
				update_post_meta( $post->ID, 'penci_recipe_rate_people', $update_rate_people );

				setcookie( 'recipe_rate_postid_'.$postid, rand(), time() + (86400 * 30), "/");
			}
		}

		wp_reset_postdata();
		wp_send_json_success( array( 'rate_total' => $update_rate_total, 'rate_people' => $update_rate_people ) );
	}
}

/**
 * Adds Penci Recipe meta box to the post editing screen
 */
if( ! function_exists( 'Penci_Pennews_Recipe_Add_Custom_Metabox' ) ){
	function Penci_Pennews_Recipe_Add_Custom_Metabox() {
		new Penci__Recipe_Add_Custom_Metabox_Class();
	}

}
if ( is_admin() ) {
	add_action( 'load-post.php', 'Penci_Pennews_Recipe_Add_Custom_Metabox' );
	add_action( 'load-post-new.php', 'Penci_Pennews_Recipe_Add_Custom_Metabox' );
}

if( !class_exists( 'Penci__Recipe_Add_Custom_Metabox_Class' ) ):
class Penci__Recipe_Add_Custom_Metabox_Class {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array( 'post' );     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'penci_recipe_meta'
				, esc_html__( 'Recipe For This Posts', 'pennews' )
				, array( $this, 'render_meta_box_content' )
				, $post_type
				, 'advanced'
				, 'default'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['penci_recipe_custom_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['penci_recipe_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'penci_recipe_custom_box' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		//     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Update the meta field.
		$penci_recipe = array(
			'penci_recipe_title'           => isset( $_POST['penci_recipe_title'] ) ? $_POST['penci_recipe_title'] : '',
			'penci_recipe_servings'        => isset( $_POST['penci_recipe_servings'] ) ? $_POST['penci_recipe_servings'] : '',
			'penci_recipe_preptime'        => isset( $_POST['penci_recipe_preptime'] ) ? $_POST['penci_recipe_preptime'] : '',
			'penci_recipe_preptime_format' => isset( $_POST['penci_recipe_preptime_format'] ) ? $_POST['penci_recipe_preptime_format'] : '',
			'penci_recipe_cooktime'        => isset( $_POST['penci_recipe_cooktime'] ) ? $_POST['penci_recipe_cooktime'] : '',
			'penci_recipe_cooktime_format' => isset( $_POST['penci_recipe_cooktime_format'] ) ? $_POST['penci_recipe_cooktime_format'] : '',
			'penci_recipe_calories'        => isset( $_POST['penci_recipe_calories'] ) ? $_POST['penci_recipe_calories'] : '',
			'penci_recipe_fat'             => isset( $_POST['penci_recipe_fat'] ) ? $_POST['penci_recipe_fat'] : '',
			'penci_recipe_instructions'    => isset( $_POST['penci_recipe_instructions'] ) ? $_POST['penci_recipe_instructions'] : '',
			'penci_recipe_ingredients'     => isset( $_POST['penci_recipe_ingredients'] ) ? $_POST['penci_recipe_ingredients'] : '',
			'penci_recipe_note'            => isset( $_POST['penci_recipe_note'] ) ? $_POST['penci_recipe_note'] : '',
		);

		update_post_meta( $post_id, 'penci_recipe', $penci_recipe );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'penci_recipe_custom_box', 'penci_recipe_custom_box_nonce' );

		$penci_recipe = get_post_meta( $post->ID, 'penci_recipe', true );

		// Use get_post_meta to retrieve an existing value from the database.
		$recipe_title          = isset( $penci_recipe['penci_recipe_title'] ) ? $penci_recipe['penci_recipe_title'] : '';
		$recipe_servings       = isset( $penci_recipe['penci_recipe_servings'] ) ? $penci_recipe['penci_recipe_servings'] : '';
		$recipe_preptime       = isset( $penci_recipe['penci_recipe_preptime'] ) ? $penci_recipe['penci_recipe_preptime'] : '';
		$recipe_preptime_fm    = isset( $penci_recipe['penci_recipe_preptime_format'] ) ? $penci_recipe['penci_recipe_preptime_format'] : '';
		$recipe_cooktime       = isset( $penci_recipe['penci_recipe_cooktime'] ) ? $penci_recipe['penci_recipe_cooktime'] : '';
		$recipe_cooktime_fm    = isset( $penci_recipe['penci_recipe_cooktime_format'] ) ? $penci_recipe['penci_recipe_cooktime_format'] : '';
		$penci_recipe_calories = isset( $penci_recipe['penci_recipe_calories'] ) ? $penci_recipe['penci_recipe_calories'] : '';
		$penci_recipe_fat      = isset( $penci_recipe['penci_recipe_fat'] ) ? $penci_recipe['penci_recipe_fat'] : '';
		$recipe_ingredients    = isset( $penci_recipe['penci_recipe_ingredients'] ) ? $penci_recipe['penci_recipe_ingredients'] : '';
		$recipe_instructions   = isset( $penci_recipe['penci_recipe_instructions'] ) ? $penci_recipe['penci_recipe_instructions'] : '';
		$recipe_note           = isset( $penci_recipe['penci_recipe_note'] ) ? $penci_recipe['penci_recipe_note'] : '';

		// Display the form, using the current value.
		?>

		<div class="penci-table-meta">
			<h3>Your Recipes</h3>
			<p>You can display your recipe for this post by using the following shortcode: <span class="penci-recipe-shortcode">[penci_recipe]</span>
				<br>If you do not need this feature, you should go to <strong>Plugins > Installed Plugins > and deactivate plugin "Penci Recipe"</strong>
				<br>Check options for Recipe/Recipe Index via <strong>Appearance > Customize > Recipe Options</strong></p>
			<p>
				<label for="penci_recipe_title" class="penci-format-row penci-format-recipe">Recipe Title:</label>
				<input style="width:100%;" type="text" name="penci_recipe_title" id="penci_recipe_title" value="<?php if ( isset( $recipe_title ) ): echo $recipe_title; endif; ?>">
			</p>
			<p>
				<label for="penci_recipe_servings" class="penci-format-row penci-format-recipe">Servings for:</label>
				<input style="width:100px;" type="text" name="penci_recipe_servings" id="penci_recipe_servings" value="<?php if ( isset( $recipe_servings ) ): echo $recipe_servings; endif; ?>">
				<span class="penci-recipe-description">Example: 4</span>
			</p>
			<p>
				<label for="penci_recipe_preptime" class="penci-format-row penci-format-recipe">Prep Time:</label>
				<input style="width:100px;" type="text" name="penci_recipe_preptime" id="penci_recipe_preptime" value="<?php if ( isset( $recipe_preptime ) ): echo $recipe_preptime; endif; ?>">
				<span class="penci-recipe-description">Example: 1 Hour</span>
			</p>
			<p>
				<label for="penci_recipe_preptime_format" class="penci-format-row penci-format-recipe">Prep Time Structured Data Format:</label>
				<input style="width:100px;" type="text" name="penci_recipe_preptime_format" id="penci_recipe_preptime_format" value="<?php if ( isset( $recipe_preptime_fm ) ): echo $recipe_preptime_fm; endif; ?>">
				<span class="penci-recipe-description">This is Structured Data time format for Prep Time, Google and other the search engines will read it. Example: If the Prep Time is: 2 Hours 30 Minutes, you need fill here: <strong>2H30M</strong> | If the Prep Time is: 40 Minutes, you need fill here: <strong>40M</strong> | If the Prep Time is: 2 Hours, you need fill here: <strong>2H</strong>. All characters need uppercase.</span>
			</p>
			<p>
				<label for="penci_recipe_cooktime" class="penci-format-row penci-format-recipe">Cooking Time:</label>
				<input style="width:100px;" type="text" name="penci_recipe_cooktime" id="penci_recipe_cooktime" value="<?php if ( isset( $recipe_cooktime ) ): echo $recipe_cooktime; endif; ?>">
				<span class="penci-recipe-description">Example: 30 Minutes</span>
			</p>
			<p>
				<label for="penci_recipe_cooktime_format" class="penci-format-row penci-format-recipe">Cooking Time Structured Data Format:</label>
				<input style="width:100px;" type="text" name="penci_recipe_cooktime_format" id="penci_recipe_cooktime_format" value="<?php if ( isset( $recipe_cooktime_fm ) ): echo $recipe_cooktime_fm; endif; ?>">
				<span class="penci-recipe-description">This is Structured Data time format for Cooking Time, Google and other the search engines will read it. Example: If the Prep Time is: 2 Hours 30 Minutes, you need fill here: <strong>2H30M</strong> | If the Prep Time is: 40 Minutes, you need fill here: <strong>40M</strong> | If the Prep Time is: 2 Hours, you need fill here: <strong>2H</strong>. All characters need uppercase.</span>
			</p>
			<p>
				<label for="penci_recipe_calories" class="penci-format-row penci-format-recipe">Number calories for this recipe:</label>
				<input style="width:100px;" type="text" name="penci_recipe_calories" id="penci_recipe_calories" value="<?php if( isset( $penci_recipe_calories ) ): echo $penci_recipe_calories; endif; ?>">
				<span class="penci-recipe-description">Fill number calories for your recipe here. Example: <strong>200</strong></span>
			</p>
			<p>
				<label for="penci_recipe_fat" class="penci-format-row penci-format-recipe">Number fat for this recipe:</label>
				<input style="width:100px;" type="text" name="penci_recipe_fat" id="penci_recipe_fat" value="<?php if( isset( $penci_recipe_fat ) ): echo $penci_recipe_fat; endif; ?>">
				<span class="penci-recipe-description">Fill the fat for your recipe here. Example: <strong>25 grams</strong></span>
			</p>

			<div class="penci-row-editor">
				<label for="penci_recipe_ingredients" class="penci-format-row penci-format-recipe">Ingredients:</label>
				<?php if( ! get_theme_mod( 'penci_recipe_ingredients_visual' ) ){ ?>
					<textarea style="width:100%; height:180px;" name="penci_recipe_ingredients" id="penci_recipe_ingredients"><?php if( isset( $recipe_ingredients ) ): echo $recipe_ingredients; endif; ?></textarea>
					<span class="penci-recipe-description">Type each ingredient on a new line.<br>You can switch the Ingredients to visual editor via Customize > Recipe Options > Make Ingredients is Visual Editor on Edit Recipe Screen</span>
				<?php } else { ?>
					<?php wp_editor( htmlspecialchars_decode($recipe_ingredients) , 'penci_recipe_ingredients', array( "media_buttons" => true )); ?>
					<span class="penci-recipe-description">Type the ingredients for your recipe here</span>
				<?php } ?>
			</div>
			<div class="penci-row-editor">
				<label for="penci_recipe_instructions" class="penci-format-row penci-format-recipe row-block">Instructions:</label>
				<?php wp_editor( htmlspecialchars_decode( $recipe_instructions ), 'penci_recipe_instructions', array( "media_buttons" => true ) ); ?>
				<span class="penci-recipe-description">Type the instructions for your recipe here</span>
			</div>
			<p>
				<label for="penci_recipe_note" class="penci-format-row penci-format-recipe">Notes:</label>
				<textarea style="width:100%; height:90px;" name="penci_recipe_note" id="penci_recipe_note"><?php if ( isset( $recipe_note ) ): echo $recipe_note; endif; ?></textarea>
				<span class="penci-recipe-description">If you have any additional notes you can write them here.</span>
			</p>
		</div>
		<?php
	}
}
endif;