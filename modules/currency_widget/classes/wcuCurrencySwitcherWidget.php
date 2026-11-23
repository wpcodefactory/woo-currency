<?php
/**
 * WBW Currency Switcher for WooCommerce - wcuCurrencySwitcherWidget Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;
class wcuCurrencySwitcherWidget extends WP_Widget {
	public $widgetName = 'wcuCurrencySwitcherWidget';
	public $widgetTemplate = 'currencySwitcher';
	public $widgetOps = array();

	/**
	 * __construct.
	 *
	 * @version 2.4.0
	 */
	public function __construct() {
		$this->widgetOps = array(
			'classname' => $this->widgetName,
			'description' => __('Displays Currency Switcher for Woocommerce products', 'woo-currency')
		);
		parent::__construct( $this->widgetName, WCU_WP_PLUGIN_NAME . ' ' . __('Switcher', 'woo-currency'), $this->widgetOps );
	}

	/**
	 * widget.
	 *
	 * @version 2.4.0
	 */
	public function widget( $args, $instance ) {
		htmlWcu::echo_escaped_html( frameWcu::_()->getModule( 'currency_widget' )->getView()->displayWidget( $instance, $this->widgetTemplate ) );
	}
	public function form($instance) {
		frameWcu::_()->getModule('currency_widget')->getView()->displayForm($instance, $this, $this->widgetTemplate);
	}
	public function update($new_instance, $old_instance) {
		return $new_instance;
	}
}
