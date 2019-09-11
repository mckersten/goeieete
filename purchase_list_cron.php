<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
ob_start();
date_default_timezone_set("Europe/Amsterdam");
//mail("phptesting2018@gmail.com","My subject",date('d-m-y H:i:s'));

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

include_once 'cron_function.php';
date_default_timezone_set("Europe/Amsterdam");
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'cron') {
    run_cron();
}
//1st PDF supplier list
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'supplier') {
    run_cron_supplier();
}
//2nd PDF order pdf
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'singleorder') {
    cron_run_singleorder();
}
//3rd Pickup location wise pdf
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'pickup_location') {
    run_cron_pickup_location();
}
//4th Pickup location for all order
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'pickup_all_order') {
    run_cron_pickup_location_all();
}
//5th Pickup location for all order with sticker
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'stickers') {
    run_cron_stickers_all();
}
//6th update order status after run the cron
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'orderstatus') {

    update_order_status_complete();
}
// 7th get all order with per page 0 order
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'getallorders') {

    run_cron_getallorders();
}
//cron run manualy
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'manualcron') {
    //mail("phptesting2018@gmail.com","My subject 1",date('d-m-y H:i:s'));
    run_cron();
    sleep(10);
    run_cron_supplier();
    sleep(10);
    cron_run_singleorder();
    sleep(10);
    run_cron_pickup_location();
    sleep(10);
    run_cron_pickup_location_all();
    sleep(10);
    run_cron_stickers_all();
    sleep(10);
    update_order_status_complete();
    sleep(10);
    run_cron_getallorders();
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}
date_default_timezone_set("Europe/Amsterdam");
function run_cron() {
    global $wpdb;
    global $contactus_table;

    //mail("phptesting2018@gmail.com","My subject 2",date('d-m-y H:i:s'));
    $woocommerce = new Client(
            site_url(), 'ck_88662c47b20b21f0b4e3e698f157792a1a1efda4', 'cs_9592cd22399d0d542a108e9bf10205b57f5fb471', [
        'wp_api' => true,
        'version' => 'wc/v2',
            ]
    );

    $contactus_table = $wpdb->prefix . "purchase_list_cron";

    $slq1 = "TRUNCATE $contactus_table";
    if ($wpdb->query($slq1)) {
        
    }

    $ddate = date('Y-m-d H:i:s');
    $date = new DateTime($ddate);
    $week = $date->format("W");

    for ($v = 1; $v < 11; $v++) {


        $data = array(
            "page" => $v,
            "per_page" => 100,
            "status" => 'processing'
        );

        $cut_of_day = ot_get_option('cut_of_day');
        $cut_of_time = ot_get_option('cut_of_time');

        $order_details = $final_data = $order_items = $meta_datas = array();
        $orderID = $productid = $supplier_id = $pickup_id = $daytime_id = 0;
        $pickup_key = $pickup_value = $daytime_key = $daytime_value = $pickup_email = '';
        // $order_status = array("on-hold", "pending", "processing");
        $order_status = array("processing");
        $order_details = $woocommerce->get('orders', $data);
        //$order_details = $woocommerce->get('orders');

        /*  START login for process only last week record */
        $last_tuesday = strtotime("last " . $cut_of_day);
        $last_tuesday = date('w', $last_tuesday) == date('w') ? $last_tuesday + 7 * 86400 : $last_tuesday;
        $last_tuesday = date("Y-m-d", $last_tuesday);
        $last_tuesday = date("Y-m-d H:i:s", strtotime($last_tuesday . ' ' . $cut_of_time . ':00:00'));

        $today = strtotime("Today");
        $day_current = date("l", strtotime("Today"));
        $today = date("Y-m-d", $today);

        $nlast_tuesday = strtotime("last " . $cut_of_day . " -7 days");
        $nlast_tuesday = date('w', $nlast_tuesday) == date('w') ? $nlast_tuesday + 7 * 86400 : $nlast_tuesday;
        $nlast_tuesday = date("Y-m-d", $nlast_tuesday);
        $nlast_tuesday = date("Y-m-d H:i:s", strtotime($nlast_tuesday . ' ' . $cut_of_time . ':00:00'));

        /*  END login for process only last week record */

        if (!empty($order_details)) {
            foreach ($order_details as $order_detail) {

                //cas1 1 last tuesday 8.30 00.00.00 and today tuesday 8.29 23.59.59
                $rcd_is_count = 0;
                if ($day_current == $cut_of_day) {
                    if ((strtotime($order_detail->date_created) >= strtotime($last_tuesday)) && (strtotime($order_detail->date_created) <= strtotime($today . ' 19:59:59'))) {
                        $rcd_is_count = 1;
                    } elseif ((strtotime($order_detail->date_created) >= strtotime($nlast_tuesday)) && (strtotime($order_detail->date_created) <= strtotime($last_tuesday))) {
                        $rcd_is_count = 1;
                    }
                    if($rcd_is_count==1 && date("H") < $cut_of_time){
        
        $rcd_is_count = 0;
    }
                } else {
                    if ((strtotime($order_detail->date_created) >= strtotime($nlast_tuesday)) && (strtotime($order_detail->date_created) < strtotime($last_tuesday))) {
                        $rcd_is_count = 1;
                    }
                }
//mail("phptesting2018@gmail.com","My subject 3",date('d-m-y H:i:s'));
                if ($rcd_is_count == 1) {
//mail("phptesting2018@gmail.com","My subject 4",date('d-m-y H:i:s'));
                    $orderID = $order_detail->id;
                    $order = wc_get_order($orderID);

                    if (in_array($order_detail->status, $order_status)) {

                        $meta_datas = $order_detail->meta_data;
                        $location = $meta_datas[0]->key;
                        $pickup = get_post_meta($meta_datas[0]->value, 'pickup_location', true);
                        $pickup_email = get_post_meta($meta_datas[0]->value, 'pickup_location_email', true);

                        foreach ($meta_datas as $meta_data) {
                            for ($p = 0; $p < count($meta_datas); $p++) {
                                if ($meta_datas[$p]->key == 'user_pickup_location') {
                                    $pickup_id = $meta_datas[$p]->id;
                                    $pickup_key = $meta_datas[$p]->key;
                                    $pickup_value = $meta_datas[$p]->value;
                                } elseif ($meta_datas[$p]->key == 'day_time') {
                                    $daytime_id = $meta_datas[$p]->id;
                                    $daytime_key = $meta_datas[$p]->key;
                                    $daytime_value = $meta_datas[$p]->value;
                                }
                            }
                        }
                        //echo $result = substr($daytime_value, 0, 4);

                        $getntime = explode("_", $daytime_value);

                        if (strpos(substr($getntime[0], 0, 4), ':') !== false) {
                            $ntime = substr($getntime[0], 0, 5);
                            $ntime1 = substr($getntime[0], 5, 9);
                        } else {
                            $ntime = substr($getntime[0], 0, 2) . ":00";
                            $ntime1 = substr($getntime[0], 2, 6);
                        }
                        $time = $ntime.' - '.$ntime1;
                        $ntday = $getntime[1];
                        
                        $loc_IDS = get_field('pickup_days_details1', $pickup_value);
                        
                        $order_items = $order_detail->line_items;

                        foreach ($order_items as $order_item) {

                            $product_tags = array();
                            $is_biological_product = 0;
                            $productname = $order_item->name;
                            $productid = $order_item->product_id;
                            /* START check it is bio logical product or not */
                            $product_tags = get_the_terms($productid, 'product_tag');
                            if (!empty($product_tags)) {
                                foreach ($product_tags as $product_tag) {
                                    if ($product_tag->term_id == 40) {
                                        $is_biological_product = 1;
                                    }
                                }
                            }
                            /* END check it is bio logical product or not */

                            $supplier_id = get_field('supplier_name_select', $productid);
                            $farmercompny = get_the_title($supplier_id);
                            $supplier_name = get_field('supplier__first__name', $supplier_id);
                            $supplier_name .= ' ' . get_field('supplier_last_name', $supplier_id);
                            $supplier_email = get_field('supplier_email_address', $supplier_id);
                            $values_kgs = wc_get_product_terms($productid, 'pa_verpakkingseenheid', array('fields' => 'all'));
                            $unit = array();
                            $total_count = count($values_kgs);
                            foreach ($values_kgs as $values_kg) {
                                $unit[] = $values_kg->name;
                            }

                            $unit_type = implode(",", $unit);

                            $Inkoop_prijs_Incl = get_field('inkoop_prijsinkoop_prijsinclincl', $productid);
                            $Inkoop_prijs_Excl = get_field('inkoop_prijsexcl', $productid);

                           // $time = str_replace("-", " tot ", $loc_IDS[0]['time']);

                            $final_data['order_id'] = $order_detail->id;
                            $final_data['product_id'] = $productid;
                            $final_data['supplier_id'] = $supplier_id;
                            $final_data['pickup_id'] = $pickup_id;
                            $final_data['pickup_value'] = $pickup_value;
                            $final_data['daytime_id'] = $daytime_id;
                            $final_data['daytime_value'] = $daytime_value;
                            $final_data['status'] = $order_detail->status;
                            $final_data['order_date'] = $order_detail->date_created;
                            $final_data['sku_id'] = $order_item->sku;
                            $final_data['product_name'] = $order_item->name;
                            $final_data['packing_unit'] = $order_item->quantity;
                            $final_data['unit_price'] = round($order_item->price, 2);
                            $final_data['price'] = round($order_item->total, 2);
                            $final_data['supplier_name'] = $supplier_name;
                            $final_data['supplier_email'] = $supplier_email;
                            $final_data['unit_type'] = $unit_type;
                            $final_data['customer_name'] = $order_detail->billing->first_name;
                            $final_data['customer_name'] .= ' ' . $order_detail->billing->last_name;
                            $final_data['customer_email'] = $order_detail->billing->email;
                            $final_data['customer_phone'] = $order_detail->billing->phone;
                            $final_data['is_biological_product'] = $is_biological_product;
                            $final_data['pickup_location'] = $pickup;
                            $final_data['pickup_time'] = $time;
                            $final_data['pickup_day'] = $ntday;
                            $final_data['pickup_week'] = $week;
                            $final_data['customer_id'] = $order_detail->customer_id;
                            $final_data['pickup_email'] = $pickup_email;
                            $final_data['purchase_price_incl'] = $Inkoop_prijs_Incl;
                            $final_data['purchase_price_excl'] = $Inkoop_prijs_Excl;
                            $final_data['farmer_company'] = $farmercompny;
                            $final_data['cart_tax'] = $order_detail->cart_tax;
                            save_order_date($final_data);
                        }
                    }
                }/* else{echo $order_detail->date_created.'<br>';} */
            }
        } else {
            //mail("phptesting2018@gmail.com","My subject 5",date('d-m-y H:i:s'));
            break;
        }
    }
    //mail("phptesting2018@gmail.com","My subject 6",date('d-m-y H:i:s'));
}

function run_cron_supplier() {
    global $wpdb;
    global $contactus_table;
    $pdf_date = '_' . date('dmY');

    $ddate = date('Y-m-d H:i:s');
    $date = new DateTime($ddate);
    $week = $date->format("W");

    $select_supplier = $wpdb->get_results("SELECT DISTINCT supplier_id from  $contactus_table");
    $suup_list = array();
    foreach ($select_supplier as $select_suppliers) {
        if ($select_suppliers->supplier_id != 0) {
            $sup_id = $select_suppliers->supplier_id;
            $get_spp_data = $wpdb->get_results("select * from $contactus_table where supplier_id = '" . $sup_id . "' group by product_id order by product_name ASC ");

            $suup_lists = array();
            $suup_lists[] = $get_spp_data;
            $suup_list[$sup_id] = $get_spp_data;
        }
    }
    if (!empty($suup_list)) {

        foreach ($suup_list as $key => $suup) {
            $supplier_id = $key;
            $tbl = '';
            $grandtotal = 0;
            $tbl .= '<table width="100%">
      <tr><td style="float:left" width="80%"><h1>' . $suup[0]->farmer_company . '</h1><br>
      <h5 style="font-size:12px;">Week:' . $week . '</h5></td>
<td style="float:right" width="80%"><img src="' . site_url() . '/img/logo.png" style="float:right"; width="100px;"></td>      
</tr>
</table>
    <table class="table table-bordered table-striped text-left" style=\"width:100%;\" >
      <tr>
        <th   style="font-size:12px;font-weight:bold;  background-color:#F2F2F2;  width:10%;  height:20;">Artikel nr</th>
        <th   style="font-size:12px;font-weight:bold;  background-color:#F2F2F2; width:40%;  height:20;">Product naam</th>
        <th   style="font-size:12px;font-weight:bold;  background-color:#F2F2F2; width:20%;  height:20;">Verpakkings eenheid</th>
        <th   style="font-size:12px;font-weight:bold;  background-color:#F2F2F2; width:8%;  height:20;">Aantal</th>
        <th   style="font-size:12px;font-weight:bold; background-color:#F2F2F2;  width:15%;  height:20;">Eenheidsprijs</th>
        <th   style="font-size:12px;font-weight:bold; background-color:#F2F2F2;  width:7%;  height:20;">Prijs</th>
      </tr>';

            for ($p = 0; $p < count($suup); $p++) {

                /* $get_spp_data_multiproducts = $wpdb->get_results("select count(*) as totalprds from $contactus_table where supplier_id = ".$supplier_id." and product_id=".$suup[$p]->product_id.""); */
                $get_spp_data_multiproducts = $wpdb->get_results("select sum(packing_unit) as totalprds from $contactus_table where supplier_id = " . $supplier_id . " and product_id=" . $suup[$p]->product_id . "");
                $nofproduct = 1;
                if (!empty($get_spp_data_multiproducts)) {
                    $nofproduct = $get_spp_data_multiproducts[0]->totalprds;
                }
                //$totalprc = round(($suup[$p]->packing_unit * $suup[$p]->purchase_price_incl), 2);
                $totalprc = round(($nofproduct * $suup[$p]->purchase_price_excl), 2);
                $grandtotal = $grandtotal + $totalprc;
                $tbl .= '<tr>
        <td style="font-size:12px;color:#000000; background-color:#FFFFFF;" height="20">' . $suup[$p]->sku_id . '</td>
        <td style="font-size:12px;color:#000000; background-color:#FFFFFF;" height="20">' . $suup[$p]->product_name . '</td>
        <td style="font-size:12px;color:#000000; background-color:#FFFFFF;" height="20">' . $suup[$p]->unit_type . '</td>
        <td style="font-size:12px;color:#000000; background-color:#FFFFFF;" height="20">' . $nofproduct . '</td>
        <td style="font-size:12px;color:#000000; background-color:#FFFFFF;" height="20">&euro; ' . $suup[$p]->purchase_price_excl . '</td>
        <td style="font-size:12px;color:#000000; background-color:#FFFFFF;" height="20">&euro; ' . number_format($totalprc, 2) . '</td>
      </tr>';
            }
            $tbl .= '<tr>
        <th style="font-size:12px;color:#000000; font-weight:bold; background-color:#F2F2F2;  height:20;">Totaal</th>
        <th style="font-size:12px;color:#000000; font-weight:bold; background-color:#F2F2F2;  height:20;"></th>
        <th style="font-size:12px;color:#000000; font-weight:bold; background-color:#F2F2F2;  height:20;"></th>
        <th style="font-size:12px;color:#000000; font-weight:bold; background-color:#F2F2F2;  height:20;"></th>
        <th style="font-size:12px;color:#000000; font-weight:bold; background-color:#F2F2F2;  height:20;"></th>
        <th style="font-size:12px;color:#000000; font-weight:bold; background-color:#F2F2F2;  height:20;">&euro; ' . number_format($grandtotal, 2) . '</th>
      </tr></table>';

            $tbl .= ot_get_option('supllier_pdf_notes');

            create_PDF($tbl, $supplier_id . $pdf_date, $suup[0]->supplier_name, $suup[0]->supplier_email, 'supplier');
            //sleep(5);
            send_PDF_mail($subject = 'Goei Eete | Inkooplijst Week ' . $suup[0]->pickup_week, $suup[0]->supplier_name, $suup[0]->supplier_email, dirname(__FILE__) . '/PDFs/supplier_' . $supplier_id . $pdf_date . '.pdf');
            // sleep(5);
        }
    }
}

