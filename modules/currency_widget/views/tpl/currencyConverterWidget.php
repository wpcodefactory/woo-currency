<?php
/**
 * WBW Currency Switcher for WooCommerce - Currency Converter Widget
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$btn_bg_color   = isset( $this->instance['btn_bg_color'] ) ? $this->instance['btn_bg_color'] : '#fafafa';
$btn_bg_color_h = isset( $this->instance['btn_bg_color_h'] ) ? $this->instance['btn_bg_color_h'] : '#fafafa';
$btn_txt_color  = isset( $this->instance['btn_txt_color'] ) ? $this->instance['btn_txt_color'] : 'black';
$layout         = isset( $this->instance['layout'] ) ? $this->instance['layout'] : 'horizontal';
?>
	<style>
		#wcuCurrencyConverterWidget_<?php echo absint( $this->randId ); ?>.wcuCurrencyConverterWidget .wcuExchangeIcon {
			color: <?php echo esc_attr( $btn_bg_color ); ?>;
		}

		#wcuCurrencyConverterWidget_<?php echo absint( $this->randId ); ?>.wcuCurrencyConverterWidget .wcuExchangeIcon:hover {
			color: <?php echo esc_attr( $btn_bg_color_h ); ?>;
		}

		#wcuCurrencyConverterWidget_<?php echo absint( $this->randId ); ?>.wcuCurrencyConverterWidget .wcuCurrencyConvertBtn {
			background: <?php echo esc_attr( $btn_bg_color ); ?>;
			color: <?php echo esc_attr( $btn_txt_color ); ?>;
		}

		#wcuCurrencyConverterWidget_<?php echo absint( $this->randId ); ?>.wcuCurrencyConverterWidget .wcuCurrencyConvertBtn:hover {
			background: <?php echo esc_attr( $btn_bg_color_h ); ?>;
		}

		#wcuCurrencyConverterWidget_<?php echo absint( $this->randId ); ?> .fnone {
			display: inline-block;
			position: relative;
			float: left !important;
			line-height: 21px;
		}

		#wcuCurrencyConverterWidget_<?php echo absint( $this->randId ); ?> .ddlabel {
			display: inline-block;
			line-height: 21px;
		}



		<?php
			$show_on_widths = isset($this->instance['show_on_widths']) ? $this->instance['show_on_widths'] : false;
			$show_on_screen_compare = isset($this->instance['show_on_screen_compare']) ? $this->instance['show_on_screen_compare'] : false;
			$show_on_screen_value = isset($this->instance['show_on_widths_value']) ? $this->instance['show_on_widths_value'] : false;
		?>

		<?php if ( $show_on_widths && $show_on_screen_value && in_array( $show_on_screen_compare, array( 'less', 'more' ), true ) ) { ?>

		#wcuCurrencyConverterWidget_<?php echo esc_attr( $widget_id ); ?> {
			display: none !important;
		}

		@media (<?php echo 'less' === $show_on_screen_compare ? 'max-width' : 'min-width'; ?>: <?php echo esc_attr( $show_on_screen_value ); ?>px) {
			#wcuCurrencyConverterWidget_<?php echo esc_attr( $widget_id ); ?> {
				display: block !important;
			}
		}
		<?php } ?>
	</style>

<?php
$styles['width'] = ! empty( $this->instance['width'] ) ? 'width: ' . $this->instance['width'] . ';' : 'width: 100%;';

if ( ! $this->moduleFlags ) {
	$this->instance['layout']             = 'vertical';
	$this->instance['show_flag_dropdown'] = false;
}
?>

	<div
		id="wcuCurrencyConverterWidget_<?php echo absint( $this->randId ); ?>"
		class="wcuCurrencyConverterWidget wcuCurrencyConverterWidget_<?php echo esc_attr( $layout ); ?>"
		style="<?php echo esc_attr( $styles['width'] ); ?>"
	>

		<?php if ( ! empty( $this->instance['title'] ) ) { ?>
			<div style="margin-bottom: 10px;"><?php echo esc_html( $this->instance['title'] ); ?></div>
		<?php } ?>

		<div class="wcuCurrencyConverterShell">

			<?php
			if (
				! empty( $this->instance['layout'] ) &&
				( $this->instance['layout'] === 'vertical' )
			) { ?>
				<div class="wcuCol-md-12 wcuCol-xs-12 wcuMargin">
					<?php
					htmlWcu::echo_escaped_html(
						htmlWcu::input(
							"amount",
							array(
								'type'  => 'text',
								'value' => 1,
								'attrs' => 'placeholder="results" style="width:100%"',
							)
						)
					);
					?>
					<?php
					htmlWcu::echo_escaped_html(
						htmlWcu::hidden(
							"precision",
							array(
								'value' => 4,
							)
						)
					);
					?>
				</div>
				<div class="wcuCol-md-5 wcuCol-xs-12 wcuMargin">
					<?php
					if (
						$this->showFlags &&
						isset( $this->instance['show_flag_dropdown'] ) && $this->instance['show_flag_dropdown'] !== 'false'
					) { ?>
						<select name="currency_from" class="wcuFlagsSelectBoxDropdown">
							<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
								<?php $current = $key == $this->currentCurrency ? 'selected' : ''; ?>
								<option
									<?php selected( $this->currentCurrency, $key ); ?>
									value="<?php echo esc_attr( $key ); ?>"
									title="<?php echo esc_html( $currency['flag'] ); ?>"
								>
									<?php echo esc_html( $currency['name'] ); ?>
								</option>
							<?php } ?>
						</select>
					<?php } else { ?>
						<select name="currency_from">
							<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
								<option
									<?php selected( $this->currentCurrency, $key ); ?>
									value="<?php echo esc_attr( $key ); ?>"
								>
									<?php echo esc_html( $currency['name'] ); ?>
								</option>
							<?php } ?>
						</select>
					<?php } ?>
				</div>

				<div class="wcuCol-md-2 wcuCol-xs-12 wcuMargin">
					<div class="wcuExchangeIcon" style="text-align: center;"><i class="fa fa-long-arrow-right"
					                                                            aria-hidden="true"></i></div>
				</div>

				<div class="wcuCol-md-5 wcuCol-xs-12 wcuMargin">
					<?php
					if (
						$this->showFlags &&
						isset( $this->instance['show_flag_dropdown'] ) &&
						$this->instance['show_flag_dropdown'] !== 'false'
					) { ?>
						<select name="currency_to" class="wcuFlagsSelectBoxDropdown">
							<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
								<option
									<?php selected( $this->currentCurrency, $key ); ?>
									value="<?php echo esc_attr( $key ); ?>"
									title="<?php echo esc_html( $currency['flag'] ); ?>"
								>
									<?php echo esc_html( $currency['name'] ); ?>
								</option>
							<?php } ?>
						</select>
					<?php } else { ?>
						<select name="currency_to">
							<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
								<option
									<?php selected( $this->currentCurrency, $key ); ?>
									value="<?php echo esc_attr( $key ); ?>"
								>
									<?php echo esc_html( $currency['name'] ); ?>
								</option>
							<?php } ?>
						</select>
					<?php } ?>
				</div>

				<div class="wcuCol-md-12 wcuCol-xs-12 wcuMargin">
					<?php
					htmlWcu::echo_escaped_html(
						htmlWcu::input(
							"result",
							array(
								'type'  => 'text',
								'value' => '',
								'attrs' => 'placeholder="results" readonly="" class="wcuCol-md-12 wcuCol-xs-12 wcuMargin"',
							)
						)
					);
					?>
				</div>

			<?php } elseif (
			$this->moduleFlags &&
			! empty( $this->instance['layout'] ) &&
			( $this->instance['layout'] === 'horizontal' )
			) { ?>
				<div class="wcuCol-md-5 wcuCol-xs-12 wcuMargin">
					<?php
					htmlWcu::echo_escaped_html(
						htmlWcu::input(
							"amount",
							array(
								'type'  => 'text',
								'value' => 1,
								'attrs' => 'style="width:100%;"',
							)
						)
					);
					?>
					<?php
					htmlWcu::echo_escaped_html(
						htmlWcu::hidden(
							"precision",
							array(
								'value' => 4,
							)
						)
					);
					?>
					<?php
					if (
						$this->showFlags &&
						isset( $this->instance['show_flag_dropdown'] ) &&
						$this->instance['show_flag_dropdown'] !== 'false'
					) {
						?>
						<select
							name="currency_from"
							class="wcuFlagsSelectBoxDropdown"
						>
							<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
								<option
									<?php selected( $this->currentCurrency, $key ); ?>
									value="<?php echo esc_attr( $key ); ?>"
									title="<?php echo esc_html( $currency['flag'] ); ?>"
								>
									<?php echo esc_html( $currency['name'] ); ?>
								</option>
							<?php } ?>
						</select>
					<?php } else { ?>
						<select name="currency_from">
							<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
								<option
									<?php selected( $this->currentCurrency, $key ); ?>
									value="<?php echo esc_attr( $key ); ?>"
								>
									<?php echo esc_html( $currency['name'] ); ?>
								</option>
							<?php } ?>
						</select>
					<?php } ?>
				</div>

				<div class="wcuCol-md-2 wcuCol-xs-12 wcuMargin">
					<div class="wcuExchangeIcon wcuExchangeIconHorizontal" style="text-align: center;"><i
							class="fa fa-long-arrow-right" aria-hidden="true"></i></div>
				</div>

				<div class="wcuCol-md-5 wcuCol-xs-12 wcuMargin">
					<?php
					htmlWcu::echo_escaped_html(
						htmlWcu::input(
							'result',
							array(
								'type'  => 'text',
								'value' => 1,
								'attrs' => 'style="width:100%;"',
							)
						)
					);
					?>

					<?php if ( $this->showFlags && isset( $this->instance['show_flag_dropdown'] ) && $this->instance['show_flag_dropdown'] !== 'false' ) { ?>
						<select name="currency_to" class="wcuFlagsSelectBoxDropdown">
							<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
								<option
									<?php selected( $this->currentCurrency, $key ); ?>
									value="<?php echo esc_attr( $key ); ?>"
									title="<?php echo esc_html( $currency['flag'] ); ?>"
								>
									<?php echo esc_html( $currency['name'] ); ?>
								</option>
							<?php } ?>
						</select>
					<?php } else { ?>
						<select name="currency_to">
							<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
								<option
									<?php selected( $this->currentCurrency, $key ); ?>
									value="<?php echo esc_attr( $key ); ?>"
								>
									<?php echo esc_html( $currency['name'] ); ?>
								</option>
							<?php } ?>
						</select>
					<?php } ?>
				</div>
			<?php } ?>

			<div class="wcuCol-md-12 wcuCol-xs-12 wcuMargin">
				<?php
				htmlWcu::echo_escaped_html(
					htmlWcu::button(
						array(
							'value' => esc_html__( 'Convert', 'woo-currency' ),
							'attrs' => 'class="wcuCurrencyConvertBtn wcuCol-md-12 wcuCol-xs-12 wcuMargin"',
						)
					)
				);
				?>
			</div>

		</div>

		<div style="clear: both;"></div>
	</div>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound