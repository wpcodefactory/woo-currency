<?php
/**
 * WBW Currency Switcher for WooCommerce - Welcome Page
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<section>
	<div class="woobewoo-item woobewoo-panel woobewoo-plugin">
		<div id="containerWrapper">
			<div class="row">
				<div class="col-sm-12">
					<h2>
						<?php
						printf(
							/* Translators: %1$s: Plugin Name, %2$s: Plugin version. */
							esc_html__( 'Welcome to the %1$s v %2$s', 'woo-currency' ),
							esc_attr( WCU_WP_PLUGIN_NAME ),
							esc_attr( WCU_VERSION )
						);
						?>
						<a style="margin-top: -8px; margin-left: 5px;" href="<?php echo esc_url(  $this->skipTutorLink );?>" class="button"><?php esc_html_e('Skip tutorial', 'woo-currency')?></a>
					</h2>
					<p>
						<?php esc_html_e('The best way to work with currency for Woocommerce Shop!', 'woo-currency')?>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-6">
							<h3><?php esc_html_e('Step-by-step tutorial', 'woo-currency')?></h3>
							<p><?php esc_html_e('As an option we can install and setup plugin for you.', 'woo-currency')?></p>
						</div>
						<div class="col-sm-6">
							<h3><?php esc_html_e('Support', 'woo-currency')?></h3>
							<p>
								<?php
								printf(
									/* Translators: %s: URL. */
									esc_html__(
										"We love our plugin and do the best to improve all features for You. But sometimes issues happened, or you can't find required feature that you need. Don't worry, just <a href='%s' target='_blank'>contact us</a> and we will help you!",
										'woo-currency'
									),
									esc_url( $this->getModule()->getContactLink() )
								);
								?>
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<h3>
						<?php esc_html_e('Frequently Asked Questions', 'woo-currency')?>
					</h3>
					<?php foreach($this->faqList as $fHead => $fDesc) { ?>
						<h4><?php echo esc_html( $fHead );?></h4>
						<p><?php echo wp_kses_post( $fDesc ); ?></p>
					<?php }?>
					<div style="clear: both;"></div>
					<a target="_blank" href="<?php echo esc_url(  $this->mainLink ); ?>#faq" style="font-size: 16px; padding-right: 15px; white-space: nowrap; font-weight: normal;">
						<i class="fa fa-info-circle"></i>
						<?php esc_html_e('Check all FAQs', 'woo-currency')?>
					</a>
					<div style="clear: both;"></div>
					<a href="<?php echo esc_url( $this->createNewLink ); ?>" class="button button-primary button-hero" style="font-size: 20px; margin: 20px 20px 20px 0; min-width: 160px; text-align: center;"><?php esc_html_e("Let's Start!", 'woo-currency')?></a>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</section>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound