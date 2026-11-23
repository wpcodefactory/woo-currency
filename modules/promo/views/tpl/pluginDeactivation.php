<?php
/**
 * WBW Currency Switcher for WooCommerce - Plugin Deactivation
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

?>
<style type="text/css">
	.wcuDeactivateDescShell {
		display: none;
		margin-left: 25px;
		margin-top: 5px;
	}
	.wcuDeactivateReasonShell {
		display: block;
		margin-bottom: 10px;
	}
	.wcuDeactivateReasonShell [type="radio"] {
		display: inline-block !important;
	    width: auto !important;
	    height: 16px !important;
	}
	#wcuDeactivateWnd input[type="text"] {
		width:100% !important;
		height: 35px !important;
	}
	.wcuDeactivateSkipDataBtn {
		padding:7.5px 0px;
		margin:0px !important;
	}
	#wcuDeactivateWnd textarea {
		width: 100%;
	}
	#wcuDeactivateWnd h4 {
		line-height: 1.53em;
	}
	#wcuDeactivateWnd + .ui-dialog-buttonpane .ui-dialog-buttonset {
		float: none;
	}
	.wcuDeactivateSkipDataBtn {
		float: right;
		margin-top: 15px;
		text-decoration: none;
		color: #777 !important;
	}
</style>
<div id="wcuDeactivateWnd" style="display: none;" title="<?php esc_html_e('Your Feedback', 'woo-currency')?>">
	<h4>
		<?php
		printf(
			/* Translators: %s: Plugin Name. */
			esc_html__( 'If you have a moment, please share why you are deactivating %s', 'woo-currency' ),
			esc_html( WCU_WP_PLUGIN_NAME )
		);
		?>
	</h4>
	<form id="wcuDeactivateForm">
		<label class="wcuDeactivateReasonShell">
			<?php
			htmlWcu::echo_escaped_html(
				htmlWcu::radiobutton( 'deactivate_reason', array(
						'value' => 'not_working',
					)
				)
			);
			?>
			<?php esc_html_e('Couldn\'t get the plugin to work', 'woo-currency')?>
			<div class="wcuDeactivateDescShell">
				<?php
				htmlWcu::echo_escaped_html(
					sprintf(
						/* Translators: %s: URL. */
						__( 'If you have a question, <a href="%s" target="_blank" rel="noopener noreferrer">contact us</a> and we will do our best to help you.', 'woo-currency' ),
						esc_url( 'https://woobewoo.com/contact-us/?utm_source=plugin&utm_medium=deactivated_contact&utm_campaign=woocurrency' )
					)
				);
				?>
			</div>
		</label>
		<label class="wcuDeactivateReasonShell">
			<?php
			htmlWcu::echo_escaped_html(
				htmlWcu::radiobutton(
					'deactivate_reason',
					array(
						'value' => 'found_better',
					)
				)
			);
			?>
			<?php esc_html_e('I found a better plugin', 'woo-currency')?>
			<div class="wcuDeactivateDescShell">
				<?php
				htmlWcu::echo_escaped_html(
					htmlWcu::text(
						'better_plugin',
						array(
							'placeholder' => esc_html__( 'If it\'s possible, specify plugin name', 'woo-currency' ),
						)
					)
				);
				?>
			</div>
		</label>
		<label class="wcuDeactivateReasonShell">
			<?php
			htmlWcu::echo_escaped_html(
				htmlWcu::radiobutton(
					'deactivate_reason',
					array(
						'value' => 'not_need',
					)
				)
			);
			?>
			<?php esc_html_e('I no longer need the plugin', 'woo-currency')?>
		</label>
		<label class="wcuDeactivateReasonShell">
			<?php htmlWcu::echo_escaped_html(
				htmlWcu::radiobutton(
					'deactivate_reason',
					array(
						'value' => 'temporary',
					)
				)
			);
			?>
			<?php esc_html_e('It\'s a temporary deactivation', 'woo-currency')?>
		</label>
		<label class="wcuDeactivateReasonShell">
			<?php
			htmlWcu::echo_escaped_html(
				htmlWcu::radiobutton(
					'deactivate_reason',
					array(
						'value' => 'other',
					)
				)
			);
			?>
			<?php esc_html_e('Other', 'woo-currency')?>
			<div class="wcuDeactivateDescShell">
				<?php
				htmlWcu::echo_escaped_html(
					htmlWcu::text(
						'other',
						array(
							'placeholder' => esc_html__( 'What is the reason?', 'woo-currency' ),
						)
					)
				);
				?>
			</div>
		</label>
		<?php htmlWcu::echo_escaped_html( htmlWcu::hidden( 'mod', array( 'value' => 'promo' ) ) ); ?>
		<?php htmlWcu::echo_escaped_html( htmlWcu::hidden( 'action', array( 'value' => 'saveDeactivateData' ) ) ); ?>
	</form>
	<a href="" class="wcuDeactivateSkipDataBtn"><?php esc_html_e('Skip & Deactivate', 'woo-currency')?></a>
</div>