function cron_run_singleorder() {
    global $wpdb;
    global $contactus_table;

$ddate = date('Y-m-d H:i:s');
    $date = new DateTime($ddate);
    $week = $date->format("W");
    
    $select_orders = $wpdb->get_results("SELECT DISTINCT order_id from  $contactus_table");

    $order_list = array();
    foreach ($select_orders as $select_order) {

        $order_id = $select_order->order_id;
        $get_ord_data = $wpdb->get_results("select * from $contactus_table where order_id = '" . $order_id . "'");

        $order_list[$order_id] = $get_ord_data;
    }

    if (!empty($order_list)) {

        foreach ($order_list as $key => $ord) {
            $order_id = $key;
            $tbl = $mailtbl = '';
            $grandtotal = 0;

            $tbl .= '<table width="100%">
      <tr><td style="float:left" width="80%"><h1>Week: '.$week.'<br><br>' . $ord[0]->customer_name . '</h1>
      <h5 style="font-size:12px;">' . $ord[0]->pickup_location . '</h5><br>
          ' . $ord[0]->pickup_day . ' pav ' . $ord[0]->pickup_time . '<br>
          <b>Bestelling :' . $order_id . '</b>
              </td>
<td style="float:right" width="80%"><img src="' . site_url() . '/img/logo.png" style="float:right"; width="100px;"></td>      
</tr>
</table><br>
    <table class="table table-bordered table-striped text-left" style=\"width:100%;\" >
      <tr>
        <th   style="font-size:14px;font-weight:bold; background-color:#F2F2F2; width:10%;">Sku</th>
        <th   style="font-size:14px;font-weight:bold; background-color:#F2F2F2; width:10%;">Aantal</th>
        <th   style="font-size:14px;font-weight:bold; background-color:#F2F2F2; width:20%;">Eenheid</th>
        <th   style="font-size:14px;font-weight:bold; background-color:#F2F2F2; width:60%;">Product Naam</th>        
      </tr>';
            for ($p = 0; $p < count($ord); $p++) {
                $terms = get_the_terms($ord[$p]->product_id, 'product_tag');

                if ($terms[0]->term_id != '40') {
                    $tbl .= '<tr>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$p]->sku_id . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$p]->packing_unit . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$p]->unit_type . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$p]->product_name . '</td>        
      </tr>';
                }
            }
            $tbl .= '<tr></tr></table>';

            $is_bio_product = 0;
            $tbl1 = '';
            $tbl1 .= '<h3>Biologisch</h3>';
            $tbl1 .= '<table class="table table-bordered table-striped text-left" style=\"width:100%;\" >
      <tr>
        <th style="font-size:14px; color:#000000; font-weight:bold; background-color:#F2F2F2; width:10%;">Sku</th>
        <th style="font-size:14px; color:#000000; font-weight:bold; background-color:#F2F2F2; width:10%;">Aantal</th>
        <th style="font-size:14px; color:#000000; font-weight:bold; background-color:#F2F2F2; width:20%;">Eenheid</th>
        <th style="font-size:14px; color:#000000; font-weight:bold; background-color:#F2F2F2; width:60%;">Product Naam</th>        
      </tr>';
            for ($m = 0; $m < count($ord); $m++) {
                $terms = get_the_terms($ord[$m]->product_id, 'product_tag');

                if ($terms[0]->term_id == '40') {
                    $tbl1 .= '<tr>
                    <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$m]->sku_id . '</td>
                    <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$m]->packing_unit . '</td>
                    <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$m]->unit_type . '</td>
                    <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$m]->product_name . '</td>        
                  </tr>';
                    $is_bio_product = 1;
                }
            }
            $tbl1 .= '<tr></tr></table>';

            if ($is_bio_product == 1) {
                $mailtbl = $tbl . $tbl1;
            } else {
                $mailtbl = $tbl;
            }

