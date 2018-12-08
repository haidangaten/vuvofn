<?php

// Post format
$format_pre = 'standard';
$format =  get_post_meta( $post_id, 'tie_post_head', true );

$format_updated = '';
if ( $format == 'thumb' ) {
	$format_pre = 'image';
} elseif ( $format == 'video' ) {
	$format_pre = 'video ';

	$featured_video = '';
	if ( $tie_embed_code = get_post_meta( $post_id, 'tie_embed_code', true ) ) {
		$featured_video = $tie_embed_code;
	} elseif ( $tie_video_self = get_post_meta( $post_id, 'tie_video_self', true ) ) {
		$featured_video = $tie_video_self;
	} elseif ( $tie_video_url = get_post_meta( $post_id, 'tie_video_url', true ) ) {
		$featured_video = $tie_video_url;
	}

	$format_updated = update_post_meta( $post_id, '_format_audio_embed', $featured_video );

} elseif ( $format == 'audio' ) {
	$format_pre = 'audio ';

	$featured_audio = '';
	if ( $tie_audio_embed = get_post_meta( $post_id, 'tie_audio_embed', true ) ) {
		$featured_audio = $tie_audio_embed;
	} elseif ( $tie_audio_mp3 = get_post_meta( $post_id, 'tie_audio_mp3', true ) ) {
		$featured_audio = $tie_audio_mp3;
	} elseif ( $tie_audio_soundcloud = get_post_meta( $post_id, 'tie_audio_soundcloud', true ) ) {
		$featured_audio = $tie_audio_soundcloud;
	}

	$video_url_updated = update_post_meta( $post_id, '_format_audio_embed', $featured_audio );

} elseif ( $format == 'slider' ) {
	$format_pre        = 'gallery';
	$gallery           = get_post_meta( $id, 'tie_post_gallery', true );
	$format_updated = update_post_meta( $post_id, '_format_audio_embed', $gallery );
}

set_post_format( $post_id, $format_pre );

if( $format_updated ) {
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'post_format' );
}

// Update custom sidebar
$sidebars_updated = get_option( 'sahifa_custom_sidebars_updated' );

if ( $sidebars_updated ) {
	$list_sidebar = get_option( 'pennews_custom_sidebars', array() );

	list( $before_widget, $before_title, $after_title ) = Penci_PenNews_MG_Helper::get_param_sidebars();

	$jannah_options  = get_option( 'tie_options' );
	$custom_sidebars = isset( $jannah_options['sidebars'] ) ? $jannah_options['sidebars'] : array();
	if ( ! empty( $custom_sidebars ) && is_array( $custom_sidebars ) ) {
		foreach ( $custom_sidebars as $sidebar ) {

			$list_sidebar[ $sidebar ] = array(
				'class'         => 'pennews-custom-sidebar',
				'id'            => sanitize_title( $sidebar ),
				'name'          => $sidebar,
				'description'   => '',
				'before_widget' => $before_widget,
				'after_widget'  => '</div>',
				'before_title'  => $before_title,
				'after_title'   => $after_title
			);
		}
	}

	$custom_sidebars = update_option( 'pennews_custom_sidebars', $list_sidebar );
	if ( $custom_sidebars ) {
		update_option( 'sahifa_custom_sidebars_updated', 1 );
		$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'custom_sidebar', timer_stop() );
	}
}

// Post layout
$post_layout  = get_post_meta( $post_id, 'tie_sidebar_pos', true );
$post_sidebar = get_post_meta( $post_id, 'tie_sidebar_post', true );

$post_layout_pre = 'sidebar-right';
if ( 'left' == $post_layout ) {
	$post_layout_pre = 'sidebar-left';
} elseif ( 'one-column' == $post_layout ) {
	$post_layout_pre = 'no-sidebar-wide';
} elseif ( 'full' == $post_layout ) {
	$post_layout_pre = 'no-sidebar';
}

$single_sidebar_pos   = update_post_meta( $post_id, 'single_sidebar_pos', $post_layout_pre );
$single_sidebar_left  = update_post_meta( $post_id, 'single_sidebar_left', $post_sidebar );
$single_sidebar_right = update_post_meta( $post_id, 'single_sidebar_right', $post_sidebar );

$single_sidebar_left  = get_post_meta( $post_id, 'single_sidebar_left' );
$single_sidebar_right = get_post_meta( $post_id, 'single_sidebar_right' );

if ( $single_sidebar_left || $single_sidebar_right ) {
	update_post_meta( $post_id, 'penci_use_option_current_single', 1 );
}

if ( $single_sidebar_pos ) {
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'post_layout' );
}


// Review
$review_style = get_post_meta( $post_id, 'taq_review_style', true );
$review_style = 'style_3';
if( 'percentage' == $score_type ) {
	$review_style = 'style_2';
}elseif( 'points' == $score_type ) {
	$review_style = 'style_1';
}

$penci_review = array(
	'penci_review_style' => $review_style,
	'penci_review_title' => get_post_meta( $post_id, 'taq_review_title', true ),
	'penci_review_des'   => get_post_meta( $post_id, 'taq_review_summary', true ),
	'penci_review_1'     => '',
	'penci_review_1_num' => '',
	'penci_review_2'     => '',
	'penci_review_2_num' => '',
	'penci_review_3'     => '',
	'penci_review_3_num' => '',
	'penci_review_4'     => '',
	'penci_review_4_num' => '',
	'penci_review_5'     => '',
	'penci_review_5_num' => '',
	'penci_review_good'  => '',
	'penci_review_bad'   => '',
);

$get_criteria = get_post_meta( $post_id, 'taq_review_criteria', true );

if ( ! empty( $get_criteria ) ) {
	$percents_count = 1;
	foreach ( $get_criteria as $section) {
		$desc = isset( $section['name'] ) ? $section['name'] : '';
		$rate = isset( $section['score'] ) ? $section['score'] / 10 : '';

		if ( $desc || $rate ) {
			$penci_review[ 'penci_review_' . $percents_count ]          = $desc;
			$penci_review[ 'penci_review_' . $percents_count . '_num' ] = $rate;
		}

		$percents_count ++;
	}
}
$penci_review_updated = update_post_meta( $post_id, 'penci_review', $penci_review );

if( $penci_review_updated ){
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'review' );
}

$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'success', timer_stop() );

return ( $mess ? implode( '<br>', $mess ) : '' );