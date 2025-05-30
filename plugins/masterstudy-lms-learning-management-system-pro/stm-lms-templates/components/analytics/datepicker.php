<?php
/**
 * @var string $id
 */

wp_enqueue_style( 'masterstudy-datepicker-library' );
wp_enqueue_style( 'masterstudy-datepicker' );
?>

<div class="masterstudy-datepicker">
	<input id="masterstudy-datepicker-<?php echo esc_attr( $id ); ?>"/>
</div>
