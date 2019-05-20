<?php 
require 'inc/helpers.php';
require 'inc/woocommerce/woocommerce-config.php';
require 'inc/woocommerce/woocommerce-helpers.php';
require 'inc/walker/menu-walker.php';

function snssimen_child_enqueue_styles()
{
    wp_enqueue_style('oceanwp-child-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Kanit:100,200,300,400,500,600,700,800,900|Prompt:100,200,300,400,500,600,700,800,900" rel="stylesheet');
}

add_action('wp_enqueue_scripts', 'snssimen_child_enqueue_styles', 100000);


/* function snssimen_child_enqueue_script() {
  //wp_enqueue_script('oceanwp-child-script', get_stylesheet_directory_uri() . '/woo-scripts.min.js',array(),false,true);
  wp_enqueue_script( 'oceanwp-child-script',  get_stylesheet_directory_uri() . '/woo-scripts.min.js', array( 'jquery' ), $theme_version, true );

  }
  remove_action('wp_footer', 'oceanwp-woocommerce',1);
  remove_action('wp_head', 'oceanwp-woocommerce',1);
  add_action('wp_footer', 'snssimen_child_enqueue_script',5);

  function custom_script_fix()
  {
  //use same handle as parent theme to override ('jquery-custom')
  wp_register_script('jquery-custom', get_stylesheet_directory_uri() .'/woo-scripts.min.js', false, '1.0');
  wp_enqueue_script( 'jquery-custom');
  }

  add_action( 'wp_enqueue_scripts', 'custom_script_fix' ); */

function wpse26822_script_fix()
{
    wp_dequeue_script('oceanwp-woocommerce');
    wp_enqueue_script('oceanwp-woocommerce-my', get_stylesheet_directory_uri() . '/woo-scripts.min.js', array(), 20151110, true);
}

add_action('wp_enqueue_scripts', 'wpse26822_script_fix', 20120207);

function get_child_menu_from_parent()
{
    $post_id = get_the_ID();
    $nav = wp_get_nav_menu_items('header');
    if (!empty($nav)) {
        foreach ($nav as $item) {
            if ($post_id == $item->object_id) {
                $menu_id = $item->ID;
                if ($item->menu_item_parent != 0) {
                    $menu_id = $item->menu_item_parent;
                }
                break;
            }
        }
        return get_child_menu($menu_id, $nav);
    }
}

function get_child_menu($menu_id, $nav_array)
{
    $child_menu = array();
    foreach ($nav_array as $items) {
        $child_menu_each = array();
        if ($menu_id == $items->menu_item_parent) {
            $child_menu_each['title'] = $items->title;
            $child_menu_each['url'] = $items->url;
            $child_menu_each['menu_item_parent'] = $items->menu_item_parent;
            $child_menu_each['object_id'] = $items->object_id;
            $child_menu[] = $child_menu_each;
        }
    }
//echo "<pre>";print_r($child_menu);
    return $child_menu;
}

function my_nav_wrap()
{
// default value of 'items_wrap' is <ul id="%1$s" class="%2$s">%3$s</ul>'
// open the <ul>, set 'menu_class' and 'menu_id' values
    $wrap = '<ul id="%1$s" class="%2$s">';

// the static link
    $wrap .= '<li class="my-static-link"><a href="#"><img src="' . get_site_url() . '/wp-content/uploads/2018/07/icon.png" alt="icon"></a></li>';

// get nav items as configured in /wp-admin/
    $wrap .= '%3$s';

// close the <ul>
    $wrap .= '</ul>';
// return the result
    return $wrap;
}

/**
  add_action('init', 'codex_Farmer_init');


 * Register a Farmer post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type

  function codex_Farmer_init() {
  $labels = array(
  'name' => _x('Farmers', 'post type general name', 'your-plugin-textdomain'),
  'singular_name' => _x('Farmer', 'post type singular name', 'your-plugin-textdomain'),
  'menu_name' => _x('Farmers', 'admin menu', 'your-plugin-textdomain'),
  'name_admin_bar' => _x('Farmer', 'add new on admin bar', 'your-plugin-textdomain'),
  'add_new' => _x('Add New', 'Farmer', 'your-plugin-textdomain'),
  'add_new_item' => __('Add New Farmer', 'your-plugin-textdomain'),
  'new_item' => __('New Farmer', 'your-plugin-textdomain'),
  'edit_item' => __('Edit Farmer', 'your-plugin-textdomain'),
  'view_item' => __('View Farmer', 'your-plugin-textdomain'),
  'all_items' => __('All Farmers', 'your-plugin-textdomain'),
  'search_items' => __('Search Farmers', 'your-plugin-textdomain'),
  'parent_item_colon' => __('Parent Farmers:', 'your-plugin-textdomain'),
  'not_found' => __('No Farmers found.', 'your-plugin-textdomain'),
  'not_found_in_trash' => __('No Farmers found in Trash.', 'your-plugin-textdomain')
  );

  $args = array(
  'labels' => $labels,
  'description' => __('Description.', 'your-plugin-textdomain'),
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'Farmer'),
  'capability_type' => 'post',
  'has_archive' => true,
  'hierarchical' => false,
  'menu_position' => null,
  'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
  'taxonomies' => array('category')
  );

  register_post_type('Farmer', $args);
  } */
