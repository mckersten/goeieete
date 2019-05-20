<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php 
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>


<?php	$categories = get_terms( 'product_cat', array(
/* 'orderby'    => 'count', */
'hide_empty' => 0,
'parent'    => 0,
) );
 // print_r($categories);?>
<h2 class="title_pro">meer producten</h2>
	<ul class="cat_product">
	 

		<?php foreach($categories as $categorie)
		{
		
		if($categorie->slug != 'uncategorized' && $categorie->term_id != 232 && $categorie->term_id != 52 && $categorie->term_id != 151 && $categorie->term_id != 85 && $categorie->term_id != 47)
		{
		$cat_thumb_id = get_woocommerce_term_meta( $categorie->term_id, 'thumbnail_id', true );
		$shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' ); 
		?>

		<li>
			<a href="<?php echo get_term_link($categorie->term_id)?>">
				<image class="cat_img" src="<?php echo $shop_catalog_img[0];?>">
				<p><?php echo $categorie->name; ?></p>
			</a>
		</li>
		
		<?php } } ?>
	</ul>
		<?php /**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php 
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); 

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
