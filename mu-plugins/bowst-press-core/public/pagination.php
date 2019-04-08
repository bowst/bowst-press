<?php

/**
 * Custom Pagination
 *
 * Use without arguments for standard loops, or include arguments to
 * customize pagination inside WP_Queries
 *
 * More info: http://callmenick.com/post/custom-wordpress-loop-with-pagination
 *
 * @param  {String} $numpages  Number of pages returned by our query
 * @param  {String} $pagerange Range of pages that we will display (even number)
 * @param  {String} $paged     The $paged value
 * @return {String}            Pagination HTML
 */

function bowst_press_pagination( $numpages = '', $pagerange = '', $paged = '' ) {

	if ( empty( $pagerange ) ) {
		$pagerange = 2;
	}

	global $paged;

	if ( empty( $paged ) ) {
		$paged = 1;
	}

	if ( '' === $numpages ) {
		global $wp_query;
		$numpages = $wp_query->max_num_pages;
		if ( ! $numpages ) {
			$numpages = 1;
		}
	}

	$pagination_args = array(
		'base'         => get_pagenum_link( 1 ) . '%_%',
		'format'       => 'page/%#%',
		'total'        => $numpages,
		'current'      => $paged,
		'show_all'     => false,
		'end_size'     => 1,
		'mid_size'     => $pagerange,
		'prev_next'    => true,
		'prev_text'    => __( '<i class="fas fa-chevron-left"></i>' ),
		'next_text'    => __( '<i class="fas fa-chevron-right"></i>' ),
		'type'         => 'list',
		'add_args'     => false,
		'add_fragment' => '',
	);

	$paginate_links = paginate_links( $pagination_args );

	if ( $paginate_links ) {
		echo "<div id='pagination' class='pagination'>";
		echo $paginate_links;
		echo '</div>';
	}
}

/**
 * Remove H2 from default the_posts_pagination()
 */
function bowst_press_sanitize_pagination( $content ) {
	// Remove role attribute
	$content = str_replace( 'role="navigation"', '', $content );

	// Remove h2 tag
	$content = preg_replace( '#<h2.*?>(.*?)<\/h2>#si', '', $content );

	return $content;
}
add_action( 'navigation_markup_template', 'bowst_press_sanitize_pagination' );

/**
 * FacetWP custom pagination
 */
add_filter( 'facetwp_pager_html', function( $output, $params ) {
	$output      = '';
	$page        = $params['page'];
	$total_pages = $params['total_pages'];

	if ( 1 < $total_pages ) {

		// Previous page (NEW)
		if ( $page > 1 ) {
			$output .= '<a class="facetwp-page" data-page="' . ( $page - 1 ) . '"><i class="fas fa-chevron-left"></i></a>';
		}

		if ( 1 < $total_pages ) {
			for ( $i = 1; $i <= $total_pages; $i++ ) {
				$is_curr = ( $i === $page ) ? ' active' : '';
				$output .= '<a class="facetwp-page' . $is_curr . '" data-page="' . $i . '">' . $i . '</a>';
			}
		}

		// Next page (NEW)
		if ( $page < $total_pages ) {
			$output .= '<a class="facetwp-page" data-page="' . ( $page + 1 ) . '"><i class="fas fa-chevron-right"></i></a>';
		}
	}

	return $output;
}, 10, 2 );
