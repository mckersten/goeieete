<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
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
 * @version     2.3.0
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/*
?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Body -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Footer -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                                        <tr>
                                            <td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="credit">
                                                            <?php echo wpautop( wp_kses_post( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
*/?>
<table class="footer-wrap" style="width: 100%; /*padding: 5px;*/">
    <tr>
       
        <td class="container" style="width: 100%;">
            <div class="content" style="padding:0;">
                <table bgcolor="#558b2f" style="width: 100%;">
                    <tbody>
                        <tr>
                            <th>
                                <p class="text-center" style="color:#ffffff;">Ⓒ 2018 |  Goei Eete®<br>
                                    <a href="tel:0653941659" style="color:#ffffff;">06 - 539 416 59</a> | 
                                    <a href="<?php echo site_url(); ?>/algemene-voorwaarden/" style="color:#ffffff;">Algemene voorwaarden</a> | <a href="<?php echo site_url();?>/privacyverklaring/" style="color:#ffffff;">Privacyverklaring</a>
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
                                                                    <a href="https://twitter.com/goeieete"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGrSURBVEhL7ZYhS0NRGIa3IYZZbE6waDMqgsEVQVgwatN/IAiCYLBYRNC/YBNMNoO2BZsgLJoNGjQYFCe6zee7593wenevO9vVlT3wcjzfeb/v3T1jeDMD+kq9Xh9Hi41GY6kX2QybpbHJYNxGnzSmgs2ymRrfHvt0aYY2UfiYYqLgKTpr+hC8oJgonP9ZMBQVE8UOnccPXeWLtnH4BTPwnuXZ7cIocAeNsM2yzqBLdIgenKuFd/ABmkNPKrWgdqTWENRXUVm2Jt7B+zor8PcZqrmT4Gw2aPwB9WX0KlsT7+Bblrws5pmiZtd7giZUDkH9ImgO4x18jkqydAT+G7V/xzv4SscdQUuenqrrDuEXLPZQTrZECF1xLRH8gxlWQfOyxYLVflLXritCV8E1tCZbLHg21NKOrq46gMGnLKOyh+CshN6csy2dBzPInrSMjtE6pWFZW1Ab4mwTvQdN8fg9MQPv0C6aZpuVL8d+EllgJTD+Tk9XXUWP6EMlH7oP7pH+BHNLiS8C9o/g/199DAz2stfNd9gWm4W2ND4Z/PbkqbzeshY0dkA/yGS+AGW6Ozkvjw98AAAAAElFTkSuQmCC"></a>
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
                             </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </td>
        
    </tr>
    </table>
</body>

</html>
