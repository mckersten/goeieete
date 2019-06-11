<?php
date_default_timezone_set("Europe/Amsterdam");
require_once( dirname(__FILE__) . '/wp-load.php' );


include_once dirname(__FILE__) . '/wp-config.php';
include_once dirname(__FILE__) . '/wp-includes/wp-db.php';
include_once dirname(__FILE__) . '/wp-includes/pluggable.php';

global $wpdb;
global $contactus_table;
$contactus_table = $wpdb->prefix . "purchase_list_cron";
date_default_timezone_set("Europe/Amsterdam");
function save_order_date($final_data) {
    global $wpdb;
    $contactus_table = $wpdb->prefix . "purchase_list_cron";
    //error with the query 
    //print_r($contactus_table);

    $sql = "INSERT INTO $contactus_table "
            . "(order_id, product_id, supplier_id, pickup_id, pickup_value,daytime_id,daytime_value,status,order_date,cron_date,sku_id,product_name,packing_unit,unit_price,price,supplier_name,supplier_email,unit_type,customer_name,customer_email,customer_phone,pickup_location,is_biological_product,pickup_time,pickup_day,pickup_week,pickup_email,customer_id,purchase_price_incl,purchase_price_excl,farmer_company,cart_tax) "
            . "VALUES ('" . $final_data['order_id'] . "', "
            . "'" . $final_data['product_id'] . "', "
            . "'" . $final_data['supplier_id'] . "', "
            . "'" . $final_data['pickup_id'] . "', "
            . "'" . $final_data['pickup_value'] . "',"
            . "'" . $final_data['daytime_id'] . "',"
            . "'" . $final_data['daytime_value'] . "',"
            . "'" . $final_data['status'] . "',"
            . "'" . $final_data['order_date'] . "', "
            . "CURRENT_TIMESTAMP,"
            . "'" . $final_data['sku_id'] . "',"
            . "'" . $final_data['product_name'] . "',"
            . "'" . $final_data['packing_unit'] . "',"
            . "'" . $final_data['unit_price'] . "',"
            . "'" . $final_data['price'] . "',"
            . "'" . $final_data['supplier_name'] . "',"
            . "'" . $final_data['supplier_email'] . "',"
            . "'" . $final_data['unit_type'] . "',"
            . "'" . $final_data['customer_name'] . "',"
            . "'" . $final_data['customer_email'] . "',"
            . "'" . $final_data['customer_phone'] . "',"
            . "'" . $final_data['pickup_location'] . "',"
            . "'" . $final_data['is_biological_product'] . "',"
            . "'" . $final_data['pickup_time'] . "',"
            . "'" . $final_data['pickup_day'] . "',"
            . "'" . $final_data['pickup_week'] . "',"
            . "'" . $final_data['pickup_email'] . "',"
            . "'" . $final_data['customer_id'] . "',"
            . "'" . $final_data['purchase_price_incl'] . "',"
            . "'" . $final_data['purchase_price_excl'] . "',"
            . "'" . $final_data['farmer_company'] . "',"
            . "'" . $final_data['cart_tax'] . "')";

    //print_r($sql);die;
    if ($wpdb->query($sql)) {

        $sql = "INSERT INTO ".$wpdb->prefix."purchase_list_cron_all_data "
            . "(order_id, product_id, supplier_id, pickup_id, pickup_value,daytime_id,daytime_value,status,order_date,cron_date,sku_id,product_name,packing_unit,unit_price,price,supplier_name,supplier_email,unit_type,customer_name,customer_email,customer_phone,pickup_location,is_biological_product,pickup_time,pickup_day,pickup_week,pickup_email,customer_id,purchase_price_incl,purchase_price_excl,farmer_company,cart_tax) "
            . "VALUES ('" . $final_data['order_id'] . "', "
            . "'" . $final_data['product_id'] . "', "
            . "'" . $final_data['supplier_id'] . "', "
            . "'" . $final_data['pickup_id'] . "', "
            . "'" . $final_data['pickup_value'] . "',"
            . "'" . $final_data['daytime_id'] . "',"
            . "'" . $final_data['daytime_value'] . "',"
            . "'" . $final_data['status'] . "',"
            . "'" . $final_data['order_date'] . "', "
            . "CURRENT_TIMESTAMP,"
            . "'" . $final_data['sku_id'] . "',"
            . "'" . $final_data['product_name'] . "',"
            . "'" . $final_data['packing_unit'] . "',"
            . "'" . $final_data['unit_price'] . "',"
            . "'" . $final_data['price'] . "',"
            . "'" . $final_data['supplier_name'] . "',"
            . "'" . $final_data['supplier_email'] . "',"
            . "'" . $final_data['unit_type'] . "',"
            . "'" . $final_data['customer_name'] . "',"
            . "'" . $final_data['customer_email'] . "',"
            . "'" . $final_data['customer_phone'] . "',"
            . "'" . $final_data['pickup_location'] . "',"
            . "'" . $final_data['is_biological_product'] . "',"
            . "'" . $final_data['pickup_time'] . "',"
            . "'" . $final_data['pickup_day'] . "',"
            . "'" . $final_data['pickup_week'] . "',"
            . "'" . $final_data['pickup_email'] . "',"
            . "'" . $final_data['customer_id'] . "',"
            . "'" . $final_data['purchase_price_incl'] . "',"
            . "'" . $final_data['purchase_price_excl'] . "',"
            . "'" . $final_data['farmer_company'] . "',"
            . "'" . $final_data['cart_tax'] . "')";
        $wpdb->query($sql);
    }
}

