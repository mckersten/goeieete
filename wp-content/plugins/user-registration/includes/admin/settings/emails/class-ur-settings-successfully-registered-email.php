<?php
/**
 * Configure Email
 *
 * @class    UR_Settings_Email_Confirmation
 * @extends  UR_Settings_Email
 * @category Class
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'UR_Settings_Successfully_Registered_Email', false ) ) :

/**
 * UR_Settings_Successfully_Registered_Email Class.
 */
class UR_Settings_Successfully_Registered_Email{

	
	public function __construct() {
		$this->id             = 'successfully_registered_email';
		$this->title          = __( 'Successfully Registered Email', 'user-registration' );
		$this->description    = __( 'Email sent to the user after successful registration', 'user-registration' );
	}

	/**
	 * Get settings
	 *
	 * @return array
	 */
	public function get_settings() {

	?><h2><?php echo esc_html__('Successfully Registered Email','user-registration'); ?> <?php ur_back_link( __( 'Return to emails', 'user-registration' ), admin_url( 'admin.php?page=user-registration-settings&tab=email' ) ); ?></h2>



	<?php
		$settings = apply_filters(
			'user_registration_successfully_registered_email', array(
				array(
					'type'  => 'title',
					'desc'  => '',
					'id'    => 'successfully_registered_email',
				),
				array(
					'title'    => __( 'Enable this email', 'user-registration' ),
					'desc'     => __( 'Enable this email sent after successful user registration.', 'user-registration' ),
					'id'       => 'user_registration_enable_successfully_registered_email',
					'default'  => 'yes',
					'type'     => 'checkbox',
					'autoload' => false,
				),
				array(
					'title'    => __( 'Email Subject', 'user-registration' ),
					'desc'     => __( 'The email subject you want to customize.', 'user-registration' ),
					'id'       => 'user_registration_successfully_registered_email_subject',
	 				'type'     => 'text',
	 				'default'  => __('Congratulations! Registration Complete on {{blog_info}}', 'user-registration'),
					'css'      => 'min-width: 350px;',
					'desc_tip' => true,
				),
				array(
					'title'    => __( 'Email Content', 'user-registration' ),
					'desc'     => __( 'The email content you want to customize.', 'user-registration' ),
					'id'       => 'user_registration_successfully_registered_email',
	 				'type'     => 'tinymce',
	 				'default'  => $this->ur_get_successfully_registered_email(),
					'css'      => 'min-width: 350px;',
					'desc_tip' => true,
				),
				array(
					'type' => 'sectionend',
					'id'   => 'successfully_registered_email',
				),
			)
		);

		return apply_filters( 'user_registration_get_settings_' . $this->id, $settings );
	}

	public function ur_get_successfully_registered_email() {
$message ='';
	

		

$message ='<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    
</head>
<body bgcolor="#FFFFFF">

    <table class="head-wrap" bgcolor="#e1f5fe" style="width: 100%;" >

    <table class="head-wrap" bgcolor="#e1f5fe" style="margin: 0 auto; width: 100%;" >

        <tr>
            <td></td>
            <td class="header container" style="width: 100%;">
                <div class="content">
                    <table bgcolor="#e1f5fe" style="margin: 0 auto;">
                        <tr>
                            <td><img src="'.site_url().'/wp-content/uploads/2018/07/cropped-logo-2.png" style="margin:0 auto;" /></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
    <table>
    <tr>
    <td>
';


$message .= apply_filters( 'user_registration_get_successfully_registered_email', sprintf( __(
                        
			'<br><br><br>
                        Hi {{username}},<br><br><br>

			Bedankt voor je inschrijving bij Goei Eete.

            Je kunt nu elke week goed en vers lokaal eten bestellen.

            Deel jouw ervaring met ons via info@goeieete.nl of onze sociale kanalen.

            Met vriendelijke groet,

            Team Goei Eete' ) ) );

$message .='</td></tr></table>
<table class="footer-wrap" style="width: 100%;">
    <tr>
        <td></td>
        <td class="container">
            <div class="content">
                <table bgcolor="#558b2f" style="width: 100%">
                <table bgcolor="#558b2f" style="width: 100%;">
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
                                <p class="text-center" style="color:#ffffff;">? 2018 |  Goei Eete®<br>
                                    <a href="tel:0653941659" style="color:#ffffff;">06 - 539 416 59</a> | 
                                    <a href="'.site_url().'/algemene-voorwaarden/" style="color:#ffffff;">Algemene voorwaarden</a> | <a href="'.site_url().'/privacyverklaring/" style="color:#ffffff;">Privacyverklaring</a> | <a href="#" style="color:#ffffff;">Unsubscribe</a>
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
    </table>';
		return $message;
	}
}
endif;

return new UR_Settings_Successfully_Registered_Email(); ?>

