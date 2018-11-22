<?php
/**
 * Defines the contract under which a component database class operates
 *
 * @package   Common_Files\Dry
 * @copyright Copyright (c) 2018, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License v2 or later
 * @since     1.0.0
 */

/**
 * Defines the CRUD methods all Database classes must have.
 *
 * @since 1.0.0
 */
interface Database {

	/**
	 * Retrieves a copy of an object for the current component.
	 *
	 * @since 1.0.0
	 *
	 * @param int $object_id Object ID.
	 * @return mixed Object if it exists, otherwise an error handler or fallback value.
	 */
	public function get( int $object_id );

	/**
	 * Queries for one or more objects.
	 *
	 * @since 1.0.0
	 *
	 * @param array $query_args Optional. Query arguments. Default empty array.
	 * @return mixed Expected results for the given object type.
	 */
	public function query( array $query_args = array() );

	/**
	 * Adds a new object for the current component.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Raw object data.
	 * @return int Newly-created object ID or 0 on failure.
	 */
	public function add( array $data ) : int;

	/**
	 * Updates an object with a given set of data.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $object_id Object ID.
	 * @param array $data      Object data to update.
	 * @return int The object ID if it was successfully updated, otherwise 0.
	 */
	public function update( int $object_id, array $data ) : int;

	/**
	 * Deletes an object.
	 *
	 * @since 1.0.0
	 *
	 * @param int $object_id Object ID.
	 * @return bool True if the object was successfully deleted, otherwise false.
	 */
	public function delete( int $object_id ) : bool;

}
