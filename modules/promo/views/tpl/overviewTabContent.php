<?php
/**
 * WBW Currency Switcher for WooCommerce - Overview Tab Content
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<section>
	<div class="woobewoo-item woobewoo-panel">
		<div id="containerWrapper">
			<div class="supsistic-half-side-box woobewoo-border-right">
				<h3><?php esc_html_e('FAQ and Documentation', 'woo-currency')?></h3>
				<div class="faq-list">
					<?php if ( ! empty( $this->faqList ) ) { ?>
						<?php foreach ( $this->faqList as $title => $desc ) { ?>
							<div class="faq-title">
								<i class="fa fa-info-circle"></i>
								<?php echo esc_html( $title ); ?>
								<div class="description" style="display: none;">
									<?php echo wp_kses_post( $desc ); ?>
								</div>
							</div>
						<?php } ?>
					<?php } else { ?>
						<?php esc_html_e('There is no main FAQs for now', 'woo-currency')?>
					<?php }?>
					<div style="clear: both;"></div>
					<a target="_blank" class="button button-primary button-hero" href="<?php echo esc_url( $this->mainLink ); ?>#faq" style="float:right;height:35px;min-height:auto;">
						<i class="fa fa-info-circle"></i>
						<?php esc_html_e('Check all FAQs', 'woo-currency')?>
					</a>
					<div style="clear: both;"></div>
				</div>
				<div class="server-settings">
					<h3><?php esc_html_e('Server Settings', 'woo-currency')?></h3>
					<ul class="settings-list">
						<?php foreach ( $this->serverSettings as $title => $element ) { ?>
							<li class="settings-line">
								<div class="settings-title"><?php echo esc_html( $title ); ?>:</div>
								<span><?php echo esc_html( $element['value'] ); ?></span>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="supsistic-half-side-box" style="padding-left: 20px;">
				<?php if ( $this->news ) { ?>
					<div class="woobewoo-overview-news">
						<h3><?php esc_html_e('News', 'woo-currency')?></h3>
						<div class="woobewoo-overview-news-content">
							<?php echo esc_html( $this->news ); ?>
						</div>
						<a href="<?php echo esc_url( $this->mainLink ); ?>" class="button button-primary button-hero" style="float: right; margin-top: 10px;height:35px;">
							<i class="fa fa-info-circle"></i>
							<?php esc_html_e('All news and info', 'woo-currency')?>
						</a>
						<div style="clear: both;"></div>
					</div>
				<?php }?>
				<div class="overview-contact-form">
					<h3><?php esc_html_e('Contact form', 'woo-currency')?></h3>
					<form id="form-settings">
						<table class="contact-form-table">
							<?php foreach($this->contactFields as $fName => $fData) { ?>
								<?php
									$htmlType = $fData['html'];
									$id = 'contact_form_'. $fName;
									$htmlParams = array('attrs' => 'id="'. $id. '"');
									if(isset($fData['placeholder']))
										$htmlParams['placeholder'] = $fData['placeholder'];
									if(isset($fData['options']))
										$htmlParams['options'] = $fData['options'];
									if(isset($fData['def']))
										$htmlParams['value'] = $fData['def'];
									if(isset($fData['valid']) && in_array('notEmpty', $fData['valid']))
										$htmlParams['required'] = true;
								?>
							<tr>
								<th scope="row">
									<label for="<?php echo esc_attr( $id ); ?>">
										<?php echo esc_html( $fData['label'] ); ?>
									</label>
								</th>
								<td>
									<?php
									htmlWcu::echo_escaped_html(
										htmlWcu::$htmlType($fName, $htmlParams
										)
									);
									?>
								</td>
							</tr>
							<?php }?>
							<tr>
								<th scope="row" colspan="2">
									<?php
									htmlWcu::echo_escaped_html(
										htmlWcu::hidden(
											'mod',
											array( 'value' => 'promo' )
										)
									);
									?>
									<?php
									htmlWcu::echo_escaped_html(
										htmlWcu::hidden(
											'action',
											array( 'value' => 'sendContact' )
										)
									);
									?>
									<button class="button button-primary button-hero" style="float: right; margin: 10px 0;height:35px;">
										<i class="fa fa-upload"></i>
										<?php esc_html_e('Send email', 'woo-currency')?>
									</button>
									<div style="clear: both;"></div>
								</th>
							</tr>
						</table>
					</form>
					<div id="form-settings-send-msg" style="display: none;">
						<i class="fa fa-envelope-o"></i>
						<?php esc_html_e('Your email was sent, we will try to respond to your as soon as possible. Thank you for support!', 'woo-currency')?>
					</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</section>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound