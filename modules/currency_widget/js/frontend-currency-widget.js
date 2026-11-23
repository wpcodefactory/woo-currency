/**
 * WBW Currency Switcher for WooCommerce - Frontend Currency Widget JS
 *
 * @version 2.4.0
 * @since   2.4.0
 *
 * @author woobewoo
 */
jQuery(document).ready(function ($) {
	$(".wcuCurrencyRatesWidget").each(function () {
		var shell = $(this);
		var select = shell.find('[name="wcu_currency_item"]');
		var list = shell.find(".wcuCurrencyRatesList tr");

		if (!select.length) {
			return;
		}

		// Initialize flag dropdown.
		if (
			typeof $.fn.msDropDown === "function" &&
			select.hasClass("wcuFlagsSelectBoxDropdown")
		) {
			select.msDropDown();
		}

		select.on("change", function () {
			var current = $(this).val();

			list.find(".wcuCurrencyRateVal").text("Loading...");
			$.sendFormWcu({
				data: {
					mod: "currency_widget",
					action: "woobewoo_cs_get_currency_rates_list",
					current: current,
					exclude: shell.data("exclude"),
				},
				onSuccess: function (res) {
					if (!res.error) {
						list.each(function () {
							var self = $(this);
							var currency = self.data("currency");

							if (currency == current) {
								self.hide();
							} else {
								self.show();
							}

							self
								.find(".wcuCurrencyRateVal")
								.html(res.data.rates[currency] || "");
						});
					}
				},
			});
		});

		// Load rates on initialization.
		select.trigger("change");
	});
});

jQuery(document).ready(function ($) {
	$(".wcuCurrencyConverterWidget").each(function () {
		var widget = $(this);
		var shell = widget.find(".wcuCurrencyConverterShell");

		// Initialize flag dropdowns.
		if (typeof $.fn.msDropDown === "function") {
			widget.find(".wcuFlagsSelectBoxDropdown").each(function () {
				var select = $(this);

				if (!select.data("dd")) {
					select.msDropDown();
				}
			});
		}

		// Set default destination currency.
		var currencyTo = widget.find('select[name="currency_to"]');
		if (currencyTo.length && currencyTo.find("option").length > 1) {
			currencyTo.prop("selectedIndex", 1);

			var handler = currencyTo.data("dd");
			if (handler) {
				handler.set("selectedIndex", 1);
			}
		}
	});

	// Exchange currencies / values.
	$(document).on(
		"click",
		".wcuCurrencyConverterWidget .wcuExchangeIcon",
		function () {
			var button = $(this);
			var widget = button.closest(".wcuCurrencyConverterWidget");

			button.toggleClass("wcuRotateAnimation");

			if (button.hasClass("wcuExchangeIconHorizontal")) {
				var from = widget.find('[name="amount"]');
				var to = widget.find('[name="result"]');

				from.attr("name", "result");
				to.attr("name", "amount");
			} else {
				var from = widget.find('[name="currency_from"]');
				var to = widget.find('[name="currency_to"]');

				from.attr("name", "currency_to");
				to.attr("name", "currency_from");
			}
		},
	);

	// Convert currency.
	$(document).on("click", ".wcuCurrencyConvertBtn", function (e) {
		e.preventDefault();

		var button = $(this);
		var shell = button.closest(".wcuCurrencyConverterShell");
		$.sendFormWcu({
			data: {
				mod: "currency_widget",
				action: "getCurrencyRate",
				amount: shell.find('input[name="amount"]').val(),
				currency_from: shell.find('[name="currency_from"]').val(),
				currency_to: shell.find('[name="currency_to"]').val(),
			},
			onSuccess: function (res) {
				if (!res.error) {
					shell.find('[name="result"]').val(res.data.result);
				}
			},
		});
	});
});

jQuery(document).ready(function ($) {
	var wcuGlobalFlagsDD = window.wcuGlobalFlagsDD || 0;
	window.wcuDDList = window.wcuDDList || {};

	// Initialize each currency switcher widget.
	$(".wcuCurrencySwitcherWidget").each(function () {
		var widget = $(this);
		var select = widget.find('[name="wcu_currency_switcher"]');

		// Initialize flag dropdown.
		if (
			typeof $.fn.msDropDown === "function" &&
			widget.find(".wcuFlagsSelectBoxDropdown").length
		) {
			widget.find(".wcuFlagsSelectBoxDropdown").each(function () {
				var dropdown = $(this);

				if (
					!dropdown.attr("id") &&
					!dropdown.closest(".ddOutOfVision").length
				) {
					wcuGlobalFlagsDD++;

					var id = "wcuFlagsSelectBoxDropdown_" + wcuGlobalFlagsDD;
					dropdown.attr("id", id);
					window.wcuDDList[id] = dropdown.msDropDown().data("dd");
				}
			});
		}

		// Currency selection.
		select.on("change", function () {
			wcuUpdateUrlParam("currency", $(this).val());
		});
	});

	window.wcuGlobalFlagsDD = wcuGlobalFlagsDD;

	// Select currency using flag images.
	$(document).on("click", ".wcuCurrencySwitcherWidgetShowAsFlag", function () {
		wcuUpdateUrlParam("currency", $(this).attr("data-currency"));
	});

	// Reinitialize flag dropdowns on window resize.
	$(window)
		.off("resize.wcuCurrencySwitcher")
		.on("resize.wcuCurrencySwitcher", function () {
			$.each(window.wcuDDList, function (id, handler) {
				if (handler) {
					handler.destroy();
				}

				var dropdown = $("#" + id);
				if (dropdown.length && typeof $.fn.msDropDown === "function") {
					window.wcuDDList[id] = dropdown.msDropDown().data("dd");
				}
			});
		});
});
