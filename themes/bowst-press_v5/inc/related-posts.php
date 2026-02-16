<?php
/**
 * Get related posts based on taxonomy
 *
 * Usage:
 * <?php
 * $related = bowst_press_get_related_posts( get_the_ID(), 3 );
 * if ( $related->have_posts() ) :
 *      ?>
 *      <div class="related-posts">
 *          <h3>Related posts</h3>
 *          <ul>
 *              <?php while ( $related->have_posts() ) : $related->the_post(); ?>
 *                  <li>
 *                      <h4><?php the_title(); ?></h4>
 *                      <?php the_excerpt(); ?>
 *                  </li>
 *              <?php endwhile; wp_reset_postdata(); ?>
 *          </ul>
 *      </div>
 *      <?php
 * endif;
 * ?>
 *
 * @package bowst_press
 */

function bowst_press_get_related_posts( $post_id, $related_count, $args = array() ) {

	$related_cached = get_transient( 'bowst_press_cached_related_' . $post_id );

	if ( false === $related_cached ) {
		$args = wp_parse_args(
			(array) $args,
			array(
				'orderby' => 'rand',
				'return'  => 'query', // Valid values are: 'query' (WP_Query object), 'array' (the arguments array).
			)
		);

		$related_args = array(
			'post_type'      => get_post_type( $post_id ),
			'posts_per_page' => $related_count,
			'post_status'    => 'publish',
			'post__not_in'   => array( $post_id ),
			'orderby'        => $args['orderby'],
			'tax_query'      => array(),
		);

		$post       = get_post( $post_id );
		$taxonomies = get_object_taxonomies( $post, 'names' );

		foreach ( $taxonomies as $taxonomy ) {
			$terms = get_the_terms( $post_id, $taxonomy );
			if ( empty( $terms ) ) {
				continue;
			}
			$term_list                   = wp_list_pluck( $terms, 'slug' );
			$related_args['tax_query'][] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $term_list,
			);
		}

		if ( count( $related_args['tax_query'] ) > 1 ) {
			$related_args['tax_query']['relation'] = 'OR';
		}

		if ( 'query' === $args['return'] ) {
			$related = new WP_Query( $related_args );
			set_transient( 'bowst_press_cached_related_' . $post_id, $related, DAY_IN_SECONDS );

			return $related;
		} else {
			return $related_args;
		}
	} else {
		return $related_cached;
	}
}

/**
 * Delete the related posts transient whenever a post is saved.
 */
// function bowst_press_purge_related_transient( $post_ID, $post, $update ) {
// delete_transient( 'bowst_press_cached_related' . $post_id );
// }
// add_action( 'publish_post', 'bowst_press_purge_related_transient', 10, 3 );

