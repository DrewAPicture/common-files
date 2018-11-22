<?php
/**
 * Sets up the ability to run a variety of {component} queries
 *
 * @package   Common_Files\Dry\Database
 * @copyright Copyright (c) 2018, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License v2 or later
 * @author    Drew Jaynes
 * @since     1.0.0
 */

namespace Common_Files\Dry\Database;

use Common_Files\{Interfaces\Database, Traits\Shared_Queries};

/**
 * Manages CRUD database operations for {component}.
 *
 * @since 1.0.0
 */
class Component_Database implements Database {

	use Shared_Queries;

	/**
	 * Retrieves a single object if it exists.
	 *
	 * @since 1.0.0
	 *
	 * @param int $object_id Object ID.
	 * @return \stdClass|\WP_Error {Component} object if it exists, otherwise a WP_Error object.
	 */
	public function get( int $object_id ) {
		$object = get_the_object( $object_id );

		if ( is_null( $download ) ) {
			$download = new \WP_Error( 'invalid_object_id' );
		}

		return $download;
	}

	/**
	 * Queries for one or more records matching the given arguments.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {Component} query arguments.
	 * @return array Array of objects, fields, or an empty array if no results.
	 */
	public function query( array $args = array() ) {
		$current_query = $this->get_current_query();

		if ( ! empty( $current_query ) ) {
			$this->reset_query();

			return $current_query;
		}

		return get_the_objects( $args );
	}

	/**
	 * Adds a new {Component} record.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data {Component} record data.
	 * @return int The ID of the newly-created object if successful, otherwise 0.
	 */
	public function add( array $data ) : int {
		return add_the_object( $data );
	}

	/**
	 * Updates a {Component} record with the given data.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $object_id Object ID.
	 * @param array $data      {Component} record data to update.
	 * @return int The object ID if it was successfully updated, otherwise 0.
	 */
	public function update( int $object_id, array $data ) : int {
		return get_the_object( $args );
	}

	/**
	 * Deletes a {Component} record.
	 *
	 * @since 1.0.0
	 *
	 * @param int $object_id Object ID.
	 * @return bool True if the record was successfully deleted, otherwise false.
	 */
	public function delete( int $object_id ) : bool {
		return (bool) delete_the_object( $object_id );
	}

}
