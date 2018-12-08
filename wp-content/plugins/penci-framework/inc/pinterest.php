<?php
if ( ! class_exists( 'Penci_Pinterest' ) ):

	class Penci_Pinterest {

		// Pinterest url
		var $pinterest_feed = 'https://pinterest.com/%s/feed.rss';

		var $start_time;

		function __construct() {
			$this->start_time = microtime( true );
		}

		// Render the pinboard and output
		function render_html( $username, $numbers, $cache_time = 1200, $follow = true ) {
			$pins = $this->get_pins( $username, $numbers, $cache_time );
			if ( is_null( $pins ) ) {
				echo( "Unable to load Pinterest pins for '$username'\n" );
			}
			else {
				echo '<div class="penci-images-pin-widget">';
				foreach ( $pins as $pin ) {
					$title = $pin['title'];
					$url   = $pin['url'];
					$image = $pin['image'];

					echo '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" target="_blank"><span class="penci-image-holder rectangle-fix-size penci-lazy" data-src="' . esc_url( $image ) . '"></span></a>';
				}

				echo '</div>';
			}
			?>

			<?php if ( $follow ): ?>
				<div class="pin_link">
					<a href="http://pinterest.com/<?php echo sanitize_text_field( $username ); ?>/" target="_blank">@<?php echo sanitize_text_field( $username ); ?></a>
				</div>
			<?php endif; ?>
			<?php
		}

		/**
		 * Retrieve RSS feed for username, and parse the data needed.
		 * Returns null if error, otherwise a has of pins.
		 * Callback it on render_html functions
		 *
		 * @since 1.0
		 */
		function get_pins( $username, $numbers, $cache_time = 1200 ) {

			if( !is_numeric( $cache_time ) && $cache_time < 1 ): $cache_time = 1200; endif;
			// Set caching.
			add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return ' . $cache_time . ';' ) );

			// Get the RSS feed.
			$url = sprintf( $this->pinterest_feed, $username );
			$rss = fetch_feed( $url );
			if ( is_wp_error( $rss ) ) {
				return null;
			}

			$maxitems  = $rss->get_item_quantity( $numbers );
			$rss_items = $rss->get_items( 0, $maxitems );

			$pins;
			if ( is_null( $rss_items ) ) {
				$pins = null;
			}
			else {

				// Build patterns to search/replace in the image urls
				$search  = array( '_b.jpg' );
				$replace = array( '_t.jpg' );

				// Make url protocol relative
				array_push( $search, 'https://' );
				array_push( $replace, '//' );

				$pins = array();
				foreach ( $rss_items as $item ) {
					$title       = $item->get_title();
					$description = $item->get_description();
					$url         = $item->get_permalink();
					if ( preg_match_all( '/<img src="([^"]*)".*>/i', $description, $matches ) ) {
						$image = str_replace( $search, $replace, $matches[1][0] );
					}
					array_push( $pins, array(
						'title' => $title,
						'image' => $image,
						'url'   => $url
					) );
				}
			}

			return $pins;
		}
	}

endif; /* End check if class exists */