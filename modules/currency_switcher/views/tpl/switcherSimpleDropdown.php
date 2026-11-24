<?php
/**
 * WBW Currency Switcher for WooCommerce - switcher Simple Dropdown
 *
 * @version 2.4.0
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

foreach($this->designTab as $p) {
	// create variable like param name with param value
	${$p} = $this->optionsParams['currency_switcher']['design_tab'][$p]['params']['value'];
}
foreach($this->displayRulesTab as $p) {
	// create variable like param name with param value
	${$p} = $this->optionsParams['currency_switcher']['display_rules_tab'][$p]['params']['value'];
}
?>

<style>

<?php if ($show_on_screen && $show_on_screen_compare && $show_on_screen_value) { ?>
	<?php if ($show_on_screen_compare === 'less') {
		$show_on_screen_compare = 'max-width';
	} else {
		$show_on_screen_compare = 'min-width';
	} ?>
	.wcuCurrencySwitcher {
		display:none !important;
	}
	@media ( <?php echo esc_attr( $show_on_screen_compare ) ?>:<?php echo esc_attr( $show_on_screen_value ) ?>px ) {
		.wcuCurrencySwitcher {
			display:inline-block !important;
		}
<?php } ?>

	<?php if (!wp_is_mobile()) { ?>
		.wcuCurrencySwitcher.left, .wcuCurrencySwitcher.right {
			top: <?php echo (float) $vertical_offset_desktop . esc_attr( $vertical_offset_desktop_dimension ); ?> !important;
		}
		.wcuCurrencySwitcher.left {
			left: <?php echo (float) $horizontal_offset_desktop . esc_attr( $horizontal_offset_desktop_dimension ); ?> !important;
		}
		.wcuCurrencySwitcher.right {
			right: <?php echo (float) $horizontal_offset_desktop . esc_attr( $horizontal_offset_desktop_dimension ); ?> !important;
		}
	<?php } else { ?>
		.wcuCurrencySwitcher.left, .wcuCurrencySwitcher.right {
			top: <?php echo (float) $vertical_offset_mobile . esc_attr( $vertical_offset_mobile_dimension ); ?> !important;
		}
		.wcuCurrencySwitcher.left {
			left: <?php echo (float) $horizontal_offset_mobile . esc_attr( $horizontal_offset_mobile_dimension ); ?> !important;
		}
		.wcuCurrencySwitcher.right {
			right: <?php echo (float) $horizontal_offset_mobile . esc_attr( $horizontal_offset_mobile_dimension ); ?> !important;
		}
	<?php } ?>

	.wcuCurrencySwitcher {
		opacity: <?php echo (float) $simple_opacity_panel * 0.01; ?> !important;
		transition:.4s;
	}
	.wcuCurrencySwitcher:hover {
		opacity:1 !important;
	}

	.wcuCurrencySwitcher li {
		background-color: <?php echo esc_attr( $bg_color ); ?>;
		color: <?php echo esc_attr( $txt_color ); ?>;
		margin: <?php echo esc_attr( $icon_spacing ); ?>px;
	}
	.wcuCurrencySwitcher li:hover {
		background-color: <?php echo esc_attr( $bg_color_h ); ?>;
		color: <?php echo esc_attr( $txt_color_h ); ?>;
	}
	.wcuCurrencySwitcher .wcuCurrent {
		background-color: <?php echo esc_attr( $bg_color_cur ); ?>;
		color: <?php echo esc_attr( $txt_color_cur ); ?>;
	}
	.wcuCurrencySwitcher.wcuCsdShowBorder_1 li {
		border:1px solid <?php echo esc_attr( $bor_color );  ?>;
	}
	.wcuCurrencySwitcher.wcuCsdShowBorder_1 li:last-child {
		border-right:1px solid <?php echo esc_attr( $bor_color );  ?>;
	}
	.wcuCurrencySwitcher.wcuCsdIconType_rectangular li {
		border-radius: <?php echo (float) $border_radius . esc_attr( $border_radius_dimension );  ?>;
		-moz-border-radius:  <?php echo (float) $border_radius . esc_attr( $border_radius_dimension );  ?>;
		-webkit-border-radius:  <?php echo (float) $border_radius . esc_attr( $border_radius_dimension );  ?>;
	}
	.wcuCurrencySwitcher.wcuCsdToggleSwitcher_on_hover ul:hover li {
		color: <?php echo esc_attr( $txt_color ); ?>;
	}
	.wcuCsdToggleSwitcherClick ul li{
		color: <?php echo esc_attr( $txt_color ); ?> !important;
	}
	.wcuCurrencySwitcher ul:hover li.wcuCurrent {
		color: <?php echo esc_attr( $txt_color_cur ); ?>;
	}
	.wcuCsdToggleSwitcherClick ul li.wcuCurrent{
		color: <?php echo esc_attr( $txt_color_cur ); ?> !important;
	}
	.wcuCurrencySwitcher ul:hover li:hover {
		color: <?php echo esc_attr( $txt_color_h ); ?>;
	}
	.wcuCsdToggleSwitcherClick ul li:hover{
		color: <?php echo esc_attr( $txt_color_h ); ?> !important;
	}
	.wcuCurrencySwitcher.wcuCsdIconType_circle.wcuCsdShowBorder_1 ul li {
		border-bottom:1px solid <?php echo esc_attr( $bor_color );  ?> !important;
	}
	.wcuCurrencySwitcher.horizontal.wcuCsdShowBorder_1 li {
		border-bottom:1px solid <?php echo esc_attr( $bor_color );  ?> !important;
	}

<?php if ($show_on_screen) { ?>
}
<?php } ?>

</style>
<div class="wcuCurrencySwitcherSimpleDropdown wcuCurrencySwitcher <?php echo esc_attr( $side_simple )?> <?php echo esc_attr( $layout ); ?> wcuCsdShow_<?php echo esc_attr( $show ); ?> wcuCsdToggleSwitcher_<?php echo esc_attr( $toggle_switcher ); ?> wcuCsdIconType_<?php echo esc_attr( $icon_type ); ?> wcuCsdIconSize_<?php echo esc_attr( $icon_size ); ?> wcuCsdShowBorder_<?php echo esc_attr( $show_border ); ?>" data-type="<?php echo esc_attr( $type ); ?>" style="display: none;">
	<?php dispatcherWcu::doAction('beforeCurrencySwitcherList', $this->optionsParams); ?>
	<ul>

		<?php if ( ( ($layout === "horizontal") && ($side_simple === "left") ) || ($layout === "vertical") ) { ?>

		<li class="wcuCurrencySwitcherSimpleDropdownClose">
			<i class="fa fa-times" aria-hidden="true"></i>
		</li>

		<li class="wcuCurrent" data-currency="<?php echo esc_attr($this->currentCurrency); ?>">
			<?php echo esc_html($this->currencies[$this->currentCurrency]); ?>
		</li>

		<?php }?>

		<?php foreach ($this->currencies as $key => $currency) { ?>
			<?php $current = $key == $this->currentCurrency ? 'wcuCurrent' : '';?>

			<?php if (empty($current)) { ?>
				<li class="<?php echo esc_attr( $current ); ?>" data-currency="<?php echo esc_attr($key); ?>">
					<?php echo esc_html($currency);?>
				</li>
			<?php } ?>

		<?php } ?>

		<?php if ( ($layout === "horizontal") && ($side_simple === "right") ) { ?>

			<li class="wcuCurrent" data-currency="<?php echo esc_attr( $this->currentCurrency ); ?>">
				<?php echo esc_html( $this->currencies[$this->currentCurrency] );?>
			</li>

			<li class="wcuCurrencySwitcherSimpleDropdownClose">
				<i class="fa fa-times" aria-hidden="true"></i>
			</li>

		<?php }?>

	</ul>
</div>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound