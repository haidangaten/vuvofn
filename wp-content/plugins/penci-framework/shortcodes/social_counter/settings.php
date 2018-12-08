<?php
// Shortcode settings
$group_color  = 'Color';
$group_social = 'Social';

return array(
	'name'   => esc_html__( 'Social Counter', 'penci-framework' ),
	'weight' => 812,
	'params' => array_merge(
		Penci_Framework_Shortcode_Params::block_title(),
		Penci_Framework_Shortcode_Params::block_option_block_title(),
		array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Select Style', 'penci-framework' ),
				'param_name'  => 'style_counter',
				'std'         => 'style-1',
				'value'       => array(
					esc_html__( 'Style 1', 'penci-framework' ) => 'style-1',
					esc_html__( 'Style 2', 'penci-framework' ) => 'style-2',
					esc_html__( 'Style 3', 'penci-framework' ) => 'style-3',
					esc_html__( 'Style 4', 'penci-framework' ) => 'style-4',
					esc_html__( 'Style 5', 'penci-framework' ) => 'style-5',
					esc_html__( 'Style 6', 'penci-framework' ) => 'style-6',

				),
				'admin_label' => true,
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Social Item Align for Style 2', 'penci-framework' ),
				'param_name'  => 'social_item_align',
				'std'         => 'left',
				'value'       => array(
					esc_html__( 'Left', 'penci-framework' ) => 'left',
					esc_html__( 'Center', 'penci-framework' ) => 'center',
					esc_html__( 'Right', 'penci-framework' ) => 'right'
				),
			),
			array(
				"param_name"  => "facebook",
				"type"        => "textfield",
				'std'         => 'PenciDesign',
				"heading"     => __( "Facebook id:", 'penci-framework' ),
				"description" =>  esc_html__( 'Please enter the page ID or page name.For example:If your page url is https://www.facebook.com/PenciDesign then your page ID is PenciDesign.', 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name" => "facebook_access_token",
				"type"       => "textfield",
				"heading"    => __( "Facebook Access Tokens:", 'penci-framework' ),
				'group'      => $group_social,
				"description" => 'Please go to <a href="https://smashballoon.com/custom-facebook-feed/access-token/" target="_blank">https://smashballoon.com/custom-facebook-feed/access-token/</a> and check this giude and get the access token ID',
			),
			array(
				"param_name" => "twitter",
				"type"       => "textfield",
				"std"        => "envato",
				"heading"    => __( "Twitter id:", 'penci-framework' ),
				'group'      => $group_social,
			),
			array(
				"param_name"  => "youtube",
				"type"        => "textfield",
				"std"         => "envato",
				"heading"     => __( "Youtube id:", 'penci-framework' ),
				"description" => "User: www.youtube.com/user/<b style='color: #000'>ENVATO</b><br/>Channel: www.youtube.com/<b style='color: #000'>channel/UCJr72fY4cTaNZv7WPbvjaSw</b>",
				'group'       => $group_social,
			),
			array(
				"param_name" => "vimeo",
				"type"       => "textfield",
				"heading"    => __( "Vimeo id:", 'penci-framework' ),
				'group'      => $group_social,
			),
			array(
				"param_name" => "google",
				"type"       => "textfield",
				"heading"    => __( "Google Plus User:", 'penci-framework' ),
				'group'      => $group_social,
			),
			array(
				"param_name" => "pinterest",
				"type"       => "textfield",
				"heading"    => __( "Pinterest Username:", 'penci-framework' ),
				'group'      => $group_social,
			),
			array(
				"param_name" => "instagram",
				"type"       => "textfield",
				"heading"    => __( "Instagram Username:", 'penci-framework' ),
				'group'      => $group_social,
			),
			array(
				"param_name" => "instagram_access_token",
				"type"       => "textfield",
				"heading"    => __( "Instagram Access Token:", 'penci-framework' ),
				"description" => 'Please enter the instagram Access Token.You can get this information from <a href="http://instagram.pixelunion.net/" target="_blank">http://instagram.pixelunion.net/</a>',
				'group'      => $group_social,
			),
			array(
				"param_name" => "github",
				"type"       => "textfield",
				"heading"    => __( "Github UserName:", 'penci-framework' ),
				'group'      => $group_social,
			),
			array(
				"param_name" => "soundcloud",
				"type"       => "textfield",
				"heading"    => __( "Soundcloud User:", 'penci-framework' ),
				'group'      => $group_social,
			),
			array(
				"param_name" => "soundcloud_client_id",
				"type"       => "textfield",
				"heading"    => __( "SoundCloud Client ID:", 'penci-framework' ),
				'group'      => $group_social,
			),
			array(
				"param_name"  => "rss",
				"type"        => "textfield",
				"heading"     => __( "Feed subscriber count:", 'penci-framework' ),
				"description" => "Write the number of followers",
				'group'       => $group_social,
			),
			array(
				"param_name"  => "linkedin",
				"type"        => "textfield",
				"heading"     => __( "Linkedin:", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "flickr",
				"type"        => "textfield",
				"heading"     => __( "Flickr:", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "behance",
				"type"        => "textfield",
				"heading"     => __( "Behance", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "behance_api",
				"type"        => "textfield",
				'std'         => '',
				"heading"     => __( "Behance API Key", 'penci-framework' ),
				"description" => __( 'You can register Behance API Key <a href="https://www.behance.net/dev/register" target="_blank">here</a>', 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "tumblr",
				"type"        => "textfield",
				"heading"     => __( "Tumblr", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "email_me",
				"type"        => "textfield",
				"heading"     => __( "Email", 'penci-framework' ),
				'group'       => $group_social,
				'description' => 'If you want to click email icon to link to your mail, please fill: mailto:yourmail@hostmail. Change yourmail@hostmail.com to your mail. You also can fill your contact link page here'
			),
			array(
				"param_name"  => "bloglovin",
				"type"        => "textfield",
				"heading"     => __( "Bloglovin", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "vk",
				"type"        => "textfield",
				"heading"     => __( "Vk", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "vine",
				"type"        => "textfield",
				"heading"     => __( "Vine", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "snapchat",
				"type"        => "textfield",
				"heading"     => __( "Snapchat", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "spotify",
				"type"        => "textfield",
				"heading"     => __( "Spotify", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "stack-overflow",
				"type"        => "textfield",
				"heading"     => __( "Stack Overflow", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "twitch",
				"type"        => "textfield",
				"heading"     => __( "Twitch", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "steam",
				"type"        => "textfield",
				"heading"     => __( "Steam", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name"  => "xing",
				"type"        => "textfield",
				"heading"     => __( "Xing", 'penci-framework' ),
				'group'       => $group_social,
			),array(
				"param_name"  => "line",
				"type"        => "textfield",
				"heading"     => __( "Line", 'penci-framework' ),
				'group'       => $group_social,
			),
			array(
				"param_name" => "open_in_new_window",
				"type"       => "dropdown",
				"value"      => array( '-- Same window --' => '', 'New window' => 'y' ),
				"heading"    => __( "Open in:", 'penci-framework' ),
				'std'        => 'y'
			),
		),
		Penci_Framework_Shortcode_Params::color_params( 'socail-counter', false ),
		array(
			array(
				'type'             => 'textfield',
				'param_name'       => 'color_item_css',
				'heading'          => esc_html__( 'Socail item colors', 'penci-framework' ),
				'value'            => '',
				'group'            => $group_color,
				'edit_field_class' => 'penci-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
			),
			array(
				'type'             => 'colorpicker',
				'heading'          => esc_html__( 'Background item social color', 'penci-framework' ),
				'param_name'       => 'background_social_color',
				'group'            => $group_color,
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type'             => 'colorpicker',
				'heading'          => esc_html__( 'Text item social color', 'penci-framework' ),
				'param_name'       => 'item_text_color',
				'group'            => $group_color,
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type'             => 'colorpicker',
				'heading'          => esc_html__( 'Background item social hover color', 'penci-framework' ),
				'param_name'       => 'background_social_hcolor',
				'group'            => $group_color,
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type'             => 'colorpicker',
				'heading'          => esc_html__( 'Text item social hover color', 'penci-framework' ),
				'param_name'       => 'item_text_hover_color',
				'group'            => $group_color,
				'edit_field_class' => 'vc_col-sm-6',
			)
		),
		Penci_Framework_Shortcode_Params::block_option_note_custom_fonts(),
		Penci_Framework_Shortcode_Params::block_option_typo(
			array(
				'prefix'       => 'block_title',
				'title'        => esc_html__( 'Block title settings' ),
				'google_fonts' => Penci_Helper_Shortcode::get_font_family( 'oswald' ),
				'font-size'    => '18px',
			)
		),
		Penci_Framework_Shortcode_Params::block_option_typo(
			array(
				'prefix'       => 'social_item',
				'title'        => esc_html__( 'Text item social settings' ),
				'google_fonts' => Penci_Helper_Shortcode::get_font_family( 'roboto' ),
				'font-size'    => '',
			)
		),
		array(
			array(
				'type'             => 'penci_number',
				'param_name'       => 'icon_font_size',
				'heading'          => esc_html__( 'Font size icon of item', 'penci-framework' ),
				'value'            => '',
				'std'              => '',
				'suffix'           => 'px',
				'min'              => 1,
				'edit_field_class' => 'vc_col-sm-6',
				'group'            => 'Typo',
			),
		)
	),
);