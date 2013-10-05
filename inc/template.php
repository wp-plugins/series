<?php
/**
 * Functions for use in theme templates.
 *
 * @package    Series
 * @since      0.2.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2009 - 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/plugins
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Displays a list of posts by series ID.
 *
 * @since  0.1.0
 * @param  array   $args
 * @return string
 */
function series_list_posts( $args = array() ) {

	if ( empty( $args['series'] ) )
		return;

	$out     = '';
	$post_id = 0;

	if ( in_the_loop() )
		$post_id = get_the_ID();

	else if ( is_singular() )
		$post_id = get_queried_object_id();

	$defaults = array(
		'series'         => '', // term slug
		'order'          => 'ASC',
		'orderby'        => 'date',
		'posts_per_page' => -1,
		'echo'           => true
	);

	$args = wp_parse_args( $args, $defaults );

	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) {

		$out .= '<ul class="series-list">';

		while ( $loop->have_posts() ) {

			$loop->the_post();

			$out .= $post_id === get_the_ID() ? the_title( '<li>', '</li>', false ) : the_title( '<li><a href="' . get_permalink() . '">', '</a></li>', false );
		}

		$out .= '</ul>';
	}

	wp_reset_postdata();

	if ( false === $args['echo'] )
		return $out;

	echo $out;
}

/**
 * Displays a list of posts related to the post by the first series.
 *
 * @since  0.1.0
 * @param  array  $args
 * @return string
 */
function series_list_related( $args = array() ) {

	$post_id = 0;

	if ( in_the_loop() )
		$post_id = get_the_ID();

	else if ( is_singular() )
		$post_id = get_queried_object_id();

	if ( !empty( $post_id ) )
		$series = get_the_terms( $post_id, 'series' );

	if ( empty( $series ) )
		return;

	$series = reset( $series );

	$args['series'] = $series->slug;

	return series_list_posts( $args );
}

/* === DEPRECATED === */

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function get_series_feed_link( $cat_id, $feed = '' ) {
	_deprecated_function( __FUNCTION__, '0.2.0', 'get_term_feed_link' );
	return get_term_feed_link( $term_id, 'series', $feed );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function is_series( $slug = false ) {
	_deprecated_function( __FUNCTION__, '0.2.0', 'is_tax' );
	return is_tax( 'series', $slug );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function in_series( $series, $_post = null ) {
	_deprecated_function( __FUNCTION__, '0.2.0', 'has_term' );
	return has_term( $series, 'series', $_post );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function create_series_taxonomy() {
	_deprecated_function( __FUNCTION__, '0.2.0', '' );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function series_register_widgets() {
	_deprecated_function( __FUNCTION__, '0.2.0', '' );
}


?>