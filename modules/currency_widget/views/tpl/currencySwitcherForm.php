<?php
/**
 * WBW Currency Switcher for WooCommerce - Currency Switcher Form
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$showFlags = false;
if (!empty(frameWcu::_()->getModule('flags'))) {
	$showFlags = true;
}
$proFlagsDisabled = !$showFlags ? 'disabled' : '' ;
$proFlagsSup =  !$showFlags ? '<sup>PRO</sup>' : '' ;
?>
<div class="wcuWidgetRow">
	<label for="<?php echo esc_attr( $this->widget->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'woo-currency') ?></label>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::input(
			$this->widget->get_field_name( 'title' ),
			array(
				'type'  => 'text',
				'value' => isset( $this->data['title'] ) ? esc_attr( $this->data['title'] ) : '',
				'attrs' => 'id="' . esc_attr( $this->widget->get_field_id( 'title' ) ) . '"',
			)
		)
	);
	?>
</div>
<div class="wcuWidgetRow">
	<label for="<?php echo esc_attr( $this->widget->get_field_id('width') ); ?>"><?php esc_html_e('Width', 'woo-currency') ?></label>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::input(
			$this->widget->get_field_name( 'width' ),
			array(
				'type'  => 'text',
				'value' => isset( $this->data['width'] ) ? esc_attr( $this->data['width'] ) : '100%',
				'attrs' => 'id="' . esc_attr( $this->widget->get_field_id( 'width' ) ) . '"',
			)
		)
	);
	?>
	<br /><i><?php esc_html_e('for example: 200px, 100%, auto', 'woo-currency')?></i>
</div>
<div class="wcuWidgetRow">
	<label style="margin-bottom:10px;" for="<?php echo esc_attr( $this->widget->get_field_id('show_as') ); ?>"><?php esc_html_e('Show as', 'woo-currency') ?></label>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::radiobutton(
			$this->widget->get_field_name( 'show_as' ),
			array(
				'attrs'   => ' class="wcuSwitcherRadioLabel" id="layout_vertical" ',
				'no_br'   => true,
				'value'   => 'dropdown',
				'checked' => ( ! $showFlags || ( isset( $this->data['show_as'] ) && ( $this->data['show_as'] === 'dropdown' ) ) ) ? 'checked' : '',
			)
		)
	);
	?>
	<span><?php esc_html_e("Dropdown", 'woo-currency')?></span>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::radiobutton(
			$this->widget->get_field_name( 'show_as' ),
			array(
				'attrs'   => ' class="wcuSwitcherRadioLabel" id="layout_horizontal" style="margin-left:20px;" ' . $proFlagsDisabled,
				'no_br'   => true,
				'value'   => 'flags',
				'checked' => ( $showFlags && ( isset( $this->data['show_as'] ) && ( $this->data['show_as'] === 'flags' ) ) ) ? 'checked' : '',
			)
		)
	);
	?>
	<span><?php esc_html_e("Flags", 'woo-currency')?> <?php echo wp_kses_post( $proFlagsSup ); ?></span>
</div>
<div class="wcuWidgetRow">
	<label for="<?php echo esc_attr( $this->widget->get_field_id('currency_display') ); ?>"><?php esc_html_e('Currency Dropdown Options Text', 'woo-currency') ?></label>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::selectbox(
			$this->widget->get_field_name( 'currency_display' ),
			array(
				'value'   => isset( $this->data['currency_display'] ) ? $this->data['currency_display'] : 'name',
				'options' => array(
					'name'   => esc_html__( 'Currency code', 'woo-currency' ),
					'title'  => esc_html__( 'Currency title', 'woo-currency' ),
					'symbol' => esc_html__( 'Currency symbol', 'woo-currency' ),
				),
				'attrs'   => 'id="' . esc_attr( $this->widget->get_field_id( 'currency_display' ) ) . '"',
			)
		)
	);
	?>
</div>
<div class="wcuWidgetRow" style="margin-bottom:0;">
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::checkbox(
			$this->widget->get_field_name( 'show_flag_dropdown' ),
			array(
				'attrs'   => "style='float:left; margin-top:0px; margin-right:5px;' id='" . esc_attr( $this->widget->get_field_id( 'show_flag_dropdown' ) ) . "' " . $proFlagsDisabled . " ",
				'value'   => ( $showFlags && isset( $this->data['show_flag_dropdown'] ) ) ? '1' : '0',
				'checked' => ( $showFlags && isset( $this->data['show_flag_dropdown'] ) ) ? 'checked' : '',
			)
		)
	);
	?>
	<label for="<?php echo esc_attr( $this->widget->get_field_id('show_flag_dropdown') ); ?>"><?php esc_html_e('show flag in dropdown', 'woo-currency') ?> <?php echo wp_kses_post( $proFlagsSup ); ?></label>
</div>
<div class="wcwuWidgetRow">
	<label for="<?php echo esc_attr(  $this->widget->get_field_id('exclude') ); ?>"><?php esc_html_e('Excluded currencies', 'woo-currency') ?></label><br>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::selectlist(
			$this->widget->get_field_name( 'exclude' ),
			array(
				'value'   => isset( $this->data['exclude'] ) ? $this->data['exclude'] : '',
				'attrs'   => 'style="width:100%;" id="' . $this->widget->get_field_id( 'exclude' ) . '"',
				'options' => frameWcu::_()->getModule( 'currency' )->getCurrencyCodes(),
			)
		)
	);
	?>
	<br /><i><?php esc_html_e("The selected currency will not be displayed in the list of switches. Press CTRL + CLICK to toggle select.", 'woo-currency')?></i>
</div>
<br />
<div class="wcuWidgetRow">
	<label for="<?php echo esc_attr(  $this->widget->get_field_id('show_on' ) ); ?>"><?php esc_html_e('Show on', 'woo-currency') ?></label>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::selectbox(
			$this->widget->get_field_name( 'show_on' ),
			array(
				'value'   => isset( $this->data['show_on'] ) ? $this->data['show_on'] : 'name',
				'options' => array(
					'both'     => esc_html__( 'both', 'woo-currency' ),
					'desktops' => esc_html__( 'desktops', 'woo-currency' ),
					'mobiles'  => esc_html__( 'mobiles', 'woo-currency' ),
				),
				'attrs'   => 'id="' . $this->widget->get_field_id( 'show_on' ) . '"',
			)
		)
	);
	?>
</div>
<div class="wcuWidgetRow">
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::checkbox(
			$this->widget->get_field_name( 'show_on_widths' ),
			array(
				'attrs'   => "style='float:left; margin-top: 6px; margin-right:5px;' id='" . $this->widget->get_field_id( 'show_on_widths' ) . "' ",
				'value'   => isset( $this->data['show_on_widths'] ) ? '1' : '0',
				'checked' => isset( $this->data['show_on_widths'] ) ? 'checked' : '',
			)
		)
	);
	?>
	<label for="<?php echo esc_attr( $this->widget->get_field_id('show_on_widths') ); ?>" style="display: inline-block; float: left; margin-top: 6px;"><?php esc_html_e('Show on screen widths', 'woo-currency') ?></label>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::selectbox(
			$this->widget->get_field_name( 'show_on_screen_compare' ),
			array(
				'value'   => isset( $this->data['show_on_screen_compare'] ) ? $this->data['show_on_screen_compare'] : 'name',
				'options' => array(
					'less' => esc_html__( 'less', 'woo-currency' ),
					'more' => esc_html__( 'more', 'woo-currency' ),
				),
				'attrs'   => 'id="' . $this->widget->get_field_id( 'show_on_screen_compare' ) . '" style="display: inline-block; float: left; width: 60px; margin-left:3px;"',
			)
		)
	);
	?>
	<span style="float:left; margin:0px 4px; margin-top:6px;"><?php esc_html_e('than', 'woo-currency'); ?></span>
	<?php
	htmlWcu::echo_escaped_html(
		htmlWcu::input(
			$this->widget->get_field_name( 'show_on_widths_value' ),
			array(
				'type'  => 'text',
				'value' => isset( $this->data['show_on_widths_value'] ) ? esc_attr( $this->data['show_on_widths_value'] ) : '',
				'attrs' => 'id="' . esc_attr( $this->widget->get_field_id( 'show_on_widths_value' ) ) . '"' . '" style="display: inline-block; float: left; width: 60px; "',
			)
		)
	);
	?>
	<span style="margin-left:3px; margin-top:6px; float:left"><?php esc_html_e( 'px', 'woo-currency' ); ?></span>
</div>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound