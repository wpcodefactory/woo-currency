<?php
/**
 * WBW Currency Switcher for WooCommerce - installerWcu Class
 *
 * @version 2.2.3
 *
 * @author  woobewoo
 */

defined( 'ABSPATH' ) || exit;

class installerWcu {

	/**
	 * update_to_version_method.
	 */
	static public $update_to_version_method = '';

	/**
	 * _firstTimeActivated.
	 */
	static private $_firstTimeActivated = false;

	/**
	 * init.
	 */
	static public function init( $isUpdate = false ) {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Version */
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$current_version = get_option($wpPrefix. WCU_DB_PREF. 'db_version', 0);
		if(!$current_version) {
			self::$_firstTimeActivated = true;
		}
		/**
		 * modules.
		 */
		if (!dbWcu::exist("@__modules")) {
			dbDelta(dbWcu::prepareQuery("CREATE TABLE IF NOT EXISTS `@__modules` (
			  `id` smallint(3) NOT NULL AUTO_INCREMENT,
			  `code` varchar(32) NOT NULL,
			  `active` tinyint(1) NOT NULL DEFAULT '0',
			  `type_id` tinyint(1) NOT NULL DEFAULT '0',
			  `label` varchar(64) DEFAULT NULL,
			  `ex_plug_dir` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE INDEX `code` (`code`)
			) DEFAULT CHARSET=utf8;"));
			dbWcu::query("INSERT INTO `@__modules` (id, code, active, type_id, label) VALUES
				(NULL, 'adminmenu',1,1,'Admin Menu'),
				(NULL, 'options',1,1,'Options'),
				(NULL, 'user',1,1,'Users'),
				(NULL, 'pages',1,1,'Pages'),
				(NULL, 'templates',1,1,'Templates'),
				(NULL, 'promo',1,1,'Promo'),
				(NULL, 'admin_nav',1,1,'Admin Nav'),
				(NULL, 'mail',1,1,'Mail'),
				(NULL, 'currency',1,1,'Currency'),
				(NULL, 'currency_switcher',1,1,'Currency Switcher'),
				(NULL, 'currency_widget',1,1,'Currency Widget');");
		}
		/**
		 * modules_type.
		 */
		if(!dbWcu::exist("@__modules_type")) {
			dbDelta(dbWcu::prepareQuery("CREATE TABLE IF NOT EXISTS `@__modules_type` (
			  `id` smallint(3) NOT NULL AUTO_INCREMENT,
			  `label` varchar(32) NOT NULL,
			  PRIMARY KEY (`id`)
			) AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;"));
			dbWcu::query("INSERT INTO `@__modules_type` VALUES
				(1,'system'),
				(6,'addons');");
		}
		/**
		 * Plugin usage statistics.
		 */
		if(!dbWcu::exist("@__usage_stat")) {
			dbDelta(dbWcu::prepareQuery("CREATE TABLE `@__usage_stat` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(64) NOT NULL,
			  `visits` int(11) NOT NULL DEFAULT '0',
			  `spent_time` int(11) NOT NULL DEFAULT '0',
			  `modify_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  UNIQUE INDEX `code` (`code`),
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8"));
			dbWcu::query("INSERT INTO `@__usage_stat` (code, visits) VALUES ('installed', 1)");
		}

		$wcuOrdersCurrencies = get_option(WCU_DB_PREF. 'orders_currencies');
		if (!empty($wcuOrdersCurrencies)) {
			$wcuOrdersCurrencies = json_decode($wcuOrdersCurrencies, true);
			foreach ($wcuOrdersCurrencies as $orderId => $wcuCurrency) {
				$order = wc_get_order($orderId);
				if ($order) {
					$order->set_currency($wcuCurrency);
				}
			}
			delete_option(WCU_DB_PREF. 'orders_currencies');
		}
	}

	/**
	 * setUsed.
	 */
	static public function setUsed() {
		update_option(WCU_DB_PREF. 'plug_was_used', 1);
	}

	/**
	 * isUsed.
	 */
	static public function isUsed() {
		return (int) get_option(WCU_DB_PREF. 'plug_was_used');
	}

	/**
	 * delete.
	 */
	static public function delete() {
		self::_checkSendStat('delete');
		global $wpdb;
		$wpPrefix = $wpdb->prefix;
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.WCU_DB_PREF."modules`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.WCU_DB_PREF."modules_type`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.WCU_DB_PREF."usage_stat`");
		delete_option($wpPrefix. WCU_DB_PREF. 'db_version');
		delete_option($wpPrefix. WCU_DB_PREF. 'db_installed');
		delete_option(WCU_DB_PREF. 'orders_currencies');
	}

	/**
	 * deactivate.
	 */
	static public function deactivate() {
		self::_checkSendStat('deactivate');
		self::_updateOrdersCurrency();
	}

	/**
	 * _checkSendStat.
	 */
	static private function _checkSendStat($statCode) {

	}

	/**
	 * _updateOrdersCurrency.
	 *
	 * @version 2.2.3
	 */
	static private function _updateOrdersCurrency() {
		$wcuCurrency = get_option('woocommerce_currency', 'USD');

		$doResetOrderCurrency = true;
		if (
			!function_exists('get_woocommerce_currencies') ||
			!($currencies = get_woocommerce_currencies()) ||
			!isset($currencies[$wcuCurrency])
		) {
			$doResetOrderCurrency = false;
		}

		if (function_exists('wc_get_orders')) {
			$oldCurrencies = array();
			$orders = wc_get_orders(array(
				'posts_per_page' => -1,
				'type'           => 'shop_order',
				'return'         => 'ids',
			));

			if (!empty($orders)) {
				foreach ($orders as $orderId) {
					$order = wc_get_order($orderId);
					if ($order) {
						$oldCurrencies[$orderId] = $order->get_currency();
						if ($doResetOrderCurrency) {
							$order->set_currency($wcuCurrency);
						}
					}
				}
			}

			if (!empty($oldCurrencies)) {
				update_option(WCU_DB_PREF. 'orders_currencies', json_encode($oldCurrencies, JSON_UNESCAPED_UNICODE));
			}
		}
	}

	/**
	 * update.
	 */
	static public function update() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Version */
		$currentVersion = get_option($wpPrefix. WCU_DB_PREF. 'db_version', 0);
		if(!$currentVersion || version_compare(WCU_VERSION, $currentVersion, '>')) {
			self::init( true );
			update_option($wpPrefix. WCU_DB_PREF. 'db_version', WCU_VERSION);
		}
	}

}
