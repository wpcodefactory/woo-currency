<?php
/**
 * WBW Currency Switcher for WooCommerce - currency_switcherWcu Class
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

class currency_switcherWcu extends moduleWcu
{
	public function init() {
		parent::init();
		add_action('wp_footer', array($this, 'showModule'));
		add_shortcode(
			WCU_SHORTCODE_FRONTEND_SWITCHER,
			function() {
				$previewOptions = array('shortcode' => true );
				return frameWcu::_()->getModule('currency_switcher')->drawModule(array(), true);
			}
		);
		$proModule = frameWcu::_()->getModule( 'promo' )->getProOptions();
		if ( !empty( $proModule ) ) {
			add_shortcode(
				WCU_SHORTCODE_FRONTEND_SWITCHER_EXTENDED,
				function () {
					return frameWcu::_()->getModule( 'currency_switcher' )->drawModule( true, true, 'extended' );
				}
			);
		}
	}

	/**
	 * showModule.
	 *
	 * @version 2.4.0
	 */
	public function showModule() {
		htmlWcu::echo_escaped_html( $this->drawModule() );
	}

	/**
	 * DIsplay main module functionality
	 *
	 * @param array $previewOptions
	 * @param bool $isShortcode
	 *
	 * @return string
	 */
    public function drawModule($previewOptions = array(), $isShortcode = false, $mode = '' ) {
		if ($previewOptions) {
			$show = true;
        } else {
            $show = frameWcu::_()->getModule('currency')->getShowModule('currency_switcher');
		}

        if ($show) {
            return $this->getView()->getCurrencySwitcher($previewOptions, $isShortcode, $mode);
        } else {
    		return '';
        }
    }
    public function getDefaultOptions() {
        return array(
            'design_tab' => array(
                'enable' => '0',
                'type' => 'floating',
                'design' => 'Classic',
                'toggle_switcher' => 'on_click',
                'show' => 'currency_symbols',
                'icon_size' => 'm',
                'show_flags_simple' => '',
                'show_symbol_rotating' => '0',
				'show_flags_rotating' => '1',
				'show_flags_rotating_pro' => '0',
                'show_flags_floating_order' => '',
                'show_rates_floating_order' => '',
                'switcher_flag_opening_button' => '',
                'layout' => 'horizontal',
                'show_floating_order' => array('name','title','symbol'),
                'side_simple' => 'left',
                'side_floating' => 'left',
                'side_rotating' => 'left',
                'cur_currency_top' => '1',
                'horizontal_offset_desktop' => '0',
                'horizontal_offset_desktop_dimension' => '%',
                'horizontal_offset_mobile' => '0',
                'horizontal_offset_mobile_dimension' => 'px',
                'vertical_offset_desktop' => '50',
                'vertical_offset_desktop_dimension' => '%',
                'vertical_offset_mobile' => '0',
                'vertical_offset_mobile_dimension' => 'px',
                'switcher_opening_button' => 'currency_codes',
                'switcher_opening_button_text' => 'Change currency',
                'switcher_button_show_current' => '0',
                'icon_type' => 'rectangular',
                'icon_spacing' => '0',
                'show_border' => '0',
				'simple_opacity_panel' => '100',
				'floating_opacity_panel' => '100',
				'floating_opacity_button' => '100',
                'border_radius' => '0',
                'border_radius_dimension' => 'px',

				'floating_panel_header_show' => '1',
				'floating_panel_header_text' => 'Choose currency',
				'floating_panel_header_txt_color' => '#ffffff',
				'floating_panel_header_bg_color' => '#1e73be',

				'floating_opening_btn_font' => 'sans-serif',
				'floating_opening_btn_size' => '14',
				'floating_opening_btn_bold' => '1',
				'floating_opening_btn_italic' => '0',

				'floating_panel_header_font' => 'sans-serif',
				'floating_panel_header_size' => '14',
				'floating_panel_header_bold' => '1',
				'floating_panel_header_italic' => '0',

				'floating_panel_txt_font' => 'sans-serif',
				'floating_panel_txt_size' => '14',
				'floating_panel_txt_bold' => '1',
				'floating_panel_txt_italic' => '0',

				'floating_icon_size' => 'm',

                'bor_color' => '#1e73be',
                'txt_color' => '#ffffff',
                'txt_color_h' => '#ffffff',
                'txt_color_cur' => '#ffffff',
                'bg_color' => '#1e73be',
                'bg_color_h' => '#194e9e',
                'bg_color_cur' => '#1a54ad',
                'rot_block_txt_color' => '#ffffff',
                'rot_block_txt_color_h' => '#ffffff',
                'rot_block_txt_color_cur' => '#ffffff',
                'rot_block_bg_color' => '#1e73be',
                'rot_block_bg_color_h' => '#194e9e',
                'rot_block_bg_color_cur' => '#1a54ad',
            ),
            'display_rules_tab' => array(
                'show_on' => 'both',
                'show_on_screen' => '0',
                'show_on_screen_compare' => 'more',
                'show_on_screen_value' => '760',
				'switcher_shortcode_frontend' => '<code>[' . WCU_SHORTCODE_FRONTEND_SWITCHER . ']</code>',
				'switcher_shortcode_frontend_php' => '<code>'.htmlentities("<?php echo do_shortcode('[" . WCU_SHORTCODE_FRONTEND_SWITCHER . "]')?>").'</code>',
                'switcher_shortcode_frontend_extended' => '<code>[' . WCU_SHORTCODE_FRONTEND_SWITCHER_EXTENDED . ']</code>',
                'switcher_shortcode_frontend_extended_php' => '<code>'.htmlentities("<?php echo do_shortcode('[" . WCU_SHORTCODE_FRONTEND_SWITCHER_EXTENDED . "]')?>").'</code>',
                'switcher_shortcode' => '<code>[' . WCU_SHORTCODE_SWITCHER . ']</code>',
                'switcher_shortcode_php' => '<code>'.htmlentities("<?php echo do_shortcode('[" . WCU_SHORTCODE_SWITCHER . "]')?>").'</code>',
                'display_by_default' => 'enable',
                'pages_to_show' => array(),
                'product_categories_to_show' => array(),
                'custom_post_types_to_show' => array(),
				'pages_to_show_checkbox' => '0',
                'product_categories_to_show_checkbox' => '0',
                'custom_post_types_to_show_checkbox' => '0',
	            'show_popup_message' => '0',
            ),
        );
    }

	/**
	 * getOptionsParams.
	 *
	 * @version 2.4.0
	 */
    public function getOptionsParams()
    {
		$fontFamilyList = frameWcu::_()->getModule('currency')->getFontFamilyList();
		$optionsPro = frameWcu::_()->getModule('options_pro');
		$optionsProFlag = frameWcu::_()->getModule('flags');
        $proModule = false;
		$flagModule = false;
        if ( !empty( $optionsPro ) ) {
            $proModule = true;
        }
        if ( !empty( $optionsProFlag ) ) {
            $flagModule = true;
        }
        // to find params description and hooks @see currencyWcu::getOptionsParams
        return array(
            'design_tab' => array(
                'enable' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Currency Switcher allows you to switch the currency of the products according to the selected settings.', 'woo-currency'),
                    'label' => __('Enable switcher', 'woo-currency'),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'type' => array(
                    'html' => 'selectbox',
                    'row_classes' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Select currency switcher type.', 'woo-currency'),
                    'label' => __('Type', 'woo-currency'),
                    'params' => array(
                        'options' => array(
                            'simple' => __('Simple', 'woo-currency'),
                            'floating' => __('Floating', 'woo-currency'),
                            'rotating' => __('Rotating', 'woo-currency'),
                        ),
                        'data-target-toggle' => '.wcuSwEnableDesign, .wcuSwEnablePosition, .wcuSwEnableShow, .wcuSwEnableLayout, .wcuSwEnableCurCurrency, .wcuSwEnableHorizOffset, .wcuSwEnableOpacity, .wcuSwEnableHeader',
                    ),
                ),
                'design' => $proModule ? frameWcu::_()->getModule('options_pro')->getProCsDesign() : array(
                    'html' => 'selectbox',
                    'row_classes' => 'wcuSwOptionsDesign wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'simple',
                    'row_hide' => '',
                    'tooltip' => __('Select design of panel for Currency Switcher Simple.', 'woo-currency'),
                    'label' => __('Design', 'woo-currency').' <sup>PRO</sup>',
                    'params' => array(
                        'value' => 'Classic',
                        'options_attrs' => array(
                            'Dropdown' => "disabled",
                        ),
                        'options' => array(
                            'Classic' => __('Classic', 'woo-currency'),
                            'Dropdown' => __('Dropdown', 'woo-currency').' <sup>PRO</sup>',
                        ),
                        'data-target-toggle' => '.wcuSwEnableSwitcher, .wcuSwEnableOpacitySimple',
                    ),
                ),
                'toggle_switcher' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwOptionsToggleSwitcher wcuSwEnableSwitcher',
                    'row_parent' => 'design',
                    'row_show' => '',
                    'row_hide' => 'Classic',
                    'row_hide_with_all' => true,
                    'tooltip' => __('Show panel by mouse hover or click.', 'woo-currency'),
                    'label' => __('Toggle Switcher', 'woo-currency'),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'on_click' => __('on click', 'woo-currency'),
                            'on_hover' => __('on hover', 'woo-currency'),
							'full_size' => __('full size view', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'on_click' => __('on click', 'woo-currency'),
                            'on_hover' => __('on hover', 'woo-currency'),
							'full_size' => __('full size view', 'woo-currency'),
                        ),
                    ),
                ),
                'cur_currency_top' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableCurCurrency',
                    'row_parent' => 'type',
                    'row_show' => '',
                    'row_hide' => 'simple',
                    'tooltip' => __('Show current currency at the top of the panel.', 'woo-currency'),
                    'label' => __('Move current currency to top', 'woo-currency'),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'show_symbol_rotating' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableShow',
                    'row_parent' => 'type',
                    'row_show' => 'rotating',
                    'tooltip' => __('Show currency symbols in Currency Switcher Rotating.', 'woo-currency'),
                    'label' => __('Show currency symbols', 'woo-currency'),
                ),
				'show_flags_rotating' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableShow',
                    'row_parent' => 'type',
                    'row_show' => !$flagModule ? 'hidden' : 'rotating',
                    'tooltip' => __('Show currency flag in Currency Switcher Rotating.', 'woo-currency'),
                    'label' => __('Show flags in Rotating', 'woo-currency'),
                    'params' => array(
                        'attrs' => !$flagModule ? 'disabled' : '',
                    ),
                ),
				'show_flags_rotating_pro' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableShow',
                    'row_parent' => 'type',
                    'row_show' => $flagModule ? 'hidden' : 'rotating',
                    'tooltip' => __('Show currency flag in Currency Switcher Rotating.', 'woo-currency'),
                    'label' => __('Show flags in Rotating', 'woo-currency').' <sup>PRO</sup>',
                    'params' => array(
                        'attrs' => 'disabled ',
                    ),
                ),
                'show_flags_simple' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableShow',
                    'row_parent' => 'type',
                    'row_show' => $flagModule ? 'hidden' : 'simple',
                    'tooltip' => __('Show currency flag in Currency Switcher Simple.', 'woo-currency'),
                    'label' => __('Show flags in Simple', 'woo-currency').' <sup>PRO</sup>',
                    'params' => array(
                        'attrs' => 'disabled ',
                    ),
                ),
                'show' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnableShow',
                    'row_parent' => 'type',
                    'row_show' => 'simple',
                    'row_hide' => '',
                    'tooltip' => __('Choose your preferred currency display.', 'woo-currency'),
                    'label' => __('Show', 'woo-currency'),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => $flagModule ? array(
                            'flags' => __('Flags', 'woo-currency'),
                            'currency_codes' => __('Currency codes', 'woo-currency'),
                            'currency_symbols' => __('Currency symbols', 'woo-currency'),
                        ) : array(
                            'currency_codes' => __('Currency codes', 'woo-currency'),
                            'currency_symbols' => __('Currency symbols', 'woo-currency'),
                        ),
                        'labeled' => $flagModule ? array(
                            'flags' => __('Flags', 'woo-currency'),
                            'currency_codes' => __('Currency codes', 'woo-currency'),
                            'currency_symbols' => __('Currency symbols', 'woo-currency'),
                        ) : array(
                            'currency_codes' => __('Currency codes', 'woo-currency'),
                            'currency_symbols' => __('Currency symbols', 'woo-currency'),
                        ),
                    ),
                ),
                'show_flags_floating_order' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableShow',
                    'row_parent' => 'type',
                    'row_show' => $flagModule ? 'hidden' : 'floating',
                    'tooltip' => __('Show currency flag in order list for Currency Switcher Floating.', 'woo-currency'),
                    'label' => __('Show flags in order', 'woo-currency').' <sup>PRO</sup>',
                    'params' => array(
                        'attrs' => 'disabled ',
                    ),
                ),
                'show_rates_floating_order' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableShow',
                    'row_parent' => 'type',
                    'row_show' => $proModule ? 'hidden' : 'floating',
                    'tooltip' => __('Show currency rates in order list for Currency Switcher Floating.', 'woo-currency'),
                    'label' => __('Show rates in order', 'woo-currency').' <sup>PRO</sup>',
                    'params' => array(
                        'attrs' => 'disabled ',
                    ),
                ),
                'show_floating_order' => array(
                    'html' => 'selectlistsortable',
                    'row_classes' => 'wcuSwEnableCurCurrency',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'tooltip' => __('Set the display order and what to display in the list.', 'woo-currency'),
                    'label' => __('Show floating order', 'woo-currency'),
                    'params' => array(
                        'id' => 'wcuShowFloatingOrder',
                        'attrs' => 'style="height:130px;"',
                        'options' => $proModule ? frameWcu::_()->getModule('options_pro')->getProCsFloatingOrder() : array(
                            'name' => __('Currency codes', 'woo-currency'),
                            'title' => __('Titles', 'woo-currency'),
                            'symbol' => __('Currency symbols', 'woo-currency'),
                        ),
                    ),
                ),
                'icon_size' => $proModule ? frameWcu::_()->getModule('options_pro')->getProCsIconSize() : array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'simple',
                    'row_hide' => '',
                    'tooltip' => __('Choose icon size for Currency Switcher Simple.', 'woo-currency'),
                    'label' => __('Icon size', 'woo-currency').' <sup>PRO</sup>',
                    'params' => array(
                        'value' => 'm',
                        'attrs' => 'class="wcuSwitcherRadioLabel" disabled',
                        'no_br'	=> true,
                        'options' => array(
                            'proS' => __('S', 'woo-currency'),
                            'm' => __('M', 'woo-currency'),
                            'proL' => __('L', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'proS' => __('S', 'woo-currency'),
                            'm' => __('M', 'woo-currency'),
                            'proL' => __('L', 'woo-currency'),
                        ),
                    ),
                ),
                'layout' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnableLayout',
                    'row_parent' => 'type',
                    'row_show' => 'simple',
                    'row_hide' => '',
                    'tooltip' => __('Choose panel layout design. Set the horizontal и vertical offset value according to the selected position of layout design.', 'woo-currency'),
                    'label' => __('Layout', 'woo-currency'),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'horizontal' => __('Horizontal', 'woo-currency'),
                            'vertical' => __('Vertical', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'horizontal' => __('Horizontal', 'woo-currency'),
                            'vertical' => __('Vertical', 'woo-currency'),
                        ),
                    ),
                ),
                'side_simple' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'simple',
                    'row_hide' => '',
                    'tooltip' => __('Set the horizontal и vertical offset value according to the selected position of layout design', 'woo-currency'),
                    'label' => __('Position', 'woo-currency'),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'left' => __('left', 'woo-currency'),
                            'right' => __('right', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'left' => __('left', 'woo-currency'),
                            'right' => __('right', 'woo-currency'),
                        ),
                    ),
                ),
                'side_rotating' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'rotating',
                    'row_hide' => '',
                    'tooltip' => __('Choose basic position of panel. Set the horizontal and vertical offset value according to the selected position of layout design.', 'woo-currency'),
                    'label' => __('Position', 'woo-currency'),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'left' => __('left', 'woo-currency'),
                            'right' => __('right', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'left' => __('left', 'woo-currency'),
                            'right' => __('right', 'woo-currency'),
                        ),
                    ),
                ),
                'side_floating' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'tooltip' => __('Choose basic position of panel. Set the horizontal and vertical offset value according to the selected position of layout design.', 'woo-currency'),
                    'label' => __('Position', 'woo-currency'),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'left' => __('left', 'woo-currency'),
                            'right' => __('right', 'woo-currency'),
                            'top' => __('top', 'woo-currency'),
                            'bottom' => __('bottom', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'left' => __('left', 'woo-currency'),
                            'right' => __('right', 'woo-currency'),
                            'top' => __('top', 'woo-currency'),
                            'bottom' => __('bottom', 'woo-currency'),
                        ),
                    ),
                ),
                'switcher_flag_opening_button' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableShow',
                    'row_parent' => 'type',
                    'row_show' => $proModule ? 'hidden' : 'floating',
                    'tooltip' => __('Show currency flag in opening button.', 'woo-currency'),
                    'label' => __('Show flags in button', 'woo-currency').' <sup>PRO</sup>',
                    'params' => array(
                        'attrs' => 'disabled ',
                    ),
                ),
                'switcher_opening_button' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnableDesign hideIfFullSizeView',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'inrow' => 'open',
                    'tooltip' => __('Choose your preferred currency display.', 'woo-currency'),
                    'label' => __('Switcher opening button', 'woo-currency'),
                    'params' => $proModule ? frameWcu::_()->getModule('options_pro')->getProCsFloatingOpeningButton() : array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array (
                            'currency_codes' => __('currency codes', 'woo-currency'),
                            'currency_symbols' => __('currency symbols', 'woo-currency'),
                            'text' => __('text', 'woo-currency'),
                        ),
                        'labeled' => array (
                            'currency_codes' => __('currency codes', 'woo-currency'),
                            'currency_symbols' => __('currency symbols', 'woo-currency'),
                            'text' => __('text', 'woo-currency'),
                        ),
                    ),
                ),
                'switcher_opening_button_text' => array(
                    'html' => 'input',
                    'row_classes' => 'wcuSwEnableDesign hideIfFullSizeView',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel" ',
                        'attrs' => 'class="wcuSwitcherInput" style="width:200px;"',
                    ),
                ),

				'floating_opening_btn_font' => array(
					'html' => 'selectbox',
					'row_classes' => 'wcuSwEnablePosition hideIfFullSizeView',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'open',
					'tooltip' => __('Select switcher opening button font setting.', 'woo-currency'),
					'label' => __('Switcher opening button font setting', 'woo-currency'),
					'params' => array(
						'attrs' => "style='width:100px'",
						'options' => $fontFamilyList,
					),
				),
				'floating_opening_btn_size' => array(
					'html' => 'input',
					'row_classes' => 'wcuSwEnablePosition hideIfFullSizeView',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'label_attrs' => 'class="wcuSwitcherInputLabel"',
						'attrs' => 'class="wcuSwitcherInput"',
						'labeled' => __('px', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),
				'floating_opening_btn_bold' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuSwEnablePosition hideIfFullSizeView',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'value' => '1',
						'labeled' => '&emsp;'.__('Bold', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),
				'floating_opening_btn_italic' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuSwEnablePosition hideIfFullSizeView',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'close',
					'params' => array(
						'value'=>'1',
						'labeled' => '&emsp;'.__('Italic', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),

				'floating_icon_size' => array(
                    'html' => 'radiobuttons',
					'row_classes' => 'wcuSwEnablePosition hideIfFullSizeView',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
                    'tooltip' => __('Choose size for opening button.', 'woo-currency'),
                    'label' => __('Panel opening button size', 'woo-currency'),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel" ',
                        'no_br'	=> true,
                        'options' => array(
                            's' => __('S', 'woo-currency'),
                            'm' => __('M', 'woo-currency'),
                            'l' => __('L', 'woo-currency'),
                        ),
                        'labeled' => array(
                            's' => __('S', 'woo-currency'),
                            'm' => __('M', 'woo-currency'),
                            'l' => __('L', 'woo-currency'),
                        ),
                    ),
                ),

                'switcher_button_show_current' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => 'wcuSwEnableDesign hideIfFullSizeView',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'tooltip' => __('Show only current currency in opening button.', 'woo-currency'),
                    'label' => __('Show current currency only', 'woo-currency'),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'horizontal_offset_desktop' => array(
                    'html' => 'input',
                    'row_classes' => 'wcuSwEnableHorizOffset',
                    'row_parent' => 'type',
                    'row_show' => '',
                    'row_hide' => 'rotating',
                    'inrow' => 'open',
                    'tooltip' => __('Change horizontal panel offset (only for top and bottom positions if type Floating or Rotating)', 'woo-currency'),
                    'label' => __('Horizontal offset', 'woo-currency'),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('desktop', 'woo-currency'),
                    ),
                ),
                'horizontal_offset_desktop_dimension' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnableHorizOffset',
                    'row_parent' => 'type',
                    'row_show' => '',
                    'row_hide' => 'rotating',
                    'inrow' => 'middle',
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                    ),
                ),
                'horizontal_offset_mobile' => array(
                    'html' => 'input',
                    'row_classes' => 'wcuSwEnableHorizOffset',
                    'row_parent' => 'type',
                    'row_show' => '',
                    'row_hide' => 'rotating',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_attrs' => 'style="margin-left:30px;" class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('mobile', 'woo-currency'),
                    ),
                ),
                'horizontal_offset_mobile_dimension' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnableHorizOffset',
                    'row_parent' => 'type',
                    'row_show' => '',
                    'row_hide' => 'rotating',
                    'inrow' => 'close',
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                    ),
                ),
                'vertical_offset_desktop' => array(
                    'html' => 'input',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'open',
                    'label' => __('Vertical offset', 'woo-currency'),
                    'tooltip' => __('Change vertical panel offset (only for left and right positions if type Floating or Rotating)', 'woo-currency'),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('desktop', 'woo-currency'),
                    ),
                ),
                'vertical_offset_desktop_dimension' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),

                    ),
                ),
                'vertical_offset_mobile' => array(
                    'html' => 'input',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_attrs' => 'style="margin-left:30px;" class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('mobile', 'woo-currency'),
                    ),
                ),
                'vertical_offset_mobile_dimension' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                    ),
                ),
                'icon_type' => $proModule ? frameWcu::_()->getModule('options_pro')->getProCsIconType() : array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'wcuSwEnableDesign wcuHidden',
                    'row_parent' => 'type',
                    'row_show' => 'simple',
                    'row_hide' => '',
                    'tooltip' => __('Choose design of currency switcher blocks.', 'woo-currency'),
                    'label' => __('Icon type', 'woo-currency').' <sup>PRO</sup>',
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel" disabled',
                        'value' => 'rectangular',
                        'no_br'	=> true,
                        'options' => array(
                            'rectangular' => __('rectangular', 'woo-currency'),
                            //'circleicon' => __('circle', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'rectangular' => __('rectangular', 'woo-currency'),
                            //'circleicon' => __('circle', 'woo-currency'),
                        ),
                        'data-target-toggle' => '.wcuSwDisableIconType',
                    ),
                ),
                'icon_spacing' => array(
                    'html' => 'input',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'simple',
                    'row_hide' => '',
                    'tooltip' => __('Set the distance between currency blocks (margin)', 'woo-currency'),
                    'label' => __('Icon spacing', 'woo-currency'),
                    'params' => array(
                        'labeled_right' => true,
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput" style="margin-left:0px"',
                        'labeled' => __('px ', 'woo-currency'),
                    ),
                ),
				'simple_opacity_panel' => array(
                    'html' => 'input',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => '',
                    'row_hide' => 'floating',
                    'tooltip' => __('Change the level of transparency for the panel.', 'woo-currency'),
                    'label' => __('Transparent', 'woo-currency'),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('panel', 'woo-currency'),
						'placeholder' => '0 - 100',
                    ),
                ),
				'floating_opacity_panel' => array(
                    'html' => 'input',
					'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'inrow' => 'open',
                    'tooltip' => __('Change the level of transparency for the panel and opening button.', 'woo-currency'),
                    'label' => __('Transparent', 'woo-currency'),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('panel', 'woo-currency'),
						'placeholder' => '0 - 100',
                    ),
                ),
				'floating_opacity_button' => array(
                    'html' => 'input',
					'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'label' => __('Transparent', 'woo-currency'),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('button', 'woo-currency'),
						'placeholder' => '0 - 100',
                    ),
                ),
                'show_border' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => '',
                    'row_show' => 'all',
                    'row_hide' => '',
                    'tooltip' => __('Show panel outer border.', 'woo-currency'),
                    'label' => __('Show border', 'woo-currency'),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'border_radius' => array(
                    'html' => 'input',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'simple',
                    'row_hide' => '',
                    'inrow' => 'open',
                    'tooltip' => __('Set panel border-radius.', 'woo-currency'),
                    'label' => __('Border-radius', 'woo-currency'),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput" style="margin-left:0px"',
                    ),
                ),
                'border_radius_dimension' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                        'labeled' => array(
                            'px' => __('px', 'woo-currency'),
                            '%' => __('%', 'woo-currency'),
                        ),
                    ),
                ),
                'bor_color' => array(
                    'html' => 'colorpicker',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose panel border color.', 'woo-currency'),
                    'label' => __('Border color', 'woo-currency'),
                ),
				'floating_panel_header_show' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'tooltip' => __('Show panel title.', 'woo-currency'),
                    'label' => __('Show header', 'woo-currency'),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
				'floating_panel_header_text' => array(
                    'html' => 'input',
					'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'tooltip' => __('Type your text for panel title.', 'woo-currency'),
					'label' => __('Panel header text', 'woo-currency'),
                    'params' => array(
                        'attrs' => 'style="width:200px;"',
                    ),
                ),
				'floating_panel_header_txt_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'tooltip' => __('Choose text color for panel title.', 'woo-currency'),
                    'label' => __('Panel header text color', 'woo-currency'),
                ),
				'floating_panel_header_bg_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
                    'row_hide' => '',
                    'tooltip' => __('Choose background color for panel title.', 'woo-currency'),
                    'label' => __('Panel header background color', 'woo-currency'),
                ),



				'floating_panel_header_font' => array(
					'html' => 'selectbox',
					'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'open',
					'tooltip' => __('Select panel header font setting.', 'woo-currency'),
					'label' => __('Panel header font setting', 'woo-currency'),
					'params' => array(
						'attrs' => "style='width:100px'",
						'options' => $fontFamilyList,
					),
				),
				'floating_panel_header_size' => array(
					'html' => 'input',
					'row_classes' => 'wcuSwEnablePosition',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'label_attrs' => 'class="wcuSwitcherInputLabel"',
						'attrs' => 'class="wcuSwitcherInput"',
						'labeled' => __('px', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),
				'floating_panel_header_bold' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuSwEnablePosition',
                    'row_parent' => 'type',
                    'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'value' => '1',
						'labeled' => '&emsp;'.__('Bold', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),
				'floating_panel_header_italic' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuSwEnablePosition',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'close',
					'params' => array(
						'value'=>'1',
						'labeled' => '&emsp;'.__('Italic', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),

				'floating_panel_txt_font' => array(
					'html' => 'selectbox',
					'row_classes' => 'wcuSwEnablePosition',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'open',
					'tooltip' => __('Select panel text font setting.', 'woo-currency'),
					'label' => __('Panel text font setting', 'woo-currency'),
					'params' => array(
						'attrs' => "style='width:100px'",
						'options' => $fontFamilyList,
					),
				),
				'floating_panel_txt_size' => array(
					'html' => 'input',
					'row_classes' => 'wcuSwEnablePosition',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'label_attrs' => 'class="wcuSwitcherInputLabel"',
						'attrs' => 'class="wcuSwitcherInput"',
						'labeled' => __('px', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),
				'floating_panel_txt_bold' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuSwEnablePosition',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'value' => '1',
						'labeled' => '&emsp;'.__('Bold', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),
				'floating_panel_txt_italic' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuSwEnablePosition',
					'row_parent' => 'type',
					'row_show' => 'floating',
					'row_hide' => '',
					'inrow' => 'close',
					'params' => array(
						'value'=>'1',
						'labeled' => '&emsp;'.__('Italic', 'woo-currency').'&emsp;',
						'labeled_right' => true,
					),
				),

                'txt_color' => array(
                    'html' => 'colorpicker',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose panel text color.', 'woo-currency'),
                    'label' => __('Text color', 'woo-currency'),
                    'inrow' => 'open',
                    'params' => array(
                        'label_before' => __('static', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'txt_color_h' => array(
                    'html' => 'colorpicker',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_before' => __('hover', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'txt_color_cur' => array(
                    'html' => 'colorpicker',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_before' => __('selected', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'bg_color' => array(
                    'html' => 'colorpicker',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose panel background color.', 'woo-currency'),
                    'label' => __('Background color', 'woo-currency'),
                    'inrow' => 'open',
                    'params' => array(
                        'label_before' => __('static', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'bg_color_h' => array(
                    'html' => 'colorpicker',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_before' => __('hover', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'bg_color_cur' => array(
                    'html' => 'colorpicker',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_before' => __('selected', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'rot_block_txt_color' => array(
                    'html' => 'colorpicker',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'rotating',
                    'row_hide' => '',
                    'tooltip' => __('Choose rotating block text color.', 'woo-currency'),
                    'label' => __('Rotating block text color', 'woo-currency'),
                    'inrow' => 'open',
                    'params' => array(
                        'label_before' => __('static', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'rot_block_txt_color_h' => array(
                    'html' => 'colorpicker',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'rotating',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_before' => __('hover', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'rot_block_txt_color_cur' => array(
                    'html' => 'colorpicker',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'rotating',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_before' => __('selected', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'rot_block_bg_color' => array(
                    'html' => 'colorpicker',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'rotating',
                    'row_hide' => '',
                    'tooltip' => __('Choose rotating block background color.', 'woo-currency'),
                    'label' => __('Rotating block background color', 'woo-currency'),
                    'inrow' => 'open',
                    'params' => array(
                        'label_before' => __('static', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'rot_block_bg_color_h' => array(
                    'html' => 'colorpicker',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'rotating',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_before' => __('hover', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'rot_block_bg_color_cur' => array(
                    'html' => 'colorpicker',
                    'row_classes' => 'wcuSwEnableDesign',
                    'row_parent' => 'type',
                    'row_show' => 'rotating',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_before' => __('selected', 'woo-currency'),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
            ),
            'display_rules_tab' => array(
                'show_on' => array(
                    'html' => 'selectbox',
                    'row_classes' => '',
                    'row_show' => 'all',
                    'row_hide' => '',
                    'tooltip' => __('Select the devices on which the panel should be displayed.', 'woo-currency'),
                    'label' => __('Show on', 'woo-currency'),
                    'params' => array(
                        'options' => array(
                            'both' => __('Mobile and Desktop', 'woo-currency'),
                            'mobiles' => __('mobiles', 'woo-currency'),
                            'desktops' => __('desktops', 'woo-currency'),
                        ),
                        'data-target-toggle' => '.wcuSwEnable, .wcuSwRotating',
                    ),
                ),
                'show_on_screen' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => '',
                    'row_show' => 'all',
                    'row_hide' => '',
                    'inrow' => 'open',
                    'tooltip' => __('If this option is selected, the panel will be displayed only under the selected conditions.', 'woo-currency'),
                    'label' => __('Show on screen size', 'woo-currency'),
                    'attrs' => 'style="margin-right: 10px;"',
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'show_on_screen_compare' => array(
                    'html' => 'selectbox',
                    'row_classes' => '',
                    'row_show' => 'all',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'label' => __('Show on', 'woo-currency'),
                    'params' => array(
                        'options' => array(
                            'less' => __('less', 'woo-currency'),
                            'more' => __('more', 'woo-currency'),
                        ),
                        'labeled_before' => '&emsp;'.__('width', 'woo-currency'),
                        'labeled_after' => __('than', 'woo-currency'),
                        'attrs' => 'style="margin:0px 20px; width:80px;"',
                        'data-target-toggle' => '.wcuSwEnable, .wcuSwRotating',
                    ),
                ),
				'show_on_screen_value' => array(
                    'html' => 'input',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_attrs' => 'style="" class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('px', 'woo-currency'),
                        'labeled_right' => true,
                    ),
                ),
                'display_by_default' => array(
                    'html' => 'selectbox',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => 'all',
                    'row_hide' => '',
                    'tooltip' => __('Select pages from the list on which you want to display the panel or select "Enable" to display the panel on each page.', 'woo-currency'),
                    'label' => __('Display everywhere', 'woo-currency'),
                    'attrs' => 'style="margin-right: 10px;"',
                    'params' => array(
                        'options' => array(
                            'enable' => __('Enable', 'woo-currency'),
                            'disable' => __('Disable', 'woo-currency'),
                        ),
                    ),
                ),
				'pages_to_show_checkbox' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'tooltip' => __('Select pages from the list on which you want to hide or display module. If you turn Display everywhere on - module will be hidden on selected pages. If Display everywhere off - module will be displayed only on the selected pages.', 'woo-currency'),
					'inrow' => 'open',
                    'label' => __('Pages', 'woo-currency'),
					'attrs' => 'style="margin-right: 10px;"',
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
				'pages_to_show' => array(
                    'html' => 'selectlist',
					'row_classes' => 'wcuToShowSelectList',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'inrow' => 'close',
                    'label' => __('Pages', 'woo-currency'),
                    'params' => array(
                        'options' => frameWcu::_()->getModule('currency')->getAllPagesListForSelectByType('page'),
                    ),
                ),
				'product_categories_to_show_checkbox' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'tooltip' => __('Select product categories from the list on which you want to hide or display module. If you turn Display everywhere on - module will be hidden on selected pages. If Display everywhere off - module will be displayed only on the selected pages.', 'woo-currency'),
					'inrow' => 'open',
                    'label' => __('Product categories', 'woo-currency'),
					'attrs' => 'style="margin-right: 10px;"',
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'product_categories_to_show' => array(
                    'html' => 'selectlist',
					'row_classes' => 'wcuToShowSelectList',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'close',
                    'label' => __('Product categories', 'woo-currency'),
                    'params' => array(
                        'options' => frameWcu::_()->getModule('currency')->getAllProductCategories(),
                    ),
                ),
				'custom_post_types_to_show_checkbox' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'tooltip' => __('Custom post type from the list on which you want to hide or display module. If you turn Display everywhere on - module will be hidden on selected pages. If Display everywhere off - module will be displayed only on the selected pages.', 'woo-currency'),
					'inrow' => 'open',
                    'label' => __('Custom post types', 'woo-currency'),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'custom_post_types_to_show' => array(
                    'html' => 'selectlist',
					'row_classes' => 'wcuToShowSelectList',
					'row_parent' => '',
					'row_show' => '',
                    'row_hide' => '',
					'inrow' => 'close',
                    'label' => __('Custom post types', 'woo-currency'),
                    'params' => array(
                        'options' => frameWcu::_()->getModule('currency')->getAllPostTypes(),
                    ),
                ),
	            'show_popup_message' => $proModule && method_exists(frameWcu::_()->getModule('options_pro'), 'getProShowPopupSwitcherMessage') ? frameWcu::_()->getModule('options_pro')->getProShowPopupSwitcherMessage() : array(
		            'html' => 'checkboxHiddenVal',
		            'row_classes' => '',
		            'row_show' => '',
		            'row_hide' => '',
		            'tooltip' => __('Show popup message "Do you want change currency?". Read more in the <a href="https://woobewoo.com/documentation/currency-switcher-mode/">documentation</a>.', 'woo-currency'),
		            'label' => sprintf(
		                /* Translators: %s: Option. */
			            __(
				            'Show popup message for switcher <sup>PRO</sup> %s',
				            'woo-currency'
			            ),
			            $proModule ?
				            (
								method_exists(
									frameWcu::_()->getModule('options_pro'),
				            'getProShowPopupSwitcherMessage'
								) ?
								'' :
								__( '(since version 1.4.0)', 'woo-currency' )
				            ) :
				            ''
		            ),
		            'params' => array(
			            'value'=>'1',
			            'attrs' => 'disabled',
		            ),
	            ),
				'switcher_shortcode_frontend' => array(
                    'html' => 'block',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'tooltip' => __('The shortcode can take parameters, read more in the documentation.', 'woo-currency'),
                    'label' => __('Shortcode', 'woo-currency'),
                ),
				'switcher_shortcode_frontend_php' => array(
                    'html' => 'block',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'tooltip' => __('The shortcode can take parameters, read more in the documentation.', 'woo-currency'),
                    'label' => __('PHP Shortcode', 'woo-currency'),
                ),
                'switcher_shortcode_frontend_extended' => array(
                    'html' => 'block',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => sprintf(
                        /* translators: %s: Image URL. */
	                    __(
		                    '<p>The shortcode can take parameters, read more in the documentation.</p> <img src="%s" />',
		                    'woo-currency'
	                    ),
	                    WCU_IMG_PATH . 'switcher-extended.png'
                    ),
                    'label' => __('Shortcode extended <sup>PRO</sup>', 'woo-currency'),
                ),
				'switcher_shortcode_frontend_extended_php' => array(
                    'html' => 'block',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => sprintf(
                        /* translators: %s: Image URL. */
	                    __(
		                    '<p>The shortcode can take parameters, read more in the documentation.</p> <img src="%s" />',
		                    'woo-currency'
	                    ),
	                    WCU_IMG_PATH . 'switcher-extended.png'
                    ),
                    'label' => __('PHP Shortcode extended <sup>PRO</sup>', 'woo-currency'),
                ),
                'switcher_shortcode' => array(
                    'html' => 'block',
                    'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Display frontend switcher with view like widget analog. The shortcode can take parameters, read more in the documentation.', 'woo-currency'),
                    'label' => __('Shortcode (widget verstion)', 'woo-currency'),
                ),
                'switcher_shortcode_php' => array(
                    'html' => 'block',
                    'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('The shortcode can take parameters, read more in the documentation.', 'woo-currency'),
                    'label' => __('PHP Shortcode (widget version)', 'woo-currency'),
                ),
            ),
        );
    }

    public function getCurrencyModule() {
        return frameWcu::_()->getModule('currency');
    }
}