//            create_PDF($mailtbl, $order_id, $ord[0]->customer_name, $ord[0]->customer_email, 'order');
//            send_PDF_mail($subject = 'Goei Eete | Inpaklijst order ' . $order_id, 'info@exulto.nl', $ord[0]->customer_email, dirname(__FILE__) . '/PDFs/order_' . $order_id . '.pdf');
            create_PDF($mailtbl, $order_id, $ord[0]->customer_name, 'goeieetetilburg@gmail.com', 'order');
            send_PDF_mail($subject = 'Goei Eete | Inpaklijst order ' . $order_id, $ord[0]->customer_name, 'goeieetetilburg@gmail.com', dirname(__FILE__) . '/PDFs/order_' . $order_id . '.pdf',1);
        }
    }
}

function run_cron_pickup_location() {
    global $wpdb;
    global $contactus_table;
    $distribution_center_list = array();
    $pdf_date = '_' . date('dmY');

    $distribution_center_1 = $distribution_center_2 = $distribution_center_3 = $distribution_center_4 = $distribution_center_5 = '';
    $distribution_center_1 = ot_get_option('distribution_center_1');
    $distribution_center_2 = ot_get_option('distribution_center_2');
    $distribution_center_3 = ot_get_option('distribution_center_3');
    $distribution_center_4 = ot_get_option('distribution_center_4');
    $distribution_center_5 = ot_get_option('distribution_center_5');

    if ($distribution_center_1 != '') {
        $distribution_center_list[] = $distribution_center_1;
    }
    if ($distribution_center_2 != '') {
        $distribution_center_list[] = $distribution_center_2;
    }
    if ($distribution_center_3 != '') {
        $distribution_center_list[] = $distribution_center_3;
    }
    if ($distribution_center_4 != '') {
        $distribution_center_list[] = $distribution_center_4;
    }
    if ($distribution_center_5 != '') {
        $distribution_center_list[] = $distribution_center_5;
    }

    $pickup_location = $wpdb->get_results("SELECT DISTINCT pickup_value from  $contactus_table");
    $pickup_list = array();

    foreach ($pickup_location as $pickup_locations) {
        if ($pickup_locations->pickup_value != 0) {
            $pickup_id = $pickup_locations->pickup_value;

            $get_pick_data = $wpdb->get_results("SELECT order_id,pickup_week,pickup_value,customer_name,customer_id,pickup_time,pickup_day,pickup_location,customer_phone, sum(packing_unit) as qty, sum(price) as total, sum(cart_tax) as carttax,cart_tax FROM `wp_purchase_list_cron` WHERE pickup_value = $pickup_id GROUP BY order_id");

            $pick_lists = array();
            $pick_lists[] = $get_pick_data;
            $pick_list[$pickup_id] = $get_pick_data;
        }
    }
    if (!empty($pick_list)) {
        foreach ($pick_list as $key => $pickup) {
            $mypickup_id = $key;
            $tbl = '';
            $grandtotal = 0;

            $ddate = date('Y-m-d H:i:s');
            $date = new DateTime($ddate);
            $week = $date->format("W");

            $tbl .= '<table width="100%">
      <tr><td style="float:left" width="80%">
      <h1>' . get_the_title($pick_list[$mypickup_id][0]->pickup_value) . '</h1>
      <h5 style="font-size:12px;">Week:' . $week . '</h5></td>
<td style="float:right" width="80%"><img src="' . site_url() . '/img/logo.png" style="float:right"; width="100px;"></td>      
</tr>
</table>
    <table class="table table-bordered table-striped text-left" style="width:100%; border: 1px solid #dee2e6;" >
      <tr class="mn" valign="bottom">
        <th valign="bottom" style="font-size:12px;padding:10px;font-weight:bold; background-color:#F2F2F2; width:25%;vertical-align:bottom;"><br><br><br><br><br><br><br><br><br><br>Afhaal Tijd</th>
        <th valign="bottom" style="font-size:12px;padding:10px;font-weight:bold; background-color:#F2F2F2; width:25%;vertical-align:bottom;"><br><br><br><br><br><br><br><br><br><br>Naam</th>
        <th valign="bottom" style="font-size:12px;padding:10px;font-weight:bold; background-color:#F2F2F2;width:11%;vertical-align:bottom;"><br><br><br><br><br><br><br><br><br><br>Bestelling</th>
        <th valign="bottom" style="font-size:12px;padding:10px;font-weight:bold; background-color:#F2F2F2; width:9%;vertical-align:bottom;"><br><br><br><br><br><br><br><br><br><br>Prijs</th>
        <th valign="bottom" style="font-size:12px;padding:10px;font-weight:bold; background-color:#F2F2F2; width:5%;vertical-align:bottom;text-align:center;"><br><br><br><br><img src="' . site_url() . '/img/cont.jpg" /></th>

        <th valign="bottom" style="font-size:12px;padding:10px;font-weight:bold; background-color:#F2F2F2;width:25%;vertical-align:bottom;text-align:center;"><br><img src="' . site_url() . '/img/Hand.jpg" /></th>
      </tr>';
            for ($q = 0; $q < count($pickup); $q++) {
                $totalprc = round(($pickup[$q]->packing_unit * $pickup[$q]->unit_price), 2);
                $grandtotal = $grandtotal + $totalprc;
                $tbl .= '<tr>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $pickup[$q]->pickup_day . ' van ' . $pickup[$q]->pickup_time . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $pickup[$q]->customer_name . '<br>' . $pickup[$q]->customer_phone . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $pickup[$q]->order_id . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">&euro; ' . number_format(($pickup[$q]->total + $pickup[$q]->cart_tax), 2) . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;"></td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;"></td>
      </tr>';
            }
            $tbl .= '</table><br>Voor vragen of opmerkingen over bestelling bel 013 - 5810013';

            create_PDF($tbl, $mypickup_id . $pdf_date, $pickup[0]->pickup_location, $pickup[0]->pickup_email, 'distribution');
            for ($dc = 0; $dc < count($distribution_center_list); $dc++) {
                send_PDF_mail($subject = 'Goei Eete | Aftekenlijsten Week ' . $pickup[0]->pickup_week, 'Distribution Center', $distribution_center_list[$dc], dirname(__FILE__) . '/PDFs/distribution_' . $mypickup_id . $pdf_date . '.pdf',1);
            }
        }
    }
}

