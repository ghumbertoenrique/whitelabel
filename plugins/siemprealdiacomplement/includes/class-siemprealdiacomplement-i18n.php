<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://www.siemprealdia.co/
 * @since      1.0.0
 *
 * @package    siemprealdiacomplement
 * @subpackage siemprealdiacomplement/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    siemprealdiacomplement
 * @subpackage siemprealdiacomplement/includes
 * @author     Humberto Gonzalez <humberto.gonzalez@alegra.com>
 */
class siemprealdiacomplement_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'siemprealdiacomplement',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
