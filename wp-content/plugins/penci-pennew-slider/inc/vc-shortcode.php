<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Penci_PenNew_Slider_VC_Shortcode {

	function __construct() {
		if ( ! defined( 'WPB_VC_VERSION' ) || ! class_exists( 'Penci_Framework' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'integrate' ) );
	}

	/**
	 * Integrate elements  into VC interface
	 */
	public function integrate() {

		vc_map( array(
			'name'        => esc_html__( 'Penci Slider', 'penci-framework' ),
			'description' => '',
			'base'        => 'penci_custom_slider',
			'class'       => '',
			'controls'    => 'full',
			'icon'        => ( defined( 'PENCI_ADDONS_URL' ) ? PENCI_ADDONS_URL : '' ) . '/assets/img/vc-custom-slider.png',
			'category'    => 'PenNews',
			'weight'      => 700,
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Select slider', 'penci-framework' ),
					'value'       => $this->get_all_sliders(),
					'param_name'  => 'slider_id',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra Class', 'penci-framework' ),
					'param_name'  => 'class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'penci-framework' ),
				)
			)
		) );

	}

	public function get_all_sliders() {
		$query_slider = new WP_Query( array(
			'post_type'      => 'penci_slider',
			'posts_per_page' => - 1,
			'order'          => 'ASC',
		) );

		$list_slider = array();

		if ( $query_slider->have_posts() ) {
			while ( $query_slider->have_posts() ) {
				$query_slider->the_post();

				$title                 = get_the_title();
				$list_slider[ $title ] = get_the_ID();
			}
			wp_reset_postdata();
		}

		if ( empty( $list_slider ) ) {
			$list_slider['No sliders found'] = '';
		}

		return $list_slider;
	}
}


