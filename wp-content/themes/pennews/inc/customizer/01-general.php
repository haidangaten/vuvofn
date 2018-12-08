<?php

$wp_customize->add_section( 'general', array(
	'title'       => esc_html__( 'General Options', 'pennews' ),
	'description' => sprintf( esc_html__( 'Before do anything with this theme, please check %s for this theme %s to understand how to config this theme. It is short and easy to understand.', 'pennews' ),
		'<a href="' . esc_url( 'http://pennews.pencidesign.com/pennews-document' ) . '" target="_blank">' . esc_html__( 'the documentation', 'pennews' ) . '</a>',
		'<a href="' . esc_url( 'http://pennews.pencidesign.com/pennews-document' ) . '" target="_blank">' . esc_html__( 'here', 'pennews' ) . '</a>'
	),
	'priority'    => 1,
) );


$wp_customize->add_setting( 'penci_custom_url_logo', array(
	'sanitize_callback' => array( $sanitizer, 'text' )
) );
$wp_customize->add_control( 'penci_custom_url_logo', array(
	'label'    => esc_html__( 'Custom Url of Logo', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_custom_url_logo',
	'priority'    => 7,
) );

// ------ Background
$wp_customize->add_setting( 'penci_general_bg_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_general_bg_heading', array(
	'label'    => esc_html__( 'Background', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_general_bg_heading',
	'type'     => 'heading',
	'priority'    => 7,
) ) );

// ------ Typography

$wp_customize->add_setting( 'penci_general_typo_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_general_typo_heading', array(
	'label'    => esc_html__( 'Typography', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_general_typo_heading',
	'type'     => 'heading',
) ) );

$wp_customize->add_setting( 'penci_font_for_title', array(
	'default'           => penci_default_setting( 'penci_font_for_title' ),
	'sanitize_callback' => array( $sanitizer, 'text' ),
) );
$wp_customize->add_control( 'penci_font_for_title', array(
	'label'       => esc_html__( 'Font For Heading Titles', 'pennews' ),
	'section'     => 'general',
	'settings'    => 'penci_font_for_title',
	'description' => 'Default font is "Mukta Vaani"',
	'type'        => 'select',
	'choices'     => penci_all_fonts()
) );

$wp_customize->add_setting( 'penci_font_weight_title', array(
	'default'           => '600',
	'sanitize_callback' => array( $sanitizer, 'select' ),
) );
$wp_customize->add_control( 'penci_font_weight_title', array(
	'label'    => esc_html__( 'Font Weight For Heading Titles', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_font_weight_title',
	'type'     => 'select',
	'choices'  => array(
		'normal'  => 'Normal',
		'bold'    => 'Bold',
		'bolder'  => 'Bolder',
		'lighter' => 'Lighter',
		'100'     => '100',
		'200'     => '200',
		'300'     => '300',
		'400'     => '400',
		'500'     => '500',
		'600'     => '600',
		'700'     => '700',
		'800'     => '800',
		'900'     => '900'
	)
) );

// Block heading title
$wp_customize->add_setting( 'penci_font_block_heading_title', array(
	'default'           => penci_default_setting( 'penci_font_block_heading_title' ),
	'sanitize_callback' => array( $sanitizer, 'text' ),
) );
$wp_customize->add_control( 'penci_font_block_heading_title', array(
	'label'       => esc_html__( 'Custom Default Font For Blocks Heading Titles', 'pennews' ),
	'section'     => 'general',
	'settings'    => 'penci_font_block_heading_title',
	'description' => 'Default font is "Mukta Vaani"',
	'type'        => 'select',
	'choices'     => penci_all_fonts()
) );

$wp_customize->add_setting( 'penci_fweight_block_heading_title', array(
	'default'           => '600',
	'sanitize_callback' => array( $sanitizer, 'select' ),
) );
$wp_customize->add_control( 'penci_fweight_block_heading_title', array(
	'label'    => esc_html__( 'Custom Default Font Weight For Blocks Heading Titles', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_fweight_block_heading_title',
	'type'     => 'select',
	'choices'  => array(
		'normal'  => 'Normal',
		'bold'    => 'Bold',
		'bolder'  => 'Bolder',
		'lighter' => 'Lighter',
		'100'     => '100',
		'200'     => '200',
		'300'     => '300',
		'400'     => '400',
		'500'     => '500',
		'600'     => '600',
		'700'     => '700',
		'800'     => '800',
		'900'     => '900'
	)
) );

// Body
$wp_customize->add_setting( 'penci_font_for_body', array(
	'default'           => penci_default_setting( 'penci_font_for_body' ),
	'sanitize_callback' => array( $sanitizer, 'text' ),
) );
$wp_customize->add_control( 'penci_font_for_body', array(
	'label'       => esc_html__( 'Font For Body Text', 'pennews' ),
	'section'     => 'general',
	'settings'    => 'penci_font_for_body',
	'description' => 'Default font is "Roboto"',
	'type'        => 'select',
	'choices'     => penci_all_fonts()
) );

// Font size
$wp_customize->add_setting( 'penci_font_for_size_body', array(
	'default'           => '15',
	'sanitize_callback' => array( $sanitizer, 'html' ),
) );
$wp_customize->add_control( new Penci_Customize_Font_size_Control( $wp_customize, 'penci_font_for_size_body', array(
	'label'    => esc_html__( 'Custom Size Of Font Body Text', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_font_for_size_body',
	'type'     => 'font_size',
) ) );

for( $i = 1; $i < 7; $i ++ ){
	$wp_customize->add_setting( 'penci_pp_h' . $i . '_fsize', array(
		'default'           => '',
		'sanitize_callback' => array( $sanitizer, 'html' ),
	) );
	$wp_customize->add_control( new Penci_Customize_Font_size_Control( $wp_customize, 'penci_pp_h' . $i . '_fsize', array(
		'label'    => esc_html__( 'Custom Size of h' . $i . '  on content posts and pages', 'pennews' ),
		'section'  => 'general',
		'settings' => 'penci_pp_h' . $i . '_fsize',
		'type'     => 'font_size',
	) ) );
}


$wp_customize->add_setting( 'penci_general_loading_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_general_loading_heading', array(
	'label'    => esc_html__( 'Loading Effect', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_general_loading_heading',
	'type'     => 'heading',
) ) );

$wp_customize->add_setting( 'penci_general_loader_effect', array(
	'default'           => 9,
	'sanitize_callback' => array( $sanitizer, 'html' ),
) );
$wp_customize->add_control( new Penci_Customize_Control_Radio_HTML( $wp_customize, 'penci_general_loader_effect', array(
	'label'    => '',
	'section'  => 'general',
	'settings' => 'penci_general_loader_effect',
	'type'     => 'radio-html',
	'choices' => array(
		'1' => '<div class="penci-loading-animation-1"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div></div>',
		'2' => '<div class="penci-loading-animation-2"><div class="penci-loading-animation"></div></div>',
		'3' => '<div class="penci-loading-animation-3"><div class="penci-loading-animation"></div></div>',
		'4' => '<div class="penci-loading-animation-4"><div class="penci-loading-animation"></div></div>',
		'5' => '<div class="penci-loading-animation-5 penci-three-bounce"><div class="penci-loading-animation one"></div><div class="penci-loading-animation two"></div><div class="penci-loading-animation three"></div></div>',
		'6' => '<div class="penci-loading-animation-6 penci-load-thecube"><div class="penci-loading-animation penci-load-cube penci-load-c1"></div><div class="penci-loading-animation penci-load-cube penci-load-c2"></div><div class="penci-loading-animation penci-load-cube penci-load-c4"></div><div class="penci-loading-animation penci-load-cube penci-load-c3"></div></div>',
		'7' => '<div class="penci-loading-animation-7"><div class="penci-loading-animation"></div><div class="penci-loading-animation penci-loading-animation-inner-2"></div><div class="penci-loading-animation penci-loading-animation-inner-3"></div><div class="penci-loading-animation penci-loading-animation-inner-4"></div><div class="penci-loading-animation penci-loading-animation-inner-5"></div><div class="penci-loading-animation penci-loading-animation-inner-6"></div><div class="penci-loading-animation penci-loading-animation-inner-7"></div><div class="penci-loading-animation penci-loading-animation-inner-8"></div><div class="penci-loading-animation penci-loading-animation-inner-9"></div></div>',
		'8' => '<div class="penci-loading-animation-8"><div class="penci-loading-animation"></div><div class="penci-loading-animation penci-loading-animation-inner-2"></div></div>',
		'9' => '<div class="penci-loading-animation-9"> <div class="penci-loading-circle"> <div class="penci-loading-circle1 penci-loading-circle-inner"></div> <div class="penci-loading-circle2 penci-loading-circle-inner"></div> <div class="penci-loading-circle3 penci-loading-circle-inner"></div> <div class="penci-loading-circle4 penci-loading-circle-inner"></div> <div class="penci-loading-circle5 penci-loading-circle-inner"></div> <div class="penci-loading-circle6 penci-loading-circle-inner"></div> <div class="penci-loading-circle7 penci-loading-circle-inner"></div> <div class="penci-loading-circle8 penci-loading-circle-inner"></div> <div class="penci-loading-circle9 penci-loading-circle-inner"></div> <div class="penci-loading-circle10 penci-loading-circle-inner"></div> <div class="penci-loading-circle11 penci-loading-circle-inner"></div> <div class="penci-loading-circle12 penci-loading-circle-inner"></div> </div> </div>',
	),
) ) );

// ------ Google Adsense
$wp_customize->add_setting( 'penci_general_google_ad_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_general_google_ad_heading', array(
	'label'    => esc_html__( 'Google Adsense Setting', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_general_google_ad_heading',
	'type'     => 'heading',
) ) );

$wp_customize->add_setting( 'penci_archive_ad_below_header', array(
	'sanitize_callback' => array( $sanitizer, 'textarea' ),
) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'penci_archive_ad_below_header', array(
	'label'       => esc_html__('Google Adsense Code to Display Below Header', 'pennews' ),
	'section'     => 'general',
	'settings'    => 'penci_archive_ad_below_header',
	'description' => esc_html__('You can display google adsense code below header by use this option', 'pennews' ),
	'type'        => 'textarea',
) ) );

$wp_customize->add_setting( 'penci_general_ad_above_footer', array(
	'sanitize_callback' => array( $sanitizer, 'textarea' ),
) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'penci_general_ad_above_footer', array(
	'label'       => esc_html__('Google Adsense Code to Display Above Footer', 'pennews' ),
	'section'     => 'general',
	'settings'    => 'penci_general_ad_above_footer',
	'description' => esc_html__('You can display google adsense code above footer by use this option', 'pennews' ),
	'type'        => 'textarea',
) ) );

// Options for show/hide social sharing on Blocks Layout

$wp_customize->add_setting( 'penci_block_social_share_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_block_social_share_heading', array(
	'label'    => esc_html__( 'Options for show/hide social sharing on WPBakery Blocks Layout', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_block_social_share_heading',
	'type'     => 'heading',
) ) );

$list_block_social = array(
	'facebook'    => esc_html__( 'Hide Button Facebook', 'pennews' ),
	'twitter'     => esc_html__( 'Hide Button Twitter', 'pennews' ),
	'google_plus' => esc_html__( 'Hide Button Google Plus', 'pennews' ),
	'pinterest'   => esc_html__( 'Hide Button Pinterest', 'pennews' ),
	'linkedin'    => esc_html__( 'Hide Button Linkedin', 'pennews' ),
	'tumblr'      => esc_html__( 'Hide Button Tumblr', 'pennews' ),
	'reddit'      => esc_html__( 'Hide Button Reddit', 'pennews' ),
	'stumbleupon' => esc_html__( 'Hide Button Stumbleupon', 'pennews' ),
	'whatsapp'    => esc_html__( 'Hide Button Whatsapp', 'pennews' ),
	'telegram'    => esc_html__( 'Hide Button Telegram', 'pennews' ),
	'email'       => esc_html__( 'Hide Button Email', 'pennews' ),
	'digg'        => esc_html__( 'Hide Button digg', 'pennews' ),
	'vk'          => esc_html__( 'Hide Button Vk', 'pennews' ),
	'line'        => esc_html__( 'Hide Button Line', 'pennews' ),
	'viber'       => esc_html__( 'Hide Button Viber', 'pennews' ),
);

foreach ( $list_block_social as $social_id => $social_label ) {

	$default = '';
	if( in_array( $social_id, array( 'linkedin','tumblr','reddit','stumbleupon','whatsapp','telegram','line','viber','digg','vk' ) ) ){
		$default = 1;
	}

	$social_id = 'penci_hide_block_share_' . $social_id;
	$wp_customize->add_setting( $social_id, array(
		'sanitize_callback' => array( $sanitizer, 'checkbox' ),
		'default' => $default
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		$social_id,
		array(
			'label'    => $social_label,
			'section'  => 'general',
			'type'     => 'checkbox',
			'settings' => $social_id,
		)
	) );
}

$wp_customize->add_setting( 'penci_general_social_share_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_general_social_share_heading', array(
	'label'    => esc_html__( 'Social Share Box', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_general_social_share_heading',
	'type'     => 'heading',
) ) );

$list_social_share = array(
	'post_like'   => esc_html__( 'Hide Button Like', 'pennews' ),
	'total_share' => esc_html__( 'Enable Total Count Share', 'pennews' ),
	'facebook'    => esc_html__( 'Hide Button Facebook', 'pennews' ),
	'twitter'     => esc_html__( 'Hide Button Twitter', 'pennews' ),
	'google_plus' => esc_html__( 'Hide Button Google Plus', 'pennews' ),
	'pinterest'   => esc_html__( 'Hide Button Pinterest', 'pennews' ),
	'linkedin'    => esc_html__( 'Hide Button Linkedin', 'pennews' ),
	'tumblr'      => esc_html__( 'Hide Button Tumblr', 'pennews' ),
	'reddit'      => esc_html__( 'Hide Button Reddit', 'pennews' ),
	'stumbleupon' => esc_html__( 'Hide Button Stumbleupon', 'pennews' ),
	'whatsapp'    => esc_html__( 'Hide Button Whatsapp', 'pennews' ),
	'telegram'    => esc_html__( 'Hide Button Telegram', 'pennews' ),
	'email'       => esc_html__( 'Hide Button Email', 'pennews' ),
	'digg'        => esc_html__( 'Hide Button digg', 'pennews' ),
	'vk'          => esc_html__( 'Hide Button Vk', 'pennews' ),
	'line'       => esc_html__( 'Hide Button Line', 'pennews' ),
	'viber'       => esc_html__( 'Hide Button Viber', 'pennews' ),
);

foreach ( $list_social_share as $social_id => $social_label ) {

	$default = '';
	if( in_array( $social_id, array( 'stumbleupon','whatsapp','line','viber','digg','vk' ) ) ){
		$default = 1;
	}

	$desc = '';

	if ( 'total_share' == $social_id ) {
		$desc = esc_html__( 'Enable this feature will slow down your site speed when access to single posts page in the  first time. Because this need to count & update the social share in the first time access.','pennews');
	}

	$social_id = 'penci_hide_single_share_' . $social_id;
	$wp_customize->add_setting( $social_id, array(
		'sanitize_callback' => array( $sanitizer, 'checkbox' ),
		'default'           => $default
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		$social_id,
		array(
			'label'       => $social_label,
			'section'     => 'general',
			'type'        => 'checkbox',
			'settings'    => $social_id,
			'description' => $desc
		)
	) );
}

// ------ Extra
$wp_customize->add_setting( 'penci_general_extra_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_general_extra_heading', array(
	'label'    => esc_html__( 'Extra', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_general_extra_heading',
	'type'     => 'heading',
) ) );

$wp_customize->add_setting( 'penci_map_api_key', array(
	'sanitize_callback' => array( $sanitizer, 'text' )
) );
$wp_customize->add_control( 'penci_map_api_key', array(
	'label'    => esc_html__( 'Map API Key', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_map_api_key',
) );

$wp_customize->add_setting( 'penci_api_weather_key', array(
	'sanitize_callback' => array( $sanitizer, 'text' )
) );
$wp_customize->add_control( 'penci_api_weather_key', array(
	'label'    => esc_html__( 'Weather API Key', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_api_weather_key',
	'description' => '<a href="' . esc_url( 'https://openweathermap.org/appid#get' ) . '" target="_blank">' . esc_html__( 'Click here to get an api key', 'pennews' ) . '</a>'
) );

// Custom image type
$wp_customize->add_setting( 'penci_archive_image_type', array(
	'default'           => 'landscape',
	'sanitize_callback' => array( $sanitizer, 'select' ),
) );

$wp_customize->add_control(
	'penci_archive_image_type',
	array(
		'label'    => esc_html__( 'Image Type For Archive, Category, Blog, Tag, Search Pages', 'pennews' ),
		'section'  => 'general',
		'type'     => 'select',
		'choices'  => array(
			'square'    => esc_html__( 'Square', 'pennews' ),
			'vertical'  => esc_html__( 'Vertical', 'pennews' ),
			'landscape' => esc_html__( 'Landscape', 'pennews' )
		),
		'settings' => 'penci_archive_image_type'
	)
);

// Menu Navigation Margin Bottom
$wp_customize->add_setting( 'penci_margin_bottom_menu_main', array(
	'default'           => '40',
	'sanitize_callback' => array( $sanitizer, 'html' ),
) );
$wp_customize->add_control( new Penci_Customize_Font_size_Control( $wp_customize, 'penci_margin_bottom_menu_main', array(
	'label'    => esc_html__( 'Menu Navigation Margin Bottom', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_margin_bottom_menu_main',
	'type'     => 'font_size',
) ) );

$wp_customize->add_setting( 'penci_space_between_content_footer', array(
	'sanitize_callback' => array( $sanitizer, 'number_absint' ),
) );
$wp_customize->add_control( new Penci_Customize_Font_size_Control( $wp_customize, 'penci_space_between_content_footer', array(
	'label'    => esc_html__( 'Custom Space Between Site Content & Footer', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_space_between_content_footer',
	'type'     => 'font_size',
) ) );

$wp_customize->add_setting( 'penci_space_between_content_sidebar', array(
	'sanitize_callback' => array( $sanitizer, 'number_absint' ),
) );
$wp_customize->add_control( new Penci_Customize_Font_size_Control( $wp_customize, 'penci_space_between_content_sidebar', array(
	'label'    => esc_html__( 'Custom Space Between Content & Sidebar', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_space_between_content_sidebar',
	'type'     => 'font_size',
	'description' => esc_html__( 'Maximum space here is 150', 'pennews' )
) ) );

$general_extra_check = array(
	'penci_dis_padding_block_widget' => esc_html__( 'Disable Padding Block & Widget.', 'pennews' ),
	'penci_sticky_content_sidebar'   => esc_html__( 'Disable Sticky Content & Sidebar.', 'pennews' ),
	'penci_smooth_scroll'            => esc_html__( 'Enable Smooth Scroll.', 'pennews' ),
	'penci_enable_retina'            => esc_html__( 'Enable Retina.', 'pennews' ),
	'penci_regen_thumbvideo'         => esc_html__( 'Auto regenerate thumbnails from Youtube, Vimeo', 'pennews' ),
	'penci_show_date_updated'        => esc_html__( 'Display latest update replace with published date', 'pennews' ),
	'penci_disable_lazyload'        => esc_html__( 'Disable Lazyload', 'pennews' ),
	'penci_disable_reponsive'        => esc_html__( 'Disable Reponsive Design', 'pennews' ),
	'penci_use_yoast_breadcrumb'     => esc_html__( 'Use Yoast SEO Breadcrumbs Replace with Breadcrumbs from This Theme', 'pennews' ),
);

foreach ( $general_extra_check as $id_option => $label_option ) {
	$wp_customize->add_setting( $id_option, array(
		'sanitize_callback' => array( $sanitizer, 'checkbox' ),
	) );

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		$id_option,
		array(
			'label'    => $label_option,
			'section' => 'general',
			'type'     => 'checkbox',
			'settings' => $id_option,
		)
	) );
}

$wp_customize->add_setting( 'penci_dis_noopener', array(
	'sanitize_callback' => array( $sanitizer, 'checkbox' ),
) );

$wp_customize->add_control( new WP_Customize_Control(
	$wp_customize,
	'penci_dis_noopener',
	array(
		'label'       => esc_html__( 'Disable Noopener', 'pennews' ),
		'section'     => 'general',
		'type'        => 'checkbox',
		'settings'    => 'penci_dis_noopener',
		'description' => esc_html__( 'Disable noopener with social media links to another page', 'pennews' ),
	)
) );

// ------ Extra
$wp_customize->add_setting( 'penci_general_gprd_heading', array(
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( new Penci_Customize_Heading_Control( $wp_customize, 'penci_general_gprd_heading', array(
	'label'    => esc_html__( 'GPRD Policy Options', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_general_gprd_heading',
	'type'     => 'heading',
) ) );

$wp_customize->add_setting( 'penci_disable_default_fonts', array(
	'sanitize_callback' => array( $sanitizer, 'checkbox' ),
) );

$wp_customize->add_control( new WP_Customize_Control(
	$wp_customize,
	'penci_disable_default_fonts',
	array(
		'label'    => esc_html__( 'Remove all default google fonts - load default fonts from located hosting ( for GPRD policy )', 'pennews' ),
		'section' => 'general',
		'type'     => 'checkbox',
		'settings' => 'penci_disable_default_fonts',
	)
) );

$wp_customize->add_setting( 'penci_enable_cookie_law', array(
	'sanitize_callback' => array( $sanitizer, 'checkbox' ),
) );

$wp_customize->add_control( new WP_Customize_Control(
	$wp_customize,
	'penci_enable_cookie_law',
	array(
		'label'    => esc_html__( 'Enable Cookie Law Policy PopUp At The Footer', 'pennews' ),
		'section' => 'general',
		'type'     => 'checkbox',
		'settings' => 'penci_enable_cookie_law',
	)
) );

$wp_customize->add_setting( 'penci_show_cookie_law', array(
	'sanitize_callback' => array( $sanitizer, 'checkbox' ),
) );

$wp_customize->add_control( new WP_Customize_Control(
	$wp_customize,
	'penci_show_cookie_law',
	array(
		'label'    => esc_html__( 'Remove "Privacy & Cookies Policy" notice after Accept clicked', 'pennews' ),
		'section' => 'general',
		'type'     => 'checkbox',
		'settings' => 'penci_show_cookie_law',
	)
) );

$wp_customize->add_setting( 'penci_gprd_desc', array(
	'default'           => penci_default_setting( 'penci_gprd_desc' ),
	'sanitize_callback' => array( $sanitizer, 'textarea' ),
) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'penci_gprd_desc', array(
	'label'    => esc_html__( 'Custom Description for Cookie Law Policy', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_gprd_desc',
	'type'     => 'textarea',
) ) );

$wp_customize->add_setting( 'penci_gprd_btn_accept', array(
	'default'           => penci_default_setting( 'penci_gprd_btn_accept' ),
	'sanitize_callback' => array( $sanitizer, 'text' )
) );
$wp_customize->add_control( 'penci_gprd_btn_accept', array(
	'label'    => esc_html__( 'Custom Text for "Accept"', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_gprd_btn_accept',
) );

$wp_customize->add_setting( 'penci_gprd_rmore', array(
	'default'           => penci_default_setting( 'penci_gprd_rmore' ),
	'sanitize_callback' => array( $sanitizer, 'text' )
) );
$wp_customize->add_control( 'penci_gprd_rmore', array(
	'label'    => esc_html__( 'Custom Text for "Read More"', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_gprd_rmore',
) );

$wp_customize->add_setting( 'penci_gprd_rmore_link', array(
	'default'           => penci_default_setting( 'penci_gprd_rmore_link' ),
	'sanitize_callback' => array( $sanitizer, 'text' )
) );
$wp_customize->add_control( 'penci_gprd_rmore_link', array(
	'label'    => esc_html__( 'Custom Link for "Read More"', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_gprd_rmore_link',
) );

$wp_customize->add_setting( 'penci_gprd_policy_text', array(
	'default'           => penci_default_setting( 'penci_gprd_policy_text' ),
	'sanitize_callback' => array( $sanitizer, 'text' )
) );
$wp_customize->add_control( 'penci_gprd_policy_text', array(
	'label'    => esc_html__( 'Custom Text for "Privacy & Cookies Policy"', 'pennews' ),
	'section'  => 'general',
	'settings' => 'penci_gprd_policy_text',
) );

$options_color_gprd = array(
	'penci_gprd_bgcolor'     => esc_html__( 'Background For Cookie Law Policy PopUp', 'pennews' ),
	'penci_gprd_color'       => esc_html__( 'Text Color For Cookie Law Policy PopUp', 'pennews' ),
	'penci_gprd_btn_color'   => esc_html__( 'Text Color For Accept Button', 'pennews' ),
	'penci_gprd_btn_bgcolor' => esc_html__( 'Background For Accept Button', 'pennews' ),
	'penci_gprd_border'      => esc_html__( 'Border Color For Cookie Law Policy PopUp', 'pennews' ),
);

foreach ( $options_color_gprd as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'sanitize_callback' => array( $sanitizer, 'hex_color' ),
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array(
		'label'    => $label,
		'section'  => 'general',
		'settings' => $key,
	) ) );
}