add_filter('acf/load_value/name=pickup_days_details1', 'ek_option_defaults', 10, 3);

function ek_option_defaults($value, $post_id, $field)
{
    if ($value === false) {
        $value = array(
            array(
                'field_5b598f080390d' => '11:00-12:00',
                'field_5b598f0f0390e' => '',
            ),
            array(
                'field_5b598f080390d' => '12:00-15:00',
                'field_5b598f0f0390e' => '',
            ),
            array(
                'field_5b598f080390d' => '15:00-17:00',
                'field_5b598f0f0390e' => '',
            ),
                //etc
        );
    }
    return $value;
}

/**
 * Update the order meta with field value
 */
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

function my_custom_checkout_field_update_order_meta($order_id)
{
    if (!empty($_POST['day_time'])) {
        update_post_meta($order_id, 'day_time', sanitize_text_field($_POST['day_time']));
    }
}

/**
 * Display field value on the order edit page
 */
add_action('woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1);

function my_custom_checkout_field_display_admin_order_meta($order)
{
    $meta = get_post_meta($order->ID);
    $day11 = $meta['day_time'][0];
    $day_time = explode('_', $day11);
//print_r($day_time);
    $d_t0 = $day_time[0];
    $date_t = str_split($d_t0, 2);
    $final_time0 = $date_t[0];
    $final_time1 = $date_t[1];

    echo '<p><strong>' . __('PickUp Location Time') . ':</strong> <br/>' . $final_time0 . ':00 - ' . $final_time1 . ':00' . '</p>';
    echo '<p><strong>' . __('PickUp Location Day') . ':</strong> <br/>' . $day_time[1] . '</p>';
}

add_action('wp_ajax_nopriv_Change_pckpulocation', 'Change_pckpulocation');
add_action('wp_ajax_Change_pckpulocation', 'Change_pckpulocation');

function Change_pckpulocation()
{

    $location_val = $_POST['location_val'];
    ?>

    <div class="title_dt">Filteren op datum en tijd</div>
    <table border="1">
        <?php
        $loc_IDS = get_field('pickup_days_details1', $location_val);
        //print_r($loc_IDS);
        if ($loc_IDS[0]['check_days'] != '') {
            ?>
            <tr>
                <td></td>
              <!--  <td>maan</td>
                <td>dins</td>-->
                <td>woe</td>
                <td>don</td>
                <td>vri</td>
                <td>zat</td>
                <!--<td>zon</td>-->
            </tr>
            <?php
            $loc_IDS = get_field('pickup_days_details1', $location_val);

            foreach ($loc_IDS as $loc_ID) {
                $time = $loc_ID['time'];
                $healthy = [":00", "-"];
                $yummy = ["", "",];
                $times = str_replace($healthy, $yummy, $time);
                $days_t = $loc_ID['check_days'];


                if (in_array('maandag', $days_t)) {
                    $f_m = '';
                } else {
                    $f_m = 'disabled';
                }
                if (in_array('dinsdag', $days_t)) {
                    $f_tue = '';
                } else {
                    $f_tue = 'disabled';
                }
                if (in_array('woensdag', $days_t)) {
                    $f_w = '';
                } else {
                    $f_w = 'disabled';
                }
                if (in_array('donderdag', $days_t)) {
                    $f_thu = '';
                } else {
                    $f_thu = 'disabled';
                }
                if (in_array('vrijdag', $days_t)) {
                    $f_fri = '';
                } else {
                    $f_fri = 'disabled';
                }
                if (in_array('zaterdag', $days_t)) {
                    $f_sat = '';
                } else {
                    $f_sat = 'disabled';
                }
                if (in_array('zondag', $days_t)) {
                    $f_sun = '';
                } else {
                    $f_sun = 'disabled';
                }
                ?>
                <tr>
                    <td><?php echo $time; ?></td>
                    <!--<td style="background-color: #f7f7f7;"><?php if ($f_m == '') {
                        ?><input name="day_time" value="<?php echo $times; ?>_maandag" <?php echo $f_m; ?> type="radio"  ><?php
} ?></td>
                    <td style="background-color: #f7f7f7;"><?php if ($f_tue == '') {
                        ?><input name="day_time" value="<?php echo $times; ?>_dinsdag" <?php echo $f_tue; ?> type="radio"><?php
} ?></td>-->
                    <td style="background-color: #f7f7f7;"><?php if ($f_w == '') {
                        ?><input name="day_time" value="<?php echo $times; ?>_woensdag" <?php echo $f_w; ?> type="radio"><?php
} ?></td>
                    <td style="background-color: #f7f7f7;"><?php if ($f_thu == '') {
                        ?><input name="day_time" value="<?php echo $times; ?>_donderdag" <?php echo $f_thu; ?> type="radio"><?php
} ?></td>
                    <td style="background-color: #f7f7f7;"><?php if ($f_fri == '') {
                        ?><input name="day_time" value="<?php echo $times; ?>_vrijdag" <?php echo $f_fri; ?> type="radio"><?php
} ?></td>
                    <td style="background-color: #f7f7f7;"><?php if ($f_sat == '') {
                        ?><input name="day_time" value="<?php echo $times; ?>_zaterdag" <?php echo $f_sat; ?> type="radio"><?php
} ?></td>
                    <!--<td style="background-color: #f7f7f7;"><?php if ($f_sun == '') {
                        ?><input name="day_time" value="<?php echo $times; ?>_zondag" <?php echo $f_sun; ?> type="radio"><?php
} ?></td>-->
                </tr>
                <input type="hidden" value="" name="No_daytime">
                <?php
            }
        } else {
            echo "<span class='error_pickup' > Ophaallocatie is niet beschikbaar </span>";
            ?>

            <input type="hidden" value="No_daytime" name="No_daytime">
            <?php
        }
        ?>
    </table>
    <?php
    exit();
}

add_action('woocommerce_checkout_process', 'misha_check_if_selected');

function misha_check_if_selected()
{

// you can add any custom validations here
    if (empty($_POST['user_pickup_location'])) {
        wc_add_notice('Nog geen afhaallocatie geselecteerd.', 'error');
    }

    if ($_POST['No_daytime'] == '') {
        if (empty($_POST['day_time'])) {
            wc_add_notice('Selecteer uw afhaaldag en -tijd.', 'error');
        }
    }
}

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');

add_filter('woocommerce_account_menu_items', 'wc_get_account_menu_item', 99, 1);

function wc_get_account_menu_item()
{
    $endpoints = array(
        'orders' => get_option('woocommerce_myaccount_orders_endpoint', 'orders'),
        'downloads' => get_option('woocommerce_myaccount_downloads_endpoint', 'downloads'),
        'edit-address' => get_option('woocommerce_myaccount_edit_address_endpoint', 'edit-address'),
        'payment-methods' => get_option('woocommerce_myaccount_payment_methods_endpoint', 'payment-methods'),
        'edit-account' => get_option('woocommerce_myaccount_edit_account_endpoint', 'edit-account'),
        'customer-logout' => get_option('woocommerce_logout_endpoint', 'customer-logout'),
    );

    $items = array(
        'dashboard' => __('Mijn Account', 'woocommerce'),
        'orders' => __('Bestellingen', 'woocommerce'),
        //'downloads'       => __( 'Downloads', 'woocommerce' ),
        'edit-address' => __('Adressen', 'woocommerce'),
        'payment-methods' => __('Betaalmethoden', 'woocommerce'),
        'edit-account' => __('Accountgegevens', 'woocommerce'),
        'customer-logout' => __('Uitloggen', 'woocommerce'),
    );

// Remove missing endpoints.
    foreach ($endpoints as $endpoint_id => $endpoint) {
        if (empty($endpoint)) {
            unset($items[$endpoint_id]);
        }
    }

// Check if payment gateways support add new payment methods.
    if (isset($items['payment-methods'])) {
        $support_payment_methods = false;
        foreach (WC()->payment_gateways->get_available_payment_gateways() as $gateway) {
            if ($gateway->supports('add_payment_method') || $gateway->supports('tokenization')) {
                $support_payment_methods = true;
                break;
            }
        }

        if (!$support_payment_methods) {
            unset($items['payment-methods']);
        }
    }
    return $items;
//return apply_filters( 'woocommerce_account_menu_items', $items );
}

function sv_custom_woocommerce_catalog_orderby($sortby)
{

    unset($sortby['rating']);
    unset($sortby['date']);
    unset($sortby['popularity']);

    return $sortby;
}

add_filter('woocommerce_default_catalog_orderby_options', 'sv_custom_woocommerce_catalog_orderby');
add_filter('woocommerce_catalog_orderby', 'sv_custom_woocommerce_catalog_orderby');
if (!function_exists('print_attribute_radio_dev')) {

    function print_attribute_radio_dev($checked_value, $value, $label, $name, $regular_price, $name1)
    {
        global $product;

        $input_name = 'attribute_' . esc_attr($name);
        $esc_value = esc_attr($value);
        $id = esc_attr($name . '_v_' . $value . $product->get_id()); //added product ID at the end of the name to target single products
        $checked = checked($checked_value, $value, false);
        $filtered_label = apply_filters('woocommerce_variation_option_name', $label, esc_attr($name));
        printf('<input type="radio" name="%1$s" value="%2$s" id="%3$s" %4$s><label for="%3$s"><span>%7$s</span> <span class="sep">-</span> <span>%5$s</span> <span>%6$s</span></label> ', $input_name, $esc_value, $id, $checked, $filtered_label, $regular_price, $name1);
    }

}




add_filter('woocommerce_product_tabs', 'woo_remove_tabs', 98);

function woo_remove_tabs($tabs)
{
    if (is_product()) {
        unset($tabs['description']); // Remove the description tab
        unset($tabs['reviews']); // Remove the reviews tab
        unset($tabs['additional_information']); // Remove the additional information tab
    }
    return $tabs;
}

add_action('init', 'codex_ONZE_BOEREN_init');

/**
 * Register a Farmer post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_ONZE_BOEREN_init()
{
    $labels = array(
        'name' => _x('ONZE BOEREN', 'post type general name', 'your-plugin-textdomain'),
        'singular_name' => _x('ONZE BOEREN', 'post type singular name', 'your-plugin-textdomain'),
        'menu_name' => _x('ONZE BOEREN', 'admin menu', 'your-plugin-textdomain'),
        'name_admin_bar' => _x('ONZE BOEREN', 'add new on admin bar', 'your-plugin-textdomain'),
        'add_new' => _x('Add New', 'ONZE BOEREN', 'your-plugin-textdomain'),
        'add_new_item' => __('Add New ONZE BOEREN', 'your-plugin-textdomain'),
        'new_item' => __('New ONZE BOEREN', 'your-plugin-textdomain'),
        'edit_item' => __('Edit ONZE BOEREN', 'your-plugin-textdomain'),
        'view_item' => __('View ONZE BOEREN', 'your-plugin-textdomain'),
        'all_items' => __('All ONZE BOEREN', 'your-plugin-textdomain'),
        'search_items' => __('Search ONZE BOEREN', 'your-plugin-textdomain'),
        'parent_item_colon' => __('Parent ONZE BOEREN:', 'your-plugin-textdomain'),
        'not_found' => __('No Farmers found.', 'your-plugin-textdomain'),
        'not_found_in_trash' => __('No Farmers found in Trash.', 'your-plugin-textdomain')
    );

    $args = array(
        'labels' => $labels,
        'description' => __('Description.', 'your-plugin-textdomain'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'onze_boeren'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies' => array('category')
    );

    register_post_type('onze_boeren', $args);
}

// Hook in
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields($fields)
{
    unset($fields['billing']['billing_city']);
    //unset($fields['billing']['billing_country']);
    unset($fields['order']['order_comments']);
    /* unset($fields['billing']['billing_address_1']); */
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_state']);
    /* unset($fields['billing']['billing_postcode']); */
    return $fields;
}

