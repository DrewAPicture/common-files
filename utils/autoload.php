<?php
/**
 * Automatically locates and loads files based on their namespaces and their
 * file names whenever they are instantiated.
 *
 * Contains support for interfaces and traits, via either directory/namespace
 * structure or naming convention. For example:
 * - interfaces/interface-database.php (namespace of Interfaces\Database)
 * - interface-database.php (namespace of Interface_Database or Database_Interface)
 * - and similar structure for traits
 *
 * This script is a fork of the the {@link https://github.com/tommcfarlin/simple-autoloader-for-wordpress Simple Autoloader for Wordpress}
 * by Tom McFarlin, licensed under GPLv3.
 *
 * @package   Common_Files\Utils
 * @copyright Copyright (c) 2018, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License v2 or later
 * @author    Drew Jaynes
 * @since     1.0.0
 */
spl_autoload_register( function( $filename ) {

	// First, separate the components of the incoming file.
	$file_path = explode( '\\', $filename );

	/*
	 * - The first index will always be the namespace since it's part of the plugin.
	 * - All but the last index will be the path to the file.
	 * - The final index will be the filename. If it doesn't begin with 'I' then it's a class.
	 */

	// Get the last index of the array. This is the class being loaded.
	$file_name = '';

	if ( isset( $file_path[ count( $file_path ) - 1 ] ) ) {

		$file_name = strtolower(
			$file_path[ count( $file_path ) - 1 ]
		);

		$file_name       = str_ireplace( '_', '-', $file_name );
		$file_name_parts = explode( '-', $file_name );

		// Use array_search() to handle both Interface_Foo or Foo_Interface.
		$interface_index = array_search( 'interface', $file_name_parts );
		$trait_index     = array_search( 'trait', $file_name_parts );

		if ( false !== $interface_index || in_array( 'Interfaces', $file_path ) ) {
			// Only drop 'interface' if not part of the namespace.
			if ( false !== $interface_index ) {
				unset( $file_name_parts[ $interface_index ] );
			}

			// Rebuild the file name.
			$file_name = implode( '-', $file_name_parts );

			$file_name = "interface-{$file_name}.php";
		} elseif ( false !== $trait_index || in_array( 'Traits', $file_path ) ) {
			// Only drop 'trait' if not part of the namespace.
			if ( false !== $trait_index ) {
				unset( $file_name_parts[ $trait_index ] );
			}

			// Rebuild the file name.
			$file_name = implode( '-', $file_name_parts );

			$file_name = "trait-{$file_name}.php";
		} else {
			$file_name = "class-$file_name.php";
		}
	}

	/*
	 * Find the fully qualified path to the class file by iterating through the $file_path array.
	 * We ignore the first index since it's always the top-level package. The last index is always
	 * the file so we append that at the end.
	 */
	$fully_qualified_path = trailingslashit(
		dirname(
			dirname( __FILE__ )
		)
	);

	for ( $i = 1; $i < count( $file_path ) - 1; $i++ ) {

		$dir = strtolower( $file_path[ $i ] );
		$fully_qualified_path .= trailingslashit( $dir );
	}

	$fully_qualified_path .= $file_name;

	// Now include the file.
	if ( stream_resolve_include_path( $fully_qualified_path ) ) {
		include_once $fully_qualified_path;
	}
});
