<?php
/**
 * @package     AppSumo
 * @since       1.0.0
 *
 * @var $args array
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="item-activation">
	<div class="activation-content">
		<div class="activation-info">
			<h3><?php echo esc_html( $args['name'] ); ?> license</h3>
			<p>Enter your license from <a href="https://support.stylemixthemes.com/my-account/appsumo" target="_blank">Deal Downloads Page on Stylemix</a> to activate the plugin and get regular updates.</p>
		</div>
		<div class="activation-form">
			<input type="text" id="license" name="license" placeholder="XXXXXXXXXXXXXXXXXXXX" autocomplete="off">
			<button class="activation-button disabled"><?php esc_html_e( 'Activate', 'appsumo' ); ?></button>
		</div>
		<p class="error"></p>
	</div>
	<div class="activation-footer">
		<p>The activation license is not Redeem code from AppSumo, DealMirror, DealFuel purchase history. You can get an activation license using Redeem code in our support panel.</p>
	</div>
</div>
