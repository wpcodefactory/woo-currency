<?php
/**
 * WBW Currency Switcher for WooCommerce - Switcher Rotating
 *
 * @version 2.4.0
 *
 * @author woobewoo
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
	<?php if ( $show_on_screen && $show_on_screen_compare && $show_on_screen_value ) { ?>
	<?php if ( $show_on_screen_compare === 'less' ) {
		$show_on_screen_compare = 'max-width';
	} else {
		$show_on_screen_compare = 'min-width';
	} ?>
	.wcuCurrencySwitcher {
		display: none !important;
	}

	@media ( <?php echo esc_attr( $show_on_screen_compare ) ?>:<?php echo esc_attr( $show_on_screen_value ) ?>px ) {
	.wcuCurrencySwitcher {
		display: inline-block !important;
	}

	<?php } ?>
	<?php if ( ! wp_is_mobile() ) { ?>
	.wcuCurrencySwitcher.left, .wcuCurrencySwitcher.right {
		top: <?php echo (float) $vertical_offset_desktop . esc_attr( $vertical_offset_desktop_dimension ); ?> !important;
	}

	<?php } else { ?>
	.wcuCurrencySwitcher.left, .wcuCurrencySwitcher.right {
		top: <?php echo (float) $vertical_offset_mobile . esc_attr( $vertical_offset_mobile_dimension ); ?> !important;
	}

	<?php } ?>
	.wcuCurrencySwitcher li {
		background-color: <?php echo esc_attr( $bg_color ); ?>;
		color: <?php echo esc_attr( $txt_color ); ?>;
		border: 1px solid<?php echo esc_attr( $bor_color ); ?>;
	}

	.wcuCurrencySwitcher li:hover {
		background-color: <?php echo esc_attr( $bg_color_h ); ?>;
		color: <?php echo esc_attr( $txt_color_h ); ?>;
	}

	.wcuCurrencySwitcher .wcuCurrent {
		background-color: <?php echo esc_attr( $bg_color_cur ); ?>;
		color: <?php echo esc_attr( $txt_color_cur ); ?>;
	}

	.wcuCurrencySwitcher.wcuRotShowBorder_1 ul li {
		border: 1px solid<?php echo esc_attr( $bor_color ); ?>;
	}

	.wcuCurrencySwitcher ul li span {
		background-color: <?php echo esc_attr( $rot_block_bg_color ); ?>;
		color: <?php echo esc_attr( $rot_block_txt_color ); ?>;
	}

	.wcuCurrencySwitcher ul li.wcuCurrent span {
		background-color: <?php echo esc_attr( $rot_block_bg_color_cur ); ?>;
		color: <?php echo esc_attr( $rot_block_txt_color_cur ); ?>;
	}

	.wcuCurrencySwitcher ul li:hover span {
		background-color: <?php echo esc_attr( $rot_block_bg_color_h ); ?>;
		color: <?php echo esc_attr( $rot_block_txt_color_h ); ?>;
	}

	.wcuCurrencySwitcher {
		opacity: <?php echo (float) $simple_opacity_panel * 0.01; ?>;
		transition: .4s;
	}

	.wcuCurrencySwitcher:hover {
		opacity: 1;
	}

	<?php if ( $show_on_screen ) { ?>
	}
	<?php } ?>
</style>

<div id="wcuCurrencySwitcherRotating" class="wcuCurrencySwitcher <?php echo esc_attr( $side_rotating ); ?> <?php echo esc_attr( $layout ); ?>  wcuRotToggleSwitcher_<?php echo esc_attr( $toggle_switcher ); ?> wcuRotShowBorder_<?php echo esc_attr( $show_border ); ?>" data-type="<?php echo esc_attr( $type )?>" style="display:none;" >
	<?php dispatcherWcu::doAction('beforeCurrencySwitcherList', $this->optionsParams); ?>
	<ul>
		<?php if ($cur_currency_top) {?>
			<li class="wcuCurrent" data-currency="<?php echo esc_attr( $this->currentCurrency ); ?>">
				<?php if ( $this->proModule && isset( $show_flags_rotating ) && $show_flags_rotating ) {?>
					<?php echo wp_kses_post( $this->currencies[$this->currentCurrency]['flag'] ); ?>
				<?php } else { ?>
					<?php echo esc_html( $this->currencies[$this->currentCurrency]['title'] );  ?>
				<?php } ?>
				&nbsp;<span><?php echo esc_html( empty( $show_symbol_rotating ) ? $this->currentCurrency : $this->currencies[ $this->currentCurrency ]['symbol'] ); ?></span>
	        </li>
		<?php }?>
		<?php foreach ($this->currencies as $key => $currency) {?>
			<?php $current = $key == $this->currentCurrency ? 'wcuCurrent' : '';?>
				<?php if ( ($cur_currency_top) && isset($current) && !empty($current) ) continue; ?>
				<li class="<?php echo esc_attr( $current ); ?>" data-currency="<?php echo esc_html( $key ); ?>">
					<?php if ( $this->proModule && isset( $show_flags_rotating ) && $show_flags_rotating ) {?>
						<?php echo wp_kses_post( $currency['flag'] ); ?>
					<?php } else { ?>
						<?php echo esc_html( $currency['title'] ); ?>
					<?php } ?>
					&nbsp;<span><?php echo esc_html( empty( $show_symbol_rotating ) ? $key : $currency['symbol'] ); ?></span>
				</li>
		<?php }?>
	</ul>
</div>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
