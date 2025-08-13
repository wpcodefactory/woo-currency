<?php
/**
 * WBW Currency Switcher for WooCommerce - viewWcu Class
 *
 * @author  woobewoo
 */

defined( 'ABSPATH' ) || exit;

abstract class viewWcu extends baseObjectWcu {

	/**
	 * @deprecated
	 */
	protected $_tpl = WCU_DEFAULT;

	/**
	 * @var string name of theme to load from templates, if empty - default values will be used
	 */
	protected $_theme = '';

	/**
	 * @var string module code for this view
	 */
	protected $_code = '';

	/**
	 * display.
	 */
	public function display($tpl = '') {
		$tpl = (empty($tpl)) ? $this->_tpl : $tpl;

		if(($content = $this->getContent($tpl)) !== false) {
			echo $content;
		}
	}

	/**
	 * getPath.
	 */
	public function getPath($tpl) {
		$path = '';
		$parentModule = frameWcu::_()->getModule( $this->_code );
		if(file_exists($parentModule->getModDir(). 'views'. DS. 'tpl'. DS. $tpl. '.php')) { //Then try to find it in module directory
			$path = $parentModule->getModDir(). DS. 'views'. DS. 'tpl'. DS. $tpl. '.php';
		}
		return $path;
	}

	/**
	 * getModule.
	 */
	public function getModule() {
		return frameWcu::_()->getModule( $this->_code );
	}

	/**
	 * getModel.
	 */
	public function getModel($code = '') {
		return frameWcu::_()->getModule( $this->_code )->getController()->getModel($code);
	}

	/**
	 * getContent.
	 */
	public function getContent($tpl = '') {
		$tpl = (empty($tpl)) ? $this->_tpl : $tpl;
		$path = $this->getPath($tpl);
		if($path) {
			$content = '';
			ob_start();
			require($path);
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
		return false;
	}

	/**
	 * setTheme.
	 */
	public function setTheme($theme) {
		$this->_theme = $theme;
	}

	/**
	 * getTheme.
	 */
	public function getTheme() {
		return $this->_theme;
	}

	/**
	 * setTpl.
	 */
	public function setTpl($tpl) {
		$this->_tpl = $tpl;
	}

	/**
	 * getTpl.
	 */
	public function getTpl() {
		return $this->_tpl;
	}

	/**
	 * init.
	 */
	public function init() {

	}

	/**
	 * assign.
	 */
	public function assign($name, $value) {
		$this->$name = $value;
	}

	/**
	 * setCode.
	 */
	public function setCode($code) {
		$this->_code = $code;
	}

	/**
	 * getCode.
	 */
	public function getCode() {
		return $this->_code;
	}

	/**
	 * This will display form for our widgets.
	 */
	public function displayWidgetForm($data = array(), $widget = array(), $formTpl = 'form') {
		$this->assign('data', $data);
		$this->assign('widget', $widget);
		if(frameWcu::_()->isTplEditor()) {
			if($this->getPath($formTpl. '_ext')) {
				$formTpl .= '_ext';
			}
		}
		self::display($formTpl);
	}

	/**
	 * sizeToPxPt.
	 */
	public function sizeToPxPt($size) {
		if(!strpos($size, 'px') && !strpos($size, '%'))
			$size .= 'px';
		return $size;
	}

	/**
	 * getInlineContent.
	 */
	public function getInlineContent($tpl = '') {
		return preg_replace('/\s+/', ' ', $this->getContent($tpl));
	}

}
