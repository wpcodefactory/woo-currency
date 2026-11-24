<?php
/**
 * WBW Currency Switcher for WooCommerce - Options Settings Tab Content
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<section class="woobewoo-bar">
	<ul class="woobewoo-bar-controls">
		<li title="<?php esc_html_e('Save all options', 'woo-currency'); ?>">
			<button class="button button-primary" id="wcuSettingsSaveBtn" data-toolbar-button>
				<i class="fa fa-fw fa-save"></i>
				<?php esc_html_e('Save', 'woo-currency'); ?>
			</button>
		</li>
	</ul>
	<div style="clear: both;"></div>
	<hr />
</section>
<section>
	<form id="wcuSettingsForm" class="wcuInputsWithDescrForm">
		<div class="woobewoo-item woobewoo-panel">
			<div id="containerWrapper">
				<a href="<?php echo esc_url( frameWcu::_()->getModule( 'currency' )->getCurrencyTabUrl() ); ?>" class="button button-primary">
					<?php esc_html_e( 'Go to Woo Currency Settings', 'woo-currency' ); ?>
				</a><br/>
				<span class="description">
					<?php esc_html_e( "To start work with Woo Currencies - go to it's section in your Woo Store", 'woo-currency' ); ?>
				</span>
				<table class="form-table">
					<?php foreach($this->options as $optCatKey => $optCatData) { ?>
						<?php if(isset($optCatData['opts']) && !empty($optCatData['opts'])) { ?>
							<?php foreach($optCatData['opts'] as $optKey => $opt) { ?>
								<?php
									$htmlType = isset($opt['html']) ? $opt['html'] : false;
									if(empty($htmlType)) continue;
									$opt['attrs'] = isset($opt['attrs']) && !empty($opt['attrs']) ? $opt['attrs'] : '';
									$htmlOpts = array('value' => $opt['value'], 'attrs' => 'data-optkey="'. $optKey. '" ' . $opt['attrs']);
									if(in_array($htmlType, array('selectbox', 'selectlist')) && isset($opt['options'])) {
										if(is_callable($opt['options'])) {
											$htmlOpts['options'] = call_user_func( $opt['options'] );
										} elseif(is_array($opt['options'])) {
											$htmlOpts['options'] = $opt['options'];
										}
									}
									if(isset($opt['pro']) && !empty($opt['pro'])) {
										$htmlOpts['attrs'] .= ' class="wcuProOpt"';
									}
								?>
								<tr
									<?php if ( isset( $opt['connect'] ) && $opt['connect'] ) { ?>
										data-connect="<?php echo esc_html( $opt['connect'] ); ?>" style="display: none;"
									<?php } ?>
								>
									<th scope="row" class="col-w-30perc">
										<?php echo esc_html( $opt['label'] ); ?>
										<?php if ( ! empty( $opt['changed_on'] ) ) { ?>
											<br />
											<span class="description">
												<?php
												$opt['value'] ?
													printf(
														/* Translators: %s: Date. */
														esc_html__( 'Turned On %s', 'woo-currency' ),
														esc_html( dateWcu::_( $opt['changed_on'] ) )
													) :
													printf(
														/* Translators: %s: Date. */
														esc_html__( 'Turned Off %s', 'woo-currency' ),
														esc_html( dateWcu::_( $opt['changed_on'] ) )
													);
												?>
											</span>
										<?php }?>
										<?php if ( ! empty( $opt['pro'] ) ) { ?>
											<span class="wcuProOptMiniLabel">
												<a href="<?php echo esc_url( $opt['pro'] ); ?>" target="_blank">
													<?php esc_html_e( 'PRO option', 'woo-currency' ); ?>
												</a>
											</span>
										<?php } ?>
									</th>
									<td class="col-w-1perc">
										<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_html( $opt['desc'] ); ?>"></i>
									</td>
									<td class="col-w-1perc">
										<?php htmlWcu::echo_escaped_html( htmlWcu::$htmlType( 'opt_values[' . $optKey . ']', $htmlOpts ) ); ?>
									</td>
									<td class="col-w-60perc">
										<div id="wcuFormOptDetails_<?php echo esc_attr( $optKey ); ?>" class="wcuOptDetailsShell">
											<?php
											if ( isset( $opt['add_sub_opts'] ) && ! empty( $opt['add_sub_opts'] ) ) {
												if ( is_string( $opt['add_sub_opts'] ) ) {
													echo esc_html( $opt['add_sub_opts'] );
												} elseif ( is_callable( $opt['add_sub_opts'] ) ) {
													echo wp_kses_post( call_user_func_array( $opt['add_sub_opts'], array( $this->options ) ) );
												}
											}
											?>
										</div>
									</td>
								</tr>
							<?php }?>
						<?php }?>
					<?php }?>
				</table>
				<div style="clear: both;"></div>
			</div>
		</div>
		<?php htmlWcu::echo_escaped_html( htmlWcu::hidden( 'mod', array( 'value' => 'options' ) ) ); ?>
		<?php htmlWcu::echo_escaped_html( htmlWcu::hidden( 'action', array( 'value' => 'saveGroup' ) ) ); ?>
	</form>
</section>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
