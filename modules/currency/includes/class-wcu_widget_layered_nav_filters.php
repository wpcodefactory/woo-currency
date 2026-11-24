<?php
/**
 * WBW Currency Switcher for WooCommerce - Wcu_Widget_Layered_Nav_Filters Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class Wcu_Widget_Layered_Nav_Filters extends WC_Widget_Layered_Nav_Filters {

	/**
	 * Output widget.
	 *
	 * @version 2.4.0
	 *
	 * @see WP_Widget
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$min_price          = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$max_price          = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$rating_filter      = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', wp_unslash( $_GET['rating_filter'] ) ) ) ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$base_link          = $this->get_current_page_url();

		if ( 0 < count( $_chosen_attributes ) || 0 < $min_price || 0 < $max_price || ! empty( $rating_filter ) ) {

			$this->widget_start( $args, $instance );

			echo '<ul>';

			// Attributes.
			if ( ! empty( $_chosen_attributes ) ) {
				foreach ( $_chosen_attributes as $taxonomy => $data ) {
					foreach ( $data['terms'] as $term_slug ) {
						$term = get_term_by( 'slug', $term_slug, $taxonomy );
						if ( ! $term ) {
							continue;
						}

						$filter_name    = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
						$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
						$current_filter = array_map( 'sanitize_title', $current_filter );
						$new_filter     = array_diff( $current_filter, array( $term_slug ) );

						$link = remove_query_arg( array( 'add-to-cart', $filter_name ), $base_link );

						if ( count( $new_filter ) > 0 ) {
							$link = add_query_arg( $filter_name, implode( ',', $new_filter ), $link );
						}

						$filter_classes = array( 'chosen', 'chosen-' . sanitize_html_class( str_replace( 'pa_', '', $taxonomy ) ), 'chosen-' . sanitize_html_class( str_replace( 'pa_', '', $taxonomy ) . '-' . $term_slug ) );

						echo '<li class="' . esc_attr( implode( ' ', $filter_classes ) ) . '"><a rel="nofollow" aria-label="' . esc_attr__( 'Remove filter', 'woo-currency' ) . '" href="' . esc_url( $link ) . '">' . esc_html( $term->name ) . '</a></li>';
					}
				}
			}

			if ( $min_price ) {
				$link = remove_query_arg( 'min_price', $base_link );
				$formatted_price = ( $min_price < 0 ? '-' : '' ) . sprintf( get_woocommerce_price_format(), '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol() . '</span>', $min_price );
				$return          = '<span class="woocommerce-Price-amount amount"><bdi>' . $formatted_price . '</bdi></span>';
				echo '<li class="chosen">
						<a rel="nofollow" aria-label="' . esc_attr__( 'Remove filter', 'woo-currency' ) . '" href="' . esc_url( $link ) . '">' .
					     sprintf(
							 /* Translators: %s: Price. */
						     esc_html__( 'Min %s', 'woo-currency' ),
						     esc_html( $return )
					     ) .
				     '</a></li>';
			}

			if ( $max_price ) {
				$link = remove_query_arg( 'max_price', $base_link );
				$formatted_price = ( $max_price < 0 ? '-' : '' ) . sprintf( get_woocommerce_price_format(), '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol() . '</span>', $max_price );
				$return          = '<span class="woocommerce-Price-amount amount"><bdi>' . $formatted_price . '</bdi></span>';
				/* Translators: %s: maximum price */
				echo '<li class="chosen"><a rel="nofollow" aria-label="' . esc_attr__( 'Remove filter', 'woo-currency' ) . '" href="' . esc_url( $link ) . '">' . sprintf( esc_html__( 'Max %s', 'woo-currency' ), esc_html( $return ) ) . '</a></li>';
			}

			if ( ! empty( $rating_filter ) ) {
				foreach ( $rating_filter as $rating ) {
					$link_ratings = implode( ',', array_diff( $rating_filter, array( $rating ) ) );
					$link         = $link_ratings ? add_query_arg( 'rating_filter', $link_ratings ) : remove_query_arg( 'rating_filter', $base_link );

					/* Translators: %s: rating */
					echo '<li class="chosen"><a rel="nofollow" aria-label="' . esc_attr__( 'Remove filter', 'woo-currency' ) . '" href="' . esc_url( $link ) . '">' . sprintf( esc_html__( 'Rated %s out of 5', 'woo-currency' ), esc_html( $rating ) ) . '</a></li>';
				}
			}

			echo '</ul>';

			$this->widget_end( $args );
		}
	}
}