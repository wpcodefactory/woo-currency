<?php
/**
 * WBW Currency Switcher for WooCommerce - Admin Tour
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

?>
<div id="woobewoo-admin-tour" class="">
	<div id="woobewoo-welcome-first_welcome">
		<div class="woobewoo-tour-content">
			<h3>
				<?php
				printf(
					/* Translators: %s: Plugin Name. */
					esc_html__( 'Welcome to %s plugin!', 'woo-currency' ),
					esc_attr( WCU_WP_PLUGIN_NAME )
				);
				?>
			</h3>
			<p>
				<?php
				printf(
					/* Translators: %s: Plugin Name. */
					esc_html__( 'Thank you for choosing our %s plugin. Just click here to start using it - and we will show you it\'s possibilities and powerfull features.', 'woo-currency' ),
					esc_attr( WCU_WP_PLUGIN_NAME )
				);
				?>
			</p>
		</div>
		<div class="woobewoo-tour-btns">
			<a href="#" class="close"><?php esc_html_e('Close', 'woo-currency')?></a>
			<a href="<?php echo esc_url( frameWcu::_()->getModule('options')->getTabUrl() ); ?>" class="button button-primary woobewoo-tour-next-btn"><?php esc_html_e('Next', 'woo-currency')?></a>
		</div>
	</div>
</div>