<?php

$mess =  array();


// Post format
$post_format =  get_post_format( $post_id );
$td_post_video = get_post_meta( $id, 'td_post_video', true );
if( isset( $td_post_video['td_video'] ) && $td_post_video['td_video'] ) {
	$video_url_updated = get_post_meta( $post_id, '_format_video_embed', $td_post_video['td_video'] );

	if( $video_url_updated ) {
		$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'video_url' );
	}
}

// Count views
$views_all = (int) get_post_meta( $post_id, 'post_views_count', true );
if( ! empty( $views_all ) ){
	$views_all_updated = update_post_meta( $post_id, '_count-views_all',$views_all  );

	if( $views_all_updated ) {
		$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'count_views' );
	}
}

// Review
$post_settings = get_post_meta( $post_id, 'td_post_theme_settings', true );

$has_review    =  isset( $post_settings['has_review'] ) ? $post_settings['has_review'] : 'rate_point';

$review_style = 'style_1';

$penci_review = array(
	'penci_review_style' => 'style_1',
	'penci_review_title' => esc_html__( 'Review overview', 'penci-pennews-migrator' ),
	'penci_review_des'   => isset( $post_settings['review'] ) ? $post_settings['review'] : '',
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

if ( 'rate_point' == $has_review ) {
	$penci_review['penci_review_style'] = 'style_1';

	if ( ! empty( $post_settings['p_review_points'] ) ) {
		$points_count = 1;
		foreach ($post_settings['p_review_points'] as $section) {
			$desc = isset( $section['desc'] ) ? $section['desc'] : '';
			$rate = isset( $section['rate'] ) ? $section['rate'] : '';

			if ( $desc || $rate ) {
				$penci_review[ 'penci_review_' . $points_count ]          = $desc;
				$penci_review[ 'penci_review_' . $points_count . '_num' ] = $rate;
			}

			$points_count ++;
		}
	}
} elseif ( 'rate_percent' == $has_review ) {
	$penci_review['penci_review_style'] = 'style_2';

	if ( ! empty( $post_settings['p_review_percents'] ) ) {
		$percents_count = 1;
		foreach ($post_settings['p_review_percents'] as $section) {
			$desc = isset( $section['desc'] ) ? $section['desc'] : '';
			$rate = isset( $section['rate'] ) ? $section['rate'] : '';

			if ( $desc || $rate ) {
				$penci_review[ 'penci_review_' . $percents_count ]          = $desc;
				$penci_review[ 'penci_review_' . $percents_count . '_num' ] = $rate;
			}

			$percents_count ++;
		}
	}

} elseif ( 'rate_stars' == $has_review ) {
	$penci_review['penci_review_style'] = 'style_3';

	if ( ! empty( $post_settings['p_review_stars'] ) ) {
		$stars_count = 1;
		foreach ($post_settings['p_review_stars'] as $section) {
			$desc = isset( $section['desc'] ) ? $section['desc'] : '';
			$rate = isset( $section['rate'] ) ? $section['rate'] : '';

			if ( $desc || $rate ) {
				$penci_review[ 'penci_review_' . $stars_count ]          = $desc;
				$penci_review[ 'penci_review_' . $stars_count . '_num' ] = $rate;
			}

			$stars_count ++;
		}
	}
}

$penci_review_updated = update_post_meta( $post_id, 'penci_review', $penci_review );

if( $penci_review_updated ){
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'review' );
}

$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'success', timer_stop() );


return ( $mess ? implode( '<br>', $mess ) : '' );