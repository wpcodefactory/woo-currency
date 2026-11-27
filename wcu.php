<?php
/**
 * Plugin Name: Currency Switcher for WooCommerce by WBW
 * Description: Currency Switcher for WooCommerce by WBW allows the customers switch products prices to any currencies. Get rates converted in the real time with dynamic currency switcher.
 * Version: 2.4.1
 * Author: woobewoo
 * Author URI: https://woobewoo.com
 * WC tested up to: 11.3
 * Requires Plugins: woocommerce
 * Text Domain: woo-currency
 * Domain Path: /languages
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package WooBeWoo\WC_Currency_Switcher
 */

defined( 'ABSPATH' ) || exit;

/**
 * Base config constants and functions.
 *
 * @version 2.4.0
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * HPOS.
 */
add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);

/**
 * Connect all required core classes.
 */
importClassWcu( 'dbWcu' );
importClassWcu( 'installerWcu' );
importClassWcu( 'baseObjectWcu' );
importClassWcu( 'moduleWcu' );
importClassWcu( 'modelWcu' );
importClassWcu( 'viewWcu' );
importClassWcu( 'controllerWcu' );
importClassWcu( 'helperWcu' );
importClassWcu( 'dispatcherWcu' );
importClassWcu( 'fieldWcu' );
importClassWcu( 'tableWcu' );
importClassWcu( 'frameWcu' );

/**
 * Deprecated.
 *
 * @deprecated since version 1.0.1.
 */
importClassWcu( 'langWcu' );
importClassWcu( 'reqWcu' );
importClassWcu( 'uriWcu' );
importClassWcu( 'htmlWcu' );
importClassWcu( 'responseWcu' );
importClassWcu( 'fieldAdapterWcu' );
importClassWcu( 'validatorWcu' );
importClassWcu( 'errorsWcu' );
importClassWcu( 'utilsWcu' );
importClassWcu( 'modInstallerWcu' );
importClassWcu( 'installerDbUpdaterWcu' );
importClassWcu( 'dateWcu' );

/**
 * Register activation/deactivation/uninstall hooks.
 *
 * @version 2.4.1
 */
register_activation_hook( __FILE__, array( 'utilsWcu', 'activatePlugin' ) );
register_uninstall_hook( __FILE__, array( 'utilsWcu', 'deletePlugin' ) );
register_deactivation_hook( __FILE__, array( 'utilsWcu', 'deactivatePlugin' ) );

/**
 * Check plugin version - maybe we need to update database, and check global errors in request.
 */
installerWcu::update();
errorsWcu::init();

/**
 * Start application after all plugins are loaded.
 *
 * @version 2.4.1
 */
add_action(
	'plugins_loaded',
	function () {
		frameWcu::_()->parseRoute();
		frameWcu::_()->init();
	}
);
