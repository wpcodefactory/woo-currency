<?php
/**
 * WBW Currency Switcher for WooCommerce - admin_navViewWcu Class
 *
 * @version 2.2.0
 *
 * @author  woobewoo
 */

defined( 'ABSPATH' ) || exit;

class admin_navViewWcu extends viewWcu {

	/**
	 * breadcrumbsList.
	 *
	 * @version 2.2.0
	 * @since   2.2.0
	 */
	public $breadcrumbsList;

	/**
	 * getBreadcrumbs.
	 */
	public function getBreadcrumbs() {
		$this->assign('breadcrumbsList', dispatcherWcu::applyFilters('mainBreadcrumbs', $this->getModule()->getBreadcrumbsList()));
		return parent::getContent('adminNavBreadcrumbs');
	}

}
