<?php
/**
 * Register one click import demo data
 */

function penci_get_list_demo() {
	$list_demo = array(
		'01-default'              => array(
			'name'  => 'Default',
			'pages' => array(
				'front_page' => 'Home Default',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			)
		),
		'30-animal'               => array( 'name' => 'Animal' ),
		'07-architecture'         => array( 'name' => 'Architecture News & Magazine' ),
		'08-art'                  => array( 'name' => 'Art News & Magazine' ),
		'43-applanding'           => array( 'name' => 'App Landing Page' ),
		'57-agency'               => array( 'name' => 'Agency Multipurpose' ),
		'21-beauty'               => array( 'name' => 'Beauty Cosmetic' ),
		'22-breakingnews'         => array( 'name' => 'Breaking News' ),
		'09-business'             => array( 'name' => 'Business News' ),
		'47-businessmulti'        => array( 'name' => 'Business Multipurpose' ),
		'33-bitcoin'              => array( 'name' => 'BitCoin News' ),
		'50-beautyblog'           => array( 'name' => 'PenNews Beauty Blog' ),
		'67-businessmulti2'       => array( 'name' => 'Business Multi-Purpose 2' ),
		'78-businessmag'          => array( 'name' => 'Business Magazine ' ),
		'80-booknews'             => array( 'name' => 'Book News' ),
		'102-club'                => array( 'name' => 'Bar Club' ),
		'16-car'                  => array( 'name' => 'Car News' ),
		'20-church'               => array( 'name' => 'Church ' ),
		'24-classic'              => array( 'name' => 'Classic' ),
		'23-construct'            => array( 'name' => 'Construction' ),
		'27-creative'             => array( 'name' => 'Creative' ),
		'39-creativemulti'        => array( 'name' => 'Creative Multipurpose' ),
		'46-coffeelanding'        => array( 'name' => 'Coffee Shop Landing Page' ),
		'49-cfratdiyblog'         => array( 'name' => 'PenNews Craft DIY Blog' ),
		'51-coffeeblog'           => array( 'name' => 'PenNews Coffee Blog' ),
		'56-constructionmulti'    => array( 'name' => 'PenNews Construction Multipurpose' ),
		'58-creative'             => array( 'name' => 'Creative Multipurpose' ),
		'62-charitymulti'         => array( 'name' => 'Charity Multipurpose' ),
		'65-cosmeticmulti'        => array( 'name' => 'Cosmetic Multi-Purpose' ),
		'75-coffeemulti'          => array( 'name' => 'Coffee Multipurpose' ),
		'110-crypterio-news'      => array( 'name' => 'Crypterio News' ),
		'109-dentist'             => array( 'name' => 'Dentist Multi-Purpose' ),
		'32-edu'                  => array( 'name' => 'Education' ),
		'48-elegant'              => array( 'name' => 'Elegant' ),
		'29-estate'               => array( 'name' => 'Real Estate' ),
		'05-fashion'              => array( 'name' => 'Fashion News & Magazine' ),
		'06-fitness'              => array( 'name' => 'Fitness News & Magazine' ),
		'03-food'                 => array( 'name' => 'Food' ),
		'53-fashionblog'          => array( 'name' => 'PenNews Fashion Blog' ),
		'54-foodblog'             => array( 'name' => 'PenNews Food Blog' ),
		'72-farmmulti'            => array( 'name' => 'Farm Multi-Purpose' ),
		'77-fashionmag'           => array( 'name' => 'Fashion Magazine' ),
		'84-financemulti'         => array( 'name' => 'Finance Multipurpose ' ),
		'86-freelancer'           => array( 'name' => 'Freelancer' ),
		'93-foodmulti'            => array( 'name' => 'Food Multipurpose' ),
		'101-fashionstylist'      => array( 'name' => 'Fashion Stylist' ),
		'105-factory'             => array( 'name' => 'Factory' ),
		'97-gameintro'            => array( 'name' => 'Game Intro' ),
		'10-game'                 => array( 'name' => 'Game News & Magazine' ),
		'59-gymmulti'             => array( 'name' => 'Gym Multipurpose' ),
		'68-gardenmulti'          => array( 'name' => 'Garden Multi-Purpose' ),
		'83-gamemag'              => array( 'name' => 'Game Magazine' ),
		'100-golfclub'            => array( 'name' => 'Golf Club' ),
		'17-health'               => array( 'name' => 'Health & Medical News' ),
		'34-hotel'                => array( 'name' => 'PenNews Hotel News' ),
		'60-hotelmulti'           => array( 'name' => 'Hotel Multipurpose' ),
		'38-healthmulti'          => array( 'name' => 'Health Clinic' ),
		'74-hairsalon'            => array( 'name' => 'Hairdressing Multipurpose' ),
		'41-interiormulti'        => array( 'name' => 'Interior Multipurpose' ),
		'25-lifestyle'            => array( 'name' => 'LifeStyle' ),
		'66-lawmulti'             => array( 'name' => 'Lawyer - Attorneys' ),
		'106-modernshop'          => array( 'name' => 'Modern Shop' ),
		'12-movie'                => array( 'name' => 'Movie News' ),
		'35-market'               => array( 'name' => 'PenNews Market News' ),
		'73-mediagency'           => array( 'name' => 'Web Agency' ),
		'81-minimalportfolio'     => array( 'name' => 'Minimal Portfolio' ),
		'95-musician'             => array( 'name' => 'Musician' ),
		'14-photography'          => array( 'name' => 'Photography News & Magazine' ),
		'31-politics'             => array( 'name' => 'Politics' ),
		'42-portfolio'            => array( 'name' => 'Portfolio Multipurpose' ),
		'45-productslanding'      => array( 'name' => 'Products Landing Page' ),
		'55-personalshop'         => array( 'name' => 'PenNews Personal Shop' ),
		'82-photographyportfolio' => array( 'name' => 'Photography Portfolio' ),
		'87-productshowcase'      => array( 'name' => 'Product Showcase' ),
		'98-petcare'              => array( 'name' => 'Pet Care' ),
		'26-restaurant'           => array( 'name' => 'Restaurant' ),
		'40-restaurantmulti'      => array( 'name' => 'Restaurant' ),
		'107-repair'              => array( 'name' => 'Repairing Multi-Purpose' ),
		'108-ristorante'          => array( 'name' => 'Ristorante Multi-Purpose' ),
		'18-spa'                  => array( 'name' => 'Spa News' ),
		'15-sport'                => array( 'name' => 'Sport News' ),
		'36-star'                 => array( 'name' => 'PenNews Star News' ),
		'63-seonews'              => array( 'name' => ' SEO News' ),
		'61-spamulti'             => array( 'name' => 'Spa Multipurpose' ),
		'88-sportclub'            => array( 'name' => 'Sport Club' ),
		'96-startup'              => array( 'name' => 'StartUp' ),
		'111-starnews'            => array( 'name' => 'Star Magazine' ),
		'94-digitalseo'           => array( 'name' => 'SEO Digital Agency' ),
		'103-sportnews'           => array( 'name' => 'Sport News' ),
		'52-travelblog'           => array( 'name' => 'PenNews Travel Blog' ),
		'13-tech'                 => array( 'name' => 'Tech News & Magazine' ),
		'28-times'                => array( 'name' => 'Time' ),
		'02-travel'               => array( 'name' => 'Travel News' ),
		'37-techmulti'            => array( 'name' => 'Tech Landing' ),
		'44-techlanding'          => array( 'name' => 'Tech Multipurpose' ),
		'64-techmag'              => array( 'name' => 'Tech Magazine' ),
		'69-travelmulti'          => array( 'name' => 'Travel Multi-Purpose' ),
		'71-travelguide'          => array( 'name' => 'Travel Guide' ),
		'76-travelmag'            => array( 'name' => 'Travel Magazine' ),
		'79-timemag'              => array( 'name' => 'Times Magazine' ),
		'89-technews'             => array( 'name' => 'Technology 2 News' ),
		'90-transportmulti'       => array( 'name' => 'Transport' ),
		'104-tattomulti'          => array( 'name' => 'Tattoo' ),
		'70-video2news'           => array( 'name' => 'Video News 2' ),
		'04-vegan'                => array( 'name' => 'Vegan News' ),
		'11-video'                => array( 'name' => 'Video News' ),
		'92-onlineshop'           => array( 'name' => 'Online Shop' ),
		'99-kidsfashion'          => array( 'name' => 'Kids Fashion' ),
		'19-yoga'                 => array( 'name' => 'Yoga News' ),
		'91-yogamulti'            => array( 'name' => 'Yoga Multipurpose' ),
		'85-weddingstudio'        => array( 'name' => 'Wedding Studio' ),
	);

	return $list_demo;
}

