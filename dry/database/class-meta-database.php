<?php
/**
 * Defines the contract under which a component meta database class operates
 *
 * @package   Common_Files\Dry
 * @copyright Copyright (c) 2018, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License v2 or later
 * @author    Drew Jaynes
 * @since     1.0.0
 */
//namespace Common_Files\Dry;

/**
 * Defines the CRUD methods all Meta_Database classes must have.
 *
 * @since 1.0.0
 */
interface Meta_Database {

	/**
	 * Retrieves a meta value based on object ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Optional. Meta key. If left empty, all meta will be returned.
	 * @param mixed  $default   Optional. An optional default value to return if the meta
	 *                          key doesn't exist. Default empty string.
	 * @return mixed Meta value if it exists, otherwise an empty string.
	 */
	public function get( int $object_id, string $meta_key = '', $default = '' );

	/**
	 * Sets a meta value based on object ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Meta key.
	 * @param mixed  $value     Meta value.
	 * @return bool True if the meta value was recorded, otherwise false.
	 */
	public function add( int $object_id, string $meta_key, $value ) : bool;

	/**
	 * Updates a meta value based on object ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Meta key.
	 * @param mixed  $value     Meta value.
	 * @return bool True if the new meta value was recorded, otherwise false.
	 */
	public function update( int $object_id, string $meta_key, $value ) : bool;

	/**
	 * Deletes a meta value.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Meta key for value to delete.
	 * @return bool True if the meta value was successfully deleted, otherwise false.
	 */
	public function delete( int $object_id, string $meta_key ) : bool;

}
