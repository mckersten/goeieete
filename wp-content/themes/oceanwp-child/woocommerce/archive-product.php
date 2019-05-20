<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */?>
<?php defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>

<?php	$categories = get_terms( 'product_cat', array(
 	/* 'orderby'    => 'count', */
 	'hide_empty' => 0,
	'parent'    => 0,
 ) );
 // print_r($categories);?>
 <div class="mobile-slider show-arrows" data-item-width="200" data-slider-when="768" data-start-at="1"><!--   -->
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
				<p><?php echo $categorie->name;?></p>
			</a>
		</li>
        <?php } }?>
	</ul>
</div>

<?php //echo do_shortcode('[product_category category="bood-banket" per_page="20" columns="4"]');?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php 
$url=$_SERVER['REQUEST_URI'];
$sub_url=explode('/',$url); 

?>

<!-- <div class="tagswrapper">
	<ul class="tage-name">
		<li><strong>DIRECT NAAR</strong></li>
		<li class="<?php //if($sub_url[3] == 'Biologisch'){ echo 'prod_tag'; } else { } ?>"><a href="<?php //echo site_url('/product-tag/Biologisch/')?>">Biologisch</a></li>
		<li class="<?php //if($sub_url[3] == 'Glutenvrij'){ echo 'prod_tag'; } else { } ?>" ><a href="<?php //echo site_url('/product-tag/Glutenvrij/')?>">Glutenvrij</a></li>
		<li class="sepreter">|</li>
		<li class="<?php //if($sub_url[3] == 'Aardappelen'){ echo 'prod_tag'; } else { } ?>" ><a href="<?php //echo site_url('/product-tag/Aardappelen/')?>">Aardappelen</a></li>
		<li class="<?php //if($sub_url[3] == 'Groente'){ echo 'prod_tag'; } else { } ?>" ><a href="<?php //echo site_url('/product-tag/Groente/')?>">Groente</a></li>
		<li class="<?php //if($sub_url[3] == 'Fruit'){ echo 'prod_tag'; } else { } ?>" ><a href="<?php //echo site_url('/product-tag/Fruit/')?>">Fruit</a></li>
		<li class="<?php //if($sub_url[3] == 'Champignons'){ echo 'prod_tag'; } else { } ?>" ><a href="<?php //echo site_url('/product-tag/Champignons/')?>">Champignons</a></li>
		<li class="<?php //if($sub_url[3] == 'Kruiden'){ echo 'prod_tag'; } else { } ?>" ><a href="<?php //echo site_url('/product-tag/Kruiden/')?>">Kruiden</a></li>
	</ul>
</div> -->
<?php

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked wc_print_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	 
	do_action( 'woocommerce_after_shop_loop' );

    }
	else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

?>

<?php $shoppage_id='34'; ?>
    <hr class="hr_text">
	<div class="descr_con">
		<h1 class="text_title"><?php echo get_field('shop_content_title',$shoppage_id); ?></h1>
		<div class="text_des"><h3 class="text_content"><?php echo get_field('shop_content',$shoppage_id); ?></h3></div>
		<div class="tet_button"><a class="text_btn" href="<?php echo get_field('shop_button_link',$shoppage_id); ?>"><?php echo get_field('shop_button',$shoppage_id); ?></a>
		</div>
	</div>

<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );


get_footer( 'shop' );