function run_cron_pickup_location_all() {
    global $wpdb;
    global $contactus_table;
    $pdf_date = date('dmY');
    $pdf_date_week = $week = (int) date('W', $date);
    $mainpsfid = 324598785;
    $mainpsfid .= '_' . $pdf_date;
    $pickup_location = $wpdb->get_results("SELECT DISTINCT pickup_value from  $contactus_table");

    $pickup_list = array();

    foreach ($pickup_location as $pickup_locations) {
        if ($pickup_locations->pickup_value != 0) {
            $pickup_id = $pickup_locations->pickup_value;

            $get_pick_data = $wpdb->get_results("SELECT order_id,pickup_week,pickup_value,customer_name,customer_id,pickup_time,pickup_day,pickup_location, sum(packing_unit) as qty, sum(price) as total FROM `wp_purchase_list_cron` WHERE pickup_value = $pickup_id GROUP BY order_id");

            $pick_lists = array();
            $pick_lists[] = $get_pick_data;
            $pick_list[$pickup_id] = $get_pick_data;
        }
    }
    if (!empty($pick_list)) {


        foreach ($pick_list as $key => $pickup) {
            $mypickup_id = $key;

            $grandtotal = 0;
            $ddate = date('Y-m-d H:i:s');
            $date = new DateTime($ddate);
            $week = $date->format("W");

            $tbl .= '<table width="100%">
      <tr><td style="float:left" width="80%">
      <h1>' . get_the_title($pick_list[$mypickup_id][0]->pickup_value) . '</h1>
      <h5 style="font-size:12px;">Week:' . $week . '</h5></td>
<td style="float:right" width="80%"><img src="' . site_url() . '/img/logo.png" style="float:right"; width="100px;"></td>      
</tr>
</table>
    <table class="table table-bordered table-striped text-left" style=\"width:100%;\" >
      <tr>
   <th valign="bottom" style="padding:10px;font-size:12px;font-weight:bold; background-color:#F2F2F2; width:25%;vertical-align:bottom;"><br><br><br><br><br><br><br><br><br><br>Afhaal Tijd</th>
        <th valign="bottom" style="font-size:14px;padding:10px;font-weight:bold; background-color:#F2F2F2; width:25%;vertical-align:bottom;"><br><br><br><br><br><br><br><br><br><br>Naam</th>
        <th valign="bottom" style="font-size:14px;padding:10px;font-weight:bold; background-color:#F2F2F2;width:11%;vertical-align:bottom;"><br><br><br><br><br><br><br><br><br><br>Bestelling</th>
        <th valign="bottom" style="font-size:14px;padding:10px;font-weight:bold; background-color:#F2F2F2; width:9%;vertical-align:bottom;"><br><br><br><br><br><br><br><br><br><br>Prijs</th>
        <th valign="bottom" style="font-size:14px;padding:10px;font-weight:bold; background-color:#F2F2F2; width:5%;vertical-align:bottom;text-align:center;"><br><br><br><br><img src="' . site_url() . '/img/cont.jpg" /></th>
        
        <th valign="bottom" style="font-size:12px;padding:10px;font-weight:bold; background-color:#F2F2F2;width:25%;vertical-align:bottom;text-align:center;"><br><img src="' . site_url() . '/img/Hand.jpg" /></th>
      </tr>';
            for ($q = 0; $q < count($pickup); $q++) {
                $totalprc = round(($pickup[$q]->packing_unit * $pickup[$q]->price), 2);
                $grandtotal = $grandtotal + $totalprc;
                $tbl .= '<tr>
        <td style="font-size:14px;color:#000000; background-color:#FFFFFF;">' . $pickup[$q]->pickup_day . '&nbsp;' . $pickup[$q]->pickup_time . '</td>
        <td style="font-size:14px;color:#000000; background-color:#FFFFFF;">' . $pickup[$q]->customer_name . '</td>
        <td style="font-size:14px;color:#000000; background-color:#FFFFFF;">' . $pickup[$q]->order_id . '</td>
        <td style="font-size:14px;color:#000000; background-color:#FFFFFF;">&euro;' . number_format($pickup[$q]->total, 2) . '</td>
      
        <td style="font-size:14px;color:#000000; background-color:#FFFFFF;"></td>
        <td style="cfont-size:14px;olor:#000000; background-color:#FFFFFF;"></td>
      </tr>';
            }
            $tbl .= '</table><br><br><br><hr>';
        }

        create_PDF($tbl, $mainpsfid, '', $pickup[0]->supplier_email, 'distribution_all');
        $distribution_center_list = array();

        $distribution_center_1 = $distribution_center_2 = $distribution_center_3 = $distribution_center_4 = $distribution_center_5 = '';
        $distribution_center_1 = ot_get_option('distribution_center_1');
        $distribution_center_2 = ot_get_option('distribution_center_2');
        $distribution_center_3 = ot_get_option('distribution_center_3');
        $distribution_center_4 = ot_get_option('distribution_center_4');
        $distribution_center_5 = ot_get_option('distribution_center_5');

        if ($distribution_center_1 != '') {
            $distribution_center_list[] = $distribution_center_1;
        }
        if ($distribution_center_2 != '') {
            $distribution_center_list[] = $distribution_center_2;
        }
        if ($distribution_center_3 != '') {
            $distribution_center_list[] = $distribution_center_3;
        }
        if ($distribution_center_4 != '') {
            $distribution_center_list[] = $distribution_center_4;
        }
        if ($distribution_center_5 != '') {
            $distribution_center_list[] = $distribution_center_5;
        }
        //for ($dc = 0; $dc < count($distribution_center_list); $dc++) {
        send_PDF_mail($subject = ' Goei Eete | Aftekenlijsten Totaal Week ' . $pickup[0]->pickup_week, 'Distribution Center', 'goeieetetilburg@gmail.com', dirname(__FILE__) . '/PDFs/distribution_all_' . $mainpsfid . '.pdf',1);
        // }
    }
}

