<?php
/**
 * WBW Currency Switcher for WooCommerce - promoViewWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class promoViewWcu extends viewWcu { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound

	/**
	 * pluginSlug.
	 *
	 * @version 2.2.0
	 * @since   2.2.0
	 */
	public $pluginSlug;

	/**
	 * mainLink.
	 *
	 * @version 2.2.0
	 * @since   2.2.0
	 */
	public $mainLink;

	/**
	 * faqList.
	 *
	 * @version 2.2.0
	 * @since   2.2.0
	 */
	public $faqList;

	/**
	 * serverSettings.
	 *
	 * @version 2.2.0
	 * @since   2.2.0
	 */
	public $serverSettings;

	/**
	 * news.
	 *
	 * @version 2.2.0
	 * @since   2.2.0
	 */
	public $news;

	/**
	 * contactFields.
	 *
	 * @version 2.2.0
	 * @since   2.2.0
	 */
	public $contactFields;

	/**
	 * displayAdminFooter.
	 */
	public function displayAdminFooter() {
		$this->assign('pluginSlug', frameWcu::_()->getModule('adminmenu')->getMainSlug());
		parent::display('adminFooter');
	}

	/**
	 * getOverviewTabContent.
	 */
	public function getOverviewTabContent() {
		frameWcu::_()->getModule('templates')->loadJqueryUi();
		frameWcu::_()->getModule('templates')->loadSlimscroll();
		frameWcu::_()->addScript('admin.overview', $this->getModule()->getModPath(). 'js/admin.overview.js');
		frameWcu::_()->addStyle('admin.overview', $this->getModule()->getModPath(). 'css/admin.overview.css');
		$this->assign('mainLink', $this->getModule()->getMainLink());
		$this->assign('faqList', $this->getFaqList());
		$this->assign('serverSettings', $this->getServerSettings());
		$this->assign('news', $this->getNewsContent());
		$this->assign('contactFields', $this->getModule()->getContactFormFields());
		return parent::getContent('overviewTabContent');
	}

	/**
	 * getFaqList.
	 */
	public function getFaqList() {
		return array();
	}

	/**
	 * getMostFaqList.
	 */
	public function getMostFaqList() {
		return array();
	}

	/**
	 * getNewsContent.
	 */
	public function getNewsContent() {
		return '';
	}

	/**
	 * getServerSettings.
	 *
	 * @verson 2.4.0
	 */
	public function getServerSettings() {
		global $wpdb;
		$server_software = isset( $_SERVER['SERVER_SOFTWARE'] ) ?
			sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) :
			'';
		return array(
			'Operating System' => array('value' => PHP_OS),
			'PHP Version' => array('value' => PHP_VERSION),
			'Server Software' => array('value' => $server_software),
			'MySQL' => array('value' =>  $wpdb->db_version()),
			'PHP Allow URL Fopen' => array('value' => ini_get('allow_url_fopen') ? __('Yes', 'woo-currency') : __('No', 'woo-currency')),
			'PHP Memory Limit' => array('value' => ini_get('memory_limit')),
			'PHP Max Post Size' => array('value' => ini_get('post_max_size')),
			'PHP Max Upload Filesize' => array('value' => ini_get('upload_max_filesize')),
			'PHP Max Script Execute Time' => array('value' => ini_get('max_execution_time')),
			'PHP EXIF Support' => array('value' => extension_loaded('exif') ? __('Yes', 'woo-currency') : __('No', 'woo-currency')),
			'PHP EXIF Version' => array('value' => phpversion('exif')),
			'PHP XML Support' => array('value' => extension_loaded('libxml') ? __('Yes', 'woo-currency') : __('No', 'woo-currency'), 'error' => !extension_loaded('libxml')),
			'PHP CURL Support' => array('value' => extension_loaded('curl') ? __('Yes', 'woo-currency') : __('No', 'woo-currency'), 'error' => !extension_loaded('curl')),
		);
	}

	/**
	 * _makeWelcomeLink.
	 */
	private function _makeWelcomeLink($link) {
		return uriWcu::_(array('baseUrl' => $link, 'from' => 'welcome-page', 'pl' => WCU_CODE));
	}

	/**
	 * getTourHtml.
	 */
	public function getTourHtml() {
		$this->assign('contactFormLink', $this->getModule()->getContactLink());
		$this->assign('finishSiteLink', $this->getModule()->generateMainLink('utm_source=plugin&utm_medium=final_step_b_step&utm_campaign=woocurrency'));
		return parent::getContent('adminTour');
	}

	/**
	 * getPluginDeactivation.
	 */
	public function getPluginDeactivation() {
		return parent::getContent('pluginDeactivation');
	}

}
