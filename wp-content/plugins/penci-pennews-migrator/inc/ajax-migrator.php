<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Penci_PenNews_Migrator_Ajax' ) ) {
	class Penci_PenNews_Migrator_Ajax {

		public function __construct() {
			add_action( 'wp_ajax_nopriv_penci_migrator_ajax', array( $this, 'ajax_callback' ) );
			add_action( 'wp_ajax_penci_migrator_ajax', array( $this, 'ajax_callback' ) );
		}

		public function ajax_callback() {
			check_ajax_referer( 'ajax-nonce', 'nonce' );

			if( ! isset( $_POST['data'] ) ) {
				wp_send_json_error();
			}



			$data = array();
			$data_serialize = $_POST['data'];

			parse_str($data_serialize, $data );

			$theme = isset( $data['theme'] ) ? $data['theme'] : '';
			$force = isset( $data['force_switch_posts'] ) ? $data['force_switch_posts'] : '';
			$post_id = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';

			if( ! $theme ) {
				wp_send_json_error( array( 'mess' => esc_html__( 'Please choose a theme first.','penci-pennews-migrator' ) ) );
			}
			if( ! $post_id ) {
				wp_send_json_error( array( 'mess' => esc_html__( 'Not found Post', 'penci-pennews-migrator' ) ) );
			}

			// No timeout limit
			set_time_limit(0);

			$skip = 'false';



			$migrator = get_post_meta( $post_id, 'pennews_migrator_' . $theme,  true );

			if( 1 == $migrator && ! $force ) {
				$skip = 'true';
				$mess = 'Skip to migrate Post "' . get_the_title( $post_id ) . '"';
			}else{
				$mess = include( PENCI_MIGRATOR_DIR . "inc/themes/{$theme}.php" );
				update_post_meta( $post_id, 'pennews_migrator_' . $theme, 1 );
			}
			wp_send_json_success(  array( 'skip' => $skip, 'mess' => $mess ) );
		}

	}
}

new Penci_PenNews_Migrator_Ajax;