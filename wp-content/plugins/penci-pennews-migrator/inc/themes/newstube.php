<?php
//  Post sidebar
$post_sidebar = get_post_meta( $post_id, 'post_sidebar', true );

$post_layout_pre = 'sidebar-right';

if ( 'right' == $post_sidebar ) {
	$post_layout_pre = 'sidebar-right';
} elseif ( 'left' == $post_sidebar ) {
	$post_layout_pre = 'sidebar-left';
} elseif ( 'hidden' == $post_sidebar ) {
	$post_layout_pre = 'no-sidebar-wide';
}
$single_sidebar_pos = update_post_meta( $post_id, 'single_sidebar_pos', $post_layout_pre );

// Review
$tmr_options                 = get_option( 'tmr_options_group' );
$tmr_options['tmr_criteria'] = isset( $tmr_options['tmr_criteria'] ) ? $tmr_options['tmr_criteria'] : '';

// Review title
$review_title = get_post_meta( $post_id, 'review_title', true );
if ( empty( $review_title ) && isset( $tmr_options['tmr_title'] ) ) {
	$review_title = $tmr_options['tmr_title'];
}

// Review type
$score_type = get_post_meta( $post_id, 'rate_type', true );
if ( empty( $score_type ) && isset( $tmr_options['tmr_rate_type'] ) ) {
	$review_title = $tmr_options['tmr_rate_type'];
}

$review_style = 'style_1';
if ( 'stars' == $score_type ) {
	$review_style = 'style_3';
}

$penci_review = array(
	'penci_review_style' => $review_style,
	'penci_review_title' => get_post_meta( $post_id, 'review_title', true ),
	'penci_review_des'   => get_post_meta( $post_id, 'final_summary', true ),
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

$custom_review = get_post_meta( $post_id, 'custom_review', true );

if ( $custom_review ) {
	$points_count = 1;
	foreach ( $custom_review as $review ) {

		$desc = isset( $review['title'] ) ? $review['title'] : '';
		$rate = isset( $review['review_point'] ) ? number_format( $review['review_point'] / 10, 1 ) : '';

		if ( $desc || $rate ) {
			$penci_review[ 'penci_review_' . $points_count ]          = $desc;
			$penci_review[ 'penci_review_' . $points_count . '_num' ] = $rate;
		}

		$points_count ++;
	}
}


$penci_review_updated = update_post_meta( $post_id, 'penci_review', $penci_review );

if ( $penci_review_updated ) {
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'review' );
}


$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'success', timer_stop() );

return ( $mess ? implode( '<br>', $mess ) : '' );