add_filter( 'penci_demo_packages', 'penci_addons_import_register' );

function penci_addons_import_register() {

	$penci_demo_url = 'https://s3.amazonaws.com/pennews-data/';

	$img_size = array(
		'penci-thumb-480-645' => array( 'width' => 480, 'height' => 645, 'crop' => 1, ),
		'penci-thumb-480-480' => array( 'width' => 480, 'height' => 480, 'crop' => 1, ),
		'penci-thumb-480-320' => array( 'width' => 480, 'height' => 320, 'crop' => 1, ),

		'penci-thumb-280-376' => array( 'width' => 280, 'height' => 376, 'crop' => 1, ),
		'penci-thumb-280-186' => array( 'width' => 280, 'height' => 186, 'crop' => 1, ),
		'penci-thumb-280-280' => array( 'width' => 280, 'height' => 280, 'crop' => 1, ),

		'penci-thumb-760-570'   => array( 'width' => 760, 'height' => 570, 'crop' => 1, ),
		'penci-thumb-1920-auto' => array( 'width' => 1920, 'height' => 999999, 'crop' => 0, ),
		'penci-thumb-960-auto'  => array( 'width' => 960, 'height' => 999999, 'crop' => 0, ),
		'penci-thumb-auto-400'  => array( 'width' => 999999, 'height' => 400, 'crop' => 0, ),
		'penci-masonry-thumb'   => array( 'width' => 585, 'height' => 99999, 'crop' => 0, ),
	);

	$list_demo = array();
	$demos     = penci_get_list_demo();

	foreach ( $demos as $folder => $demo_data ) {

		$pages = isset( $demo_data['pages'] ) ? $demo_data['pages'] : '';
		$menus = isset( $demo_data['menus'] ) ? $demo_data['menus'] : '';

		if ( empty( $pages ) ) {
			$pages = array(
				'front_page' => 'Home',
				'blog'       => '',
			);
		}

		if ( empty( $menus ) ) {
			$menus = array( 'menu-1' => 'main-menu' );
		}

		$list_demo[] = array(
			'name'       => $demo_data['name'],
			'content'    => $penci_demo_url . $folder . '/demo-content.xml',
			'widgets'    => $penci_demo_url . $folder . '/widgets.wie',
			'preview'    => $penci_demo_url . $folder . '/preview.jpg',
			'customizer' => $penci_demo_url . $folder . '/customizer.dat',
			'options'    => $img_size,
			'pages'      => $pages,
			'menus'      => $menus,
		);
	}

	return $list_demo;
}

