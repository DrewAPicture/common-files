<?php
/**
 * Registry abstract
 *
 * @package   Common_Files\Utils
 * @copyright Copyright (c) 2018, Drew Jaynes
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License v2 or later
 * @author    Drew Jaynes
 * @since     1.0.0
 */
//namespace Common_Files\Utils;

/**
 * Defines the construct for building an item registry.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Registry extends \ArrayObject {

	/**
	 * Array of registry items.
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	private $items = array();

	/**
	 * Sets up and retrieves the singleton instance for the current registry.
	 *
	 * Each extending class must define a public static $instance member.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed Registry instance.
	 */
	public static function instance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new static();

			static::$instance->init();
		}

		return static::$instance;
	}

	/**
	 * Initializes the registry.
	 *
	 * Each sub-class can use this method to perform various initialization operations as needed.
	 *
	 * @since 1.0.0
	 */
	abstract public function init();

	/**
	 * Adds an item to the registry.
	 *
	 * @since 1.0.0
	 *
	 * @param int         $item_id       Item ID.
	 * @param array|mixed $value_or_atts Item value or array of attributes. Each sub-class can individually
	 *                                   define the attributes schema.
	 * @return true Always true.
	 */
	public function add_item( $item_id, $value_or_atts ) {
		if ( is_array( $value_or_atts ) ) {
			foreach ( $value_or_atts as $attribute => $value ) {
				$this->items[ $item_id ][ $attribute ] = $value;
			}
		} else {
			$this->items[ $item_id ] = $value_or_atts;
		}

		return true;
	}

	/**
	 * Removes an item from the registry by ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_id Item ID.
	 */
	public function remove_item( $item_id ) {
		unset( $this->items[ $item_id ] );
	}

	/**
	 * Retrieves an item and its associated attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_id Item ID.
	 * @return array|false Array of attributes for the item if registered, otherwise false.
	 */
	public function get( $item_id ) {
		if ( isset( $this->items[ $item_id ] ) ) {
			return $this->items[ $item_id ];
		}

		return false;
	}

	/**
	 * Retrieves registered items.
	 *
	 * @since 1.0.0
	 *
	 * @return array The list of registered items.
	 */
	public function get_items() {
		return $this->items;
	}

	/**
	 * Retrieves the value of a given item attribute, if the item and its attribute exist.
	 *
	 * @param string      $item_id   Item ID.
	 * @param string      $attribute Attribute key/name.
	 * @param false|mixed $default   Optional. Default value to return if the attribute is not set.
	 *                               Note: The default will always be false if the item doesn't exist.
	 * @return mixed|false Value of the item attribute (if it exists), otherwise the value of `$default`.
	 *                     If the item doesn't exist, always false.
	 */
	public function get_item_attribute( $item_id, $attribute, $default = false ) {
		$value = $default;

		if ( false !== $value_or_atts = $this->get( $item_id ) ) {
			if ( ! is_array( $value_or_atts ) ) {
				$value = $value_or_atts;
			} else {
				$value = $value_or_atts[ $attribute ] ?? $default;
			}
		}

		return $value;
	}

	/**
	 * Only intended for use by PHPUnit.
	 *
	 * @since 1.0.0
	 */
	public function _reset_items() {
		if ( ! defined( 'WP_TESTS_DOMAIN' ) ) {
			_doing_it_wrong( 'This method is only intended for use in phpunit tests', '1.0.0' );
		} else {
			$this->items = array();
		}
	}

	/**
	 * Determines whether an item exists.
	 *
	 * @since 1.0.0
	 *
	 * @param string $offset Item ID.
	 * @return bool True if the item exists, false on failure.
	 */
	public function offsetExists( $offset ) {
		return false !== $this->get( $offset );
	}

	/**
	 * Retrieves an item by its ID.
	 *
	 * Defined only for compatibility with ArrayAccess, use get() directly.
	 *
	 * @since 1.0.0
	 *
	 * @param string $offset Item ID.
	 * @return mixed The registered item, if it exists.
	 */
	public function offsetGet( $offset ) {
		return $this->get( $offset );
	}

	/**
	 * Adds/overwrites an item in the registry.
	 *
	 * Defined only for compatibility with ArrayAccess, use add_item() directly.
	 *
	 * @since 1.0.0
	 *
	 * @param string $offset Item ID.
	 * @param mixed  $value  Item attributes.
	 */
	public function offsetSet( $offset, $value ) {
		$this->add_item( $offset, $value );
	}

	/**
	 * Removes an item from the registry.
	 *
	 * Defined only for compatibility with ArrayAccess, use remove_item() directly.
	 *
	 * @since 1.0.0
	 *
	 * @param string $offset Item ID.
	 */
	public function offsetUnset( $offset ) {
		$this->remove_item( $offset );
	}

}
