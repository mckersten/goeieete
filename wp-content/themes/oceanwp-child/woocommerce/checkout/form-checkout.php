<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div><h2 class="checkout_topic">Afhaallocatie en moment</h2></div>
			<div class="col-2">
				<?php
				//date_default_timezone_set (date_default_timezone_get());

				/*$monday = strtotime("next monday");
				$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;

				$sunday = strtotime(date("Y-m-d",$monday)." +6 days");

				$this_week_sd = date("Y-m-d",$monday);
				$this_week_ed = date("Y-m-d",$sunday);

				echo "<span class='colordate'>(". $this_week_sd ." to " .  $this_week_ed .")</span>";*/
				
				do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>

			<div class="date_time">
				<div class="chng_location">
				</div>
			</div>
			<div id="info"></div>
			<div id="loc_address">
			</div>

			<hr>

			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
<!--				<input type="checkbox" name="copyright">Klik hier om de <a href="<?php //echo site_url('/algemene-voorwaarden'); ?>" style="color: #8bc350;">algemene voorwaarden</a> te accepteren.-->
			</div>

			<!-- <?php //echo "string";  ?> -->
			<!-- <div class="col-2">
				<?php //do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
			<div class="date_time">
				<div class="chng_location">
				</div>
			</div>
			<div id="info"></div>
			<div id="loc_address">
			</div> -->
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
<div class="order_review_sidebar">
	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>
</div>
	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
