<?php
// Count views
$view_count = (int) get_post_meta( $post_id, '_bimber_fake_view_count', true );;
if( ! empty( $view_count ) ){
	$views_all_updated = update_post_meta( $post_id, '_count-views_all',$view_count  );

	if( $views_all_updated ) {
		$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'count_views' );
	}
}

$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id,'success', timer_stop() );

return ( $mess ? implode( '<br>', $mess ) : '' );