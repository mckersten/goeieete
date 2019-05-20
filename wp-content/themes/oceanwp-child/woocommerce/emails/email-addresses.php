<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates/Emails
 * @version     3.2.1
 */
if (!defined('ABSPATH')) {
    exit;
}

$text_align = is_rtl() ? 'right' : 'left';
?>
    <table  style="width:100%; border:1; float: left; background-color: #f9f9f9 ;vertical-align: top;  margin-top: 0px; padding-top: 0px;margin-top: 0px;margin-bottom: 41px;">

    <tr>
        <th style="text-align:left; padding-right: 1px !important; padding-top: 1px !important; padding-left: 12px !important; padding-bottom: 0px !important;"><?php echo '<b style="text-align: left; background-image: none;padding:0px; color:#000000;">Factuur adres</b>'; ?></th>
        </th>
    </tr>
    <tr>
        <td >
            <p style="margin:0px;">
<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __('N/A', 'woocommerce'); ?>
                <?php if ($order->get_billing_phone()) : ?>
                    <br/><?php echo esc_html($order->get_billing_phone()); ?>
                <?php endif; ?>
                <?php /* if ( $order->get_billing_email() ) : ?>
                  <p><?php echo esc_html( $order->get_billing_email() ); ?></p>
                  <?php endif; */ ?>
            </p>
        </td>
<?php /* if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ( $shipping = $order->get_formatted_shipping_address() ) ) : ?>
  <td style="text-align:<?php echo $text_align; ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0;" valign="top" width="50%">
  <h2><?php _e( 'Shipping address', 'woocommerce' ); ?></h2>

  <address class="address"><?php echo $shipping; ?></address>
  </td>
  <?php endif; */ ?>
    </tr>
</table>
