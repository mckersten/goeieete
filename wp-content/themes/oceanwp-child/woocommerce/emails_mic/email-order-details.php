<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.3.1
 */
if (!defined('ABSPATH')) {
    exit;
}

$text_align = is_rtl() ? 'right' : 'left';

do_action('woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email);
$items = $order->get_items();
$product_id = array();
foreach ($items as $item) {
    $product_id[] = $item->get_product_id();
}
$product_name = implode(",", $product_id);
?>

<h2 style="font-size:25px;background-color:#fff;background-image: none;padding-bottom: 20px;text-align: left; margin-left: 15px; margin-right: 15px; color:#000000;">
    <?php
    if ($sent_to_admin) {
        $before = '<a class="link" href="' . esc_url($order->get_edit_order_url()) . '">';
        $after = '</a>';
    } else {
        $before = '';
        $after = '';
    }
    /* translators: %s: Order ID. */
    echo wp_kses_post($before . sprintf(__('Order #%s', 'woocommerce') . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format('c'), wc_format_datetime($order->get_date_created())));
    ?>
</h2>

<div style="margin-bottom:14px;/*padding-left: 1.7%;padding-right: 1.7%;*/">
    <table class="td" cellspacing="2" cellpadding="10" style="width: 70%; margin-left: 15px; margin-right: 15px; font-size: 14px; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; /*padding: 10px;*/" border="0">
        <thead>
            <tr>
                <th class="td" scope="col" style="text-align:<?php echo esc_attr($text_align); ?>; background-color: #DCECFF;"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                <th class="td" scope="col" style="text-align:center; width:100px; background-color: #DCECFF;"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                <th class="td" scope="col" style="text-align:center; width:100px;background-color: #DCECFF;"><?php esc_html_e('Weight', 'woocommerce'); ?></th>
                <th class="td" scope="col" style="text-align:<?php echo esc_attr($text_align); ?>; width:100px; background-color: #DCECFF;"><?php esc_html_e('Price', 'woocommerce'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            echo wc_get_email_order_items($order, array(// WPCS: XSS ok.
                'show_sku' => $sent_to_admin,
                'show_image' => false,
                'image_size' => array(32, 32),
                'plain_text' => $plain_text,
                'sent_to_admin' => $sent_to_admin,
            ));
            ?>
        </tbody>
        <tfoot><tr><td colspan="4" ><hr></td></tr>
            <?php
            $bil_method = '';
            $totals = $order->get_order_item_totals();

            if ($totals) {
                $i = 0;
                foreach ($totals as $total) {
                    $i++;
                    if (wp_kses_post($total['label']) != ' Betalingsmiddel:') {
                        ?>
                        <tr>
                            <th class="td" scope="row" colspan="3" style="text-align:right; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post($total['label']); ?></th>
                            <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"> <?php echo wp_kses_post($total['value']); ?></td>
                        </tr>
                    <?php
                    } else {
                        $bil_method = '<b>Betaalwijze</b> ' . wp_kses_post($total['value']);
                    }
                }
                ?>
                <?php
            }
            if ($order->get_customer_note()) {
                ?>
                <tr>
                    <th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                    <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo wp_kses_post(wptexturize($order->get_customer_note())); ?></td>
                </tr>
                <?php
            }
            ?>  
        </tfoot>
    </table>
    <div style="float:left; width:100%; margin-left: 15px;/*padding: 10px;  margin-right: 15px;*/"><br><br><?php echo $bil_method; ?><br> &nbsp; <br></div>
</div>
<?php do_action('woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email); ?>
