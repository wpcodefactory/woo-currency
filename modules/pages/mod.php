<?php
/**
 * WBW Currency Switcher for WooCommerce - pagesWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class pagesWcu extends moduleWcu {
    /**
     * Check if current page is Login page
     *
     * @version 2.4.0
     */
    public function isLogin() {
	    $script_name = isset( $_SERVER['SCRIPT_NAME'] ) ?
		    sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ) :
		    '';
	    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ?
		    esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) :
		    '';

	    return (
			basename( $script_name ) == 'wp-login.php' ||
			strpos( $request_uri, '/login/' ) === 0
	    ); // Some plugins create login page by this address
    }
}

