<?php
/**
 * WBW Currency Switcher for WooCommerce - Currency Switcher Widget
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$show_on_widths         = ! empty( $this->instance['show_on_widths'] );
$show_on_screen_compare = $this->instance['show_on_screen_compare'] ?? '';
$show_on_screen_value   = absint( $this->instance['show_on_widths_value'] ?? 0 );

if (
	$show_on_widths &&
	$show_on_screen_value &&
	in_array( $show_on_screen_compare, array( 'less', 'more' ), true )
) {
	$media_condition = ( 'less' === $show_on_screen_compare ) ? 'max-width' : 'min-width';
	?>
	<style>
		#wcuCurrencySwitcherWidget_<?php echo absint( $this->randId ); ?> {
			display: none !important;
		}

		@media (<?php echo esc_attr( $media_condition ); ?>: <?php echo esc_attr( $show_on_screen_value ); ?>px) {
		#wcuCurrencySwitcherWidget_<?php echo absint( $this->randId ); ?> {
			display: block !important;
		}
		}
	</style>
	<?php
}

$formStyles = 'margin-bottom: 20px;';
$formStyles .= ! empty( $this->instance['width'] ) ? 'width: ' . $this->instance['width'] . ';' : 'width: 100%;';

if ( ! $this->moduleFlags ) {
	$this->instance['show_flag_dropdown'] = false;
	$this->instance['show_as']            = 'dropdown';
}

?>

	<div id="wcuCurrencySwitcherWidget_<?php echo absint( $this->randId ); ?>" class="wcuCurrencySwitcherWidget" style="<?php echo esc_attr( $formStyles ); ?>">

		<?php if ( ! empty( $this->instance['title'] ) ) { ?>
			<div style="margin-bottom: 10px;"><?php echo esc_html( $this->instance['title'] ); ?></div>
		<?php } ?>

		<?php
		if (
			$this->showFlags &&
			(
				( ! empty( $this->instance['show_flag_dropdown'] ) && $this->instance['show_flag_dropdown'] != 'false' ) ||
				( isset( $this->instance['show_as'] ) && ( $this->instance['show_as'] === 'flags' ) )
			)
		) { ?>
			<?php if ( isset( $this->instance['show_as'] ) && ( $this->instance['show_as'] === 'dropdown' ) && isset( $this->instance['show_flag_dropdown'] ) ) { ?>
				<div class="wcuFlagsSelectBoxDropdownWrapper">
					<select name="wcu_currency_switcher" class="wcuFlagsSelectBoxDropdown">
						<?php
						foreach ( $this->currenciesOpts as $key => $currency ) { ?>
							<?php $current = $key == $this->currentCurrency ? 'selected' : ''; ?>
							<option
								<?php selected($this->currentCurrency, $key) ?>
								value="<?php echo esc_attr( $key ); ?>"
								title="<?php echo esc_html( $currency['flag'] ); ?>"
							>
								<?php echo esc_html( $currency['name'] ); ?>
							</option>
						<?php } ?>
					</select>
				</div>

			<?php } else { ?>

				<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
					<?php $current = $key == $this->currentCurrency ? 'wcuCurrent' : ''; ?>
					<?php if ( ! empty( $currency['flag'] ) ) { ?>
						<img
							class="wcuCurrencySwitcherWidgetShowAsFlag <?php echo esc_attr( $current ); ?>"
							data-currency="<?php echo esc_attr( $key ); ?>"
							src="<?php echo esc_url( $currency['flag'] ); ?>"
						>
					<?php } else { ?>
						<span
							class="wcuCurrencySwitcherWidgetShowAsFlag <?php echo esc_attr( $current ) ?>"
							data-currency="<?php echo esc_attr( $key ); ?>"
						>
							<?php echo esc_html( $key ); ?>
						</span>
					<?php } ?>
				<?php } ?>

			<?php } ?>

		<?php } else { ?>
			<select name="wcu_currency_switcher">
				<?php foreach ( $this->currenciesOpts as $key => $currency ) { ?>
					<?php $current = $key == $this->currentCurrency ? 'selected' : ''; ?>
					<option
						<?php selected( $this->currentCurrency, $key ) ?>
						value="<?php echo esc_attr( $key ); ?>"
					>
						<?php echo esc_html( $currency['name'] ); ?>
					</option>
				<?php } ?>
			</select>
		<?php } ?>

	</div>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound