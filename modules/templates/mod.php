<?php
/**
 * WBW Currency Switcher for WooCommerce - templatesWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class templatesWcu extends moduleWcu {
    protected $_styles = array();

	/**
	 * init.
	 *
	 * @version 2.4.0
	 */
    public function init() {
        if (is_admin()) {
			if($isAdminPlugOptsPage = frameWcu::_()->isAdminPlugOptsPage()) {
				$this->loadCoreJs();
				$this->loadAdminCoreJs();
				$this->loadCoreCss();
				$this->load_selectwoo();
				frameWcu::_()->addScript('adminOptionsWcu', WCU_JS_PATH. 'admin.options.js', array(), false, true);
				add_action('admin_enqueue_scripts', array($this, 'loadMediaScripts'));
				add_action('init', array($this, 'connectAdditionalAdminAssets'));
				// Some common styles - that need to be on all admin pages - be careful with them
				frameWcu::_()->addStyle('woobewoo-for-all-admin-'. WCU_CODE, WCU_CSS_PATH. 'woobewoo-for-all-admin.css');
			}
	        frameWcu::_()->addScript('adminStartWcu', WCU_JS_PATH. 'admin.wcu.start.js', array(), false, true);
		}
        parent::init();
    }
	public function connectAdditionalAdminAssets() {
		if(is_rtl()) {
			frameWcu::_()->addStyle('styleWcu-rtl', WCU_CSS_PATH. 'style-rtl.css');
		}
	}
	public function loadMediaScripts() {
		if(function_exists('wp_enqueue_media')) {
			wp_enqueue_media();
		}
	}
	public function loadAdminCoreJs() {
		frameWcu::_()->addScript('jquery-ui-dialog');
		frameWcu::_()->addScript('jquery-ui-slider');
		frameWcu::_()->addScript('wp-color-picker');
		frameWcu::_()->addScript('icheck', WCU_JS_PATH. 'icheck.min.js');
		$this->loadTooltipster();
	}
	public function loadCoreJs() {
		static $loaded = false;
		if(!$loaded) {
			frameWcu::_()->addScript('jquery');
			$suf = WCU_MINIFY_ASSETS ? '.min' : '';
			frameWcu::_()->addScript('commonWcu', WCU_JS_PATH. 'common'. $suf. '.js');
			frameWcu::_()->addScript('coreWcu', WCU_JS_PATH. 'core'. $suf. '.js');

			$ajaxurl = admin_url('admin-ajax.php');
			$jsData = array(
				'siteUrl'					=> WCU_SITE_URL,
				'imgPath'					=> WCU_IMG_PATH,
				'cssPath'					=> WCU_CSS_PATH,
				'loader'					=> WCU_LOADER_IMG,
				'close'						=> WCU_IMG_PATH. 'cross.gif',
				'ajaxurl'					=> $ajaxurl,
				'options'					=> frameWcu::_()->getModule('options')->getAllowedPublicOptions(),
				'WCU_CODE'					=> WCU_CODE,
				//'ball_loader'				=> WCU_IMG_PATH. 'ajax-loader-ball.gif',
				//'ok_icon'					=> WCU_IMG_PATH. 'ok-icon.png',
				'jsPath'					=> WCU_JS_PATH,
			);
			if(is_admin()) {
				$jsData['isPro'] = frameWcu::_()->getModule('promo')->isPro();
				$jsData['mainLink'] = frameWcu::_()->getModule('promo')->getMainLink();
				$jsData['isPreview'] = true;
			}
			$jsData = dispatcherWcu::applyFilters('jsInitVariables', $jsData);
			frameWcu::_()->addJSVar('coreWcu', 'WCU_DATA', $jsData);
			$loaded = true;
		}
	}
	public function loadTooltipster() {
		frameWcu::_()->addScript('tooltipster', FrameWcu::_()->getModule('templates')->getModPath(). 'lib/tooltipster/jquery.tooltipster.min.js');
		frameWcu::_()->addStyle('tooltipster', FrameWcu::_()->getModule('templates')->getModPath(). 'lib/tooltipster/tooltipster.css');
	}
	public function loadSlimscroll() {
		frameWcu::_()->addScript('jquery.slimscroll', WCU_JS_PATH. 'slimscroll.min.js');
	}

	public function loadCoreCss() {
		$this->_styles = array(
			'styleWcu'			=> array('path' => WCU_CSS_PATH. 'style.css', 'for' => 'admin'),
			'woobewoo-uiWcu'	=> array('path' => WCU_CSS_PATH. 'woobewoo-ui.css', 'for' => 'admin'),
			'dashicons'			=> array('for' => 'admin'),
			'bootstrap-alerts'	=> array('path' => WCU_CSS_PATH. 'bootstrap-alerts.css', 'for' => 'admin'),
			'icheck'			=> array('path' => WCU_CSS_PATH. 'jquery.icheck.css', 'for' => 'admin'),
			//'uniform'			=> array('path' => WCU_CSS_PATH. 'uniform.default.css', 'for' => 'admin'),
			'wp-color-picker'	=> array('for' => 'admin'),
		);
		foreach($this->_styles as $s => $sInfo) {
			if(!empty($sInfo['path'])) {
				frameWcu::_()->addStyle($s, $sInfo['path']);
			} else {
				frameWcu::_()->addStyle($s);
			}
		}
		$this->loadFontAwesome();
	}
	public function loadJqueryUi() {
		static $loaded = false;
		if(!$loaded) {
			frameWcu::_()->addStyle('jquery-ui', WCU_CSS_PATH. 'jquery-ui.min.css');
			frameWcu::_()->addStyle('jquery-ui.structure', WCU_CSS_PATH. 'jquery-ui.structure.min.css');
			frameWcu::_()->addStyle('jquery-ui.theme', WCU_CSS_PATH. 'jquery-ui.theme.min.css');
			frameWcu::_()->addStyle('jquery-slider', WCU_CSS_PATH. 'jquery-slider.css');
			$loaded = true;
		}
	}
	public function loadJqGrid() {
		static $loaded = false;
		if(!$loaded) {
			$this->loadJqueryUi();
			frameWcu::_()->addScript('jq-grid', FrameWcu::_()->getModule('templates')->getModPath(). 'lib/jqgrid/jquery.jqGrid.min.js');
			frameWcu::_()->addStyle('jq-grid', FrameWcu::_()->getModule('templates')->getModPath(). 'lib/jqgrid/ui.jqgrid.css');
			$langToLoad = utilsWcu::getLangCode2Letter();
			$availableLocales = array('ar','bg','bg1251','cat','cn','cs','da','de','dk','el','en','es','fa','fi','fr','gl','he','hr','hr1250','hu','id','is','it','ja','kr','lt','mne','nl','no','pl','pt','pt','ro','ru','sk','sr','sr','sv','th','tr','tw','ua','vi');
			if(!in_array($langToLoad, $availableLocales)) {
				$langToLoad = 'en';
			}
			frameWcu::_()->addScript('jq-grid-lang', FrameWcu::_()->getModule('templates')->getModPath(). 'lib/jqgrid/i18n/grid.locale-'. $langToLoad. '.js');
			$loaded = true;
		}
	}
	public function loadFontAwesome() {
		frameWcu::_()->addStyle('font-awesomeWcu', FrameWcu::_()->getModule('templates')->getModPath(). 'css/font-awesome.min.css');
	}

	/**
	 * load_selectwoo.
	 *
	 * @version 2.4.0
	 * @since   2.4.0
	 */
	public function load_selectwoo() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		wp_enqueue_script( 'selectWoo' );
		wp_enqueue_style( 'select2' );
	}
	public function loadDatePicker() {
		frameWcu::_()->addScript('jquery-ui-datepicker');
	}
	public function loadJqplot() {
		static $loaded = false;
		if(!$loaded) {
			$jqplotDir = FrameWcu::_()->getModule('templates')->getModPath(). 'lib/jqplot/';

			frameWcu::_()->addStyle('jquery.jqplot', $jqplotDir. 'jquery.jqplot.min.css');

			frameWcu::_()->addScript('jplot', $jqplotDir. 'jquery.jqplot.min.js');
			frameWcu::_()->addScript('jqplot.canvasAxisLabelRenderer', $jqplotDir. 'jqplot.canvasAxisLabelRenderer.min.js');
			frameWcu::_()->addScript('jqplot.canvasTextRenderer', $jqplotDir. 'jqplot.canvasTextRenderer.min.js');
			frameWcu::_()->addScript('jqplot.dateAxisRenderer', $jqplotDir. 'jqplot.dateAxisRenderer.min.js');
			frameWcu::_()->addScript('jqplot.canvasAxisTickRenderer', $jqplotDir. 'jqplot.canvasAxisTickRenderer.min.js');
			frameWcu::_()->addScript('jqplot.highlighter', $jqplotDir. 'jqplot.highlighter.min.js');
			frameWcu::_()->addScript('jqplot.cursor', $jqplotDir. 'jqplot.cursor.min.js');
			frameWcu::_()->addScript('jqplot.barRenderer', $jqplotDir. 'jqplot.barRenderer.min.js');
			frameWcu::_()->addScript('jqplot.categoryAxisRenderer', $jqplotDir. 'jqplot.categoryAxisRenderer.min.js');
			frameWcu::_()->addScript('jqplot.pointLabels', $jqplotDir. 'jqplot.pointLabels.min.js');
			frameWcu::_()->addScript('jqplot.pieRenderer', $jqplotDir. 'jqplot.pieRenderer.min.js');
			$loaded = true;
		}
	}
	public function loadSortable() {
		static $loaded = false;
		if(!$loaded) {
			frameWcu::_()->addScript('jquery-ui-core');
			frameWcu::_()->addScript('jquery-ui-widget');
			frameWcu::_()->addScript('jquery-ui-mouse');

			frameWcu::_()->addScript('jquery-ui-draggable');
			frameWcu::_()->addScript('jquery-ui-sortable');
			$loaded = true;
		}
	}
	public function loadMagicAnims() {
		static $loaded = false;
		if(!$loaded) {
			frameWcu::_()->addStyle('magic.anim', FrameWcu::_()->getModule('templates')->getModPath(). 'css/magic.min.css');
			$loaded = true;
		}
	}
	public function loadBootstrapSimple() {
		static $loaded = false;
		if(!$loaded) {
			frameWcu::_()->addStyle('bootstrap-simple', WCU_CSS_PATH. 'bootstrap-simple.css');
			$loaded = true;
		}
	}
}
