<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Penci_Review_Schema_Markup' ) ):
	class Penci_Review_Schema_Markup {

		public static function output_schema( $args ) {

			$penci_review = $schema_type = $schema_type_val = $ratingValue = $post_id = '';

			$args = shortcode_atts( array(
				'penci_review'    => '',
				'schema_type'     => '',
				'schema_type_val' => '',
				'ratingValue'     => '',
				'post_id'         => ''
			), $args );

			extract( $args );

			if( 'none' == $schema_type || ! $schema_type_val ) {
				return '';
			}

			if( ! $schema_type_val ){
				return '';
			}

			$review_ct_image    = isset( $penci_review['penci_review_ct_image'] ) ? $penci_review['penci_review_ct_image'] : '';
			$url_review_ct_image = wp_get_attachment_thumb_url( $review_ct_image );
			if( ! $url_review_ct_image && has_post_thumbnail( get_the_ID() ) ){
				$url_review_ct_image = get_the_post_thumbnail_url( get_the_ID(),'thumbnail' );
			}

			$json = array(
				'@context' => 'http://schema.org',
				'@type' => $schema_type,
				'image' => $url_review_ct_image,
			);

			$offers = array();
			foreach ( $schema_type_val as $key => $value ) {

				if( 'Product' == $schema_type ){
					if ( $value && in_array( $key, array( 'price', 'priceCurrency','availability' ) ) ) {
						$offers[$key] =  $value;
						continue;
					}

					if( $value && 'brand' == $key ){
						$value = array(
							"@type" => "Thing",
							"name"  => $value
						);
					}
				}
				if( 'SoftwareApplication' == $schema_type ){
					if ( $value && in_array( $key, array( 'price', 'priceCurrency' ) ) ) {
						$offers[$key] =  $value;
						continue;
					}
				}


				if ( $value && in_array( $key, array( 'director', 'actor' ) ) ) {
					$mul_value = preg_split( '/\r\n|[\r\n]/', $value );
					$value     = array();
					foreach ( (array) $mul_value as $mul_value_item ) {
						$value[] = array(
							"@type" => "Person",
							"name"  => $mul_value_item
						);
					}
				}

				if ( $value && in_array( $key, array( 'openingHours','servesCuisine' ) ) ) {
					$value = preg_split( '/\r\n|[\r\n]/', $value );
				}

				$json[ $key ] = $value;
			}

			if( get_theme_mod( 'penci_user_review_enable' ) ){
				$review_count = get_comments( array( 'post_id' => $post_id, 'type' => 'penci_review', 'status'  => 1,'order'   => 'ASC' ) );
				$review_scores = get_post_meta( $post_id, 'penci_ur_review_scores', true );

				if( $review_count && $review_scores ){
					$json[ 'aggregateRating' ] = array(
						'@type' => 'AggregateRating',
						'ratingValue' => ( $review_scores >= 1 ? $review_scores : 1 ),
						'reviewCount' => count( (array)$review_count ),
					);
				}
			}

			if( $offers ){
				$json[ 'offers' ] = array_merge( array( "@type" => "Offer" ), $offers  );
			}

			$json[ 'review' ] = self::get_schema_markup_rating( $schema_type, $schema_type_val, $ratingValue );

			if( ! $json ){
				return '';
			}

			echo '<script type="application/ld+json">' . wp_json_encode( $json, JSON_PRETTY_PRINT ) . '</script>';

		}


		public static function get_schema_markup_rating($schema_type, $schema_type_val, $ratingValue ){


			return array(
				'@type'        => 'Review',
				'reviewRating' => array(
					'@type'       => 'Rating',
					'ratingValue' => $ratingValue,
					'bestRating'  => 5,
				),
				'author'       => array(
					'@type' => 'Person',
					'name'  => isset( $schema_type_val['author'] ) ? $schema_type_val['author'] : ''
				)
			);
		}

		public static function get_list_schema() {
			return array(
				'Thing'               => penci_review_tran_setting('penci_review_text_thing'),
				'none'                => penci_review_tran_setting('penci_review_text_none'),
				'Book'                => penci_review_tran_setting('penci_review_text_book'),
				'Game'                => penci_review_tran_setting('penci_review_text_game'),
				'Movie'               => penci_review_tran_setting('penci_review_text_movie'),
				'MusicRecording'      => penci_review_tran_setting('penci_review_text_musicreco'),
				'Painting'            => penci_review_tran_setting('penci_review_text_painting'),
				'Place'               => penci_review_tran_setting('penci_review_text_place'),
				'Product'             => penci_review_tran_setting('penci_review_text_product'),
				'Restaurant'          => penci_review_tran_setting('penci_review_text_restaurant'),
				'SoftwareApplication' => penci_review_tran_setting('penci_review_text_sfapp'),
				'Store'               => penci_review_tran_setting('penci_review_text_store'),
				'TVSeries'            => penci_review_tran_setting('penci_review_text_tvseries'),
				'WebSite'             => penci_review_tran_setting('penci_review_text_webSite')
			);
		}

		public static function get_schema_types( $type = '' ) {
			$schema_types = array(
				'Book'                => self::get_book_fields(),
				'Game'                => self::get_game_fields(),
				'Movie'               => self::get_movie_fields(),
				'MusicRecording'      => self::get_music_recording_fields(),
				'Painting'            => self::get_painting_fields(),
				'Place'               => self::get_place_fields(),
				'Product'             => self::get_product_fields(),
				'Restaurant'          => self::get_restaurant_fields(),
				'SoftwareApplication' => self::get_software_application_fields(),
				'Store'               => self::get_store_fields(),
				'TVSeries'            => self::get_TVSeries_fields(),
				'WebSite'             => self::get_webSite_fields()
			);

			$return_schema_types = apply_filters( 'penci_review_schema_types', $schema_types );

			return isset( $return_schema_types[$type] ) ? $return_schema_types[$type] : array();
		}

		public static function get_book_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => penci_review_tran_setting('penci_reviewt_btitle'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => penci_review_tran_setting('penci_reviewt_burl'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'author',
					'label'   => penci_review_tran_setting('penci_reviewt_bauthor'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'bookEdition',
					'label'   => penci_review_tran_setting('penci_reviewt_bedition'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'bookFormat',
					'label'   => penci_review_tran_setting('penci_reviewt_bformat'),
					'type'    => 'select',
					'default' => '',
					'options' => array(
						''                => esc_html__( 'Default', 'penci' ),
						'AudiobookFormat' => 'AudiobookFormat',
						'EBook'           => 'EBook',
						'Hardcover'       => 'Hardcover',
						'Paperback'       => 'Paperback'
					)
				),
				array(
					'name'    => 'datePublished',
					'label'   => penci_review_tran_setting('penci_reviewt_bdate'),
					'type'    => 'date',
					'default' => '',
				),
				array(
					'name'    => 'illustrator',
					'label'   => penci_review_tran_setting('penci_reviewt_billustrator'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'isbn',
					'label'   => penci_review_tran_setting('penci_reviewt_bISBN'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'numberOfPages',
					'label'   => penci_review_tran_setting('penci_reviewt_bnumberofpage'),
					'type'    => 'number',
					'default' => ''
				),
				array(
					'name'    => 'description',
					'label'   => penci_review_tran_setting('penci_reviewt_bdesc'),
					'type'    => 'textarea',
					'default' => ''
				),
			);
		}
		public static function get_game_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => penci_review_tran_setting('penci_reviewt_game_title'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => penci_review_tran_setting('penci_reviewt_game_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'description',
					'label'   => penci_review_tran_setting('penci_reviewt_game_desc'),
					'type'    => 'textarea',
					'default' => ''
				)

			);
		}
		public static function get_movie_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => esc_html__( 'Movie title', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_mv_title'),
					'type'    => 'text',
					'default' => '',
				),

				array(
					'name'    => 'url',
					'label'   => esc_html__( 'URL', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_mv_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'dateCreated',
					'label'   => esc_html__( 'Date published', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_mv_date'),
					'type'    => 'date',
					'default' => '',
				),
				array(
					'name'    => 'description',
					'label'   => esc_html__( 'Movie description', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_mv_desc'),
					'type'    => 'textarea',
					'default' => ''
				),
				array(
					'name'      => 'director',
					'label'     => esc_html__( 'Director(s)', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_mv_dir'),
					'type'      => 'textarea',
					'default'   => '',
					'desc'      => esc_html__( 'Add one director per line', 'penci' ),
				),
				array(
					'name'      => 'actor',
					'label'     => esc_html__( 'Actor(s)', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_mv_actor'),
					'type'      => 'textarea',
					'default'   => '',
					'desc'      => esc_html__( 'Add one actor per line', 'penci' ),
				),
				array(
					'name'      => 'genre',
					'label'     => esc_html__( 'Genre', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_mv_genre'),
					'type'      => 'textarea',
					'default'   => ''
				),
			);
		}
		public static function get_music_recording_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => esc_html__( 'Track name', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_music_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => esc_html__( 'URL', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_music_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'byArtist',
					'label'   => esc_html__( 'Author', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_music_author'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'duration',
					'label'   => esc_html__( 'Track Duration', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_music_dur'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'inAlbum',
					'label'   => esc_html__( 'Album name', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_music_album'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'      => 'genre',
					'label'     => esc_html__( 'Genre', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_music_genre'),
					'type'      => 'textarea',
					'default'   => ''
				),
			);
		}
		public static function get_painting_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => esc_html__( 'Name', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_painting_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'author',
					'label'   => esc_html__( 'Author', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_painting_author'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => esc_html__( 'URL', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_painting_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'datePublished',
					'label'   => esc_html__( 'Date published', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_painting_date_pub'),
					'type'    => 'date',
					'default' => '',
				),
				array(
					'name'      => 'genre',
					'label'     => esc_html__( 'Genre', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_painting_genre'),
					'type'      => 'textarea',
					'default'   => ''
				)

			);
		}
		public static function get_place_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => penci_review_tran_setting('penci_reviewt_place_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => penci_review_tran_setting('penci_reviewt_place_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'description',
					'label'   => penci_review_tran_setting('penci_reviewt_place_desc'),
					'type'    => 'textarea',
					'default' => ''
				)
			);
		}
		public static function get_product_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => penci_review_tran_setting('penci_reviewt_prod_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => penci_review_tran_setting('penci_reviewt_prod_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'price',
					'label'   => penci_review_tran_setting('penci_reviewt_prod_price'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'priceCurrency',
					'label'   => penci_review_tran_setting('penci_reviewt_prod_currency'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'availability',
					'label'   => penci_review_tran_setting('penci_reviewt_prod_avai'),
					'type'    => 'select',
					'default' => '',
					'options' => array(
						''                    => '---',
						'Discontinued'        => 'Discontinued',
						'InStock'             => 'In Stock',
						'InStoreOnly'         => 'In Store Only',
						'LimitedAvailability' => 'Limited',
						'OnlineOnly'          => 'Online Only',
						'OutOfStock'          => 'Out Of Stock',
						'PreOrder'            => 'Pre Order',
						'PreSale'             => 'Pre Sale',
						'SoldOut'             => 'Sold Out'
					)
				),
				array(
					'name'    => 'brand',
					'label'   => penci_review_tran_setting('penci_reviewt_prod_band'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'sku',
					'label'   => penci_review_tran_setting('penci_reviewt_prod_suk'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'description',
					'label'   => penci_review_tran_setting('penci_reviewt_prod_desc'),
					'type'    => 'textarea',
					'default' => ''
				),
			);
		}
		public static function get_restaurant_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => penci_review_tran_setting('penci_reviewt_restau_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => penci_review_tran_setting('penci_reviewt_restau_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'address',
					'label'   => penci_review_tran_setting('penci_reviewt_restau_address'),
					'type'    => 'text',
					'default' => ''
				),array(
					'name'    => 'priceRange',
					'label'   => penci_review_tran_setting('penci_reviewt_restau_price'),
					'type'    => 'text',
					'default' => ''
				),array(
					'name'    => 'telephone',
					'label'   => penci_review_tran_setting('penci_reviewt_restau_telephone'),
					'type'    => 'text',
					'default' => ''
				),array(
					'name'    => 'servesCuisine',
					'label'   => penci_review_tran_setting('penci_reviewt_restau_serves'),
					'type'    => 'textarea',
					'default' => '',
					'desc'    => esc_html__( 'Add one cuisine  per line', 'penci' ),
				),array(
					'name'    => 'openingHours',
					'label'   => penci_review_tran_setting('penci_reviewt_restau_ophours'),
					'type'    => 'textarea',
					'default' => '',
					'desc'    => esc_html__( 'Add one opening hour per line', 'penci' ),
				),
				array(
					'name'    => 'description',
					'label'   => penci_review_tran_setting('penci_reviewt_restau_desc'),
					'type'    => 'textarea',
					'default' => ''
				),
			);
		}
		public static function get_software_application_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => penci_review_tran_setting('penci_reviewt_app_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => penci_review_tran_setting('penci_reviewt_app_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'price',
					'label'   => penci_review_tran_setting('penci_reviewt_app_price'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'priceCurrency',
					'label'   => penci_review_tran_setting('penci_reviewt_app_currency'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'operatingSystem',
					'label'   => penci_review_tran_setting('penci_reviewt_app_opsystem'),
					'type'    => 'text',
					'default' => '',
					'desc'    => esc_html__( 'For example, "Windows 7", "OSX 10.6", "Android 1.6"', 'penci' )
				),
				array(
					'name'    => 'applicationCategory',
					'label'   => penci_review_tran_setting('penci_reviewt_app_app_cat'),
					'type'    => 'text',
					'default' => '',
					'desc'    => esc_html__( 'For example, "Game", "Multimedia"', 'penci' )
				),
				array(
					'name'    => 'description',
					'label'   => penci_review_tran_setting('penci_reviewt_app_desc'),
					'type'    => 'textarea',
					'default' => ''
				),
			);
		}
		public static function get_store_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => esc_html__( 'Store Name', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_store_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => esc_html__( 'URL', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_store_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'address',
					'label'   => esc_html__( 'Address', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_store_address'),
					'type'    => 'text',
					'default' => ''
				),array(
					'name'    => 'priceRange',
					'label'   => esc_html__( 'Price range', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_store_price'),
					'type'    => 'text',
					'default' => ''
				),array(
					'name'    => 'telephone',
					'label'   => esc_html__( 'Telephone', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_store_telephone'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'description',
					'label'   => esc_html__( 'Store Description', 'penci' ),
					'label'   => penci_review_tran_setting('penci_reviewt_store_desc'),
					'type'    => 'textarea',
					'default' => ''
				),
			);
		}
		public static function get_TVSeries_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => penci_review_tran_setting('penci_reviewt_tv_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => penci_review_tran_setting('penci_reviewt_tv_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'description',
					'label'   => penci_review_tran_setting('penci_reviewt_tv_desc'),
					'type'    => 'textarea',
					'default' => ''
				),
			);
		}
		public static function get_webSite_fields() {
			return array(
				array(
					'name'    => 'name',
					'label'   => penci_review_tran_setting('penci_reviewt_web_name'),
					'type'    => 'text',
					'default' => '',
				),
				array(
					'name'    => 'url',
					'label'   => penci_review_tran_setting('penci_reviewt_web_url'),
					'type'    => 'text',
					'default' => ''
				),
				array(
					'name'    => 'description',
					'label'   => penci_review_tran_setting('penci_reviewt_web_desc'),
					'type'    => 'textarea',
					'default' => ''
				),
			);
		}

		public static function get_schema_filed( $type,$schema_val , $post_id ){
			$datas = self::get_schema_types( $type );
			$schema_options_val = get_post_meta( $post_id, 'penci_review_schema_options', true );

			echo '<div class="penci-review_schema_fields penci-review_' . $type .  '_fields" ' . ( $schema_val != $type ? 'style="display:none;"' : '' ) . '>';

			foreach ( (array)$datas as $field ){
				$type_field = isset( $field['type'] ) ? $field['type'] : '';
				$name       = isset( $field['name'] ) ? $field['name'] : '';
				$label      = isset( $field['label'] ) ? $field['label'] : '';
				$desc       = isset( $field['desc'] ) ? $field['desc'] : '';
				$options    = isset( $field['options'] ) ? $field['options'] : array();
				$default    = isset( $field['default'] ) ? $field['default'] : '';

				$opt_id   = 'penci_review_schema_options_' . $type_field . '_' . $name;
				$opt_name = 'penci_review_schema_options[' . $type . '][' . $name . ']';
				$opt_val  = isset( $schema_options_val[ $type ][ $name ] ) ? $schema_options_val[ $type ][ $name ] : $default;

				if( 'image' == $type_field ) {
					echo '<div>';
				}else{
					echo '<p ' . (  'textarea' != $type_field ? 'class="col-6"' : '' ) . '>';
				}

				?>
				<label for="penci_review_schema_markup" class="penci-format-row"><?php echo $label; ?></label>
				<?php
				if( 'textarea' == $type_field ) {
					?>
					<textarea style="width:100%; height:120px;" name="<?php echo $opt_name; ?>" id="<?php echo $opt_id; ?>"><?php echo $opt_val; ?></textarea>
					<?php
				}elseif( 'image' == $type_field ) {
					$url_image = wp_get_attachment_thumb_url( $opt_val );
					?>
					<div class="penci-widget-image media-widget-control" style="max-width: 350px;">
						<input name="<?php echo $opt_name; ?>" type="hidden" class="penci-widget-image__input" value="<?php echo esc_attr( $opt_val ); ?>">
						<img src="<?php echo esc_url( $url_image ); ?>" class="penci-widget-image__image<?php echo $url_image ? '' : ' hidden'; ?>">
						<div class="placeholder <?php echo( $url_image ? 'hidden' : '' ); ?>"><?php _e( 'No image selected' ); ?></div>
						<button class="button penci-widget-image__select"><?php esc_html_e( 'Select' ); ?></button>
						<button class="button penci-widget-image__remove"><?php esc_html_e( 'Remove' ); ?></button>
					</div>
					<?php
				}elseif( 'select' == $type_field ) {
					?>
					<select name="<?php echo $opt_name; ?>" id="<?php echo $opt_id; ?>">
						<?php
						foreach ( $options as $option_val => $option_label ) {
							echo '<option value="' . $option_val . '" ' . selected( $opt_val, $option_val, false ) . '>' . $option_label . '</option>';
						}
						?>
					</select>
					<?php
				}elseif( 'date' == $type_field ) {
					?>
					<input class="penci-datepicker" type="text" name="<?php echo $opt_name; ?>" id="<?php echo $opt_id; ?>" value="<?php echo $opt_val; ?>" size="30" />
					<?php
				}elseif( 'number' == $type_field ) {
					?>
					<input type="number" name="<?php echo $opt_name; ?>" id="<?php echo $opt_id; ?>" value="<?php echo $opt_val; ?>" size="30" />
					<?php
				} else {
					?>
					<input  type="text" name="<?php echo $opt_name; ?>" id="<?php echo $opt_id; ?>" value="<?php echo $opt_val; ?>">
					<?php
				}
				?>

				<?php if( $desc ): ?>
					<span class="penci-recipe-description"><?php echo $desc; ?></span>
				<?php endif; ?>
				<?php
				echo ( 'image' == $type_field ? '</div><p></p>' : '</p>' );
			}
			echo '</div>';
		}
	}
endif;