//add_action( 'pencidi_after_setup_pages', 'penci_addons_import_order_tracking' );

/**
 * Update more page options
 *
 * @param $pages
 */
function penci_addons_import_order_tracking( $pages ) {
	if ( isset( $pages['order_tracking'] ) ) {
		$order = get_page_by_title( $pages['order_tracking'] );

		if ( $order ) {
			update_option( 'sober_order_tracking_page_id', $order->ID );
		}
	}

	if ( isset( $pages['portfolio'] ) ) {
		$portfolio = get_page_by_title( $pages['portfolio'] );

		if ( $portfolio ) {
			update_option( 'sober_portfolio_page_id', $portfolio->ID );
		}
	}
}

//add_action( 'penci_before_import_content', 'penci_addons_import_order_tracking' );

/**
 * Prepare product attributes before import demo content
 *
 * @param $file
 */
function penci_addons_import_product_attributes( $file ) {
	global $wpdb;

	if ( ! class_exists( 'WXR_Parser' ) ) {
		require_once WP_PLUGIN_DIR . '/penci-demo-importer/includes/parsers.php';
	}

	$parser      = new WXR_Parser();
	$import_data = $parser->parse( $file );

	if ( isset( $import_data['posts'] ) ) {
		$posts = $import_data['posts'];

		if ( $posts && sizeof( $posts ) > 0 ) {
			foreach ( $posts as $post ) {
				if ( 'product' === $post['post_type'] ) {
					if ( ! empty( $post['terms'] ) ) {
						foreach ( $post['terms'] as $term ) {
							if ( strstr( $term['domain'], 'pa_' ) ) {
								if ( ! taxonomy_exists( $term['domain'] ) ) {
									$attribute_name = wc_sanitize_taxonomy_name( str_replace( 'pa_', '', $term['domain'] ) );

									// Create the taxonomy
									if ( ! in_array( $attribute_name, wc_get_attribute_taxonomies() ) ) {
										$attribute = array(
											'attribute_label'   => $attribute_name,
											'attribute_name'    => $attribute_name,
											'attribute_type'    => 'select',
											'attribute_orderby' => 'menu_order',
											'attribute_public'  => 0
										);
										$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );
										delete_transient( 'wc_attribute_taxonomies' );
									}

									// Register the taxonomy now so that the import works!
									register_taxonomy(
										$term['domain'],
										apply_filters( 'woocommerce_taxonomy_objects_' . $term['domain'], array( 'product' ) ),
										apply_filters( 'woocommerce_taxonomy_args_' . $term['domain'], array(
											'hierarchical' => true,
											'show_ui'      => false,
											'query_var'    => true,
											'rewrite'      => false,
										) )
									);
								}
							}
						}
					}
				}
			}
		}
	}
}

