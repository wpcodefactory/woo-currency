<?php
/**
 * WBW Currency Switcher for WooCommerce - csvgeneratorWcu Class
 *
 * @author woobewoo
 *
 * @package WooBeWoo\WC_Currency_Switcher\Classes
 */

defined( 'ABSPATH' ) || exit;

class csvgeneratorWcu { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
    protected $_filename = '';
    protected $_delimiter = ';';
    protected $_enclosure = "\n";
    protected $_data = array();
	protected $_escape = '\\';
    public function __construct($filename) {
        $this->_filename = $filename;
    }
    public function addCell($x, $y, $value) {
        $this->_data[ $x ][ $y ] = '"'. $value. '"';    //If will not do "" then wymbol for example , will broke file
    }
    public function generate() {
        $strData = '';
        if(!empty($this->_data)) {
            $rows = array();
            foreach($this->_data as $cells) {
                $rows[] = implode($this->_delimiter, $cells);
            }
            $strData = implode($this->_enclosure, $rows);
        }
        filegeneratorWcu::_($this->_filename, $strData, 'csv')->generate();
    }
	public function getDelimiter() {
		return $this->_delimiter;
	}
	public function getEnclosure() {
		return $this->_enclosure;
	}
	public function getEscape() {
		return $this->_escape;
	}
}

