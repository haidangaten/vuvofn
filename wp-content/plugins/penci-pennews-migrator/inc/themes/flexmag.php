<?php
// Post format
$featured_video =  get_post_meta( $post_id, 'mvp_video_embed', true );

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

$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'success', timer_stop() );


return ( $mess ? implode( '<br>', $mess ) : '' );