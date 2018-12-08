<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Penci_PenNew_Slider_Shortcode {

	function __construct() {
		//[penci_custom_slider slider_id='123']

		add_shortcode( 'penci_custom_slider', array( $this, 'penci_slider' ) );
	}


	public function get_button_item_slider() {

	}

	/**
	 * Out put shortcode timetable
	 */
	public function penci_slider( $atts, $content ) {

		if ( empty( $atts['slider_id'] ) ) {
			return '';
		}


		$id_slider       = intval( $atts['slider_id'] );
		$slider_settings = get_post_meta( $id_slider, 'penci_sliders', true );

		if ( empty( $slider_settings ) ) {
			return '';
		}


		$slider_fullscreen = get_post_meta( $id_slider, 'slider_fullscreen', true );
		$slider_height = get_post_meta( $id_slider, 'slider_height', true );
		$slider_height = $slider_height ? $slider_height : '650';

		$rand_slider = rand( 100, 9999 );

		$output = '<div class="featured-area-custom-slider featured-area featured-area-' . $rand_slider . '">';
		$output .= sprintf( '<div id="penci-slider-%s" class="penci-owl-carousel-slider penci-owl-featured-area %s%s"  %s %s>',
			$id_slider,
			isset( $atts['class'] ) ? $atts['class'] : '',
			$slider_fullscreen ? ' penci-slider-fullscreen' : '',
			$this->get_data_slider( $id_slider ),
			!$slider_fullscreen && $slider_height ? 'style="max-height:' . esc_attr( $slider_height ) . 'px"' : ''

		);

		wp_enqueue_script( 'jarallax-video' );

		$css_slider = $this->update_speed_slider( $id_slider );


		foreach ( $slider_settings as $key => $slider_setting ) {

			/* Get data of this slide */

			$slider_title = ! empty( $slider_setting['_slider_title'] ) ? $slider_setting['_slider_title'] : '';
			$caption      = ! empty( $slider_setting['_slider_caption'] ) ? $slider_setting['_slider_caption'] : '';

			$button_text  = ! empty( $slider_setting['_slider_button'] ) ? $slider_setting['_slider_button'] : '';
			$button_url   = ! empty( $slider_setting['_slider_button_url'] ) ? $slider_setting['_slider_button_url'] : '';
			$button2_text  = ! empty( $slider_setting['_slider_button2'] ) ? $slider_setting['_slider_button2'] : '';
			$button2_url   = ! empty( $slider_setting['_slider_button2_url'] ) ? $slider_setting['_slider_button2_url'] : '';

			$slider_align = ! empty( $slider_setting['_slide_alignment'] ) ? $slider_setting['_slide_alignment'] : 'center';
			$animation    = ! empty( $slider_setting['_slide_element_animation'] ) ? $slider_setting['_slide_element_animation'] : '';
			$title_cap_bg = ! empty( $slider_setting['title-cap-bg'] ) ? $slider_setting['title-cap-bg'] : '';

			$style_button  = '';
			$style_button2 = '';
			$button_html   = $button2_html = '';

			if ( ! empty( $button_text ) ) {

				$button1_type = isset( $slider_setting['button1_type'] ) ? $slider_setting['button1_type'] : '';
				$button1_class = 'pencislider-button-text pencislider-btn-1';
				$button1_class .= 'simple' != $button1_type ? ' button' : '';
				$button1_class .= $button1_type ? ' pencislider-btn-' . $button1_type : '';

				$button_html = '<span class="' . $button1_class . '" style="' . $style_button . '">' . $button_text . '</span>';
				$button_url  = ! $button_url ? '' : $button_url;
				if ( ! empty( $button_url ) ):
					$button_html = '<a class="' . $button1_class . '" style="' . $style_button . '" href="' . esc_url( $button_url ) . '">' . wp_kses_post( $button_text ) . '</a>';
				endif;
			}

			if ( ! empty( $button2_text ) ) {

				$button2_type = isset( $slider_setting['button2_type'] ) ? $slider_setting['button2_type'] : '';
				$button2_class = 'pencislider-button-text pencislider-btn-2';
				$button2_class .= 'simple' != $button2_type ? ' button' : '';
				$button2_class .= $button2_type ? ' pencislider-btn-' . $button2_type : '';

				$button2_html = '<span class="' . $button2_class . '" style="' . $style_button2 . '">' . $button2_text . '</span>';
				$button2_url  = ! $button2_url ? '' : $button2_url;
				if ( ! empty( $button2_url ) ):
					$button2_html = '<a class="' . $button2_class . '" style="' . $style_button2 . '" href="' . esc_url( $button2_url ) . '">' . wp_kses_post( $button2_text ) . '</a>';
				endif;
			}

			$open_link_html = $close_link_html = '';
			if ( $button_url ) {
				$open_link_html  = '<a href="' . esc_url( $button_url ) . '">';
				$close_link_html = '</a>';
			}


			$background_video = $this->get_background_video( $slider_setting, $id_slider );
			$style_slider_item = $this->get_style_item_slider( $slider_setting, $id_slider );

			if ( ! empty( $style_slider_item ) ) {

				$output .= '<div class="penci-slider__item penci-slider__item-'. $key .' penci-image-holder' . ( ! $background_video ? ' penci-jarallax-slider penci-jarallax-inviewport' : '' ) . '" style="' . $style_slider_item . '">';
			
				if( $background_video ) {
					$elementinviewport = get_post_meta( $id_slider, 'elementinviewport', true );
					$output .= sprintf( '<div class="penci-jarallax-slider%s" style="height: %spx;" data-video-src="%s"></div>',
						! $elementinviewport ? ' penci-jarallax-inviewport' : '',
						$this->get_height_slider( $id_slider ),
						$this->get_background_video( $slider_setting, $id_slider )
					);
				}

				$output .= sprintf( '<div class="penci-custom-slider-container penci-%s %s">',
					esc_attr( $animation ),
					$this->get_class_align( $slider_align )
				);
				$output .= '<div class="pencislider-content">';

				$bg_title = $bgcaption = '';

				if( ! empty( $slider_setting['_slider_title_bgcolor'] ) && function_exists( 'penci_convert_hex_rgb' ) ) {
					$bg_title = 'style=" background-color:' . penci_convert_hex_rgb( $slider_setting['_slider_title_bgcolor'], '0.4' ) . ';"';
				}

				if( ! empty( $slider_setting['_slider_caption_bgcolor'] ) && function_exists( 'penci_convert_hex_rgb' ) ) {
					$bgcaption = 'style=" background-color:' . penci_convert_hex_rgb( $slider_setting['_slider_caption_bgcolor'], '0.4' ) . ';"';
				}

				if ( ! empty( $slider_title ) ) {
					$output .= sprintf( '<h2 class="pencislider-title" style="%s">%s<span class="%s" %s>%s</span>%s</h2>',
						$this->get_style_title( $slider_setting ),
						$open_link_html,
						$title_cap_bg ? 'pencititle-inner-bg' : '',
						$title_cap_bg ? $bg_title : '',
						$slider_title,
						$close_link_html
					);
				}

				if ( ! empty( $caption ) ) {
					$output .= sprintf( '<div class="pencislider-caption" style="%s"><span class="%s" %s>%s</span></div>',
						$this->get_style_caption( $slider_setting ),
						$title_cap_bg ? 'pencicaption-inner-bg' : '',
						$title_cap_bg ? $bgcaption : '',
						$caption
					);
				}

				if( $button_html || $button2_html )	{
					$output .= '<div class="pencislider-button">';
					$output .= $button_html;
					$output .= $button2_html;
					$output .= '</div>';
				}

				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
			}


			$css_slider .= $this->css_slider( $id_slider. ' .penci-slider__item-'. $key, $slider_setting );
		}

		$output .= '</div>';
		$output .= '</div>';


		if( $css_slider ){
			$output .= '<style>' . $css_slider . '</style>';
		}

		return $output;
	}


	function update_speed_slider( $id_slider ) {

		$auto_speed = get_post_meta( $id_slider, 'slider_auto_speed', true );
		$dots_color = get_post_meta( $id_slider, 'slider_dots_color', true );
		$dots_size = get_post_meta( $id_slider, 'slider_dots_size', true );

		$output = '';
		$id = '#penci-slider-' . $id_slider;

		if ( $auto_speed && '600' != $auto_speed ) {

			$slider_speed   = $auto_speed;
			$slider_title   = ( $slider_speed - 100 ) / 1000;
			$slider_caption = $slider_title + 0.2;
			$slider_button  = $slider_caption + 0.2;

			$output .= sprintf( '%s .penci-custom-slider-container .pencislider-title{ animation-delay:%ss;  -webkit-animation-delay: %ss; }', $id, $slider_title, $slider_title );
			$output .= sprintf( '%s .penci-custom-slider-container .pencislider-caption{ animation-delay:%ss; -webkit-animation-delay: %ss; }', $id, $slider_caption, $slider_caption );
			$output .= sprintf( '%s .penci-custom-slider-container .pencislider-content .pencislider-button{ animation-delay:%ss; -webkit-animation-delay: %ss; }', $id, $slider_button, $slider_button );
		}

		if( $dots_color ) {
			$output .= $id . ' .owl-dot.active span,' . $id . ' .owl-dot:hover span{ background-color: ' . $dots_color . ' !important; }';
			$output .= ' .featured-area-custom-slider ' . $id . ' .owl-dot span{ border-color: ' . $dots_color . '; }';
		}

		if( $dots_size ) {
			$output .= $id . ' .owl-dot span{ width: ' . $dots_size . 'px; height: ' . $dots_size . 'px; }';
		}

		return $output;
	}

	function css_slider( $id_slider, $slider_setting ) {
		$id     = '#penci-slider-' . $id_slider;
		$output = '';

		$style_button  = $this->get_style_button( $slider_setting );
		$style_button2 = $this->get_style_button_2( $slider_setting );

		if( $style_button ) {
			$output .= $id . ' .pencislider-btn-1{ ' . $style_button . ' }';
		}
		if( $style_button2 ) {
			$output .= $id . ' .pencislider-btn-2{ ' . $style_button2 . ' }';
		}

		$button1_type = isset( $slider_setting['button1_type'] ) ? $slider_setting['button1_type'] : '';

		if( ! empty( $slider_setting['_slider_btn1_hcolor'] ) ) {
			$output .= $id . ' .pencislider-btn-1:hover{ color:' . esc_attr( $slider_setting['_slider_btn1_hcolor'] ) . ' }';
		}

		if ( 'simple' !== $button1_type ) {
			if( ! empty( $slider_setting['_slider_btn_hbg'] ) ) {
				$output .= $id . ' .pencislider-btn-1:hover{ background-color:' . esc_attr( $slider_setting['_slider_btn_hbg'] ) . ' }';
			}

			if( ! empty( $slider_setting['_slider_btn_hbcolor'] ) ) {
				$output .= $id . ' .pencislider-btn-1:hover{ border-color:' . esc_attr( $slider_setting['_slider_btn_hbcolor'] ) . ' }';
			}
		}

		$button2_type = isset( $slider_setting['button2_type'] ) ? $slider_setting['button2_type'] : '';

		if( ! empty( $slider_setting['_slider_btn2_hcolor'] ) ) {
			$output .= $id . ' .pencislider-btn-2:hover{ color:' . esc_attr( $slider_setting['_slider_btn2_hcolor'] ) . ' }';
		}

		if ( 'simple' !== $button2_type ) {
			if( ! empty( $slider_setting['_slider_btn2_hbg'] ) ) {
				$output .= $id . ' .pencislider-btn-2:hover{ background-color:' . esc_attr( $slider_setting['_slider_btn2_hbg'] ) . ' }';
			}

			if( ! empty( $slider_setting['_slider_btn2_hbcolor'] ) ) {
				$output .= $id . ' .pencislider-btn-2:hover{ border-color:' . esc_attr( $slider_setting['_slider_btn2_hbcolor'] ) . ' }';
			}
		}

		if( isset( $slider_setting['_slider_content_width'] ) && $slider_setting['_slider_content_width'] ) {
			$output .= '@media screen and (min-width: ' . esc_attr( $slider_setting['_slider_content_width'] ) . 'px) {' . $id . ' .penci-custom-slider-container .pencislider-content{ max-width:' . esc_attr( $slider_setting['_slider_content_width'] ) . 'px; } }';
		}

		if( isset( $slider_setting['_slider_title_offuppear'] ) && $slider_setting['_slider_title_offuppear'] ) {
			$output .= $id . ' .penci-custom-slider-container .pencislider-content .pencislider-title{ text-transform: none; }';
		}

		return $output;
	}

	function get_background_video( $slider_setting, $id_slider ) {
		$background_type = ! empty( $slider_setting['background_type'] ) ? $slider_setting['background_type'] : '';

		if ( 'image' == $background_type ) {
			return;
		}

		$link_video = '';


		if ( 'yt_vm_video' == $background_type && ! empty( $slider_setting['yt_vm_video'] ) ) {
			$link_video = $slider_setting['yt_vm_video'];
		} elseif ( 'video' == $background_type && isset( $slider_setting['local_video'][0] ) ) {
			$metadata   = wp_get_attachment_metadata( $slider_setting['local_video'][0] );
			$fileformat = isset( $metadata['fileformat'] ) ? $metadata['fileformat'] : '';
			$link_video = $fileformat . ':' . wp_get_attachment_url( $slider_setting['local_video'][0] );
		}

		if ( ! $link_video ) {
			return '';
		}

		return $link_video;


	}

	public function get_height_slider( $id_slider ) {
		$slider_height = get_post_meta( $id_slider, 'slider_height', true );

		return $slider_height ? $slider_height : '650';
	}


	public function get_style_item_slider( $slider_setting, $id_slider ) {

		$style = '';

		$image_id = ! empty( $slider_setting['_slider_image'][0] ) ? $slider_setting['_slider_image'][0] : '';

		if ( empty( $image_id ) ) {
			return $style;
		}

		// Height slider
		$slider_height = $this->get_height_slider( $id_slider );
		$style         .= 'height:' . esc_attr( $slider_height ) . 'px;';

		$image_url = $this->get_url_image_by_size( array(
			'attach_id'  => $image_id,
			'thumb_size' => 'penci-thumb-1920-auto'
		) );

		$background_video =$this->get_background_video( $slider_setting, $id_slider );

		if( $background_video ) {

			if( false !== strpos( $background_video, 'youtu') ) {
				$urlArr = explode("/", $background_video);
				$urlArrNum = count($urlArr);

				$youtubeVideoId = $urlArr[$urlArrNum - 1];
				$youtubeVideoId = str_replace( 'watch?v=','', $youtubeVideoId );
				$image_url = 'http://img.youtube.com/vi/'.$youtubeVideoId.'/sddefault.jpg';
			}elseif( false !== strpos( $background_video, 'vimeo') ) {
				$vimeo_video_id = (int) substr(parse_url($background_video, PHP_URL_PATH), 1);
				 $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vimeo_video_id.php"));
    			$image_url = isset( $hash[0]['thumbnail_large'] ) ? $hash[0]['thumbnail_large'] : ''; 
			}
		}

		$style     .= 'background-image: url(' . esc_url( $image_url ) . ');';
		$style     .= 'background-size: cover; background-position: center center;';

		return $style;
	}

	public function get_image_item_slider( $slider_setting, $id_slider ) {

		$style = '';

		$image_id = ! empty( $slider_setting['_slider_image'][0] ) ? $slider_setting['_slider_image'][0] : '';

		if ( empty( $image_id ) ) {
			return $style;
		}


		// Height slider
		$slider_height = $this->get_height_slider( $id_slider );

		$image_url = $this->get_url_image_by_size( array(
			'attach_id'  => $image_id,
			'thumb_size' => 'penci-thumb-1920-auto'
		) );

		return $image_url;
	}

	public function get_style_title( $slider_setting ) {
		$style = '';

		$style .= ! empty( $slider_setting['_slider_title_color'] ) ? ' color:' . $slider_setting['_slider_title_color'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_title_fsize'] ) ? ' font-size:' . $slider_setting['_slider_title_fsize'] . 'px;' : '';
		$style .= ! empty( $slider_setting['_slider_title_spacing'] ) ? ' letter-spacing:' . $slider_setting['_slider_title_spacing'] . 'px;' : '';
		$style .= ! empty( $slider_setting['_slider_title_fweight'] ) ? ' font-weight:' . $slider_setting['_slider_title_fweight'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_title_fstyle'] ) ? ' font-style:' . $slider_setting['_slider_title_fstyle'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_title_family'] ) && function_exists( 'penci_google_fonts_parse_attributes' ) ? ' font-family:' . penci_google_fonts_parse_attributes( $slider_setting['_slider_title_family'] ) . ';' : '';

		if( isset( $slider_setting['_slider_title_family'] ) && $slider_setting['_slider_title_family'] ) {
			$this->enqueue_font( $slider_setting['_slider_title_family'] );
		}

		return $style;
	}

	public function enqueue_font( $font_name ) {
		$penci_font_enqueue = array( 'Mukta Vaani', 'Roboto', 'Oswald' );
		$font_family        = str_replace( '"', '', $font_name );
		$font_family_explo  = explode( ", ", $font_family );
		$font_id            = isset( $font_family_explo[0] ) ? $font_family_explo[0] : '';

		if ( $font_id && ! in_array( $font_id, $penci_font_enqueue ) ) {
			wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( urlencode( $font_id ) ), '//fonts.googleapis.com/css?family=' . urlencode( $font_id ) );
		}
	}

	public function get_style_caption( $slider_setting ) {
		$style = '';

		$style .= ! empty( $slider_setting['_slider_caption_color'] ) ? ' color:' . $slider_setting['_slider_caption_color'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_cap_fsize'] ) ? ' font-size:' . $slider_setting['_slider_cap_fsize'] . 'px;' : '';
		$style .= ! empty( $slider_setting['_slider_cap_fweight'] ) ? ' font-weight:' . $slider_setting['_slider_cap_fweight'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_cap_fstyle'] ) ? ' font-style:' . $slider_setting['_slider_cap_fstyle'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_cap_family'] ) && function_exists( 'penci_google_fonts_parse_attributes' ) ? ' font-family:' . penci_google_fonts_parse_attributes( $slider_setting['_slider_cap_family'] ) . ';' : '';

		if( isset( $slider_setting['_slider_cap_family'] ) && $slider_setting['_slider_cap_family'] ) {
			$this->enqueue_font( $slider_setting['_slider_cap_family'] );
		}


		return $style;
	}

	public function get_style_button( $slider_setting ) {
		$style = '';

		$button1_type = isset( $slider_setting['button1_type'] ) ? $slider_setting['button1_type'] : 'fill';

		if ( 'simple' !== $button1_type ) {
			if ( ! empty( $slider_setting['_slider_btn_plr'] ) ) {
				$style .= 'padding-left: ' . esc_attr( $slider_setting['_slider_btn_plr'] ) . 'px;';
				$style .= 'padding-right: ' . esc_attr( $slider_setting['_slider_btn_plr'] ) . 'px;';
			}

			if ( ! empty( $slider_setting['_slider_btn_ptb'] ) ) {
				$style .= 'padding-top: ' . esc_attr( $slider_setting['_slider_btn_ptb'] ) . 'px;';
				$style .= 'padding-bottom: ' . esc_attr( $slider_setting['_slider_btn_ptb'] ) . 'px;';
			}

			if ( ! empty( $slider_setting['_slider_btn1_radius'] ) ) {
				$style .= 'border-radius: ' . esc_attr( $slider_setting['_slider_btn1_radius'] ) . 'px;';
			}

			if ( isset( $slider_setting['_slider_btn1_width'] ) && $slider_setting['_slider_btn1_width'] ) {
				$style .= 'border-width: ' . esc_attr( $slider_setting['_slider_btn1_width'] ) . 'px;';
			}

			if ( ! empty( $slider_setting['_slider_button_bcolor'] ) ) {
				$style .= 'border-color: ' . esc_attr( $slider_setting['_slider_button_bcolor'] ) . ';';
			}elseif( ! empty( $slider_setting['_slider_button_bcolor'] ) ) {
				$style .= 'border-color:' . $slider_setting['_slider_button2_bg'] . ';';
			}


			if( ! empty( $slider_setting['_slider_button_bg'] ) && 'fill' == $button1_type ) {
				$style .= 'background-color:' . $slider_setting['_slider_button_bg'] . ';';
			}
		}


		$style .= ! empty( $slider_setting['_slider_button_text_color'] ) ? ' color:' . $slider_setting['_slider_button_text_color'] . ';' : '';

		$style .= ! empty( $slider_setting['_slider_button_fsize'] ) ? ' font-size:' . $slider_setting['_slider_button_fsize'] . 'px;' : '';
		$style .= ! empty( $slider_setting['_slider_button_fweight'] ) ? ' font-weight:' . $slider_setting['_slider_button_fweight'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_button1_fstyle'] ) ? ' font-style:' . $slider_setting['_slider_button1_fstyle'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_button_family'] ) && function_exists( 'penci_google_fonts_parse_attributes' ) ? ' font-family:' . penci_google_fonts_parse_attributes( $slider_setting['_slider_button_family'] ) . ';' : '';

		if( isset( $slider_setting['_slider_button_family'] ) && $slider_setting['_slider_button_family'] ) {
			$this->enqueue_font( $slider_setting['_slider_button_family'] );
		}

		return $style;
	}

	public function get_style_button_2( $slider_setting ) {
		$style = '';

		$button1_type = isset( $slider_setting['button2_type'] ) ? $slider_setting['button2_type'] : '';

		if ( 'simple' !== $button1_type ) {
			if ( ! empty( $slider_setting['_slider_btn2_plr'] ) ) {
				$style .= 'padding-left: ' . esc_attr( $slider_setting['_slider_btn2_plr'] ) . 'px;';
				$style .= 'padding-right: ' . esc_attr( $slider_setting['_slider_btn2_plr'] ) . 'px;';
			}

			if ( ! empty( $slider_setting['_slider_btn2_ptb'] ) ) {
				$style .= 'padding-top: ' . esc_attr( $slider_setting['_slider_btn2_ptb'] ) . 'px;';
				$style .= 'padding-bottom: ' . esc_attr( $slider_setting['_slider_btn2_ptb'] ) . 'px;';
			}

			if ( ! empty( $slider_setting['_slider_btn2_radius'] ) ) {
				$style .= 'border-radius: ' . esc_attr( $slider_setting['_slider_btn2_radius'] ) . 'px;';
			}

			if ( isset( $slider_setting['_slider_btn2_width'] ) && $slider_setting['_slider_btn2_width'] ) {
				$style .= 'border-width: ' . esc_attr( $slider_setting['_slider_btn2_width'] ) . 'px;';
			}

			if ( ! empty( $slider_setting['_slider_button2_bcolor'] ) ) {
				$style .= 'border-color: ' . esc_attr( $slider_setting['_slider_button2_bcolor'] ) . ';';
			}elseif( ! empty( $slider_setting['_slider_button2_bg'] ) ) {
				$style .= 'border-color: ' . esc_attr( $slider_setting['_slider_button2_bcolor'] ) . ';';
			}

			if( ! empty( $slider_setting['_slider_button2_bg'] ) && 'fill' == $button1_type ) {
				$style .= 'background-color:' . $slider_setting['_slider_button2_bg'] . ';';
			}
		}

		if( ! empty( $slider_setting['_slider_button2_color'] ) ) {
			$style .= 'color:' . $slider_setting['_slider_button2_color'] . ';';
		}

		if( ! empty( $slider_setting['_slider_mgn_left'] ) ) {
			$style .= 'margin-left:' . $slider_setting['_slider_mgn_left'] . 'px;';
		}

		$style .= ! empty( $slider_setting['_slider_button2_fsize'] ) ? ' font-size:' . $slider_setting['_slider_button2_fsize'] . 'px;' : '';
		$style .= ! empty( $slider_setting['_slider_button2_fweight'] ) ? ' font-weight:' . $slider_setting['_slider_button2_fweight'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_button2_fstyle'] ) ? ' font-style:' . $slider_setting['_slider_button2_fstyle'] . ';' : '';
		$style .= ! empty( $slider_setting['_slider_button2_family'] ) && function_exists( 'penci_google_fonts_parse_attributes' ) ? ' font-family:' . penci_google_fonts_parse_attributes( $slider_setting['_slider_button2_family'] ) . ';' : '';

		if( isset( $slider_setting['_slider_button2_family'] ) && $slider_setting['_slider_button2_family'] ) {
			$this->enqueue_font( $slider_setting['_slider_button2_family'] );
		}

		return $style;
	}

	public function get_data_slider( $id_slider ) {


		$auto              = get_post_meta( $id_slider, 'slider_autoplay', true );
		$auto_time         = get_post_meta( $id_slider, 'slider_auto_time', true );
		$auto_speed        = get_post_meta( $id_slider, 'slider_auto_speed', true );
		$slider_fullscreen = get_post_meta( $id_slider, 'slider_fullscreen', true );
		$slider_dots       = get_post_meta( $id_slider, 'slider_dots', true );
		$slider_nav        = get_post_meta( $id_slider, 'slider_nav', true );
		$slider_height     = $this->get_height_slider( $id_slider );

		// Data slider
		$data = 'data-style="penci_custom_slider"';
		$data .= ' data-auto="' . $auto . '"';
		$data .= ' data-autotime="' . ( ! empty( $auto_time ) ? $auto_time : 4000 ) . '"';
		$data .= ' data-speed="' . ( ! empty( $auto_speed ) ? $auto_speed : 600 ) . '"';
		$data .= ' data-items="1"';
		$data .= ' data-loop="0"';
		$data .= ' data-dots="' . ( ! empty( $slider_dots ) ? 1 : 0 ) . '"';
		$data .= ' data-nav="' . ( ! empty( $slider_nav ) ? 0 : 1 ) . '"';

		return $data;
	}

	public function get_url_image_by_size( $params = array() ) {
		$params = array_merge( array(
			'post_id'    => null,
			'attach_id'  => null,
			'thumb_size' => 'thumbnail',
			'class'      => '',
		), $params );


		if ( ! $params['attach_id'] && ! $params['post_id'] ) {
			return false;
		}

		$post_id = $params['post_id'];

		$attach_id   = $post_id ? get_post_thumbnail_id( $post_id ) : $params['attach_id'];
		$thumbnail = wp_get_attachment_image_src( $attach_id, $params['thumb_size'] );

		return isset( $thumbnail[0] ) ? $thumbnail[0] : '';
	}

	public function get_class_align( $slider_align ){
		$class = '';

		if( in_array( $slider_align, array( 'left50l','left','right50l' ) )  ) {
			$class .= 'align-left';
		}elseif( in_array( $slider_align, array( 'left50r','right','right50r' ) )  ) {
			$class .= 'align-right';
		}else{
			$class = 'align-' . $slider_align;
		}

		if( in_array( $slider_align, array( 'left50l','left50c','left50r' ) )  ) {
			$class .= ' penci-left-50percent';
		}elseif( in_array( $slider_align, array( 'right50l','right50c','right50r' ) )  ) {
			$class .= ' penci-right-50percent';
		}

		return $class;
	}
}


