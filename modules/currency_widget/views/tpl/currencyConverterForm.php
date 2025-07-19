<script type="text/javascript">
	g_wcuCurrencyConverterBtnBgColorTimeoutSet = false;
	g_wcuCurrencyConverterBtnBgColorLast = '';
	g_wcuCurrencyConverterBtnTxtColorTimeoutSet = false;
	g_wcuCurrencyConverterBtnTxtColorLast = '';
	g_wcuCurrencyConverterBtnBgColorHTimeoutSet = false;
	g_wcuCurrencyConverterBtnBgColorHLast = '';
	function wpColorPicker_widget_wcucurrencyconverterwidget3btn_bg_color_change(event, ui) {
		g_wcuCurrencyConverterBtnBgColorLast = ui.color.toString();
		if(!g_wcuCurrencyConverterBtnBgColorTimeoutSet) {
			setTimeout(function(){
				jQuery(event.target).parents('form:first').trigger('change');
			}, 500);
			g_wcuCurrencyConverterBtnBgColorTimeoutSet = true;
		}
	}
	function wpColorPicker_widget_wcucurrencyconverterwidget3btn_txt_color_change(event, ui) {
		g_wcuCurrencyConverterBtnTxtColorLast = ui.color.toString();
		if(!g_wcuCurrencyConverterBtnTxtColorTimeoutSet) {
			setTimeout(function(){
				jQuery(event.target).parents('form:first').trigger('change');
			}, 500);
			g_wcuCurrencyConverterBtnTxtColorTimeoutSet = true;
		}
	}
	function wpColorPicker_widget_wcucurrencyconverterwidget3btn_bg_color_h_change(event, ui) {
		g_wcuCurrencyConverterBtnBgColorHLast = ui.color.toString();
		if(!g_wcuCurrencyConverterBtnBgColorHTimeoutSet) {
			setTimeout(function(){
				jQuery(event.target).parents('form:first').trigger('change');
			}, 500);
			g_wcuCurrencyConverterBtnBgColorHTimeoutSet = true;
		}
	}
</script>
<?php
	$showFlags = false;
	if (!empty(frameWcu::_()->getModule('flags'))) {
		$showFlags = true;
	}
	$proFlagsDisabled = !$showFlags ? 'disabled' : '' ;
	$proFlagsSup =  !$showFlags ? '<sup>PRO</sup>' : '' ;
?>
<div class="wcuWidgetRow" style="margin-top:20px;">
	<label for="<?php echo $this->widget->get_field_id('title'); ?>"><?php _e('Title', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::input($this->widget->get_field_name('title'), array(
		'type' => 'text',
		'value' => isset($this->data['title']) ? $this->data['title'] : '',
		'attrs' => 'id="'. $this->widget->get_field_id('title'). '"',
	));?>
</div>
<div class="wcuWidgetRow">
	<label for="<?php echo $this->widget->get_field_id('width'); ?>"><?php _e('Width', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::input($this->widget->get_field_name('width'), array(
		'type' => 'text',
		'value' => isset($this->data['width']) ? $this->data['width'] : '100%',
		'attrs' => 'id="'. $this->widget->get_field_id('width'). '"',
	));?>
	<br /><i><?php _e('for example: 200px, 100%, auto', WCU_LANG_CODE)?></i>
</div>
<div class="wcuWidgetRow">
	<label for="<?php echo $this->widget->get_field_id('currency_display'); ?>"><?php _e('Currency Dropdown Options Text', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::selectbox($this->widget->get_field_name('currency_display'), array(
		'value' => isset($this->data['currency_display']) ? $this->data['currency_display'] : 'name',
		'options' => array(
			'name' => __('Currency code', WCU_LANG_CODE),
			'title' => __('Currency title', WCU_LANG_CODE),
		),
		'attrs' => 'id="'. $this->widget->get_field_id('currency_display'). '"',
	));?>
	<br /><i><?php _e("set the currency's display name for currencies dropdown list", WCU_LANG_CODE)?></i>
</div>
<div class="wcuWidgetRow" style="margin-bottom:0px;">
	<?php echo htmlWcu::checkbox($this->widget->get_field_name('show_flag_dropdown'), array(
		'attrs' => "style='float:left; margin-top:0px; margin-right:5px;' id='" . $this->widget->get_field_id('show_flag_dropdown') . "' ".$proFlagsDisabled." ",
		'value' => ($showFlags && isset($this->data['show_flag_dropdown'])) ?  '1'  : '0',
		'checked' => ($showFlags && isset($this->data['show_flag_dropdown'])) ? 'checked' : '',
	));?>
	<label for="<?php echo $this->widget->get_field_id('show_flag_dropdown'); ?>"><?php _e('show flag in dropdown', WCU_LANG_CODE) ?> <?php echo $proFlagsSup ?></label>
</div>
<div class="wcwuWidgetRow">
	<label for="<?php echo $this->widget->get_field_id('exclude'); ?>"><?php _e('Excluded currencies', WCU_LANG_CODE) ?></label><br>
	<?php echo htmlWcu::selectlist($this->widget->get_field_name('exclude'), array(
		'value' => isset($this->data['exclude']) ? $this->data['exclude'] : '',
		'attrs' => 'style="width:100%;" id="'. $this->widget->get_field_id('exclude'). '"',
		'options' => frameWcu::_()->getModule('currency')->getCurrencyCodes(),
	));?>
	<br /><i><?php _e("The selected currency will not be displayed in the list of switches. Press CTRL + CLICK to toggle select.", WCU_LANG_CODE)?></i>
</div>
<br />
<div class="wcuWidgetRow">
	<label style="margin-bottom:10px;" for="<?php echo $this->widget->get_field_id('layout'); ?>"><?php _e('Layout', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::radiobutton($this->widget->get_field_name('layout'), array(
		'attrs' => 'class="wcuSwitcherRadioLabel" id="layout_vertical" ',
		'no_br'	=> true,
		'value' => 'vertical',
		'checked' => ( !$showFlags || ( isset($this->data['layout']) && ($this->data['layout'] === 'vertical') ) ) ? 'checked' : '',
	));?>
	<span><?php _e("Vertical", WCU_LANG_CODE)?></span>
	<?php echo htmlWcu::radiobutton($this->widget->get_field_name('layout'), array(
		'attrs' => 'class="wcuSwitcherRadioLabel" id="layout_horizontal" style="margin-left:20px;"'.$proFlagsDisabled,
		'no_br'	=> true,
		'value' => 'horizontal',
		'checked' => ( $showFlags && ( isset($this->data['layout']) && ($this->data['layout'] === 'horizontal') ) ) ? 'checked' : '',
	));?>
	<span><?php _e("Horizontal", WCU_LANG_CODE)?> <?php echo $proFlagsSup?></span>
</div>
<div class="wcuWidgetRow">
	<label for="<?php echo $this->widget->get_field_id('btn_txt_color'); ?>"><?php _e('Convert Button Text Color', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::colorpicker($this->widget->get_field_name('btn_txt_color'), array(
		'value' => isset($this->data['btn_txt_color']) ? $this->data['btn_txt_color'] : '#ffffff',
		'attrs' => 'id="'. $this->widget->get_field_id('btn_txt_color'). '"',
	));?>
</div>
<div class="wcuWidgetRow">
	<label for="<?php echo $this->widget->get_field_id('btn_bg_color'); ?>"><?php _e('Convert Button Background Color', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::colorpicker($this->widget->get_field_name('btn_bg_color'), array(
		'value' => isset($this->data['btn_bg_color']) ? $this->data['btn_bg_color'] : '#43454b',
		'attrs' => 'id="'. $this->widget->get_field_id('btn_bg_color'). '"',
	));?>
</div>
<div class="wcuWidgetRow">
	<label for="<?php echo $this->widget->get_field_id('btn_bg_color_h'); ?>"><?php _e('Convert Button Background Hover Color', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::colorpicker($this->widget->get_field_name('btn_bg_color_h'), array(
		'value' => isset($this->data['btn_bg_color_h']) ? $this->data['btn_bg_color_h'] : '#ffffff',
		'attrs' => 'id="'. $this->widget->get_field_id('btn_bg_color_h'). '"',
	));?>
</div>
<div class="wcuWidgetRow">
	<label for="<?php echo $this->widget->get_field_id('show_on'); ?>"><?php _e('Show on', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::selectbox($this->widget->get_field_name('show_on'), array(
		'value' => isset($this->data['show_on']) ? $this->data['show_on'] : 'name',
		'options' => array(
			'both' => __('both', WCU_LANG_CODE),
			'desktops' => __('desktops', WCU_LANG_CODE),
			'mobiles' => __('mobiles', WCU_LANG_CODE),
		),
		'attrs' => 'id="'. $this->widget->get_field_id('show_on'). '"',
	));?>
</div>
<div class="wcuWidgetRow">
	<?php echo htmlWcu::checkbox($this->widget->get_field_name('show_on_widths'), array(
		'attrs' => "style='float:left; margin-top: 6px; margin-right:5px;' id='" . $this->widget->get_field_id('show_on_widths') . "' ",
		'value' => isset($this->data['show_on_widths']) ?  '1'  : '0',
		'checked' => isset($this->data['show_on_widths']) ? 'checked' : '',
	));?>
	<label for="<?php echo $this->widget->get_field_id('show_on_widths'); ?>" style="display: inline-block; float: left; margin-top: 6px;"><?php _e('Show on screen widths', WCU_LANG_CODE) ?></label>
	<?php echo htmlWcu::selectbox($this->widget->get_field_name('show_on_screen_compare'), array(
		'value' => isset($this->data['show_on_screen_compare']) ? $this->data['show_on_screen_compare'] : 'name',
		'options' => array(
			'less' => __('less', WCU_LANG_CODE),
			'more' => __('more', WCU_LANG_CODE),
		),
		'attrs' => 'id="'. $this->widget->get_field_id('show_on_screen_compare'). '" style="display: inline-block; float: left; width: 60px; margin-left:3px;"',
	));?>
	<span style="float:left; margin:0px 4px; margin-top:6px;"><?php echo __('than', WCU_LANG_CODE)?></span>
	<?php echo htmlWcu::input($this->widget->get_field_name('show_on_widths_value'), array(
		'type' => 'text',
		'value' => isset($this->data['show_on_widths_value']) ? $this->data['show_on_widths_value'] : '',
		'attrs' => 'id="'. $this->widget->get_field_id('show_on_widths_value'). '"'. '" style="display: inline-block; float: left; width: 60px; "',
	));?>
	<span style="margin-left:3px; margin-top:6px; float:left"><?php echo __('px', WCU_LANG_CODE)?></span>
</div>
