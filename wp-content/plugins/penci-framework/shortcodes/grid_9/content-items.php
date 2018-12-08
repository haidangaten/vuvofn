<?php
$grid_9_i = 1;
$items    = '';
while ( $query_slider->have_posts() ) {
	$query_slider->the_post();
	$items .= '<article  class="' . join( ' ', penci_get_post_class( 'penci-grid-item', get_the_ID() ) ) . '">';
	$items .='<div class="penci-post-item__inner">';
	$items .= Penci_Helper_Shortcode::get_image_holder_pre( array(
		'image_size'  => Penci_Helper_Shortcode::get_image_size_by_type( 'penci-thumb-480-320',  $atts['image_type'] ),
		'class'       => '',
		'show_icon'   => ! $atts['hide_icon_post_format'],
		'size_icon'   => 'small-size-icon icon_pos_right',
		'hide_review' => $atts['hide_review_piechart'],
	) );
	$items .= '<div class="penci_post_content">';
	$items .= Penci_Helper_Shortcode::get_markup_title_post(  $atts['post_standard_title_length'] );
	$items .= Penci_Helper_Shortcode::get_post_meta( array( 'date', 'comment' ), $atts, true, array( 'author','view' ) );
	$items .= '</div></div></article>';
	$grid_9_i ++;
}
wp_reset_postdata();

return Penci_Helper_Shortcode::pre_output_content_items( $items , $atts );