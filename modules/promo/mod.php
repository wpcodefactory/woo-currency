<?php
/**
 * WBW Currency Switcher for WooCommerce - promoWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class promoWcu extends moduleWcu {
	private $_mainLink = '';
	private $_minDataInStatToSend = 20;	// At least 20 points in table shuld be present before send stats
	private $_assetsUrl = '';
	public function __construct($d) {
		parent::__construct($d);
		$this->getMainLink();
		dispatcherWcu::addFilter('jsInitVariables', array($this, 'addMainOpts'));
	}
	public function init() {
		parent::init();

		add_action('admin_footer', array($this, 'displayAdminFooter'), 9);
		if(is_admin()) {
			add_action('init', array($this, 'checkWelcome'));
			//add_action('init', array($this, 'checkStatisticStatus'));
			add_action('admin_footer', array($this, 'checkPluginDeactivation'));
		}
		//$this->weLoveYou();
		dispatcherWcu::addFilter('mainAdminTabs', array($this, 'addAdminTab'));
		dispatcherWcu::addFilter('subDestList', array($this, 'addSubDestList'));
		dispatcherWcu::addAction('beforeSaveOpts', array($this, 'checkSaveOpts'));
		add_action('admin_notices', array($this, 'checkAdminPromoNotices'));
		// Admin tutorial
		//add_action('admin_enqueue_scripts', array( $this, 'loadTutorial'));
	}

	/**
	 * checkAdminPromoNotices.
	 *
	 * @version 2.4.0
	 */
	public function checkAdminPromoNotices() {
		if(!frameWcu::_()->isAdminPlugOptsPage())	// Our notices - only for our plugin pages for now
			return;
		$notices = array();
		// Start usage
		$startUsage = (int) frameWcu::_()->getModule('options')->get('start_usage');
		$currTime = time();
		$day = 24 * 3600;
		if($startUsage) {	// Already saved
			$rateMsg = sprintf(
				'<h3>%s</h3><p>%s</p>',
				sprintf(
					/* Translators: %s: Plugin Name. */
					__( 'Hey, I noticed you just use %s over a week – that’s awesome!', 'woo-currency' ),
					esc_html( WCU_WP_PLUGIN_NAME )
				),
				__( 'Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.', 'woo-currency' )
			);
			$rateMsg .= '<p><a href="#" target="_blank" class="button button-primary" data-statistic-code="done">'. __('Ok, you deserve it', 'woo-currency'). '</a>
			<a href="#" class="button" data-statistic-code="later">'. __('Nope, maybe later', 'woo-currency'). '</a>
			<a href="#" class="button" data-statistic-code="hide">'. __('I already did', 'woo-currency'). '</a></p>';

			$enbPromoLinkMsg = sprintf(
				'<h3>%s</h3>',
				sprintf(
					/* Translators: %s: Plugin Name. */
					__( 'More than eleven days with our %s plugin - Congratulations!', 'woo-currency' ),
					esc_html( WCU_WP_PLUGIN_NAME )
				)
			);
			$enbPromoLinkMsg .= sprintf(
				'<p>%s</p>',
				sprintf(
					/* Translators: %s: Link. */
					__(
						'On behalf of the entire %s company, I would like to thank you for being with us, and I really hope that our software has helped you. If you found it useful, please share your opinion by leaving a review.',
						'woo-currency'
					),
					'<a href="https://woobewoo.com/" target="_blank" rel="noopener noreferrer">woobewoo.com</a>'
				)
			);
			$enbPromoLinkMsg .= '<p><a href="https://wordpress.org/plugins/woo-currency/#reviews" class="button button-primary" data-statistic-code="done">'. __('Ok, you deserve it', 'woo-currency'). '</a>
			<a href="#" class="button" data-statistic-code="later">'. __('Nope, maybe later', 'woo-currency'). '</a>
			<a href="#" class="button" data-statistic-code="hide">'. __('Skip', 'woo-currency'). '</a></p>';

			$enbStatsMsg = sprintf(
				'<p>%s</p>',
				sprintf(
					/* Translators: %s: Link. */
					__(
						'You can help us improve our plugin by %s. We will collect only our plugin usage statistics data to understand your needs and make our solution better for you.',
						'woo-currency'
					),
					sprintf(
						/* Translators: %1$s: URL, %2$s: Text. */
						'<a href="%1$s" data-statistic-code="hide" class="button button-primary wcuEnbStatsAdBtn">%2$s</a>',
						esc_url( frameWcu::_()->getModule( 'options' )->getTabUrl( 'settings' ) ),
						esc_html__( 'enabling Usage Statistics', 'woo-currency' )
					)
				)
			);

			$notices = array(
				'rate_msg' => array('html' => $rateMsg, 'show_after' => 7 * $day),
				'enb_promo_link_msg' => array('html' => $enbPromoLinkMsg, 'show_after' => 11 * $day),
				'enb_stats_msg' => array('html' => $enbStatsMsg, 'show_after' => 5 * $day),
			);
			foreach($notices as $nKey => $n) {
				if($currTime - $startUsage <= $n['show_after']) {
					unset($notices[ $nKey ]);
					continue;
				}
				$done = (int) frameWcu::_()->getModule('options')->get('done_'. $nKey);
				if($done) {
					unset($notices[ $nKey ]);
					continue;
				}
				$hide = (int) frameWcu::_()->getModule('options')->get('hide_'. $nKey);
				if($hide) {
					unset($notices[ $nKey ]);
					continue;
				}
				$later = (int) frameWcu::_()->getModule('options')->get('later_'. $nKey);
				if($later && ($currTime - $later) <= 2 * $day) {	// remember each 2 days
					unset($notices[ $nKey ]);
					continue;
				}
				if($nKey == 'enb_promo_link_msg' && (int)frameWcu::_()->getModule('options')->get('add_love_link')) {
					unset($notices[ $nKey ]);
					continue;
				}
			}
		} else {
			frameWcu::_()->getModule('options')->getModel()->save('start_usage', $currTime);
		}
		if(!empty($notices)) {
			if(isset($notices['rate_msg']) && isset($notices['enb_promo_link_msg']) && !empty($notices['enb_promo_link_msg'])) {
				unset($notices['rate_msg']);	// Show only one from those messages
			}
			$html = '';
			foreach($notices as $nKey => $n) {
				$this->getModel()->saveUsageStat($nKey. '.'. 'show', true);
				$html .= '<div class="updated notice is-dismissible woobewoo-admin-notice" data-code="'. $nKey. '">'. $n['html']. '</div>';
			}
			htmlWcu::echo_escaped_html( $html );
		}
	}
	/**
	 * addAdminTab.
	 *
	 * @version 2.4.0
	 */
	public function addAdminTab($tabs) {
		$tabs['overview'] = array(
			'label' => __('Overview', 'woo-currency'), 'callback' => array($this, 'getOverviewTabContent'), 'fa_icon' => 'fa-info', 'sort_order' => 5,
		);
		return $tabs;
	}

	/**
	 * addSubDestList.
	 *
	 * @version 2.4.0
	 */
	public function addSubDestList($subDestList) {
		if(!$this->isPro()) {
			$subDestList = array_merge($subDestList, array(
				'constantcontact' => array('label' => __('Constant Contact - PRO', 'woo-currency'), 'require_confirm' => true),
				'campaignmonitor' => array('label' => __('Campaign Monitor - PRO', 'woo-currency'), 'require_confirm' => true),
				'verticalresponse' => array('label' => __('Vertical Response - PRO', 'woo-currency'), 'require_confirm' => true),
				'sendgrid' => array('label' => __('SendGrid - PRO', 'woo-currency'), 'require_confirm' => true),
				'get_response' => array('label' => __('GetResponse - PRO', 'woo-currency'), 'require_confirm' => true),
				'icontact' => array('label' => __('iContact - PRO', 'woo-currency'), 'require_confirm' => true),
				'activecampaign' => array('label' => __('Active Campaign - PRO', 'woo-currency'), 'require_confirm' => true),
				'mailrelay' => array('label' => __('Mailrelay - PRO', 'woo-currency'), 'require_confirm' => true),
				'arpreach' => array('label' => __('arpReach - PRO', 'woo-currency'), 'require_confirm' => true),
				'sgautorepondeur' => array('label' => __('SG Autorepondeur - PRO', 'woo-currency'), 'require_confirm' => true),
				'benchmarkemail' => array('label' => __('Benchmark - PRO', 'woo-currency'), 'require_confirm' => true),
				'infusionsoft' => array('label' => __('InfusionSoft - PRO', 'woo-currency'), 'require_confirm' => false),
				'salesforce' => array('label' => __('SalesForce - Web-to-Lead - PRO', 'woo-currency'), 'require_confirm' => false),
				'convertkit' => array('label' => __('ConvertKit - PRO', 'woo-currency'), 'require_confirm' => false),
				'myemma' => array('label' => __('Emma - PRO', 'woo-currency'), 'require_confirm' => false),
				'sendinblue' => array('label' => __('SendinBlue - PRO', 'woo-currency'), 'require_confirm' => false),
				'vision6' => array('label' => __('Vision6 - PRO', 'woo-currency'), 'require_confirm' => false),
				'vtiger' => array('label' => __('Vtiger - PRO', 'woo-currency'), 'require_confirm' => false),
				'ymlp' => array('label' => __('Your Mailing List Provider (Ymlp) - PRO', 'woo-currency'), 'require_confirm' => false),
				'fourdem' => array('label' => __('4Dem.it - PRO', 'woo-currency'), 'require_confirm' => false),
				'dotmailer' => array('label' => __('Dotmailer - PRO', 'woo-currency'), 'require_confirm' => false),
			));
		}
		return $subDestList;
	}
	public function getOverviewTabContent() {
		return $this->getView()->getOverviewTabContent();
	}
	public function displayAdminFooter() {
		if(frameWcu::_()->isAdminPlugPage()) {
			$this->getView()->displayAdminFooter();
		}
	}
	private function _preparePromoLink($link, $ref = '') {
		if(empty($ref))
			$ref = 'user';
		return $link;
	}
	public function weLoveYou() {
		//
	}
	/**
	 * Public shell for private method
	 */
	public function preparePromoLink($link, $ref = '') {
		return $this->_preparePromoLink($link, $ref);
	}
	public function checkStatisticStatus(){
		// Not used for now - using big data methods
		/*$canSend = (int) frameWcu::_()->getModule('options')->get('send_stats');
		if($canSend && frameWcu::_()->getModule('user')->isAdmin()) {
			// Before this version we had many wrong data collected taht we don't need at all. Let's clear them.
			if(WCU_VERSION == '1.3.5') {
				$clearedTrashStatData = (int) get_option(WCU_DB_PREF. 'cleared_trash_stat_data');
				if(!$clearedTrashStatData) {
					$this->getModel()->clearUsageStat();
					update_option(WCU_DB_PREF. 'cleared_trash_stat_data', 1);
					return;	// We just cleared whole data - so don't need to even check send stats
				}
			}
			$this->getModel()->checkAndSend();
		}*/
	}
	public function getMinStatSend() {
		return $this->_minDataInStatToSend;
	}
	public function getMainLink() {
		if(empty($this->_mainLink)) {
			$affiliateQueryString = '';
			$this->_mainLink = 'https://woobewoo.com/plugins/woo-currency/' . $affiliateQueryString;
		}
		return $this->_mainLink ;
	}
	public function generateMainLink($params = '') {
		$mainLink = $this->getMainLink();
		if(!empty($params)) {
			return $mainLink. (strpos($mainLink , '?') ? '&' : '?'). $params;
		}
		return $mainLink;
	}

	/**
	 * getContactFormFields.
	 *
	 * @version 2.4.0
	 */
	public function getContactFormFields() {
		$fields = array(
            'name' => array('label' => __('Name', 'woo-currency'), 'valid' => 'notEmpty', 'html' => 'text'),
			'email' => array('label' => __('Email', 'woo-currency'), 'html' => 'email', 'valid' => array('notEmpty', 'email'), 'placeholder' => 'example@mail.com', 'def' => get_bloginfo('admin_email')),
			'website' => array('label' => __('Website', 'woo-currency'), 'html' => 'text', 'placeholder' => 'http://example.com', 'def' => get_bloginfo('url')),
			'subject' => array('label' => __('Subject', 'woo-currency'), 'valid' => 'notEmpty', 'html' => 'text'),
            'category' => array('label' => __('Topic', 'woo-currency'), 'valid' => 'notEmpty', 'html' => 'selectbox', 'options' => array(
				'plugins_options' => __('Plugin options', 'woo-currency'),
				'bug' => __('Report a bug', 'woo-currency'),
				'functionality_request' => __('Require a new functionality', 'woo-currency'),
				'other' => __('Other', 'woo-currency'),
			)),
			'message' => array('label' => __('Message', 'woo-currency'), 'valid' => 'notEmpty', 'html' => 'textarea', 'placeholder' => __('Hello!', 'woo-currency')),
        );
		foreach($fields as $k => $v) {
			if(isset($fields[ $k ]['valid']) && !is_array($fields[ $k ]['valid']))
				$fields[ $k ]['valid'] = array( $fields[ $k ]['valid'] );
		}
		return $fields;
	}
	public function isPro() {
		static $isPro;
		if(is_null($isPro)) {
			// license is always active with PRO - even if license key was not entered,
			// add_options module was from the begining of the times in PRO, and will be active only once user will activate license on site
			$isPro = frameWcu::_()->getModule('license') && frameWcu::_()->getModule('on_exit');
		}
		return $isPro;
	}
	public function checkWelcome() {
		$from = reqWcu::getVar('from', 'get');
		$pl = reqWcu::getVar('pl', 'get');
		if($from == 'welcome-page' && $pl == WCU_CODE && frameWcu::_()->getModule('user')->isAdmin()) {
			$welcomeSent = (int) get_option(WCU_DB_PREF. 'welcome_sent');
			if(!$welcomeSent) {
				$this->getModel()->welcomePageSaveInfo();
				update_option(WCU_DB_PREF. 'welcome_sent', 1);
			}
			$skipTutorial = (int) reqWcu::getVar('skip_tutorial', 'get');
			if($skipTutorial) {
				$tourHst = $this->getModel()->getTourHst();
				$tourHst['closed'] = 1;
				$this->getModel()->setTourHst( $tourHst );
			}
		}
	}
	public function getContactLink() {
		return $this->getMainLink(). '#contact';
	}
	public function addMainOpts($opts) {
		$title = 'WordPress WooCurrency Plugin';
		$opts['options']['love_link_html'] = '<a title="'. $title. '" style="color: #26bfc1 !important; font-size: 9px; position: absolute; bottom: 15px; right: 15px;" href="'. $this->generateMainLink('utm_source=plugin&utm_medium=love_link&utm_campaign=woocurrency'). '" target="_blank">'
			. $title
			. '</a>';
		return $opts;
	}
	public function checkSaveOpts($newValues) {
		$loveLinkEnb = (int) frameWcu::_()->getModule('options')->get('add_love_link');
		$loveLinkEnbNew = isset($newValues['opt_values']['add_love_link']) ? (int) $newValues['opt_values']['add_love_link'] : 0;
		if($loveLinkEnb != $loveLinkEnbNew) {
			$this->getModel()->saveUsageStat('love_link.'. ($loveLinkEnbNew ? 'enb' : 'dslb'));
		}
	}
	public function loadTutorial() {
		// Don't run on WP < 3.3
		if ( get_bloginfo( 'version' ) < '3.3' )
			return;

		if ( is_admin() && current_user_can(frameWcu::_()->getModule('adminmenu')->getMainCap()) ) {
			$this->checkToShowTutorial();
        }
	}
	public function checkToShowTutorial() {
		if(reqWcu::getVar('tour', 'get') == 'clear-hst') {
			$this->getModel()->clearTourHst();
		}
		$hst = $this->getModel()->getTourHst();
		if((isset($hst['closed']) && $hst['closed'])
			|| (isset($hst['finished']) && $hst['finished'])
		) {
			return;
		}
		$tourData = array();
		$tourData['tour'] = array(
			'welcome' => array(
				'points' => array(
					'first_welcome' => array(
						'target' => '#toplevel_page_woo-currency',
						'options' => array(
							'position' => array(
								'edge' => 'bottom',
								'align' => 'top',
							),
						),
						'show' => 'not_plugin',
					),
				),
			),
		);
		$isAdminPage = frameWcu::_()->isAdminPlugOptsPage();
		$activeTab = frameWcu::_()->getModule('options')->getActiveTab();
		foreach($tourData['tour'] as $stepId => $step) {
			foreach($step['points'] as $pointId => $point) {
				$pointKey = $stepId. '-'. $pointId;
				if(isset($hst['passed'][ $pointKey ]) && $hst['passed'][ $pointKey ]) {
					unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
					continue;
				}
				$show = isset($point['show']) ? $point['show'] : 'plugin';
				if(!is_array($show))
					$show = array( $show );
				if((in_array('plugin', $show) && !$isAdminPage) || (in_array('not_plugin', $show) && $isAdminPage)) {
					unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
					continue;
				}
				$showForTabs = false;
				$hideForTabs = false;
				foreach($show as $s) {
					if(strpos($s, 'tab_') === 0) {
						$showForTabs = true;
					}
					if(strpos($s, 'tab_not_') === 0) {
						$showForTabs = true;
					}
				}
				if($showForTabs && (!in_array('tab_'. $activeTab, $show) || !$isAdminPage)) {
					unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
					continue;
				}
				if($hideForTabs && (in_array('tab_not_'. $activeTab, $show) || !$isAdminPage)) {
					unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
					continue;
				}
			}
		}
		foreach($tourData['tour'] as $stepId => $step) {
			if(!isset($step['points']) || empty($step['points'])) {
				unset($tourData['tour'][ $stepId ]);
			}
		}
		if(empty($tourData['tour']))
			return;
		$tourData['html'] = $this->getView()->getTourHtml();
		frameWcu::_()->getModule('templates')->loadCoreJs();
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'wp-pointer' );
		frameWcu::_()->addScript(WCU_CODE. 'admin.tour', $this->getModPath(). 'js/admin.tour.js');
		frameWcu::_()->addJSVar(WCU_CODE. 'admin.tour', 'wcuAdminTourData', $tourData);
	}
	public function getContactFormPlgUrl() {
		return 'http://wordpress.org/support/plugin/contact-form-by-woobewoo';
	}

	/**
	 * checkPluginDeactivation.
	 *
	 * @version 2.4.0
	 */
	public function checkPluginDeactivation() {
		if(function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if($screen && isset($screen->base) && $screen->base == 'plugins') {
				frameWcu::_()->getModule('templates')->loadCoreJs();
				frameWcu::_()->getModule('templates')->loadCoreCss();
				wp_enqueue_style('wp-jquery-ui-dialog');
				frameWcu::_()->addScript( 'jquery-ui-dialog' );
				frameWcu::_()->addScript(WCU_CODE. '.admin.plugins', $this->getModPath(). 'js/admin.plugins.js');
				frameWcu::_()->addJSVar(WCU_CODE. '.admin.plugins', 'wcuPluginsData', array(
					'plugName' => WCU_PLUG_NAME. '/'. WCU_MAIN_FILE,
				));
				htmlWcu::echo_escaped_html( $this->getView()->getPluginDeactivation() );
			}
		}
	}
	public function getProOptions($returnBool = false) {
		$proModule = frameWcu::_()->getModule('options_pro');
		if ($returnBool) {
			$proModule = isset($proModule) ? true : false;
		}
		return $proModule;
	}


}
