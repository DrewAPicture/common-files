<?php
/**
 * Trait that makes queries reusable across calls of the same instance
 *
 * @package   Common_Files\Dry
 * @copyright Copyright (c) 2018, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License v2 or later
 * @author    Drew Jaynes
 * @since     1.0.0
 */

/**
 * Defines a set of methods to allow a has_* query to be cached (once) for later iteration.
 *
 * Usage:
 *
 *     if ( $component->has_items( ...args ) {
 *         // Iterate through the items from the now-cached query.
 *         $items = $component->query( ...args );
 *         ...
 *     }
 *
 * @since 1.0.0
 */
trait Shared_Queries {

	/**
	 * Represents the current query.
	 *
	 * Use the setter and getter to access it.
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	private $current_query = array();

	/**
	 * Sets the current query to persist through the instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $query Query to persist.
	 */
	public function set_current_query( $query ) {
		$this->current_query = $query;
	}

	/**
	 * Retrieves the current query being persisted through the instance.
	 *
	 * @since 1.0.0
	 *
	 * @return array Current query.
	 */
	public function get_current_query() {
		return $this->current_query;
	}

	/**
	 * Resets the current query.
	 *
	 * Should be used following the method that the query ultimately uses.
	 *
	 * @since 1.0.0
	 */
	public function reset_query() {
		$this->current_query = array();
	}

	/**
	 * Checks if the current data store has any of the current items.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Optional. Arguments for querying for items. Default empty array.
	 * @return bool Whether the current data store has any of the current items according
	 *              to the custom or default arguments.
	 */
	public function has_items( $args = array() ) {
		$this->set_current_query( $this->query( $args ) );

		return ! empty( $this->get_current_query() );
	}

}