/*
 * Creating a function to create our CPT
 */

function custom_post_type()
{

// Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Suppliers', 'Post Type General Name', 'twentythirteen'),
        'singular_name' => _x('Supplier', 'Post Type Singular Name', 'twentythirteen'),
        'menu_name' => __('Suppliers', 'twentythirteen'),
        'parent_item_colon' => __('Parent Supplier', 'twentythirteen'),
        'all_items' => __('All Suppliers', 'twentythirteen'),
        'view_item' => __('View Supplier', 'twentythirteen'),
        'add_new_item' => __('Add New Supplier', 'twentythirteen'),
        'add_new' => __('Add New', 'twentythirteen'),
        'edit_item' => __('Edit Supplier', 'twentythirteen'),
        'update_item' => __('Update Supplier', 'twentythirteen'),
        'search_items' => __('Search Supplier', 'twentythirteen'),
        'not_found' => __('Not Found', 'twentythirteen'),
        'not_found_in_trash' => __('Not found in Trash', 'twentythirteen'),
    );

// Set other options for Custom Post Type

    $args = array(
        'label' => __('suppliers', 'twentythirteen'),
        'description' => __('Supplier', 'twentythirteen'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields',),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        'taxonomies' => array('genres'),
        /* A hierarchical CPT is like Pages and can have
         * Parent and child items. A non-hierarchical CPT
         * is like Posts.
         */
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );

// Registering your Custom Post Type
    register_post_type('suppliers', $args);
}

