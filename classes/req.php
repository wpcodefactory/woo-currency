<?php
/**
 * WBW Currency Switcher for WooCommerce - reqWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class reqWcu {
    static protected $_requestData;
    static protected $_requestMethod;

	/**
	 * $_requestWithNonce.
	 *
	 * @version 2.4.0
	 */
	public static $_requestWithNonce = false;
    static public function init() {
		// Empty for now
    }

	static public function startSession() {
		if(!utilsWcu::isSessionStarted()) {
			session_start();
		}
	}

	/**
	 * getVar.
	 *
	 * @param string $name key in variables array
	 * @param string $from from where get result = "all", "input", "get"
	 * @param mixed $default default value - will be returned if $name wasn't found
	 *
	 * @return mixed value of a variable, if didn't found - $default (NULL by default)
	 * @version 2.4.0
	 *
	 */
	static public function getVar( $name, $from = 'all', $default = null ) {
		if ( self::$_requestWithNonce ) {
			$nonce = empty( $_REQUEST['_wpnonce'] ) ?
				'' :
				sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) );

			if ( ! wp_verify_nonce( $nonce, 'my-nonce' ) ) {
				esc_html__( 'Security check', 'woo-currency' );
				exit();
			}
		}

		$from = strtolower( $from );
		if ( $from == 'all' ) {
			if ( isset( $_GET[ $name ] ) ) {
				$from = 'get';
			} elseif ( isset( $_POST[ $name ] ) ) {
				$from = 'post';
			}
		}

		switch ( $from ) {
			case 'get':
				if ( isset( $_GET[ $name ] ) ) {
					return map_deep( wp_unslash( $_GET[ $name ] ), 'sanitize_text_field' );
				}
				break;
			case 'post':
				if ( isset( $_POST[ $name ] ) ) {
					return map_deep( wp_unslash( $_POST[ $name ] ), 'sanitize_text_field' );
				}
				break;
			case 'file':
			case 'files':
			if ( isset( $_FILES[ $name ] ) ) {
				return self::sanitizeFiles( $_FILES[ $name ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			}
				break;
			case 'session':
				if ( isset( $_SESSION[ $name ] ) ) {
					return map_deep( $_SESSION[ $name ], 'sanitize_text_field' );
				}
				break;
			case 'server':
				if ( isset( $_SERVER[ $name ] ) ) {
					$value =  map_deep( wp_unslash( $_SERVER[ $name ] ), 'sanitize_text_field' );
					if ( is_string( $value ) && strpos( $value, '_JSON:' ) === 0 ) {
						$value = explode( '_JSON:', $value );
						$value = WooBeWoo_PF_Utils::jsonDecode( array_pop( $value ) );
					}
					return $value;
				}
				break;
			case 'cookie':
				if ( isset( $_COOKIE[ $name ] ) ) {
					$value = map_deep( wp_unslash( $_COOKIE[ $name ] ), 'sanitize_text_field' );
					if ( is_string( $value ) && strpos( $value, '_JSON:' ) === 0 ) {
						$value = explode( '_JSON:', $value );
						$value = WooBeWoo_PF_Utils::jsonDecode( array_pop( $value ) );
					}

					return $value;
				}
				break;
		}

		return $default;
	}
	static public function isEmpty($name, $from = 'all') {
		$val = self::getVar($name, $from);
		return empty($val);
	}
    static public function setVar($name, $val, $in = 'input', $params = array()) {
        $in = strtolower($in);
        switch($in) {
            case 'get':
                $_GET[$name] = $val;
            break;
            case 'post':
                $_POST[$name] = $val;
            break;
            case 'session':
                $_SESSION[$name] = $val;
            break;
			case 'cookie':
				$expire = isset($params['expire']) ? time() + $params['expire'] : 0;
				$path = isset($params['path']) ? $params['path'] : '/';
				if(is_array($val) || is_object($val)) {
					$saveVal = '_JSON:'. utilsWcu::jsonEncode( $val );
				} else {
					$saveVal = $val;
				}
				setcookie($name, $saveVal, $expire, $path);
			break;
        }
    }

	/**
	 * clearVar.
	 *
	 * @version 2.4.0
	 */
    static public function clearVar($name, $in = 'input', $params = array()) {
	    if ( self::$_requestWithNonce ) {
		    $nonce = empty( $_REQUEST['_wpnonce'] ) ?
			    '' :
			    sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) );

		    if ( ! wp_verify_nonce( $nonce, 'my-nonce' ) ) {
			    esc_html__( 'Security check', 'woo-currency' );
			    exit();
		    }
	    }
        $in = strtolower($in);
	    switch ( $in ) {
		    case 'get':
			    if ( isset( $_GET[ $name ] ) ) {
				    unset( $_GET[ $name ] );
			    }
			    break;
		    case 'post':
			    if ( isset( $_POST[ $name ] ) ) {
				    unset( $_POST[ $name ] );
			    }
			    break;
		    case 'session':
			    if ( isset( $_SESSION[ $name ] ) ) {
				    unset( $_SESSION[ $name ] );
			    }
			    break;
		    case 'cookie':
			    $path = isset( $params['path'] ) ? $params['path'] : '/';
			    setcookie( $name, '', time() - 3600, $path );
			    break;
	    }
    }

	/**
	 * get.
	 *
	 * @version 3.2.0
	 */
	static public function get( $what ) {
		if ( self::$_requestWithNonce ) {
			$nonce = empty( $_REQUEST['_wpnonce'] ) ?
				'' :
				sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) );

			if ( ! wp_verify_nonce( $nonce, 'my-nonce' ) ) {
				esc_html__( 'Security check', 'woo-currency' );
				exit();
			}
		}

		$what = strtolower( $what );
		switch ( $what ) {
			case 'get':
				return map_deep( wp_unslash( $_GET ), 'sanitize_text_field' );
			case 'post':
				return map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );
			case 'session':
				return map_deep( $_SESSION, 'sanitize_text_field' );
			case 'files':
				return self::sanitizeFiles( $_FILES );
			default:
				return null;
		}
	}

	/**
	 * sanitizeFiles.
	 *
	 * Sanitizes a $_FILES array: file names and MIME types are cleaned;
	 * tmp_name is server-generated and left as-is.
	 *
	 * @version 2.4.0
	 * @since   2.4.0
	 *
	 * @param array $files Raw $_FILES array.
	 *
	 * @return array
	 */
	private static function sanitizeFiles( $files ) {
		// Single file.
		if ( isset( $files['name'] ) && ! is_array( $files['name'] ) ) {
			return array(
				'name'     => isset( $files['name'] ) ? sanitize_file_name( $files['name'] ) : '',
				'type'     => isset( $files['type'] ) ? sanitize_mime_type( $files['type'] ) : '',
				'tmp_name' => isset( $files['tmp_name'] ) ? $files['tmp_name'] : '',
				'size'     => isset( $files['size'] ) ? absint( $files['size'] ) : 0,
				'error'    => isset( $files['error'] ) ? absint( $files['error'] ) : UPLOAD_ERR_NO_FILE,
			);
		}

		// Multi-file input.
		if ( isset( $files['name'] ) && is_array( $files['name'] ) ) {
			$sanitized = array();
			foreach ( array_keys( $files['name'] ) as $i ) {
				$sanitized['name'][ $i ]     = sanitize_file_name( $files['name'][ $i ] );
				$sanitized['type'][ $i ]     = sanitize_mime_type( $files['type'][ $i ] );
				$sanitized['tmp_name'][ $i ] = $files['tmp_name'][ $i ];
				$sanitized['size'][ $i ]     = absint( $files['size'][ $i ] );
				$sanitized['error'][ $i ]    = absint( $files['error'][ $i ] );
			}

			return $sanitized;
		}

		// Nested field groups.
		$sanitized = array();
		foreach ( $files as $key => $value ) {
			$sanitized[ $key ] = is_array( $value ) ? self::sanitizeFiles( $value ) : $value;
		}

		return $sanitized;
	}

	/**
	 * getMethod.
	 *
	 * @version @2.4.0
	 */
	static public function getMethod() {
		if ( ! self::$_requestMethod ) {
			$request_method       = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_key( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : 'GET';
			self::$_requestMethod = strtoupper( self::getVar( 'method', 'all', $request_method ) );
		}

		return self::$_requestMethod;
	}
    static public function getAdminPage() {
        $pagePath = self::getVar('page');
        if(!empty($pagePath) && strpos($pagePath, '/') !== false) {
            $pagePath = explode('/', $pagePath);
            return str_replace('.php', '', $pagePath[count($pagePath) - 1]);
        }
        return false;
    }

	/**
	 * getRequestUri.
	 *
	 * @version 2.4.0
	 */
    static public function getRequestUri() {
	    return isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
    }
    static public function getMode() {
        $mod = '';
        if(!($mod = self::getVar('mod')))  //Frontend usage
            $mod = self::getVar('page');     //Admin usage
        return $mod;
    }
}
