<?php

$wp_customize->add_section( 'penci-woocommrce', array(
	'title'    => esc_html__( 'Woocommerce Options', 'pennews' ),
	'priority' => 30,
) );

$wp_customize->add_setting( 'penci_woo_sidebar_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_woo_sidebar_heading', array(
	'label'    => esc_html__( 'Sidebar', 'pennews' ),
	'section'  => 'penci-woocommrce',
	'settings' => 'penci_woo_sidebar_heading',
	'type'     => 'heading',
) ) );

$wp_customize->add_setting( 'penci_woo_sidebar_shop', array(
	'default'           => 'sidebar-right',
	'sanitize_callback' => array( $sanitizer, 'select' ),
) );
$wp_customize->add_control( new Penci_Customize_Control_Radio_Image(
	$wp_customize,
	'penci_woo_sidebar_shop',
	array(
		'label'    => __( 'Sidebar On Shop Page ', 'pennews' ),
		'section'  => 'penci-woocommrce',
		'type'     => 'radio-image',
		'choices'  => array(
			'no-sidebar'      => array( 'url' => '%s/images/layout/no-sidebar.png', 'label' => esc_html__( 'No Sidebar', 'pennews' ) ),
			'sidebar-left'    => array( 'url' => '%s/images/layout/sidebar-left.png', 'label' => esc_html__( 'Sidebar Left', 'pennews' ) ),
			'sidebar-right'   => array( 'url' => '%s/images/layout/sidebar-right.png', 'label' => esc_html__( 'Sidebar Right', 'pennews' ) ),
		),
		'settings' => 'penci_woo_sidebar_shop',
	)
) );

$wp_customize->add_setting( 'penci_woo_sidebar_product', array(
	'default'           => 'no-sidebar',
	'sanitize_callback' => array( $sanitizer, 'select' ),
) );
$wp_customize->add_control( new Penci_Customize_Control_Radio_Image(
	$wp_customize,
	'penci_woo_sidebar_product',
	array(
		'label'    => __( 'Sidebar On Product Detail', 'pennews' ),
		'section'  => 'penci-woocommrce',
		'type'     => 'radio-image',
		'choices'  => array(
			'no-sidebar'      => array( 'url' => '%s/images/layout/no-sidebar.png', 'label' => esc_html__( 'No Sidebar', 'pennews' ) ),
			'sidebar-left'    => array( 'url' => '%s/images/layout/sidebar-left.png', 'label' => esc_html__( 'Sidebar Left', 'pennews' ) ),
			'sidebar-right'   => array( 'url' => '%s/images/layout/sidebar-right.png', 'label' => esc_html__( 'Sidebar Right', 'pennews' ) ),
		),
		'settings' => 'penci_woo_sidebar_product',
	)
) );

$wp_customize->add_setting( 'penci_woo_extra_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_woo_extra_heading', array(
	'label'    => esc_html__( 'Extra', 'pennews' ),
	'section'  => 'penci-woocommrce',
	'settings' => 'penci_woo_extra_heading',
	'type'     => 'heading',
) ) );

$wp_customize->add_setting( 'penci_woo_extra_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_woo_extra_heading', array(
	'label'    => esc_html__( 'Extra', 'pennews' ),
	'section'  => 'penci-woocommrce',
	'settings' => 'penci_woo_extra_heading',
	'type'     => 'heading',
) ) );

$options_woocommrce = array(
	'penci_woo_disable_breadcrumb'      => esc_html__( 'Disable Breadcrumb', 'pennews' ),
	'penci_woo_disable_zoom'            => esc_html__( 'Disable Zoom on Gallery Product', 'pennews' ),
);

foreach ( $options_woocommrce as $id_option => $label_option ) {

	$wp_customize->add_setting( $id_option, array(
		'sanitize_callback' => array( $sanitizer, 'checkbox' ),
	) );

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		$id_option,
		array(
			'label'    => $label_option,
			'section' => 'penci-woocommrce',
			'type'     => 'checkbox',
			'settings' => $id_option,
		)
	) );
}

$wp_customize->add_setting( 'penci_woo_paging_align', array(
	'default'           => 'center',
	'sanitize_callback' => array( $sanitizer, 'select' ),
) );
$wp_customize->add_control( 'penci_woo_paging_align', array(
	'label'    => esc_html__( 'Page Navigation Alignment', 'pennews' ),
	'section'  => 'penci-woocommrce',
	'settings' => 'penci_woo_paging_align',
	'type'     => 'select',
	'choices'  => array(
		'left' 		=> esc_html__( 'Left', 'pennews' ),
		'center'    => esc_html__( 'Center', 'pennews' ),
		'right'    => esc_html__( 'Right', 'pennews' )
	)
) );

$wp_customize->add_setting( 'penci_woo_post_per_page', array(
	'default'           => '24',
	'sanitize_callback' => array( $sanitizer, 'html' ),
) );
$wp_customize->add_control( new Penci_Customize_Number_Control( $wp_customize, 'penci_woo_post_per_page', array(
	'label'    => esc_html__( 'Custom Amount of Products Shown Per Page on Shop page & Categories page', 'pennews' ),
	'section'  => 'penci-woocommrce',
	'settings' => 'penci_woo_post_per_page',
	'type'     => 'number',
) ) );

$wp_customize->add_setting( 'penci_woo_number_related_products', array(
	'default'           => '4',
	'sanitize_callback' => array( $sanitizer, 'html' ),
) );
$wp_customize->add_control( new Penci_Customize_Number_Control( $wp_customize, 'penci_woo_number_related_products', array(
	'label'    => esc_html__( 'Custom Amount of Related Products', 'pennews' ),
	'section'  => 'penci-woocommrce',
	'settings' => 'penci_woo_number_related_products',
	'type'     => 'number',
) ) );


$wp_customize->add_setting( 'penci_woo_colors_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_woo_colors_heading', array(
	'label'    => esc_html__( 'Colors', 'pennews' ),
	'section'  => 'penci-woocommrce',
	'settings' => 'penci_woo_colors_heading',
	'type'     => 'heading',
) ) );
$wp_customize->add_setting( 'penci_woo_shortcode_dis_bg', array(
	'sanitize_callback' => array( $sanitizer, 'checkbox' ),
) );

$wp_customize->add_control( new WP_Customize_Control(
	$wp_customize,
	'penci_woo_shortcode_dis_bg',
	array(
		'label'    => esc_html__( 'Disable Background For Shortcode', 'pennews' ),
		'section' => 'penci-woocommrce',
		'type'     => 'checkbox',
		'settings' => 'penci_woo_shortcode_dis_bg',
	)
) );

$wp_customize->add_setting( 'penci_woo_shortcode_bg', array(
	'default'           => '',
	'sanitize_callback' => array( $sanitizer, 'hex_color' ),
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'penci_woo_shortcode_bg', array(
	'label'    => esc_html__( 'Background Color For Shortcode', 'pennews' ),
	'section' => 'penci-woocommrce',
	'settings' => 'penci_woo_shortcode_bg',
	'description' => ''
) ) );