/* Hook into the 'init' action so that the function
 * Containing our post type registration is not
 * unnecessarily executed.
 */

add_action('init', 'custom_post_type');

add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu()
{
    add_menu_page('Cron Run Manually', 'Cron', 'manage_options', 'gcron-plugin', 'test_init');
}

function test_init()
{
    ?>
    <h1>Start PDF generatie</h1>
    <p>Start de pdf generatie na het cut-off moment. je kunt dit moment instellen bij theme options.</p>
    <form action="" method="post">            
        <input type="text" value="test_upload1" name="test_upload" hidden="hidden"/>
    <?php submit_button('Start PDF generatie') ?>
    </form>
    <?php
    if (isset($_POST['test_upload'])) {
        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => site_url() . '/purchase_list_cron.php?action=manualcron',
        ));
// Send the request & save response to $resp
        $resp = curl_exec($curl);
// Close request to clear up some resources
        curl_close($curl);
        echo "<h3 style='color:green;'>PDF generatie was succesvol!</h3>";
    }
}

//Remove zoom from product page
add_action('after_setup_theme', 'removing_gallery_zoom', 100);

function removing_gallery_zoom()
{
    remove_theme_support('wc-product-gallery-zoom');
}

function remove_core_updates()
{
    global $wp_version;
    return(object) array('last_checked' => time(), 'version_checked' => $wp_version,);
}

