<?php
// Post format

$post_format       = get_post_format( $post_id );
$video_url_updated = '';
if ( 'gallery' == $post_format ) {
	$featured_gallery  = get_post_meta( $post_id, 'cb_gallery_post_images', true );
	$video_url_updated = update_post_meta( $post_id, '_format_gallery_images', $featured_gallery );
} elseif ( 'audio' == $post_format ) {
	$featured_audio    = get_post_meta( $post_id, 'cb_audio_post_url', true );
	$video_url_updated = update_post_meta( $post_id, '_format_audio_embed', $featured_audio );
} elseif ( 'video' == $post_format ) {
	$featured_video    = get_post_meta( $post_id, 'cb_video_embed_code_post', true );
	$video_url_updated = update_post_meta( $post_id, '_format_video_embed', $featured_video );
}

if( $video_url_updated ) {
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'video_url' );
}

$post_layout = get_post_meta( $post_id, 'cb_full_width_post', true );

$post_layout_pre = 'sidebar-right';

if( 'sidebar' == $post_layout ){
	$post_layout_pre = 'sidebar-right';
}elseif( 'sidebar_left' == $post_layout ){
	$post_layout_pre = 'sidebar-left';
}elseif( 'nosidebar' == $post_layout ){
	$post_layout_pre = 'no-sidebar-wide';
}elseif( 'nosidebar-fw' == $post_layout ){
	$post_layout_pre = 'no-sidebar';
}

$single_sidebar_pos =  update_post_meta( $post_id, 'single_sidebar_pos', $post_layout_pre );

// Review
$score_type   = get_post_meta( $post_id, 'cb_score_display_type', true );

$review_style = 'style_1';
if( 'percentage' == $score_type ) {
	$review_style = 'style_2';
}elseif( 'stars' == $score_type ) {
	$review_style = 'style_3';
}

$penci_review = array(
	'penci_review_style' => $review_style,
	'penci_review_title' => get_post_meta( $post_id, 'cb_review_title_user', true ),
	'penci_review_des'   => get_post_meta( $post_id, 'cb_rating_short_summary_in', true ),
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

$cb_rev_crits = get_post_meta( $post_id, 'cb_review_crits', true );

if ( $cb_rev_crits != NULL ) {

	$points_count = 1;
	foreach ( $cb_rev_crits as $cb_rev_crit ) {

		$desc = isset( $cb_rev_crit['title'] ) ? $cb_rev_crit['title'] : '';
		$rate = isset( $cb_rev_crit['cb_cs'] ) ? $cb_rev_crit['cb_cs'] / 10 : '';

		if ( $desc || $rate ) {
			$penci_review[ 'penci_review_' . $points_count ]          = $desc;
			$penci_review[ 'penci_review_' . $points_count . '_num' ] = $rate;
		}

		$points_count ++;
	}
}

$penci_review_updated = update_post_meta( $post_id, 'penci_review', $penci_review );

if( $penci_review_updated ){
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'review' );
}

$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'success', timer_stop() );

return ( $mess ? implode( '<br>', $mess ) : '' );