<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
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
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

?>
<?php 
$url=$_SERVER['REQUEST_URI'];
$sub_url=explode('/',$url);
?>
<h3>Filteren op: </h3>
<div class="product_sort">
    <ul>
        <li class="<?php if($sub_url[3] == 'Biologisch'){ echo 'prod_tag'; } else { } ?>"><a href="<?php echo site_url('/product-tag/Biologisch/')?>">Biologisch</a></li>
    </ul>
</div>
<div class="sepreter">|</div>
<!--<div class="pronav">
        <?php dynamic_sidebar( 'product-navigation' ); ?>
    </div>-->
<div class="product_sort" style="margin-top: -3px; font-size: 17px;
    margin-left: 7px;">
        <?php
        $currmonth= date('M');
        $currseizen=78;
        switch ($currmonth) {
    case "Jan":
        $currseizen=78;
        break;
    case "Feb":
         $currseizen=77;
        break;
    case "Mar":
         $currseizen=76;
        break;
    case "Apr":
         $currseizen=75;
        break;
    case "May":
         $currseizen=70;
        break;
    case "Jun":
         $currseizen=51;
        break;
    case "Jul":
         $currseizen=50;
        break;
    case "Aug":
         $currseizen=49;
        break;
    case "Sept":
         $currseizen=48;
        break;
    case "Oct":
         $currseizen=63;
        break;
    case "Nov":
         $currseizen=62;
        break;
    case "Dec":
         $currseizen=61;
        break;
    default:
        $currseizen=78;
}
        
        
        $categories_seizen = get_terms( 'product_cat', array(
 	/* 'orderby'    => 'count', */
 	'hide_empty' => 0,
	'parent'    => 47,
 ) );
        foreach($categories_seizen as $seizen)
        {
            if($seizen->term_id==$currseizen){?><a class="seizen" href="<?php echo get_term_link($seizen->term_id);?>">seizoensproducten</a><?php  }
        }       ?>
    </div>
<!-- <form class="woocommerce-ordering" method="get">
	<div class="selectdiv ">
  <label>
	<select name="orderby" class="orderby">
	<option value="">Naam</option>
		<?php //foreach ( $catalog_orderby_options as $id => $name ) :
		//if($id == 'alphabetical'  || $id == 'reverse_alpha')
		{?>
		
		<option value="<?php //echo esc_attr( $id ); ?>" <?php //selected( $orderby, $id ); ?>><?php //echo esc_html( $name ); ?>
		</option><?php }?>
		<?php //endforeach; ?>
	</select>
</label></div>
	<input type="hidden" name="paged" value="1" />
	<?php //wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>

<form class="woocommerce-ordering" method="get">
	<div class="selectdiv ">
  <label>
	<select name="orderby" class="orderby">
	<option  value="">Prijs</option>
		<?php //foreach ( $catalog_orderby_options as $id => $name ) :
			//if($id == 'price'  || $id == 'price-desc')
		{?>	
			<option value="<?php //echo esc_attr( $id ); ?>" <?php //if($_GET['orderby']== esc_attr( $id )){echo "selected";}?>><?php //echo esc_html( $name ); ?></option>	
                            <?php }?>
		<?php //endforeach; ?>
	</select></label></div>
	<input type="hidden" name="paged" value="1"/>
	<?php //wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form> -->

<!-- <form class="woocommerce-ordering" method="get">
	<div class="selectdiv ">
  <label>
	<select name="orderby" class="orderby">
	<option value="">Aanbieding</option>
		<?php //foreach ($catalog_orderby_options as $id => $name) :
       //if($id == 'on_sale_first')
		{?>			
			<option value="<?php //echo esc_attr( $id ); ?>" <?php //selected( $orderby, $id ); ?>><?php //echo esc_html( $name ); ?></option><?php }?>
		<?php //endforeach; ?>
	</select></label></div>
	<input type="hidden" name="paged" value="1" />
	<?php //wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form> -->

<div class="topnav">
  <div class="search-container">
    <form action="">
        <input type="text" placeholder="Zoek product" name="s" autocomplete="off"><button type="submit"><i class="fa fa-search"></i>	
      </button>
    </form>
  </div>
</div>