add_filter('pre_site_transient_update_core', 'remove_core_updates');
add_filter('pre_site_transient_update_plugins', 'remove_core_updates');
add_filter('pre_site_transient_update_themes', 'remove_core_updates');
add_filter('auto_update_plugin', '__return_false');
add_filter('auto_update_theme', '__return_false');
// Product Navigation

register_sidebar(array(
    'name' => esc_html__('Product Navigation'),
    'id' => 'product-navigation',
    'description' => esc_html__('Widgets in this area are used in the product navigation region.', 'oceanwp'),
    'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>',
));
add_action('wp_ajax_nopriv_wp_wcmenucartmy', 'wp_wcmenucartmy');
add_action('wp_ajax_wp_wcmenucartmy', 'wp_wcmenucartmy');

function wp_wcmenucartmy()
{
    sleep(2);

    global $woocommerce;

    $cart_contents_count = $woocommerce->cart->get_cart_contents_count() + 1;
    echo $cart_contents_count;

    /* //echo $woocommerce->cart->cart_contents_count+1;
      $cart_contents =  sprintf(_n('%d', '%d', $cart_contents_count, 'twentyseventeen'), $cart_contents_count);
      // echo $cart_contents;
      $count = 0;
      foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
      $count++;
      }
      echo $count; */
}

function my_hide_shipping_when_free_is_available($rates)
{
    $free = array();
    foreach ($rates as $rate_id => $rate) {
        if ('free_shipping' === $rate->method_id) {
            $free[ $rate_id ] = $rate;
            break;
        }
    }
    return ! empty($free) ? $free : $rates;
}
add_filter('woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100);
add_action( 'woocommerce_save_account_details', 'my_account_saving_billing_phone', 10, 1 );
function my_account_saving_billing_phone( $user_id ) {
    $billing_phone = $_POST['billing_phone'];
    if( ! empty( $billing_phone ) )
        update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $billing_phone ) );
}