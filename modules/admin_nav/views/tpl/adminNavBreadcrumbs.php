<?php
/**
 * WBW Currency Switcher for WooCommerce - Admin Nav Breadcrumbs
 *
 * @version 2.4.0
 *
 * @author woobewoo
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$countBreadcrumbs = count($this->breadcrumbsList);
?>
<nav id="woobewoo-breadcrumbs" class="woobewoo-breadcrumbs <?php dispatcherWcu::doAction('adminBreadcrumbsClassAdd')?>">
	<?php dispatcherWcu::doAction('beforeAdminBreadcrumbs')?>
	<?php foreach($this->breadcrumbsList as $i => $crumb) { ?>
		<a class="woobewoo-breadcrumb-el" href="<?php echo esc_url( $crumb['url'] ); ?>"><?php echo esc_html( $crumb['label'] ); ?></a>
		<?php if($i < ($countBreadcrumbs - 1)) { ?>
			<span class="breadcrumbs-separator"></span>
		<?php }?>
	<?php }?>
	<?php dispatcherWcu::doAction('afterAdminBreadcrumbs')?>
</nav>
<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound