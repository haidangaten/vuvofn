<?php

$mess = array();

// Update custom sidebar
$sidebars_updated = get_option( 'vlog_custom_sidebars_updated' );
if ( ! $sidebars_updated ) {
	$list_sidebar = get_option( 'pennews_custom_sidebars', array() );

	list( $before_widget, $before_title, $after_title ) = Penci_PenNews_MG_Helper::get_param_sidebars();

	for ( $i = 1; $i <= 10; $i ++ ) {
		$list_sidebar[ 'custom-sidebar-' . $i ] = array(
			'class'         => 'pennews-custom-sidebar',
			'id'            => 'custom-sidebar-' . $i,
			'name'          => sprintf( esc_html__( 'Custom Sidebar %s', 'penci-framework' ), $i ),
			'description'   => '',
			'before_widget' => $before_widget,
			'after_widget'  => '</div>',
			'before_title'  => $before_title,
			'after_title'   => $after_title
		);
	}

	$custom_sidebars = update_option( 'pennews_custom_sidebars', $list_sidebar );
	if ( $custom_sidebars ) {
		update_option( 'vlog_custom_sidebars_updated', 1 );
		$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'custom_sidebar', timer_stop() );
	}
}

// Update post sidebar

$post_layout  = get_post_meta( $post_id, 'penci_post_sidebar_display', true );
$post_sidebar = get_post_meta( $post_id, 'penci_custom_sidebar_page_display', true );

$post_layout_pre = 'sidebar-right';
if ( 'left' == $post_layout ) {
	$post_layout_pre = 'sidebar-left';
} elseif ( 'no' == $post_layout ) {
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

/**
 * Review
 */

$penci_review         = array(
	'penci_review_style' => 'style_1',
	'penci_review_title' => get_post_meta( $post_id, 'penci_review_title', true ),
	'penci_review_des'   => get_post_meta( $post_id, 'penci_review_des', true ),
	'penci_review_1'     => get_post_meta( $post_id, 'penci_review_1', true ),
	'penci_review_1_num' => get_post_meta( $post_id, 'penci_review_1_num', true ),
	'penci_review_2'     => get_post_meta( $post_id, 'penci_review_2', true ),
	'penci_review_2_num' => get_post_meta( $post_id, 'penci_review_2_num', true ),
	'penci_review_3'     => get_post_meta( $post_id, 'penci_review_3', true ),
	'penci_review_3_num' => get_post_meta( $post_id, 'penci_review_3_num', true ),
	'penci_review_4'     => get_post_meta( $post_id, 'penci_review_4', true ),
	'penci_review_4_num' => get_post_meta( $post_id, 'penci_review_4_num', true ),
	'penci_review_5'     => get_post_meta( $post_id, 'penci_review_5', true ),
	'penci_review_5_num' => get_post_meta( $post_id, 'penci_review_5_num', true ),
	'penci_review_good'  => get_post_meta( $post_id, 'penci_review_good', true ),
	'penci_review_bad'   => get_post_meta( $post_id, 'penci_review_bad', true ),
);
$penci_review_updated = update_post_meta( $post_id, 'penci_review', $penci_review );

if ( $penci_review_updated ) {
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'review' );
}

/**
 * Recipe
 */
$penci_recipe         = array(
	'penci_recipe_title'           => get_post_meta( $post_id, 'penci_recipe_title', true ),
	'penci_recipe_servings'        => get_post_meta( $post_id, 'penci_recipe_servings', true ),
	'penci_recipe_preptime'        => get_post_meta( $post_id, 'penci_recipe_preptime', true ),
	'penci_recipe_preptime_format' => get_post_meta( $post_id, 'penci_recipe_preptime_format', true ),
	'penci_recipe_cooktime'        => get_post_meta( $post_id, 'penci_recipe_cooktime', true ),
	'penci_recipe_cooktime_format' => get_post_meta( $post_id, 'penci_recipe_cooktime_format', true ),
	'penci_recipe_instructions'    => get_post_meta( $post_id, 'penci_recipe_ingredients', true ),
	'penci_recipe_ingredients'     => get_post_meta( $post_id, 'penci_recipe_instructions', true ),
	'penci_recipe_note'            => get_post_meta( $post_id, 'penci_recipe_note', true ),
);
$penci_recipe_updated = update_post_meta( $post_id, 'penci_recipe', $penci_recipe );
if ( $penci_recipe_updated ) {
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'recipe' );
}

/**
 * Penci Slider
 */

if ( $mess ) {
	$mess[] = Penci_PenNews_MG_Helper::get_mess_by_type( $post_id, 'success', timer_stop() );
}

return ( $mess ? implode( '<br>', $mess ) : '' );