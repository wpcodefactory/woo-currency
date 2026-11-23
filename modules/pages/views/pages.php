<?php
/**
 * WBW Currency Switcher for WooCommerce - pagesViewWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class pagesViewWcu extends viewWcu { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
    public function displayDeactivatePage() {
        $this->assign('GET', reqWcu::get('get'));
        $this->assign('POST', reqWcu::get('post'));
        $this->assign('REQUEST_METHOD', strtoupper(reqWcu::getVar('REQUEST_METHOD', 'server')));
        $this->assign('REQUEST_URI', basename(reqWcu::getVar('REQUEST_URI', 'server')));
        parent::display('deactivatePage');
    }
}

