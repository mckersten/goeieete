<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$product_ID=$product->get_id();
$values_kgs = wc_get_product_terms( $product_ID, 'pa_verpakkingseenheid', array( 'fields' => 'all' ) );
$total_count=count($values_kgs);

?>
<div class="main_attri">
<span class="attr_vl">
<?php
	$count=1;
	foreach($values_kgs as $values_kg){ 
		echo $values_kg->name;
		if($count < $total_count ){
			echo ' , ';
			
		} 
		$count++;
	}
?>
</span>
<p class="price"><?php echo $product->get_price_html(); ?></p>
</div>
