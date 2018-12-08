<?php

// Post format
$post_format =  get_post_format( $post_id );
$post_format_updated = '';

if ( 'video' == $post_format ) {
	$post_video          = get_post_meta( $post_id, 'add_video_url', true );
	$post_format_updated = update_post_meta( $post_id, '_format_audio_embed', $post_video );
} elseif ( 'audio' == $post_format ) {
	$post_audio          = get_post_meta( $post_id, 'add_audio_url', true );
	$post_format_updated = update_post_meta( $post_id, '_format_audio_embed', $featured_video );
} elseif ( 'gallery' == $post_format ) {
	$post_gallery        = get_post_meta( $post_id, 'post_upload_gallery', true );
	$post_format_updated = update_post_meta( $post_id, '_format_audio_embed', $post_gallery );
}

if( $post_format_updated ) {
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'video_url' );
}


// Review
$penci_review = array(
	'penci_review_style' => 'style_1',
	'penci_review_title' => get_post_meta( $post_id, 'taq_review_title', true ),
	'penci_review_des'   => get_post_meta( $post_id, 'rating_note', true ),
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

$criteria_number = get_post_meta( $post_id, 'rating_module', true );

if ( $criteria_number > 0 ) {
	$percents_count = 1;
	for ( $i = 0; $i < $criteria_number; $i ++ ) {
		$desc = get_post_meta( $post_id, 'rating_module_' . $i . '_score_label', true );
		$rate = get_post_meta( $post_id, 'rating_module_' . $i . '_score_number', true );

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