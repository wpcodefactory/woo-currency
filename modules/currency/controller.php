<?php
/**
 * WBW Currency Switcher for WooCommerce - currencyControllerWcu Class
 *
 * @version 2.2.6
 *
 * @author  woobewoo
 */

defined( 'ABSPATH' ) || exit;

class currencyControllerWcu extends controllerWcu {

	/**
	 * saveCurrencyTab.
	 *
	 * @version 2.2.6
	 */
	public function saveCurrencyTab() {
		if (!current_user_can(frameWcu::_()->getModule('adminmenu')->getMainCap())) {
			wp_send_json_error(__('You are not allowed to perform this action.', 'woo-currency'));
		}
		check_ajax_referer('wbw_currency_nonce', '_wbw_currency_nonce');

		$res = new responseWcu();
		$module = $this->getModule();
		$currencies = reqWcu::getVar($module->currencyDbOpt);
		$options = reqWcu::getVar($module->optionsDbOpt);

		$this->getModel()->saveCurrencies($currencies);

		$customSymbolsModule = frameWcu::_()->getModule('custom_symbols');
		if ($customSymbolsModule) {
			$currenciesSymbols = reqWcu::getVar($customSymbolsModule->currencyDbOptSymbols);
			$customSymbolsModule->getModel('custom_symbols')->saveCurrenciesSymbols($currenciesSymbols);
		}

		$optionsProModule = frameWcu::_()->getModule('options_pro');
		if ($optionsProModule) {
			$optionsPro = reqWcu::getVar($module->optionsDbOptPro);
			$optionsProModule->getModel()->saveOptionsProParams($optionsPro);
		}

		$this->getModel()->saveOptions($options);

		$updateRates = frameWcu::_()->getModule('update_rates');
		$module->getModel()::$savedCurrencies = null;

		return $res->ajaxExec();
	}

	/**
	 * saveCurrenciesList.
	 */
	public function saveCurrenciesList() {
		$res = new responseWcu();

		parse_str(reqWcu::getVar('currencies', 'all', ''), $currencies);

		$this->getModel()->saveCurrencies($currencies[$this->getModule()->currencyDbOpt]);

		return $res->ajaxExec();
	}

	/**
	 * getCurrencyRate.
	 */
	public function getCurrencyRate() {

		$res = new responseWcu();
		$fromCurrency = reqWcu::getVar('default_currency');
		$toCurrency = reqWcu::getVar('currency_name');
		$rate = $this->getModel()->getCurrencyRate($fromCurrency, $toCurrency);

		if ($rate) {
			$res->addMessage(__('Done', WCU_LANG_CODE));
			$res->addData('rate', $rate);
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}

	/**
	 * getPermissions.
	 */
	public function getPermissions() {
		return array(
			WCU_USERLEVELS => array(
				WCU_ADMIN => array()
			),
		);
	}

}
