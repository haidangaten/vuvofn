<?php
/**
 * Hook to change gallery
 */
if( ! penci_get_theme_mod( 'penci_hide_single_gallery' ) ):
	require get_template_directory() . '/inc/post-format/gallery.php';
endif;

require get_template_directory() . '/inc/post-format/video-format.php';
/**
 * Show entry format images, video, gallery, audio, etc.
 *
 * @param string $size
 *
 * @return void
 */
function penci_post_formats( $size = 'thumbnail', $show = false, $parallax = false ) {
	$html  = '';
	$post_id = get_the_ID();
	$thumb = get_the_post_thumbnail( $post_id, $size );
	$show_cap = penci_get_setting( 'penci_show_single_featured_img_cap' );
	$single_style = penci_get_setting( 'penci_single_template' );

	$caption = $image_src = '';
	if ( is_singular() ) {
		$thumbnail_id   = get_post_thumbnail_id( $post_id );
		$get_image_info = wp_get_attachment_image_src( $thumbnail_id, 'penci-thumb-1920-auto' );

		$image_src = isset( $get_image_info[0] ) ? $get_image_info[0] : '';

		if ( $show_cap && in_array( $single_style, array( 'style-1','style-2','style-9','style-10' ) ) ) {
			$caption = get_post_field( 'post_excerpt', $thumbnail_id );
		}
	}

	$href = '';
	$img_tag = 'div';
	$img_a = 'post-image penci-standard-format';
	$featured_img_action =  penci_get_theme_mod( 'penci_single_featured_img_action' );

	if( $featured_img_action ) {
		$href = ' href="' . esc_url( $image_src ) . '"';
		$img_tag = 'a';

		if( 'lightbox' == $featured_img_action ){
			$img_a .= ' penci-image-popup-no-margins';
		}
	}

	$default_img = sprintf( '<%s class="%s"%s>%s%s</%s>',
		$img_tag,
		$img_a,
		$href,
		$thumb,
		$caption ? '<div class="penci-wp-caption"><figcaption class="penci-wp-caption-text">' . $caption . '</figcaption></div>' : '',
		$img_tag
	);

	if( $parallax ) {
		$default_img = '<div class="penci-jarallax"><img class="jarallax-img" src="' . esc_attr( $image_src ) . '" alt="Image default"></div>';
	}


	switch ( get_post_format() ) {
		case 'video':
			$video = get_post_meta( $post_id, '_format_video_embed', true );
			$html .= Penci_Video_Format::show_video_embed( $video, $parallax );
			break;
		case 'audio':
			$audio = get_post_meta( $post_id, '_format_audio_embed', true );
			$audio_str = substr( $audio, -4 );

			if ( has_post_thumbnail() ) {
				$html .= $thumb;
			}

			$html .='<div class="audio-iframe">';
			if ( wp_oembed_get( $audio ) ) {
				$html .= wp_oembed_get( $audio );
			}elseif( $audio_str == '.mp3' ) {
				$html .= do_shortcode('[audio src="'. esc_url( $audio ) .'"]');
			}else {
				$html .= do_shortcode( $audio );
			}

			$html .= '</div>';
			break;
		case 'gallery':
			$images = get_post_meta( $post_id, '_format_gallery_images', true );

			if( $images ) {
				$html .= '<div class="penci-owl-carousel-slider popup-gallery-slider" data-auto-height="true" data-items="1" data-autotime="4000" data-speed="600" data-loop="0" data-nav="1">';
				foreach ( $images as $image ){
					$the_image = wp_get_attachment_image_src( $image, $size );
					$the_caption = get_post_field( 'post_excerpt', $image );
					$image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true);

					if( empty( $the_image[0] ) ) {
						continue;
					}

					$html .= sprintf( '<a class="%s" href="%s" %s><img src="%s" title="%s" alt="%s"/></a>',
						penci_check_lazyload_type( 'class', null, false ),
						esc_url( $the_image[0] ),
						penci_check_lazyload_type( 'src', esc_url( $the_image[0] ), false ),
						esc_url( $the_image[0] ),
						$the_caption,
						$image_alt ? $image_alt : get_the_title( $post_id )
						);
				}
				$html .='</div>';
			}
			break;
		default:
			if ( empty( $thumb ) ) {
				return;
			}
	}

	if( empty( $html ) && !empty( $thumb ) ) {
		$html .= $default_img;
	}

	if( ! $show ) {
		return '<div class="post-format-meta ' . ( ( ! has_post_thumbnail() ) ? ' no-thumbnail' : '' ) . '">' . ( function_exists( 'penci_balanceTags' ) ?  penci_balanceTags( $html ) : $html ) . '</div>';
	}

	echo '<div class="post-format-meta ' . ( ( ! has_post_thumbnail() ) ? ' no-thumbnail' : '' ) . '">' . ( function_exists( 'penci_balanceTags' ) ?  penci_balanceTags( $html ) : $html ) . '</div>';
}

