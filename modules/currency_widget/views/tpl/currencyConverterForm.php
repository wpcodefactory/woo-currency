<?php
/**
 * WBW Currency Switcher for WooCommerce - Currency Converter Widget Form
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
	<script type="text/javascript">
        g_wcuCurrencyConverterBtnBgColorTimeoutSet = false;
        g_wcuCurrencyConverterBtnBgColorLast = '';
        g_wcuCurrencyConverterBtnTxtColorTimeoutSet = false;
        g_wcuCurrencyConverterBtnTxtColorLast = '';
        g_wcuCurrencyConverterBtnBgColorHTimeoutSet = false;
        g_wcuCurrencyConverterBtnBgColorHLast = '';

        function wpColorPicker_widget_wcucurrencyconverterwidget3btn_bg_color_change( event, ui )
        {
            g_wcuCurrencyConverterBtnBgColorLast = ui.color.toString();
            if ( !g_wcuCurrencyConverterBtnBgColorTimeoutSet ) {
                setTimeout( function () {
                    jQuery( event.target ).parents( 'form:first' ).trigger( 'change' );
                }, 500 );
                g_wcuCurrencyConverterBtnBgColorTimeoutSet = true;
            }
        }

        function wpColorPicker_widget_wcucurrencyconverterwidget3btn_txt_color_change( event, ui )
        {
            g_wcuCurrencyConverterBtnTxtColorLast = ui.color.toString();
            if ( !g_wcuCurrencyConverterBtnTxtColorTimeoutSet ) {
                setTimeout( function () {
                    jQuery( event.target ).parents( 'form:first' ).trigger( 'change' );
                }, 500 );
                g_wcuCurrencyConverterBtnTxtColorTimeoutSet = true;
            }
        }

        function wpColorPicker_widget_wcucurrencyconverterwidget3btn_bg_color_h_change( event, ui )
        {
            g_wcuCurrencyConverterBtnBgColorHLast = ui.color.toString();
            if ( !g_wcuCurrencyConverterBtnBgColorHTimeoutSet ) {
                setTimeout( function () {
                    jQuery( event.target ).parents( 'form:first' ).trigger( 'change' );
                }, 500 );
                g_wcuCurrencyConverterBtnBgColorHTimeoutSet = true;
            }
        }
	</script>
<?php
$showFlags = false;
if ( ! empty( frameWcu::_()->getModule( 'flags' ) ) ) {
	$showFlags = true;
}
$proFlagsDisabled = ! $showFlags ? 'disabled' : '';
$proFlagsSup      = ! $showFlags ? '<sup>PRO</sup>' : '';
?>
	<div class="wcuWidgetRow" style="margin-top:20px;">
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'title' ) ); ?>">
			<?php esc_html_e( 'Title', 'woo-currency' ) ?>
		</label>
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
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'width' ) ); ?>">
			<?php esc_html_e( 'Width', 'woo-currency' ) ?>
		</label>
		<?php htmlWcu::echo_escaped_html(
			htmlWcu::input(
				$this->widget->get_field_name( 'width' ),
				array(
					'type'  => 'text',
					'value' => isset( $this->data['width'] ) ? $this->data['width'] : '100%',
					'attrs' => 'id="' . $this->widget->get_field_id( 'width' ) . '"',
				)
			)
		);
		?>
		<br/><i><?php esc_html_e( 'for example: 200px, 100%, auto', 'woo-currency' ) ?></i>
	</div>
	<div class="wcuWidgetRow">
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'currency_display' ) ); ?>">
			<?php esc_html_e( 'Currency Dropdown Options Text', 'woo-currency' ) ?>
		</label>
		<?php
		htmlWcu::echo_escaped_html(
			htmlWcu::selectbox(
				$this->widget->get_field_name( 'currency_display' ),
				array(
					'value'   => isset( $this->data['currency_display'] ) ? esc_attr( $this->data['currency_display'] ) : 'name',
					'options' => array(
						'name'  => esc_html__( 'Currency code', 'woo-currency' ),
						'title' => esc_html__( 'Currency title', 'woo-currency' ),
					),
					'attrs'   => 'id="' . $this->widget->get_field_id( 'currency_display' ) . '"',
				)
			)
		);
		?>
		<br/><i><?php esc_html_e( "set the currency's display name for currencies dropdown list", 'woo-currency' ) ?></i>
	</div>
	<div class="wcuWidgetRow" style="margin-bottom:0px;">
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
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'show_flag_dropdown' ) ); ?>">
			<?php esc_html_e( 'show flag in dropdown', 'woo-currency' ) ?><?php echo wp_kses_post( $proFlagsSup ); ?>
		</label>
	</div>
	<div class="wcwuWidgetRow">
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'exclude' ) ); ?>">
			<?php esc_html_e( 'Excluded currencies', 'woo-currency' ) ?>
		</label><br>
		<?php
		htmlWcu::echo_escaped_html(
			htmlWcu::selectlist(
				$this->widget->get_field_name( 'exclude' ),
				array(
					'value'   => $this->data['exclude'] ?? '',
					'attrs'   => 'style="width:100%;" id="' . esc_attr( $this->widget->get_field_id( 'exclude' ) ) . '"',
					'options' => frameWcu::_()->getModule( 'currency' )->getCurrencyCodes(),
				)
			)
		);
		?>
		<br/>
		<i><?php esc_html_e( "The selected currency will not be displayed in the list of switches. Press CTRL + CLICK to toggle select.", 'woo-currency' ) ?></i>
	</div>
	<br/>
	<div class="wcuWidgetRow">
		<label
			style="margin-bottom:10px;"
			for="<?php echo esc_attr( $this->widget->get_field_id( 'layout' ) ); ?>"
		>
			<?php esc_html_e( 'Layout', 'woo-currency' ) ?>
		</label>
		<?php htmlWcu::echo_escaped_html(
			htmlWcu::radiobutton(
				$this->widget->get_field_name( 'layout' ),
				array(
					'attrs'   => 'class="wcuSwitcherRadioLabel" id="layout_vertical" ',
					'no_br'   => true,
					'value'   => 'vertical',
					'checked' => ( ! $showFlags || ( isset( $this->data['layout'] ) && ( $this->data['layout'] === 'vertical' ) ) ) ? 'checked' : '',
				)
			)
		);
		?>
		<span><?php esc_html_e( "Vertical", 'woo-currency' ) ?></span>
		<?php
		htmlWcu::echo_escaped_html(
			htmlWcu::radiobutton(
				$this->widget->get_field_name( 'layout' ),
				array(
					'attrs'   => 'class="wcuSwitcherRadioLabel" id="layout_horizontal" style="margin-left:20px;"' . $proFlagsDisabled,
					'no_br'   => true,
					'value'   => 'horizontal',
					'checked' => ( $showFlags && ( isset( $this->data['layout'] ) && ( $this->data['layout'] === 'horizontal' ) ) ) ? 'checked' : '',
				)
			)
		);
		?>
		<span><?php esc_html_e( "Horizontal", 'woo-currency' ) ?><?php echo wp_kses_post( $proFlagsSup ); ?></span>
	</div>
	<div class="wcuWidgetRow">
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'btn_txt_color' ) ); ?>">
			<?php esc_html_e( 'Convert Button Text Color', 'woo-currency' ) ?>
		</label>
		<?php
		htmlWcu::echo_escaped_html(
			htmlWcu::colorpicker(
				$this->widget->get_field_name( 'btn_txt_color' ),
				array(
					'value' => isset( $this->data['btn_txt_color'] ) ? esc_attr( $this->data['btn_txt_color'] ) : '#ffffff',
					'attrs' => 'id="' . esc_attr( $this->widget->get_field_id( 'btn_txt_color' ) ) . '"',
				)
			)
		);
		?>
	</div>
	<div class="wcuWidgetRow">
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'btn_bg_color' ) ); ?>">
			<?php esc_html_e( 'Convert Button Background Color', 'woo-currency' ) ?>
		</label>
		<?php
		htmlWcu::echo_escaped_html(
			htmlWcu::colorpicker(
				$this->widget->get_field_name( 'btn_bg_color' ),
				array(
					'value' => isset( $this->data['btn_bg_color'] ) ? esc_attr( $this->data['btn_bg_color'] ) : '#43454b',
					'attrs' => 'id="' . esc_attr( $this->widget->get_field_id( 'btn_bg_color' ) ) . '"',
				)
			)
		);
		?>
	</div>
	<div class="wcuWidgetRow">
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'btn_bg_color_h' ) ); ?>">
			<?php esc_html_e( 'Convert Button Background Hover Color', 'woo-currency' ) ?>
		</label>
		<?php
		htmlWcu::echo_escaped_html(
			htmlWcu::colorpicker(
				$this->widget->get_field_name( 'btn_bg_color_h' ),
				array(
					'value' => isset( $this->data['btn_bg_color_h'] ) ? esc_attr( $this->data['btn_bg_color_h'] ) : '#ffffff',
					'attrs' => 'id="' . esc_attr( $this->widget->get_field_id( 'btn_bg_color_h' ) ) . '"',
				)
			)
		);
		?>
	</div>
	<div class="wcuWidgetRow">
		<label for="<?php echo esc_attr( $this->widget->get_field_id( 'show_on' ) ); ?>">
			<?php esc_html_e( 'Show on', 'woo-currency' ) ?>
		</label>
		<?php
		htmlWcu::echo_escaped_html(
			htmlWcu::selectbox(
				$this->widget->get_field_name( 'show_on' ),
				array(
					'value'   => isset( $this->data['show_on'] ) ? esc_attr( $this->data['show_on'] ) : 'name',
					'options' => array(
						'both'     => esc_html__( 'both', 'woo-currency' ),
						'desktops' => esc_html__( 'desktops', 'woo-currency' ),
						'mobiles'  => esc_html__( 'mobiles', 'woo-currency' ),
					),
					'attrs'   => 'id="' . esc_attr( $this->widget->get_field_id( 'show_on' ) ) . '"',
				)
			)
		);
		?>
	</div>
	<div class="wcuWidgetRow">
		<?php htmlWcu::echo_escaped_html(
			htmlWcu::checkbox(
				$this->widget->get_field_name( 'show_on_widths' ),
				array(
					'attrs'   => "style='float:left; margin-top: 6px; margin-right:5px;' id='" . esc_attr( $this->widget->get_field_id( 'show_on_widths' ) ) . "' ",
					'value'   => isset( $this->data['show_on_widths'] ) ? '1' : '0',
					'checked' => isset( $this->data['show_on_widths'] ) ? 'checked' : '',
				)
			)
		);
		?>
		<label
			for="<?php echo esc_attr( $this->widget->get_field_id( 'show_on_widths' ) ); ?>"
			style="display: inline-block; float: left; margin-top: 6px;"
		>
			<?php esc_html_e( 'Show on screen widths', 'woo-currency' ) ?>
		</label>
		<?php
		htmlWcu::echo_escaped_html(
			 htmlWcu::selectbox(
				 $this->widget->get_field_name( 'show_on_screen_compare' ),
				 array(
			'value'   => isset( $this->data['show_on_screen_compare'] ) ? esc_attr( $this->data['show_on_screen_compare'] ) : 'name',
			'options' => array(
				'less' => esc_html__( 'less', 'woo-currency' ),
				'more' => esc_html__( 'more', 'woo-currency' ),
			),
			'attrs'   => 'id="' . esc_attr( $this->widget->get_field_id( 'show_on_screen_compare' ) ) . '" style="display: inline-block; float: left; width: 60px; margin-left:3px;"',
		)
			 )
		);
		?>
		<span style="float:left; margin:0px 4px; margin-top:6px;"><?php esc_html_e( 'than', 'woo-currency' ) ?></span>
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
		<span style="margin-left:3px; margin-top:6px; float:left"><?php esc_html_e( 'px', 'woo-currency' ) ?></span>
	</div>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound