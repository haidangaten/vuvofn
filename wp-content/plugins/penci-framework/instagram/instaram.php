<?php

if ( ! class_exists( 'Penci_Instagram' ) ) {
	class Penci_Instagram {
		public function __construct() {
		}

		public static function display_images( $args ) {

			if( is_admin() ){
				return;
			}

			$username           = isset( $args['username'] ) && ! empty( $args['username'] ) ? trim( $args['username'] ) : false;
			$template           = isset( $args['template'] ) ? $args['template'] : 'slider';
			$images_number      = isset( $args['images_number'] ) ? absint( $args['images_number'] ) : 4;
			$image_type         = isset( $args['image_type'] ) ? $args['image_type'] : 'square';
			$image_size         = isset( $args['image_size'] ) ? $args['image_size'] : '480';
			$onclick            = isset( $args['onclick'] ) ? $args['onclick'] : 'link_image';
			$columns            = isset( $args['columns'] ) ? absint( $args['columns'] ) : 4;
			$refresh_hour       = isset( $args['refresh_hour'] ) ? absint( $args['refresh_hour'] ) : 5;
			$caption_words      = isset( $args['caption_words'] ) ? absint( $args['caption_words'] ) : 100;

			$hide_video_icon    = isset( $args['hide_video_icon'] ) ? $args['hide_video_icon'] : false;
			$hide_button_follow = isset( $args['hide_button_follow'] ) ? $args['hide_button_follow'] : false;
			$hide_avatar        = isset( $args['hide_avatar'] ) ? $args['hide_avatar'] : false;
			$hide_username      = isset( $args['hide_username'] ) ? $args['hide_username'] : false;
			$hide_followers     = isset( $args['hide_followers'] ) ? $args['hide_followers'] : false;

			if ( $refresh_hour == 0 ) {
				$refresh_hour = 5;
			}

			if( ! $username ) {
				esc_html_e('Please fill an instagram username.','penci-framework');
				return;
			}

			$images_data = self::get_instagram_data( $username, $refresh_hour, $images_number );

			if( ! is_array( $images_data ) ) {
				esc_html_e('No any image found. Please check it again or try with another instagram account.','penci-framework');
				return;
			}
			$images_div = '';
			if( isset($images_data['user_info']) && $images_data['user_info'] ) {

				$profile_pic_url = '';
				if (isset($images_data['user_info']['profile_pic_url'])) {
					$profile_pic_url = $images_data['user_info']['profile_pic_url'];
				}

				$followed_by = '';
				if (isset($images_data['user_info']['followed_by'])) {
					$followed_by = self::format_followers( $images_data['user_info']['followed_by'] );
				}

				if( ! $hide_avatar || ! $hide_username || ! $hide_followers ) {
					$images_div .= '<div class="penci-insta-profile penci_media_object">';
					if(  ! $hide_avatar ){
						$images_div .= '<div class="penci-insta-profile-image penci_mobj__img"><img class="penci-lazy" data-src="'. $profile_pic_url .'" alt="profile pic url" src="' . PENCI_ADDONS_URL . 'assets/img/penci-holder.png' . '"/></div>';
					}
					$images_div .= '<div class="penci-insta-meta penci_mobj__body">';
					if( ! $hide_username ) {
						$images_div .= '<div class="penci-insta-user"><a href="https://www.instagram.com/' . $username . '" target="_blank"><h4>@' . $username . '</h4></a></div>';
					}

					if( ! $hide_followers ) {
						$text_followers      = esc_html__( 'Followers', 'penci-framework' );
						$follow_followers    = esc_html__( 'Follow', 'penci-framework' );
						if( function_exists( 'penci_get_tran_setting' ) ) {
							$text_followers = penci_get_tran_setting( 'penci_social_followers_text' );
							$follow_followers    = penci_get_tran_setting( 'penci_social_follow_text' );
						}

						$images_div .= '<div class="penci-insta-followers"><span>' . $followed_by . '</span> ' . $text_followers . '</div>';
					}

					if( ! $hide_button_follow ) {
						$images_div .= '<a class="penci-insta-button button" href="https://www.instagram.com/' . $username . '" target="_blank">' . $follow_followers . '</a>';
					}
					$images_div .= '</div>';
					$images_div .= '</div>';
				}
			}

			$images_div_class = 'penci-insta-thumb';
			$images_div_class .= ' penci-insta-' . $image_type;
			$images_div_class .= 'lightbox' == $onclick ? ' penci-popup-gallery' : '';

			if( $template == 'thumbs-no-border' ) {
				$images_div_class .= ' penci-insta-no-border';
			}

			$slider_script = '';
			$unique_id = rand( 1000, 100000 );

			$images_div .= '<div id="penci-insta-thumb' . $unique_id . '" class="' . $images_div_class . '">';			

			if ( 'slider' == $template ) {
				$data = ' data-items="1"';
				$data .= ' data-auto="' . ( empty( $atts['auto_play'] ) ? 1 : 0 ) . '"';
				$data .= ' data-autotime="' . ( ! empty( $atts['auto_time'] ) ? $atts['auto_time'] : 4000 ) . '"';
				$data .= ' data-speed="' . ( ! empty( $atts['speed'] ) ? $atts['speed'] : 800 ) . '"';
				$data .= ' data-loop="' . ( ! empty( $atts['disable_loop'] ) ? 1 : 0 ) . '"';
				$data .= ' data-dots="0"';
				$data .= ' data-nav="1"';

				$images_ul = '<div class="penci-owl-carousel-slider thumbnails" ' . $data . '>';
			} else {
				$ul_class  = ( $template == 'thumbs-no-border' ) ? 'thumbnails no-border penci_col_' . $columns : 'thumbnails penci_col_' . $columns;
				$images_ul = '<ul class="no-bullet ' . $ul_class . '">';
			}

			$output = '';

			if ( is_array( $images_data ) && ! empty( $images_data ) ) {

				$output = $slider_script . $images_div . $images_ul;

				$i = 0;
				foreach ( $images_data as $key => $image_data ) {

					if ( $i >= $images_number ) {
						continue;
					}

					$image_url = isset( $image_data[ 'url_thumbnail_' . $image_size ] ) ? $image_data[ 'url_thumbnail_' . $image_size ] : '';

					if( empty( $image_url ) ) {
						continue;
					}

					$is_video     = $image_data['is_video'];
					$short_caption = preg_replace( "/[^A-Za-z0-9?! ]/", "", $image_data['caption'] );
					$short_caption = wp_trim_words( sanitize_text_field( $short_caption ), 10, '...' );

					$icon_video = '';
					if( ! $hide_video_icon && $is_video ) {
						$icon_size_icon = isset( $args['icon_size'] ) ? ' penci-insta-video-' . $args['icon_size'] : '';
						$icon_video = '<span class="penci-insta-video-type' . $icon_size_icon .  '"><i class="fa fa-play"></i></span>';
					}

					if ( 'slider' == $template ) {
						$caption = wp_trim_words( $image_data['caption'], $caption_words );
						$caption = preg_replace( '/@([a-z0-9_]+)/i', '&nbsp;<a href="https://www.instagram.com/$1/" rel="nofollow" target="_blank">@$1</a>&nbsp;', $caption );
						$caption = preg_replace( '/\#([a-zA-Z0-9_-]+)/i', '&nbsp;<a href="https://www.instagram.com/explore/tags/$1/" rel="nofollow" target="_blank">$0</a>&nbsp;', $caption );

						$time = human_time_diff( $image_data['timestamp'] );

						$output .= '<a class="instagram-item-slider" href="' . $image_data['link'] . '" target="_blank">';
						$output .= '<span class="penci-image-holder penci-lazy instagram-square-lazy" data-src="' . $image_url . '"></span>';
						$output .= $icon_video;
						$output .= '<span class="penci-insta-datacontainer">';
						$output .= '<span class="penci-insta-time">' . $time . ' ago</span>';
						$output .= '<span class="penci-insta-username">by <span>' . $username . '</span></span>';
						$output .= '<span class="penci-insta-caption">' .  wp_trim_words( sanitize_text_field( $caption ), 25, '...' ) . '</span>';
						$output .= '</span>';
						$output .= '</a>';
					} else {

						$onclick_link = $image_data['link'];

						if( 'lightbox' == $onclick ) {
							$onclick_link = isset( $image_data[ 'url_thumbnail_640' ] ) ? $image_data[ 'url_thumbnail_640' ] : $image_url;
						}elseif( 'none' == $onclick ){
							$onclick_link = '';
						}

						$output .= '<li>';

						if( $onclick_link ) {
							$output .= '<a class="instagram-item-thumbs" href="' . $onclick_link . '" target="_blank">';
						}else{
							$output .= '<span class="instagram-item-thumbs">';
						}

						$output .= $icon_video;
						$output .= '<span class="penci-image-holder penci-lazy instagram-square-lazy" data-src="' . $image_url . '"></span>';
						$output .= $onclick_link ? '</a>' : '';
						$output .= '</li>';
					}

					$i ++;
				}

				if ( 'slider' == $template ) {
					$output .= '</div>';
				} else {
					$output .= '</ul>';
				}

				$output .= '</div>';

			}

			echo $output;

		}

		public static function get_instagram_data( $username, $cache_hours, $images_number ) {
			$opt_name   = 'penci_insta_' . md5( $username );
			$insta_data = get_transient( $opt_name );
			$old_opts   = (array) get_option( $opt_name );

			$new_opts = array(
				'username'    => $username,
				'cache_hours' => $cache_hours,
			);

			if ( true === self::trigger_refresh_data( $insta_data, $old_opts, $new_opts ) ) {
				$insta_data = array();

				$response = wp_remote_get( 'https://www.instagram.com/' . trim( $username ), array( 'sslverify' => false, 'timeout' => 60 ) );

				if ( is_wp_error( $response ) ) {
					return $response->get_error_message();
				}

				if ( $response['response']['code'] == 200 ) {
					$json = self::parse_instagram_html( $response );

					$results = json_decode( $json, true );

					if ( $results === null and json_last_error() !== JSON_ERROR_NONE ) {
						return 'Error decoding the instagram json';
					}

					if ( $results && is_array( $results ) ) {
						$entry_data = isset(  $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ?  $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] : array();
						if ( empty( $entry_data ) ) {
							return __( 'No images found', 'penci-framework' );
						}


						$follows = $followed_by = $profile_pic_url = 0;
						if( isset( $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_follow']['count'] ) ) {
							$follows = $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_follow']['count'];
						}

						if( isset( $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_followed_by']['count'] ) ) {
							$followed_by = $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_followed_by']['count'];
						}

						if( isset( $results['entry_data']['ProfilePage'][0]['graphql']['user']['profile_pic_url'] ) ) {
							$profile_pic_url = $results['entry_data']['ProfilePage'][0]['graphql']['user']['profile_pic_url'];
						}

						$insta_data['user_info'] = array(
							'follows'         => $follows,
							'followed_by'     => $followed_by,
							'profile_pic_url' => $profile_pic_url
						);

						foreach ( $entry_data as $current => $result ) {

							$image_data                  = array();
							$image_data['caption']       = isset( $result['node']['edge_media_to_caption']['edges']['0']['node']['text'] ) ? sanitize_textarea_field( $result['node']['edge_media_to_caption']['edges']['0']['node']['text'] ) : '';
							$image_data['id']            = isset( $result['node']['id'] ) ? $result['node']['id']  : '';
							$image_data['link']          = isset( $result['node']['shortcode'] ) ? 'https://www.instagram.com/p/'. $result['node']['shortcode'] . '/' : '';
							$image_data['timestamp']     = isset( $result['node']['taken_at_timestamp'] ) ?  (float) $result['node']['taken_at_timestamp'] : '';
							$image_data['url']           = isset( $result['node']['display_url'] ) ? $result['node']['display_url'] : '';
							$image_data['url_thumbnail'] = isset( $result['node']['thumbnail_src'] ) ? $result['node']['thumbnail_src'] : '';
							$image_data['is_video']      = isset( $result['node']['is_video'] ) ? $result['node']['is_video'] : '';

							$thumbnail_resources = isset( $result['node']['thumbnail_resources'] ) ? $result['node']['thumbnail_resources'] : array();

							foreach ( $thumbnail_resources as $thumbnail_resource ) {
								$config_width = isset( $thumbnail_resource['config_width'] ) ? $thumbnail_resource['config_width'] : '';
								$src          = isset( $thumbnail_resource['src'] ) ? $thumbnail_resource['src'] : '';

								if ( ! $src || ! $config_width ) {
									continue;
								}

								$image_data[ 'url_thumbnail_' . $config_width ] = $src;
							}

							$insta_data[] = $image_data;
						}
					}
				} else {

					return $response['response']['message'];

				} // end -> $response['response']['code'] === 200 )


				update_option( $opt_name, $new_opts );
				if ( is_array( $insta_data ) && ! empty( $insta_data ) ) {

					set_transient( $opt_name, $insta_data, $cache_hours * 60 * 60 );
				}

			}// end -> false === $insta_data

			return $insta_data;
		}

		private static function parse_instagram_html( $response ) {
			$json = str_replace( 'window._sharedData = ', '', strstr( $response['body'], 'window._sharedData = ' ) );

			// Compatibility for version of php where strstr() doesnt accept third parameter
			if ( version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
				$json = strstr( $json, '</script>', true );
			} else {
				$json = substr( $json, 0, strpos( $json, '</script>' ) );
			}

			$json = rtrim( $json, ';' );

			return $json;
		}

		public static function trigger_refresh_data( $insta_data, $old_opts, $new_opts ) {

			$trigger = 0;

			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				return false;
			}

			if ( false === $insta_data ) {
				$trigger = 1;
			}
			
			if ( is_array( $old_opts ) && is_array( $old_opts ) && array_diff( $old_opts, $new_opts ) !== array_diff( $new_opts, $old_opts ) ) {
				$trigger = 1;
			}

			if ( $trigger == 1 ) {
				return true;
			}

			return false;
		}

		public static function format_followers( $followers ) {

			if ( $followers >= 1000000 ) {
				$followers = number_format_i18n( $followers / 1000000, 1 ) . 'm';
			} elseif ( $followers >= 10000 ) {
				$followers = number_format_i18n( $followers / 1000, 1 ) . 'k';
			} else {
				$followers = number_format_i18n( $followers );
			}

			return $followers;
		}
	}
}

new Penci_Instagram();

