<?php
$vlog_settings    = get_option( 'vlog_settings' );
$sidebars_updated = get_option( 'vlog_custom_sidebars_updated' );
if ( isset( $vlog_settings['sidebars'] ) && ! $sidebars_updated ) {
	$vlog_custom_sidebar = $vlog_settings['sidebars'];

	if ( ! empty( $vlog_custom_sidebar ) ) {

		$list_sidebar = get_option( 'pennews_custom_sidebars', array() );
		foreach ( $vlog_custom_sidebar as $key => $title ) {

			if ( is_numeric( $key ) ) {
				$class_before_widget = ' penci-block-vc penci-widget-sidebar';
				$class_before_widget .= ' ' . penci_get_setting( 'penci_style_block_title' );
				$class_before_widget .= ' ' . penci_get_setting( 'penci_align_blocktitle' );

				$before_widget = '<div id="%1$s" class="widget ' . $class_before_widget . ' %2$s">';
				$before_title  = '<div class="penci-block-heading"><h4 class="widget-title penci-block__title"><span>';
				$after_title   = '</span></h4></div>';

				$list_sidebar[ 'vlog_sidebar_' . $key ] = array(
					'class'         => 'pennews-custom-sidebar',
					'id'            => 'vlog_sidebar_' . $key,
					'name'          => stripcslashes( $title ),
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
			update_option( 'vlog_custom_sidebars_updated', 1 );
			$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'custom_sidebar', timer_stop() );
		}
	}
}

$_vlog_meta   = get_post_meta( $post_id, '_vlog_meta', true );
$post_layout  = isset( $_vlog_meta['use_sidebar'] ) ? $_vlog_meta['use_sidebar'] : '';
$post_sidebar = isset( $_vlog_meta['sidebar'] ) ? $_vlog_meta['sidebar'] : '';

$post_layout_pre = 'sidebar-right';
if ( 'left' == $post_layout ) {
	$post_layout_pre = 'sidebar-left';
} elseif ( 'none' == $post_layout ) {
	$post_layout_pre = 'no-sidebar-wide';
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
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'post_layout', timer_stop() );
}

$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'success', timer_stop() );

return ( $mess ? implode( '<br>', $mess ) : '' );