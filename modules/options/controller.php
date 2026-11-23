<?php
/**
 * WBW Currency Switcher for WooCommerce - optionsControllerWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class optionsControllerWcu extends controllerWcu {

	/**
	 * saveGroup.
	 *
	 * @version 2.4.0
	 */
	public function saveGroup() {
		$res = new responseWcu();
		if($this->getModel()->saveGroup(reqWcu::get('post'))) {
			$res->addMessage(__('Done', 'woo-currency'));
		} else
			$res->pushError ($this->getModel('options')->getErrors());
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			WCU_USERLEVELS => array(
				WCU_ADMIN => array('saveGroup')
			),
		);
	}
}

