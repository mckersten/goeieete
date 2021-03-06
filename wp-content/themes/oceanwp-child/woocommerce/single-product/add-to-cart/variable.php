<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 *
 * Modified to use radio buttons instead of dropdowns
 * @author 8manos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>

		<div class="variations" cellspacing="0">
			<?php foreach ( $attributes as $name => $options ) : ?>
				<div class="attribute-<?php echo sanitize_title($name); ?>">
					
					<?php
					$sanitized_name = sanitize_title( $name );
					if ( isset( $_REQUEST[ 'attribute_' . $sanitized_name ] ) ) {
						$checked_value = $_REQUEST[ 'attribute_' . $sanitized_name ];
					} elseif ( isset( $selected_attributes[ $sanitized_name ] ) ) {
						$checked_value = $selected_attributes[ $sanitized_name ];
					} else {
						$checked_value = '';
					}
					?>
					<ul class="value">

						<?php
						if ( ! empty( $options ) ) {
							if ( taxonomy_exists( $name ) ) {
								// Get terms if this is a taxonomy - ordered. We need the names too.
								$terms = wc_get_product_terms( $product->get_id(), $name, array( 'fields' => 'all' ) );


								foreach ( $terms as $term ) {
									if ( ! in_array( $term->slug, $options ) ) {
										continue;

									}
									print_attribute_radio_dev( $checked_value, $term->slug, $term->name, $sanitized_name );
								}
							} else { $vd=0;
								foreach ( $options as $option ) {
									$variation_id=$available_variations[$vd]['variation_id']; 
$variable_product1= new WC_Product_Variation( $variation_id );
 
 $regular_price = $variable_product1 ->regular_price;
 $symbol= get_woocommerce_currency_symbol().'  '.$regular_price ;
 
//echo $sales_price = $variable_product1 ->sale_price;
$vd++;
 
?> 
<li><?php print_attribute_radio_dev( $checked_value, $option, $option, $sanitized_name,$symbol,$name );
									?></li><?php
								}
							}
						}
						echo end( $attribute_keys ) === $name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce' ) . '</a>' ) : '';
						?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
				do_action( 'woocommerce_before_single_variation' );
				do_action( 'woocommerce_single_variation' );
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
