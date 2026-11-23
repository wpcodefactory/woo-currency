<?php
/**
 * WBW Currency Switcher for WooCommerce - uriWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class uriWcu {
	/**
	 * Tell link form method to replace symbols for special html caracters only for ONE output
	 */
	static private $_oneHtmlEnc = false;
    static public function fileToPageParam($file) {
        $file = str_replace(DS, '/', $file);
        return substr($file, strpos($file, WCU_PLUG_NAME));
    }

	static public function _( $params ) {
		global $wp_rewrite;
		$link = '';
		if ( is_string( $params )
		     && ( strpos( $params, 'http' ) === 0
		          || strpos( $params, WCU_PLUG_NAME ) !== false )    // If relative links in WP is used (by other plugin for example)
		) {
			if ( self::isHttps() ) {
				$params = self::makeHttps( $params );
			}

			return $params;
		} elseif ( is_array( $params ) && isset( $params['page_id'] ) ) {
			if ( is_null( $wp_rewrite ) ) {
				$wp_rewrite = new WP_Rewrite();
			}
			$link = get_page_link( $params['page_id'] );
			unset( $params['page_id'] );
		} elseif ( is_array( $params ) && isset( $params['baseUrl'] ) ) {
			$link = $params['baseUrl'];
			unset( $params['baseUrl'] );
		} else {
			$link = WCU_URL;
		}
		if ( ! empty( $params ) ) {
			$query = is_array( $params ) ? http_build_query( $params, '', '&' ) : $params;
			$sign  = ( strpos( $query, '/' ) === 0 ) ? '' : ( strpos( $link, '?' ) === false ? '?' : '&' );
			$link  .= $sign . ltrim( $query, '/' );
		}
		if ( self::$_oneHtmlEnc ) {
			$link              = str_replace( '&', '&amp;', $link );
			self::$_oneHtmlEnc = false;
		}

		return $link;
	}

	/**
	 * _e.
	 *
	 * @version 2.4.0
	 */
	static public function _e( $params ) {
		echo esc_url( self::_( $params ) );
	}
    static public function page($id) {
        return get_page_link($id);
    }

	/**
	 * getGetParams.
	 *
	 * @version 2.4.0
	 */
	static public function getGetParams( $exclude = array() ) {
		$res = array();
		if ( isset( $_GET ) && ! empty( $_GET ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			foreach ( $_GET as $key => $val ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				if ( in_array( $key, $exclude ) ) {
					continue;
				}
				$res[ sanitize_key( wp_unslash( $key ) ) ] = map_deep( wp_unslash( $val ), 'sanitize_text_field' );
			}
		}

		return $res;
	}
    static public function mod($name, $action = '', $data = NULL) {
        $params = array('mod' => $name);
        if($action)
            $params['action'] = $action;
		$params['pl'] = WCU_CODE;
        if($data) {
            if(is_array($data)) {
                $params = array_merge($params, $data);
				if(isset($data['reqType']) && $data['reqType'] == 'ajax') {
					$params['baseUrl'] = admin_url('admin-ajax.php');
				}
            } elseif(is_string($data)) {
                $params = http_build_query($params);
                $params .= '&'. $data;
            }
        }
        return self::_($params);
    }
    static public function atach($params) {
        $getData = self::getGetParams();
        if(!empty($getData)) {
            if(is_array($params))
                $params = array_merge($getData, $params);
            else
                $params = http_build_query($getData). '&'. $params;
        }
        return self::_($params);
    }
    /**
     * Get current path
     *
     * @version 2.4.0
     *
     * @return string current link
     */
	static public function getCurrent() {
		$host        = isset( $_SERVER['HTTP_HOST'] ) ?
			sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) :
			'';
		$script_name = isset( $_SERVER['SCRIPT_NAME'] ) ?
			sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ) :
			'';

		if ( ! empty( $_SERVER['HTTPS'] ) ) {
			return 'https://' . $host . $script_name;
		} else {
			return 'http://' . $host . $script_name;
		}
	}

	/**
	 * getFullUrl.
	 *
	 * @version 2.4.0
	 */
	static public function getFullUrl() {
		$url         = isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
		$host        = isset( $_SERVER['HTTP_HOST'] ) ?
			sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) :
			'';
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ?
			esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) :
			'';
		$url         .= $host . $request_uri;

		return $url;
	}
	/**
	 * Replace symbols to special html caracters in one output
	 */
	static public function oneHtmlEnc() {
		self::$_oneHtmlEnc = true;
	}
	static public function makeHttps($link) {
		if(strpos($link, 'https:') === false) {
			$link = str_replace('http:', 'https:', $link);
		}
		return $link;
	}
	static public function isHttps() {
		return is_ssl();
		//return (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on');
	}
	/**
	 * If url is without http:// - just domain name for example - we will add it here
	 * @param string $url Url to check
	 * @return string Checked and corrected URL (if this will be required)
	 */
	static public function normal($url) {
		$url = trim($url);
		if(strpos($url, 'http') !== 0) {
			$url = 'http://'. $url;
		}
		return $url;
	}
}

