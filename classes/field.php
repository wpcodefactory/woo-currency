<?php
/**
 * WBW Currency Switcher for WooCommerce - fieldWcu Class
 *
 * @author woobewoo
 *
 * @version 2.4.0
 */

defined( 'ABSPATH' ) || exit;

class fieldWcu {

	public $name        = '';
	public $html        = '';
	public $type        = '';
	public $default     = '';
	public $value       = '';
	public $label       = '';
	public $maxlen      = 0;
	public $id          = 0;
	public $htmlParams  = array();
	public $validate    = array();
	public $description = '';

	/**
	 * Whether or not add error html element right after input field
	 * if bool - will be added standard element
	 * if string - it will be add this string
	 */
	public $errorEl = false;

	/**
	 * Name of method in table object to prepare data before insert / update operations
	 */
	public $adapt = array('htmlWcu' => '', 'dbFrom' => '', 'dbTo' => '');

	/**
	 * Init database field representation
	 * @param string $html html type of field (text, textarea, etc. @see html class)
	 * @param string $type database type (int, varchar, etc.)
	 * @param mixed $default default value for this field
	 */
	public function __construct($name, $html = 'text', $type = 'other', $default = '', $label = '', $maxlen = 0, $adaption = array(), $validate = '', $description = '') {
		$this->name = $name;
		$this->html = $html;
		$this->type = $type;
		$this->default = $default;
		$this->value = $default;    //Init field value same as default
		$this->label = $label;
		$this->maxlen = $maxlen;
		$this->description = $description;
		if($adaption)
			$this->adapt = $adaption;
		if($validate) {
			$this->setValidation($validate);
		}
		if($type == 'varchar' && !empty($maxlen) && !in_array('validLen', $this->validate)) {
			$this->addValidation('validLen');
		}
	}

	/**
	 * @param mixed $errorEl - if bool and "true" - than we will use standard error element, if string - we will use this string as error element
	 */
	public function setErrorEl($errorEl) {
		$this->errorEl = $errorEl;
	}

	public function getErrorEl() {
		return $this->errorEl;
	}

	public function setValidation($validate) {
		if(is_array($validate))
			$this->validate = $validate;
		else {
			if(strpos($validate, ','))
				$this->validate = array_map('trim', explode(',', $validate));
			else
				$this->validate = array(trim($validate));
		}
	}

	public function addValidation($validate) {
		$this->validate[] = $validate;
	}

	/**
	 * Set $value property.
	 * Sure - it is public and can be set directly, but it can be more
	 * comfortable to use this method in future
	 * @param mixed $value value to be set
	 */
	public function setValue($value, $fromDB = false) {
		if(isset($this->adapt['dbFrom']) && $this->adapt['dbFrom'] && $fromDB)
			$value = fieldAdapterWcu::_($value, $this->adapt['dbFrom'], fieldAdapterWcu::DB);
		$this->value = $value;
	}

	public function setLabel($label) {
		$this->label = $label;
	}

	public function setHtml($html) {
		$this->html = $html;
	}

	public function getHtml() {
		return $this->html;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function getValue() {
		return $this->value;
	}

	public function getLabel() {
		return $this->label;
	}

	public function setID($id) {
		$this->id = $id;
	}

	public function getID() {
		return $this->id;
	}

	public function setAdapt($adapt) {
		$this->adapt = $adapt;
	}

	/**
	 * drawHtml.
	 *
	 * @version 2.4.0
	 */
	public function drawHtml($tag, $id) {
		if(method_exists('htmlWcu', $this->html)) {
			$method = $this->html;
			if(!empty($this->value))
				$this->htmlParams['value'] = $this->value;
			if ($method == 'checkbox') {
				if ($this->value == 1) {
					$this->htmlParams['checked'] = 1;
				}
			}
			if($this->adapt['html']) {
				fieldAdapterWcu::_($this, $this->adapt['html'], fieldAdapterWcu::HTML);
			}
			$params = $this->processParams($tag, $id);
			if ($params != '')
				return $params;
			if ($this->name == 'default_value') {
				$optionsFromDb = frameWcu::_()->getModule('optionsWcu')->getHelper()->getOptions($id);
				if (!empty($optionsFromDb)) {
					$options = array(0 => __('Select', 'woo-currency'));
					foreach($optionsFromDb as $k => $v)
						$options[$k] = $v;
					$method = 'selectbox';
					$this->htmlParams['optionsWcu'] = $options;
				}
			}
			$htmlContent = htmlWcu::$method($this->name, $this->htmlParams);
			if(!empty($this->errorEl)) {
				if(is_bool($this->errorEl))
					$errorEl = '<div class="toeErrorForField toe_'. htmlWcu::nameToClassId($this->name). '"></div>';
				else    //if it is string
					$errorEl = $this->errorEl;
				$htmlContent .= $errorEl;
			}
			return $htmlContent;
		}
		return false;
	}

	/**
	 * displayValue.
	 *
	 * @version 2.4.0
	 */
	public function displayValue( $echo = false ) {
		$value = '';
		switch($this->html) {
			case 'countryList':
				$value = fieldAdapterWcu::displayCountry($this->value);
				break;
			case 'statesList':
				$value = fieldAdapterWcu::displayState($this->value);
				break;
			case 'checkboxlist':
				$options = $this->getHtmlParam('optionsWcu');
				$value = array();
				if(!empty($options) && is_array($options)) {
					foreach($options as $opt) {
						if(isset($opt['checked']) && $opt['checked']) {
							$value[] = $opt['text'];
						}
					}
				}
				if(empty($value))
					$value = __('N/A', 'woo-currency');
				else
					$value = implode('<br />', $value);
				break;
			case 'selectbox': case 'radiobuttons':
				$options = $this->getHtmlParam('optionsWcu');
				if(!empty($options) && !empty($options[ $this->value ])) {
					$value = $options[ $this->value ];
				} else {
					$value = __('N/A', 'woo-currency');
				}
				break;
			default:
				if ($this->value == '') {
					$value = __('N/A', 'woo-currency');
				} else {
					if(is_array($this->value)) {
						$options = $this->getHtmlParam('optionsWcu');
						if(!empty($options) && is_array($options)) {
							$valArr = array();
							foreach($this->value as $v) {
								$valArr[] = $options[$v];
							}
							$value = recImplode('<br />', $valArr);
						} else {
							$value = recImplode('<br />', $this->value);
						}
					} else
						$value = $this->value;
				}
				break;
		}
		if ( $echo ) {
			htmlWcu::echo_escaped_html( $value );
		} else {
			return $value;
		}
	}

	/**
	 * showValue.
	 *
	 * @version 2.4.0
	 */
	public function showValue() {
		htmlWcu::echo_escaped_html( $this->displayValue() );
	}

	/**
	 * display.
	 *
	 * @version 2.4.0
	 */
	public function display($tag = 1, $id = 0) {
		htmlWcu::echo_escaped_html( $this->drawHtml($tag, $id) );
	}

	public function addHtmlParam($name, $value) {
		$this->htmlParams[$name] = $value;
	}

	/**
	 * Alias for addHtmlParam();
	 */
	public function setHtmlParam($name, $value) {
		$this->addHtmlParam($name, $value);
	}

	public function setHtmlParams($params) {
		$this->htmlParams = $params;
	}

	public function getHtmlParam($name) {
		return isset($this->htmlParams[$name]) ? $this->htmlParams[$name] : false;
	}

	/**
	 * Function to display userfields in front-end
	 *
	 * @param string $name
	 * @param mixed $fieldValue
	 * @return string
	 */
	public function viewField($name, $fieldValue = '') {
		$method = $this->html;
		$options = frameWcu::_()->getModule('optionsWcu')->getHelper()->getOptions($this->id);
		$attrs = '';
		if (is_object($this->htmlParams['attr']) && count($this->htmlParams['attr']) > 0) {
			foreach ($this->htmlParams['attr'] as $attribute=>$value) {
				if ($value != '') {
					$attrs .= $attribute.'="'.$value.'" ';
				}
			}
		}
		if ($fieldValue == $this->default_value) {
			$checked = 1;
		} else {
			$checked = 0;
		}
		if ($fieldValue == '') {
			$fieldValue = $this->default_value;
		}
		$params = array('optionsWcu'=>$options, 'attrs' => $attrs, 'value' => $fieldValue, 'checked' => $checked);
		$output = '';
		if(method_exists('htmlWcu', $method)) {
			$output .= htmlWcu::$method($name, $params);
			$output .= htmlWcu::hidden('extra_field['.$this->name.']',array('value'=>$this->id));
		}
		return $output;
	}

	/**
	 * processParams.
	 *
	 * @version 2.4.0
	 */
	public function processParams( $tag, $id ) {
		return '';
	}

	/**
	 * Check if the element exists in array
	 * @param array $param
	 */
	function checkVarFromParam($param, $element) {
		return utilsWcu::xmlAttrToStr($param, $element);
	}

	/**
	 * Prepares configuration options
	 *
	 * @param file $xml
	 * @return array $config_params
	 */
	public function prepareConfigOptions($xml) {
		// load xml structure of parameters
		$config = simplexml_load_file($xml);
		$config_params = array();
		foreach ($config->params->param as $param) {
			// read the variables
			$name        = $this->checkVarFromParam($param,'name');
			$type        = $this->checkVarFromParam($param,'type');
			$label       = $this->checkVarFromParam($param,'label');
			$helper      = $this->checkVarFromParam($param,'helperWcu');
			$module      = $this->checkVarFromParam($param,'moduleWcu');
			$values      = $this->checkVarFromParam($param,'values');
			$default     = $this->checkVarFromParam($param,'default');
			$description = $this->checkVarFromParam($param,'description');
			if ($name == '') continue;
			// fill in the variables to configuration array
			$config_params[$name] = array(
				'type'       => $type,
				'label'      => $label,
				'helperWcu'  => $helper,
				'moduleWcu'  => $module,
				'values'     => $values,
				'default'    => $default,
				'description'=> $description,
			);
		}
		return $config_params;
	}

	public function setDescription($desc) {
		$this->description = $desc;
	}

	public function getDescription() {
		return $this->description;
	}

	/**
	 * Displays the config options for given module.
	 *
	 * @version 2.4.0
	 *
	 * @param string $module
	 * @param array $addDefaultOptions - if you want to add some additionsl options - specify it here
	 */
	public function drawConfig($module, $additionalOptions = array()) {
		if(!frameWcu::_()->getModule($module))
			return false;
		// check for xml file with params structure
		if(frameWcu::_()->getModule($module)->isExternal())
			$config_xml = frameWcu::_()->getModule($module)->getModDir(). 'mod.xml';
		else
			$config_xml = WCU_MODULES_DIR.$module.DS.'mod.xml';

		if (!file_exists($config_xml)) {
			// if there is no configuration file for this $module
			return __('There are no configuration options for this module', 'woo-currency');
		}
		$output = '';
		// reading params structure
		$configOptions = $this->prepareConfigOptions($config_xml);
		// reading params from database
		//bugodel2nia..............
		if(is_string($this->value))
			$params = Utils::jsonDecode($this->value);
		elseif(is_object($this->value) || is_array($this->value))
			$params = toeObjectToArray($this->value);
		if (!empty($configOptions)){
			$i = 0;
			if (empty($params)) {
				$params = array('0'=>array());
			}
			if(is_array($additionalOptions) && !empty($additionalOptions)) {
				$configOptions = array_merge($configOptions, $additionalOptions);
			}
			foreach ($params as $param) {
				$output .= '<div class="module_options">';
				foreach ($configOptions as $key=>$value){
					$fieldValue = '';
					$output .= '<div class="module_option">';
					$method = $configOptions[$key]['type'];
					$name = 'params['.$i.']['.$key.']';
					$options = array();
					// if the values attribute is set
					if ($configOptions[$key]['values'] != ''){
						$extract_options = explode(',', $configOptions[$key]['values']);
						if (count($extract_options) > 1) {
							foreach ($extract_options as $item=>$string) {
								if(strpos($string, '=>')) {
									$keyVal = array_map('trim', explode('=>', $string));
									$options[ $keyVal[0] ] = $keyVal[1];
								} else {
									$options[$string] = $string;
								}
							}
						} else {
							$fieldValue = $configOptions[$key]['default'];
						}
					// if helper is needed to render the object
					} elseif ($configOptions[$key]['helper'] != '') {
						$helper_name = $configOptions[$key]['helper'];
						// is helper from current module or other?
						if ($configOptions[$key]['module'] != '') {
							$hmodule = $configOptions[$key]['module'];
						} else {
							$hmodule = $module;
						}
						// calling the helper class
						$helper = frameWcu::_()->getModule($hmodule)->getHelper();
						if ($helper) {
							// calling the helper method for current option
							if (method_exists($helper, $helper_name))
								$options = $helper->$helper_name();
						}
					}
					if (isset($param[$key])) {
						$fieldValue = $param[$key];
					} else {
						if ($fieldValue == '')
							$fieldValue = $configOptions[$key]['default'];
					}
					// filling the parameters to build html element
					$htmlParams = array('value'=>$fieldValue,'optionsWcu'=>$options);
					if($method == 'checkbox') {
						$htmlParams['value'] = 1;
						$htmlParams['checked'] = (bool)$fieldValue;
					}
					if(!empty($configOptions[$key]['htmlParams']) && is_array($configOptions[$key]['htmlParams'])) {
						$htmlParams = array_merge($htmlParams, $configOptions[$key]['htmlParams']);
					}
					// output label and html element
					$output .= '<label>' . $configOptions[ $key ]['label'];
					if ( $configOptions[ $key ]['description'] != '' ) {
						$output .= '<a class="toeOptTip" tip="' . $configOptions[ $key ]['description'] . '"></a>';
					}
					$output .= '</label><br />';
					$output .= htmlWcu::$method($name,$htmlParams).'<br />';
					$output .= '</div>';
				}
				$i++;
				$output .= '</div>';
			}
		}
		return $output;
	}

	/**
	 * displayConfig.
	 *
	 * @version 2.4.0
	 */
	public function displayConfig( $module ) {
		htmlWcu::echo_escaped_html( $this->drawConfig( $module ) );
	}

	/**
	 * This method will prepare internal value to it's type
	 * @see $this->type
	 * @return mixed - prepared value on the basis of $this->type
	 *
	 * @version 2.2.9
	 */
	public function valToType() {
		switch($this->type) {
			case 'int':
			case 'mediumint':
			case 'smallint':
				$this->value = (int) $this->value;
				break;
			case 'decimal':
			case 'double':
			case 'float':
				$this->value = (float) $this->value;
				break;
		}
		return $this->type;
	}
}
