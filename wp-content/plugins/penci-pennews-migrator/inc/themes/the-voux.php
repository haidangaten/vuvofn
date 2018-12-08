<?php

// Primary Category
$cat_label = get_post_meta( $post_id, 'post-primary-category', true );

if ( $cat_label ) {
	$meta_prefix_seo = class_exists( 'WPSEO_Meta' ) ? WPSEO_Meta::$meta_prefix : '_yoast_wpseo_';
	$primary_term    = update_post_meta( $post_id, $meta_prefix_seo . 'primary_category', true );
	if( $primary_term ) {
		$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'primary_term' );
	}
}

$featured_video =  get_post_meta( $post_id, 'post_video', true );

if( $featured_video ) {
	$post_format =  get_post_format( $post_id );
	$video_url_updated = '';
	if( 'audio' == $post_format ){
		$video_url_updated = update_post_meta( $post_id, '_format_audio_embed', $featured_video );
	}else {
		$video_url_updated = update_post_meta( $post_id, '_format_video_embed', $featured_video );
	}

	if( $video_url_updated ) {
		$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'video_url' );
	}
}

// Review
$penci_review = array(
	'penci_review_style' => 'style_2',
	'penci_review_title' => get_post_meta( $post_id, 'post_ratings_title', true ),
	'penci_review_des'   => '',
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

if( $stored_criteria = get_post_meta( $id, 'post_ratings_percentage', true ) ){

	if( is_array( $stored_criteria ) ){
		$i = 1;
		foreach ( $stored_criteria as $single_criteria ) {

			if( ! empty( $single_criteria['title'] ) ){

				$score = ! empty( $single_criteria['feature_score'] ) ? $single_criteria['feature_score'] : 0;

				$penci_review[ 'penci_review_' . $i ]  = $single_criteria['title'];
				$penci_review[ 'penci_review_' . $i . '_num' ] = $score;

				$i ++;
			}
		}
	}
}

$penci_review_updated = update_post_meta( $post_id, 'penci_review', $penci_review );

if( $penci_review_updated ){
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'review' );
}

$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'success', timer_stop() );

return ( $mess ? implode( '<br>', $mess ) : '' );