function run_cron_stickers_all() {
    global $wpdb;
    global $contactus_table;
    $symbcnt = 1;
    $stickersno = date('YmdHis');

    $ddate = date('Y-m-d H:i:s');
    $date = new DateTime($ddate);
    $week = $date->format("W");

    $select_orders = $wpdb->get_results("SELECT DISTINCT order_id from  $contactus_table");

    $order_list = array();
    foreach ($select_orders as $select_order) {

        $order_id = $select_order->order_id;
        $get_ord_data = $wpdb->get_results("select * from $contactus_table where order_id = '" . $order_id . "'");

        $order_list[$order_id] = $get_ord_data;
    }
    $tbl .= '';
    if (!empty($order_list)) {

        $tbl .= '<table width="100%" border="0"  >';

        foreach ($order_list as $key => $ord) {
            $order_id = $key;
            //$tbl = $mailtbl = '';
            //$grandtotal = 0;
            $loc_IDS = get_field('pickup_location_symbol', $ord[0]->pickup_value);
            if (!isset($loc_IDS['url'])) {
                $loc_IDS['url'] = '';
            }

            $even = array(0, 2, 4, 6, 8, 10, 12, 14);
            $odd = 0;
            if (in_array(substr($symbcnt, -1), $even)) {

                $tbl .= '<td style="float:right; width:360px; height:150px; boarde ">
      <h1  style="margin:0px;">' . $ord[0]->customer_name . '</h1>
      <table width="100%"  border="0" ><tr><td style="width:80%;"><b>' . get_the_title($ord[0]->pickup_value) . '</b><br>' . $ord[0]->pickup_day . ' pav ' . $ord[0]->pickup_time . '<br><br>Bestelling :' . $order_id . '</td>
              <td style="float:right; width:20%;">
              <img src="' . $loc_IDS['url'] . '"  style="width:40px; height:40px;" > </td></tr></table></td></tr>';
                $odd = 0;
            } else {
                $tbl .= '<tr><td style="float:left; width:360px; height:150px; "> <h1 style="margin:0px;">' . $ord[0]->customer_name . '</h1>
      <table width="100%"  border="0"><tr><td style="width:80%;"><b>' . get_the_title($ord[0]->pickup_value) . '</b><br>' . $ord[0]->pickup_day . ' pav ' . $ord[0]->pickup_time . '<br><br>Bestelling :' . $order_id . '</td>
              <td style="float:right; width:20%;">
              <img src="' . $loc_IDS['url'] . '" style="width:40px; height:40px;" > </td></tr></table></td>';
                $odd = 1;
            }

            $symbcnt++;
        }
        if ($odd == 1) {
            $tbl .= '<td style="float:right; width:373px; height:150px;"> &nbsp; </td></tr></table></td></tr>';
        }
        $tbl .= '</table>';


        create_PDF($tbl, $stickersno, 'Admin', '', 'order_with_stickers', 1);
        $distribution_center_list = array();

        $distribution_center_1 = $distribution_center_2 = $distribution_center_3 = $distribution_center_4 = $distribution_center_5 = '';
        $distribution_center_1 = ot_get_option('distribution_center_1');
        $distribution_center_2 = ot_get_option('distribution_center_2');
        $distribution_center_3 = ot_get_option('distribution_center_3');
        $distribution_center_4 = ot_get_option('distribution_center_4');
        $distribution_center_5 = ot_get_option('distribution_center_5');

        if ($distribution_center_1 != '') {
            $distribution_center_list[] = $distribution_center_1;
        }
        if ($distribution_center_2 != '') {
            $distribution_center_list[] = $distribution_center_2;
        }
        if ($distribution_center_3 != '') {
            $distribution_center_list[] = $distribution_center_3;
        }
        if ($distribution_center_4 != '') {
            $distribution_center_list[] = $distribution_center_4;
        }
        if ($distribution_center_5 != '') {
            $distribution_center_list[] = $distribution_center_5;
        }
        for ($dc = 0; $dc < count($distribution_center_list); $dc++) {
            send_PDF_mail($subject = 'Goei Eete | Stickers week ' . $week, 'Distribution Center', $distribution_center_list[$dc], dirname(__FILE__) . '/PDFs/order_with_stickers_' . $stickersno . '.pdf');
        }
    }
}

