<?php
/**
 * Custom ACF Gutenberg blocks and block patterns
 *
 * @package bowst-press
 */

/**
 * Register all ACF blocks from the blocks directory.
 *
 * Scans the /blocks directory for subdirectories containing block.json files
 * and registers each one as a block type.
 *
 * @return void
 */
function register_acf_blocks() {
	$blocks_dir = get_template_directory() . '/blocks';

	// Scan the blocks directory for all subdirectories.
	$block_folders = glob( $blocks_dir . '/*', GLOB_ONLYDIR );

	// Register each block that has a block.json file.
	foreach ( $block_folders as $block_folder ) {
		$block_json = $block_folder . '/block.json';
		if ( file_exists( $block_json ) ) {
			register_block_type( $block_json );
		}
	}
}
add_action( 'init', 'register_acf_blocks' );

/**
 * Add custom block categories for Mosaic blocks.
 *
 * @param array                   $categories Array of block categories.
 * @param WP_Block_Editor_Context $editor The current block editor context.
 * @return array Modified array of block categories.
 */
function add_block_categories( $categories, $editor ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'bowst',
				'title' => __( 'Bowst', 'bowst-press' ),
			),
		)
	);
}
add_filter( 'block_categories_all', 'add_block_categories', 10, 2 );

/**
 * Register custom block pattern categories.
 *
 * @return void
 */
function bowst_press_register_block_categories() {
	if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {
		register_block_pattern_category(
			'bowst',
			array( 'label' => _x( 'Bowst', 'Block pattern category', 'bowst-press' ) )
		);
	}
}
add_action( 'init', 'bowst_press_register_block_categories' );