function create_PDF($html = '', $supplier_id = 0, $rec_name = '', $rec_email = '',$tag='',$is_margin=0) {

    require_once('tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('Nicola Asuni');
    //$pdf->SetTitle('TCPDF Example 048');
    //$pdf->SetSubject('TCPDF Tutorial');
    //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 048', PDF_HEADER_STRING);
// set header and footer fonts
    //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    //$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
    //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
if($is_margin==1){
    // set margins
    $pdf->SetMargins(4, 1, 4);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 1);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
}else{
// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
}
// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

// ---------------------------------------------------------
// set font
    $pdf->SetFont('helvetica', 'B', 20);

// add a page
    $pdf->AddPage();

    //  $pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

    $pdf->SetFont('helvetica', '', 8);
    // Print text using writeHTMLCell()

    $header = '<style type="text/css">*,::after,::before{box-sizing:border-box}table{border-collapse:collapse}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.text-center{text-align:center}.text-left{text-align:left}.header{-ms-flex-pack:justify;justify-content:space-between;display:-ms-flexbox;display:flex}.header h1{margin-top:0;margin-bottom:10px}.header h6{margin-top:0;margin-bottom:0}.header img{width:100px}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.table{width:100%;max-width:100%;margin-bottom:1rem;background-color:transparent}.table td,.table th{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table-sm td,.table-sm th{padding:.3rem}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}.table-hover tbody tr:hover{background-color:rgba(0,0,0,.075)}.table-primary,.table-primary>td,.table-primary>th{background-color:#b8daff}.table-hover .table-primary:hover,.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{background-color:#9fcdff}.table-secondary,.table-secondary>td,.table-secondary>th{background-color:#d6d8db}.table-hover .table-secondary:hover,.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{background-color:#c8cbcf}.table-success,.table-success>td,.table-success>th{background-color:#c3e6cb}.table-hover .table-success:hover,.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{background-color:#b1dfbb}.table-info,.table-info>td,.table-info>th{background-color:#bee5eb}.table-hover .table-info:hover,.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{background-color:#abdde5}.table-warning,.table-warning>td,.table-warning>th{background-color:#ffeeba}.table-hover .table-warning:hover,.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{background-color:#ffe8a1}.table-danger,.table-danger>td,.table-danger>th{background-color:#f5c6cb}.table-hover .table-danger:hover,.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{background-color:#f1b0b7}.table-light,.table-light>td,.table-light>th{background-color:#fdfdfe}.table-hover .table-light:hover,.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{background-color:#ececf6}.table-dark,.table-dark>td,.table-dark>th{background-color:#c6c8ca}.table-hover .table-dark:hover,.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{background-color:#b9bbbe}.table-active,.table-active>td,.table-active>th,.table-hover .table-active:hover,.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{background-color:rgba(0,0,0,.075)}.table .thead-dark th{color:#fff;background-color:#212529;border-color:#32383e}.table .thead-light th{color:#495057;background-color:#e9ecef;border-color:#dee2e6}.table-dark{color:#fff;background-color:#212529}.table-dark td,.table-dark th,.table-dark thead th{border-color:#32383e}.table-dark.table-bordered,.table-responsive>.table-bordered{border:0}.table-dark.table-striped tbody tr:nth-of-type(odd){background-color:rgba(255,255,255,.05)}.table-dark.table-hover tbody tr:hover{background-color:rgba(255,255,255,.075)}@media (max-width:575.98px){.table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-sm>.table-bordered{border:0}}@media (max-width:767.98px){.table-responsive-md{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-md>.table-bordered{border:0}}@media (max-width:991.98px){.table-responsive-lg{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-lg>.table-bordered{border:0}}@media (max-width:1199.98px){.table-responsive-xl{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-xl>.table-bordered{border:0}}.table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}tr.mn{height:180px}th.rot{white-space:nowrap}th.rot>div{transform:translate(20px,145px) rotate(90deg);width:10px}th.rot>div>span{float:right}th div.asd{margin-top:135px} table, th{vertical-align:bottom;}</style>';

    //$pdf->Output(dirname(__FILE__) . '/PDFs/'.date('His').'.pdf', 'F');
    // output the HTML content
   // echo $header . $html;die;
    $pdf->writeHTML($header . $html, true, false, true, false, '');



// ---------------------------------------------------------
    $pdf->lastPage();


    ob_end_clean();
//Close and output PDF document
//$pdf->Output('example_061.pdf', 'I');
    $pdf->Output(dirname(__FILE__) . '/PDFs/' .$tag.'_'. $supplier_id . '.pdf', 'F');


    
}