function update_order_status_complete() {
    global $wpdb;
    global $contactus_table;

    $woocommerce = new Client(
            site_url(), 'ck_88662c47b20b21f0b4e3e698f157792a1a1efda4', 'cs_9592cd22399d0d542a108e9bf10205b57f5fb471', [
        'wp_api' => true,
        'version' => 'wc/v2',
            ]
    );

    $select_orders = $wpdb->get_results("SELECT DISTINCT order_id from  $contactus_table where status ='processing'");

    foreach ($select_orders as $select_order) {

        $order_id = $select_order->order_id;
        $order = new WC_Order($order_id);
        $order->update_status('completed');

        /* $data = array("status" => "completed");
          print_R($woocommerce->put('orders/' . $order_id, $data)); */
    }
}

function run_cron_getallorders() {
    global $wpdb;
    global $contactus_table;
    $pdf_date = date('dmY');
    $select_orders = $wpdb->get_results("SELECT DISTINCT order_id from  $contactus_table");

    $ddate = date('Y-m-d H:i:s');
    $date = new DateTime($ddate);
    $week = $date->format("W");
    
    $order_list = array();
    foreach ($select_orders as $select_order) {

        $order_id = $select_order->order_id;
        $get_ord_data = $wpdb->get_results("select * from $contactus_table where order_id = '" . $order_id . "'");

        $order_list[$order_id] = $get_ord_data;
    }

    if (!empty($order_list)) {
        $v = 1;
        foreach ($order_list as $key => $ord) {
            $order_id = $key;
            $tbl = $mailtbl = '';
            $grandtotal = 0;

            $tbl .= '<table width="100%">
                <tr><td style="float:left" width="80%"><h1>Week: '.$week.'<br><br>' . $ord[0]->customer_name . '</h1>
      <h5 style="font-size:12px;">' . $ord[0]->pickup_location . '</h5><br>
          ' . $ord[0]->pickup_day . ' pav ' . $ord[0]->pickup_time . '<br>
          <b>Bestelling :' . $order_id . '</b>
              </td>
<td style="float:right" width="80%"><img src="' . site_url() . '/img/logo.png" style="float:right"; width="100px;"></td>      
</tr>
</table><br>
    <table class="table table-bordered table-striped text-left" style=\"width:100%;\" >
      <tr>
        <th   style="font-size:14px;font-weight:bold; background-color:#F2F2F2; width:10%;">Sku</th>
        <th   style="font-size:14px;font-weight:bold; background-color:#F2F2F2; width:10%;">Aantal</th>
        <th   style="font-size:14px;font-weight:bold; background-color:#F2F2F2; width:20%;">Eenheid</th>
        <th   style="font-size:14px;font-weight:bold; background-color:#F2F2F2; width:60%;">Product Naam</th>        
      </tr>';
            for ($p = 0; $p < count($ord); $p++) {
                $terms = get_the_terms($ord[$p]->product_id, 'product_tag');

                if ($terms[0]->term_id != '40') {
                    $tbl .= '<tr>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$p]->sku_id . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$p]->packing_unit . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$p]->unit_type . '</td>
        <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$p]->product_name . '</td>        
      </tr>';
                }
            }
            $tbl .= '<tr></tr></table><br> <br> ';

            $is_bio_product = 0;
            $tbl1 = '';
            $tbl1 .= '<h3>Biologisch</h3>';
            $tbl1 .= '<table class="table table-bordered table-striped text-left" style=\"width:100%;\" >
      <tr>
        <th style="font-size:14px; color:#000000; font-weight:bold; background-color:#F2F2F2; width:10%;">Sku</th>
        <th style="font-size:14px; color:#000000; font-weight:bold; background-color:#F2F2F2; width:10%;">Aantal</th>
        <th style="font-size:14px; color:#000000; font-weight:bold; background-color:#F2F2F2; width:20%;">Eenheid</th>
        <th style="font-size:14px; color:#000000; font-weight:bold; background-color:#F2F2F2; width:60%;">Product Naam</th>        
      </tr>';
            for ($m = 0; $m < count($ord); $m++) {
                $terms = get_the_terms($ord[$m]->product_id, 'product_tag');

                if ($terms[0]->term_id == '40') {
                    $tbl1 .= '<tr>
                    <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$m]->sku_id . '</td>
                    <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$m]->packing_unit . '</td>
                    <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$m]->unit_type . '</td>
                    <td style="font-size:14px; color:#000000; background-color:#FFFFFF;">' . $ord[$m]->product_name . '</td>        
                  </tr>';
                    $is_bio_product = 1;
                }
            }
            $tbl1 .= '<tr></tr></table>';


            if ($is_bio_product == 1) {
                $mailtbl = $tbl . $tbl1;
            } else {
                $mailtbl = $tbl;
            }
            if ($v != count($order_list)) {

                $mailtbl .= '<br pagebreak="true"/>';
            }
            $new_arry[] = $mailtbl;
            $v++;
        }


        $final_arr = implode(" ", $new_arry);

        create_PDF($final_arr, $pdf_date, 'Admin', '', 'all_order', 0);

        $admin_email = get_option('admin_email');
        send_PDF_mail($subject = 'Goei Eete | Inpaklijst order ', 'Admin', $admin_email, dirname(__FILE__) . '/PDFs/all_order_' . $pdf_date . '.pdf');
        //exit;
    } 
}
