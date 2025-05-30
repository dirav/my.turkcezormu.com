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
<div class="notice notice-<?php echo esc_html( $args['type'] ); ?>">
	<p>
		<?php
		if ( ! empty( $args['title'] ) ) {
			echo '<b>' . esc_html( $args['title'] ) . '</b> ';
		}

		echo wp_kses_post( $args['message'] );
		?>
	</p>
</div>