function send_PDF_mail($subject = 'test', $rec_name = '', $rec_email = '', $mail_attachment) {
    $mailmessage = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Goeieete</title>
    <style>
*{margin:0;padding:0}*{font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif}img{max-width:100%}.collapse{margin:0;padding:0}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%}a{color:#2BA6CB}.btn{text-decoration:none;color:#FFF;background-color:#666;padding:10px 16px;font-weight:bold;margin-right:10px;text-align:center;cursor:pointer;display:inline-block}p.callout{padding:15px;background-color:#ECF8FF;margin-bottom:15px}.callout a{font-weight:bold;color:#2BA6CB}table.social{background-color:#ebebeb}.social .soc-btn{padding:3px 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color:#FFF;font-weight:bold;display:block;text-align:center}a.fb{background-color:#3B5998!important}a.tw{background-color:#1daced!important}a.gp{background-color:#DB4A39!important}a.ms{background-color:#000!important}.sidebar .soc-btn{display:block;width:100%}table.head-wrap{width:100%}.header.container table td.logo{padding:15px}.header.container table td.label{padding:15px;padding-left:0px}table.body-wrap{width:100%}table.footer-wrap{width:100%;clear:both!important}.footer-wrap .container td.content p{border-top:1px solid rgb(215, 215, 215);padding-top:15px}.footer-wrap .container td.content p{font-size:10px;font-weight:bold}h1,
    h2,
    h3,
    h4,
    h5,
    h6{font-family:"HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;line-height:1.1;margin-bottom:15px;color:#000}h1 small,
    h2 small,
    h3 small,
    h4 small,
    h5 small,
    h6 small{font-size:60%;color:#6f6f6f;line-height:0;text-transform:none}h1{font-weight:200;font-size:44px}h2{font-weight:200;font-size:37px}h3{font-weight:500;font-size:27px}h4{font-weight:500;font-size:23px}h5{font-weight:900;font-size:17px}h6{font-weight:900;font-size:14px;text-transform:uppercase;color:#444}.collapse{margin:0!important}p,
    ul{margin-bottom:10px;font-weight:normal;font-size:14px;line-height:1.6}p.lead{font-size:17px}p.last{margin-bottom:0px}ul li{margin-left:5px;list-style-position:inside}ul.sidebar{background:#ebebeb;display:block;list-style-type:none}ul.sidebar li{display:block;margin:0}ul.sidebar li a{text-decoration:none;color:#666;padding:10px 16px;margin-right:10px;cursor:pointer;border-bottom:1px solid #777777;border-top:1px solid #FFFFFF;display:block;margin:0}ul.sidebar li a.last{border-bottom-width:0px}ul.sidebar li a h1,
    ul.sidebar li a h2,
    ul.sidebar li a h3,
    ul.sidebar li a h4,
    ul.sidebar li a h5,
    ul.sidebar li a h6,
    ul.sidebar li a p{margin-bottom:0!important}.container{display:block!important;max-width:600px!important;margin:0 auto!important;/* makes it centered */clear:both!important}.content{padding:15px;max-width:600px;margin:0 auto;display:block}.content table{width:100%}.column{width:300px;float:left}.column tr td{padding:15px}.column-wrap{padding:0!important;margin:0 auto;max-width:600px!important}.column table{width:100%}.social .column{width:280px;min-width:279px;float:left}.clear{display:block;clear:both}@media only screen and (max-width: 600px){a[class="btn"]{display:block!important;margin-bottom:10px!important;background-image:none!important;margin-right:0!important}div[class="column"]{width:auto!important;float:none!important}table.social div[class="column"]{width:auto!important}}
    </style>
</head>

<body bgcolor="#FFFFFF">
    <table class="head-wrap" bgcolor="#e1f5fe">
        <tr>
            <td></td>
            <td class="header container">
                <div class="content">
                    <table bgcolor="#e1f5fe">
                        <tr>
                            <td><img src="' . site_url() . '/wp-content/uploads/2018/07/cropped-logo-2.png" style="display: block;margin:0 auto;" /></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
    <table class="body-wrap">
    	<tr><td>&nbsp;</td></tr>
        <tr>
            <td>Beste ' . $rec_name . '<br><br> In de bijlage vind je de lijsten uit de webshop van Goei Eete.<br><br></td>
        </tr>
        <tr>
            <td>Heb je vragen over deze email of de inhoud ervan, neem dan contact met ons op via 013 - 5810013 of mail naar info@goeieete.nl</td>
        </tr>
        <tr><td><br><br>Met vriendelijke groet<br><br><br>Team Goei Eete</td></tr>
    </table>
    <table class="footer-wrap">
    <tr style="background-color:#558B2F;">
        <td></td>
        <td class="container">
            <div class="content">
                <table bgcolor="#558b2f">
                    <tbody>
                        <tr>
                            <th>
                                <table class="spacer">
                                    <tbody>
                                        <tr>
                                            <td height="16px" style="font-size:16px;line-height:16px;">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-center" style="color:#ffffff;"&copy; 2018 |  Goei Eete&reg;<br>
                                    <a href="tel:0653941659" style="color:#ffffff;">06 - 539 416 59</a> | 
                                    <a href="' . site_url() . '/algemene-voorwaarden/" style="color:#ffffff;">Algemene voorwaarden</a> | <a href="' . site_url() . '/privacyverklaring/" style="color:#ffffff;">Privacyverklaring</a> | <a href="#" style="color:#ffffff;">Unsubscribe</a>
                                </p>
                                <center data-parsed="">
                                    <table align="center" class="menu float-center">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <th class="menu-item float-center">
                                                                    <a href="https://www.facebook.com/goeieete/" class="facebook"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE/SURBVEhL7ZaxSgNBFEX3C2xdLa1CKsFgY5qAn2DnJ9goCGLtf9hpYW2dJlVaqxQpBT8isut5kzs6ZtfJ4o6GwB64bHbeffcmkGKyjo1SFMUeGpVledpGlmFZio2D8Rq9s5gEy7JMxddj3y5lqUflu6qpgme4tKaH4hPVVGH+q2JC5+gCDVAfHaNLjT1D1VSx4dLTHAqmaEcRnzBazUpbDEda/wbnf1fML33VqoOjHmf3PJ94jp3pi6TFU606eH/UqI6kxROtOnh/1qiOLS0mfMbjwMTnfa06OMuD2S3PkNbFL7JHwXenFc+/FT9oxdO6+A3dSOdadfB+FszmWvFs6Z8rpCvuikOYRS8COYbGV5+mxZaJfr76GBjssrfQThR8a4stC13JEge//fK111s8A604ODtcmVtGrnHHJsiyD1opUPx7lntHAAAAAElFTkSuQmCC"></a>
                                                                </th>
                                                                <th class="menu-item float-center">
                                                                    <a href="https://twitter.com"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGrSURBVEhL7ZYhS0NRGIa3IYZZbE6waDMqgsEVQVgwatN/IAiCYLBYRNC/YBNMNoO2BZsgLJoNGjQYFCe6zee7593wenevO9vVlT3wcjzfeb/v3T1jeDMD+kq9Xh9Hi41GY6kX2QybpbHJYNxGnzSmgs2ymRrfHvt0aYY2UfiYYqLgKTpr+hC8oJgonP9ZMBQVE8UOnccPXeWLtnH4BTPwnuXZ7cIocAeNsM2yzqBLdIgenKuFd/ABmkNPKrWgdqTWENRXUVm2Jt7B+zor8PcZqrmT4Gw2aPwB9WX0KlsT7+Bblrws5pmiZtd7giZUDkH9ImgO4x18jkqydAT+G7V/xzv4SscdQUuenqrrDuEXLPZQTrZECF1xLRH8gxlWQfOyxYLVflLXritCV8E1tCZbLHg21NKOrq46gMGnLKOyh+CshN6csy2dBzPInrSMjtE6pWFZW1Ab4mwTvQdN8fg9MQPv0C6aZpuVL8d+EllgJTD+Tk9XXUWP6EMlH7oP7pH+BHNLiS8C9o/g/199DAz2stfNd9gWm4W2ND4Z/PbkqbzeshY0dkA/yGS+AGW6Ozkvjw98AAAAAElFTkSuQmCC"></a>
                                                                </th>
                                                                <th class="menu-item float-center">
                                                                    <a href="https://linkedin.com"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFXSURBVEhL7ZYhb8JAHMUrprFjhqD2AeaWYUj4Ekvm+ARLJnCz6InJfYFhUAgk32AWOYchBDPC0vLe3Stt06bJlSs1/SUvvb773/9xpWkuaGmUMAzvoGEURaNLxB7spbbloPAN+sdCL7AXe6p9Mfx1PkNjFH6rmDyoGdhS/yD4STF5MF8YjEU7D09ioJg8nLQ1CQgca66P8ca6lXAO7mia78BCdhWcgz+ge+gZ+pNdBbdgjzjv+BOXKYXxrzz+18aTf4BmGn9DRS+i8457muZ/vKKB648sA+4fNTTg/sWszOI/GNYNvMwHgjWsTVHLjufQEXqQRe/LrE6oJfgg/1UWvXd6KWp51DETWfQm1jrTBidw0tZkaCaYYdBS2srbp7ylKQQYr1P+WnaM84590UwwnkDpQaCLgusffQgKeNg7as3FsBd0/rCUgnru3MvxFteu2rY0QRCcAAk2dGnJa19CAAAAAElFTkSuQmCC"></a>
                                                                </th>
                                                                <th class="menu-item float-center">
                                                                    <a href="https://youtube.com"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFESURBVEhL7ZY9TsNAFIQtTkAJJyA5BD81lIgbgOgRRUo6Gk4RuAMHgBok+sABIkCigsbmm+xYm0BYBWFnJeRPGtl6894byUrsLTo6lkZZlv2qqs64XqFb9IBG6Bm9oDf8GVSzpx71akazl9ja1ff6+dCwh97DuubQTrTrmO9gPrm3cdg9cswsGOvuaZM1x0UI3rbZGmRsOS5C/SDYaRge+/bXMLvvuAjFI/tJ6DvnssP1LlQWh5lDx0UontpPomD1c7vC/TFa+AnQezIJm4b6INhp6uAaSqvULtBH6Egy8FhExeCl+Rpcg9XDuw5dP/IPgin97VEzmOfHRTHP34l6thfIMl6Zm46LUMzzkRCEP7qhcdg9/7MoMPMcBAR9PaTjyhDdoHuk48wY6XjzOtk2hWr21KNezWh2iK1dG17f0dE2RfEJehtiZ7kn1fcAAAAASUVORK5CYII="></a>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <table class="spacer">
                                    <tbody>
                                        <tr>
                                            <td height="16px" style="font-size:16px;line-height:16px;">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </th>
                            <th class="expander"></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </td>
        <td></td>
    </tr>
</table>
</body>

</html><hr>';

    $name = get_bloginfo('name');
    $admin_email = get_option('admin_email');


    $mail_attachment = array($mail_attachment);

    $headers1 = "From: info@goeieete.nl \r\n";
    $headers1 .= "Reply-To: info@goeieete.nl \r\n";
    $headers1 .= "CC: info@exulto.nl \r\n";
    $headers1 .= "CC: goeieetetilburg@gmail.com \r\n";
    $headers1 .= "MIME-Version: 1.0 \r\n";
    $headers1 .= "Content-Type: text/html; charset=ISO-8859-1 \r\n";


    $mre = $mailstuats = wp_mail($rec_email, $subject, $mailmessage, $headers1, $mail_attachment);
    error_log($mre.' - '.$rec_email, 3, "/public_html/goeieete/my-errors.log");
    error_log($mre, 3, "/public_html/goeieete/my-errors.log");
}