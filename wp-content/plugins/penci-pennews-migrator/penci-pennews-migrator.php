<?php
/*
Plugin Name: Penci PenNews Migrator
Plugin URI: http://pencidesign.com/
Description:  Plugin for switch to PenNews without losing data
Version: 1.2
Author: PenciDesign
Author URI: http://pencidesign.com/
License: GPLv2 or later
Text Domain: penci-pennews-migrator
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PENCI_MIGRATOR_VERSION', '1.1' );
define( 'PENCI_MIGRATOR_DIR', plugin_dir_path( __FILE__ ) );
define( 'PENCI_MIGRATOR_URL', plugin_dir_url( __FILE__ ) );

if(  ! class_exists( 'Penci_PenNews_Migrator' ) ) {
	class Penci_PenNews_Migrator{
		public function __construct() {
			// Run only admin
			if( ! is_admin() ) {
				return;
			}

			add_action( 'init', array( $this, 'hooks' ) );

			$this->load_files();

			if( ! get_option( 'pennews_migrator_post_ids' ) ) {
				update_option( 'pennews_migrator_post_ids', Penci_PenNews_MG_Helper::get_post_ids() );
			}
		}

		public function load_files(){
			require_once dirname( __FILE__ ) . '/inc/helper.php';
			require_once dirname( __FILE__ ) . '/inc/ajax-migrator.php';
		}

		public function hooks(){
			add_action( 'penci_migrator_panel', array( $this, 'migrator_panel' ),99 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_menu', array( $this, 'menu' ) );
		}

		/**
		 * Enqueue scripts for dashboard page.
		 *
		 * @param string $hook Page hook.
		 */
		public function enqueue_scripts( $hook ) {
			if( 'pennews_page_pennews_migrator' == $hook || 'admin_page_pennews_migrator'== $hook  ){
				wp_enqueue_style( "penci-migrator",PENCI_MIGRATOR_URL . 'assets/css/migrator.css',array(),PENCI_MIGRATOR_VERSION );
				wp_enqueue_script( "penci-migrator",PENCI_MIGRATOR_URL . 'assets/js/migrator.js', array( 'jquery','jquery-ui-progressbar' ), PENCI_MIGRATOR_VERSION );

				$localize_script = array(
					'postIds'    => Penci_PenNews_MG_Helper::get_post_ids(),
					'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
					'nonce'      => wp_create_nonce( 'ajax-nonce' ),
				);
				wp_localize_script( 'penci-migrator', 'PENCIDASHBOARD', $localize_script );
			}
		}

		/**
		 * Get icon penci
		 */
		function get_icon_penci() {
			?>
			<svg style="position: relative; top:4px;margin-right: 5px;" version="1.0" xmlns="http://www.w3.org/2000/svg"
			     width="18px" height="18px" viewBox="0 0 26.000000 26.000000"
			     preserveAspectRatio="xMidYMid meet">
				<g transform="translate(0.000000,26.000000) scale(0.100000,-0.100000)"
				   fill="#000000" stroke="none">
					<path d="M72 202 l-62 -60 0 -66 0 -66 125 0 125 0 0 61 0 61 -63 65 -62 64
				-63 -59z m73 28 c3 -5 -3 -10 -15 -10 -12 0 -18 5 -15 10 3 6 10 10 15 10 5 0
				12 -4 15 -10z m57 -57 c34 -33 36 -38 20 -49 -14 -10 -21 -8 -45 12 -36 31
				-62 30 -93 -1 -21 -21 -28 -23 -44 -13 -19 12 -18 14 17 50 51 52 92 52 145 1z
				m-77 -93 c0 -59 -1 -60 -27 -60 -26 0 -28 3 -28 42 0 24 7 49 17 60 28 32 38
				21 38 -42z m49 44 c10 -9 16 -33 16 -60 0 -40 -2 -44 -25 -44 -24 0 -25 3 -25
				60 0 62 7 71 34 44z m-130 -20 c9 -8 16 -31 16 -50 0 -27 -4 -34 -20 -34 -17
				0 -20 7 -20 50 0 28 2 50 4 50 3 0 12 -7 20 -16z m201 -34 c0 -44 -3 -50 -20
				-50 -18 0 -20 5 -17 38 4 35 17 62 31 62 3 0 6 -22 6 -50z"/>
					<path d="M90 70 c0 -5 5 -10 10 -10 6 0 10 5 10 10 0 6 -4 10 -10 10 -5 0 -10
				-4 -10 -10z"/>
				</g>
			</svg>
			<?php
		}

		public function menu(){
			add_submenu_page(
				'pennews_dashboard_welcome',
				esc_html__( 'Migrator Data', 'pennews-migrator' ),
				esc_html__( 'Migrator Data', 'pennews-migrator' ),
				'manage_options',
				'pennews_migrator',
				array( $this, 'migrator_panel' ) );
		}

		public function migrator_panel(){
			$themes = Penci_PenNews_MG_Helper::get_themes_info();

			if( ! $themes  ) {
				return;
			}

			if( isset( $_GET['item'] ) ){
				$this->markup_migrate();
			}else{
				$this->markup_list_theme( $themes );
			}
		}

		public function markup_list_theme( $themes ){
			?>
			<div id="penci-migrator-theme" class="penci-migrator-theme">
				<input class="penci-migrator-search fuzzy-search" placeholder="<?php esc_html_e( 'Search a theme by theme name or author name','penci-pennews-migrator' ) ?>" />
				<ul class="list penci-theme-items">
					<?php
					foreach ( $themes as $theme_id => $theme_info ) {
						if( empty( $theme_id ) ) {
							continue;
						}

						echo '<li class="penci-theme-item">';
						echo '<a class="penci-theme-item-inner" href="' . admin_url( 'admin.php?page=pennews_migrator&item=' . $theme_id ) . '">';
						echo '<div class="penci-theme-img"><img src="' . PENCI_MIGRATOR_URL . '/thumbnails/' . $theme_id . '.png" alt="thumb"/></div>';
						echo '<div class="penci-theme-name name">' . $theme_info['theme_name'] . '</div>';
						echo '<div class="penci-theme-author author">' . $theme_info['author_name'] . '</div>';
						echo '</a>';
						echo '</li>';
					}
					?>
				</ul>
			</div>
			<?php
		}

		public function markup_migrate(){
			$theme_id   = $_GET['item'];
			$themes     = Penci_PenNews_MG_Helper::get_themes_info();
			$theme_info = $themes[ $theme_id ];
			?>
			<div class="penci-migration-page">
				<div class="penci-mg-form-header">
					<ul class="list penci-theme-items">
						<?php
						echo '<li class="penci-theme-item">';
						echo '<div class="penci-theme-item-inner">';
						echo '<div class="penci-theme-img"><img src="' . PENCI_MIGRATOR_URL . '/thumbnails/' . $theme_id . '.png" alt="thumb"/></div>';
						echo '<div class="penci-theme-name name">' . $theme_info['theme_name'] . '</div>';
						echo '<div class="penci-theme-author author">' . $theme_info['author_name'] . '</div>';
						echo '</div>';
						echo '</li>';

						echo '<li class="penci-theme-item penci-migrator-loading">';
						echo '<img src="' . PENCI_MIGRATOR_URL . '/thumbnails/arrow_right.png" alt="thumb"/>';
						echo '</li>';

						echo '<li class="penci-theme-item penci-theme-item-right">';
						echo '<div class="penci-theme-item-inner">';
						echo '<div class="penci-theme-img"><img src="' . PENCI_MIGRATOR_URL . '/thumbnails/pennews.png" alt="thumb"/></div>';
						echo '<div class="penci-theme-name name">PenNews</div>';
						echo '<div class="penci-theme-author author">PenciDesign</div>';
						echo '</div>';
						echo '</li>';
						?>
					</ul>
				</div>
				<div class="penci-mg-finished">
					<div class="penci-mg-message">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0" y="0" viewBox="0 0 774 774" xml:space="preserve" enable-background="new 0 0 774 774">
							<g id="icon--checkmark" fill="#47aa42">
								<path d="M387 0C173.3 0 0 173.3 0 387s173.3 387 387 387 387-173.3 387-387S600.7 0 387 0zM575.7 292.4L339.7 528.3c-0.2 0.2-0.4 0.3-0.6 0.5 -1.1 1.5-2.3 3.1-3.7 4.5 -14.1 14.1-36.9 14.1-51 0l-86.2-74.1c-14.1-14-14.1-36.8 0-50.9 14.1-14.1 36.8-14.1 50.9 0l57.8 49.6L524 240.7c14.3-14.3 37.4-14.3 51.7 0C589.9 255 589.9 278.1 575.7 292.4z"/>
							</g>
						</svg>
						<div class="penci-mg-message-content"></div>
						<p><strong><?php printf( __('Migrator done. You can deactivate the Penci PenNews Migrator plugin via %1sPlugins%2s page.', 'penci-pennews-migrator' ),
									'<a href="'. admin_url( 'plugins.php' ) .'">','</a>' ); ?></strong></p>

					</div>
				</div>
				<div class="penci-mg-process-info">
					<p><?php esc_html_e("Please be patient while the posts are switched. You can see changes logs in the process below.", 'penci-pennews-migrator' ) ; ?></p>
					<div id="penci-progressbar"><div class="penci-progress-label">Loading...</div></div>
					<div class="penci-mg-process-control">
						<a href="#" data-action="pause" class="button hide-if-no-js">
							<span><?php esc_html_e('Pause importing', 'penci-pennews-migrator' ) ?></span>
						</a>
					</div>
				</div>
				<div class="penci-mg-process-detail">
					<h3 class="title"><?php esc_html_e('Process Information:', 'penci-pennews-migrator'); ?></h3>
					<ul>
						<li><span class="label">
								<span class="dashicons dashicons-admin-post"></span>
								<p><?php esc_html_e( 'Total : ', 'penci-pennews-migrator' ); ?></span><span class="text"><?php Penci_PenNews_MG_Helper::count_posts(); ?></span></p></li>
						<li><span class="label">
								<span class="dashicons dashicons-yes"></span>
								<p><?php esc_html_e( 'Success : ', 'penci-pennews-migrator' ); ?></span><span class="text successcount">0</span></p></li>
						<li><span class="label">
								<span class="dashicons dashicons-no-alt"></span>
								<p><?php esc_html_e( 'Skipped : ', 'penci-pennews-migrator' ); ?></span><span class="text kippedcount">0</span></p></li>
						<li><span class="label">
								<span class="dashicons dashicons-warning"></span>
								<p><?php esc_html_e( 'Warning : ', 'penci-pennews-migrator' ); ?></span><span class="text failurecount">0</span></p></li>
					</ul>

					<ol id="penci-mg-debuglist"></ol>
				</div>
				<form action="" method="post" id="penci-migration-form">
					<div class="penci-mg-form-main">
						<div class="penci-mg-settings">
							<p>
								<label for="force_switch_posts">
									<input name="force_switch_posts" type="checkbox" id="force_switch_posts" value="1">
									<strong>Force Switch Posts</strong><br><small>Check this option if you want to run the switcher data again on the posts that already switched before</small>
								</label>
							</p>
							<div class="migration-button">
								<input type="hidden" name="theme" id="theme" value="<?php echo esc_html( $theme_id ); ?>">
								<input type="submit" class="button button-primary button-hero hide-if-no-js" name="penci-switcher" id="penci-switcher" value="Start Migrator">
							</div>
						</div>
					</div>
				</form>

			</div>
			<?php
		}
	}
}

new Penci_PenNews_Migrator();