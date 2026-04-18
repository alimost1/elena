<?php
/**
 * Front page shared product helpers.
 *
 * @package Mashaussure
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'masha_fp_get_sale_badge' ) ) {
	/**
	 * Build sale badge text (e.g. -30%).
	 *
	 * @param WC_Product|null $product Product object.
	 * @return string
	 */
	function masha_fp_get_sale_badge( $product ) {
		if ( ! $product || ! is_a( $product, 'WC_Product' ) || ! $product->is_on_sale() ) {
			return '';
		}

		$regular = (float) $product->get_regular_price();
		$sale    = (float) $product->get_sale_price();
		if ( $regular <= 0 || $sale <= 0 || $sale >= $regular ) {
			return '';
		}

		$percent = round( ( ( $regular - $sale ) / $regular ) * 100 );
		return '-' . $percent . '%';
	}
}

if ( ! function_exists( 'masha_fp_is_new_product' ) ) {
	/**
	 * Check if product should display NEW badge.
	 *
	 * @param WC_Product|null $product Product object.
	 * @param int             $max_days Max product age in days.
	 * @return bool
	 */
	function masha_fp_is_new_product( $product, $max_days = 30 ) {
		if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
			return false;
		}

		$product_id = $product->get_id();
		if ( has_term( array( 'new', 'NEW' ), 'product_tag', $product_id ) ) {
			return true;
		}

		$created = get_post_time( 'U', true, $product_id );
		if ( ! $created ) {
			return false;
		}

		return ( time() - $created ) < ( absint( $max_days ) * DAY_IN_SECONDS );
	}
}

if ( ! function_exists( 'masha_fp_get_size_attributes' ) ) {
	/**
	 * Extract likely size options from variable product attributes.
	 *
	 * @param WC_Product|null $product Product object.
	 * @return array
	 */
	function masha_fp_get_size_attributes( $product ) {
		if ( ! $product || ! is_a( $product, 'WC_Product' ) || ! $product->is_type( 'variable' ) ) {
			return array();
		}

		$attrs = $product->get_variation_attributes();
		if ( empty( $attrs ) || ! is_array( $attrs ) ) {
			return array();
		}

		foreach ( $attrs as $name => $options ) {
			if ( stripos( $name, 'pointure' ) !== false || stripos( $name, 'size' ) !== false || stripos( $name, 'taille' ) !== false ) {
				return is_array( $options ) ? $options : array();
			}
		}

		$fallback = reset( $attrs );
		return is_array( $fallback ) ? $fallback : array();
	}
}
