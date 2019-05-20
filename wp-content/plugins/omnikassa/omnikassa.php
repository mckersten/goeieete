<?php
/*
Plugin Name: OmniKassa for WooCommerce
Plugin URI: https://ajdg.solutions/?pk_campaign=omnikassa&pk_kwd=plugin_url
Author: Arnan de Gans
Author URI: http://www.arnan.me/?pk_campaign=omnikassa&pk_kwd=author_url
Description: Accept payments through Visa, MasterCard, MiniTix, Maestro, iDeal and Bancontact/Mister Cash offered by Rabobank Omnikassa in WooCommerce.
Text Domain: omnikassa
Domain Path: /
Version: 1.2.1
License: GPL
*/

register_activation_hook(__FILE__, 'omnikassa_activate');
register_uninstall_hook(__FILE__, 'omnikassa_uninstall');

add_action('plugins_loaded', 'omnikassa_init');

if(is_admin()) {
	add_action("admin_print_styles", 'omnikassa_dashboard_styles');
	add_action('admin_notices', 'omnikassa_notifications_dashboard');
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'omnikassa_action_links');
}

/*-------------------------------------------------------------
 Name:      omnikassa_add_gateway
 Purpose:   Make WooCommerce aware of the gateway
 Since:		1.0
-------------------------------------------------------------*/
function omnikassa_add_gateway($methods) {
    $methods[] = 'AJdG_Omnikassa'; 
    return $methods;
}

/*-------------------------------------------------------------
 Name:      omnikassa_init
-------------------------------------------------------------*/
function omnikassa_init() {

	if(!class_exists('WC_Payment_Gateway')) return;

	add_filter('woocommerce_payment_gateways', 'omnikassa_add_gateway');
	load_plugin_textdomain('omnikassa', false, basename(dirname(__FILE__)));

    class AJdG_Omnikassa extends WC_Payment_Gateway {
    
    	function __construct() {
			global $woocommerce;
	
	        $this->id = 'ajdg_omnikassa';
	        $this->has_fields = true;
	        $this->method_title	= 'Omnikassa';

	        $this->version = '1.1';
	        
	        $this->liveurl = 'https://payment-webinit.omnikassa.rabobank.nl/paymentServlet';
			$this->testurl = 'https://payment-webinit.simu.omnikassa.rabobank.nl/paymentServlet';
	        $this->merchantiddemo = '002020000000001';
			$this->secretkeydemo = '002020000000001_KEY1';
			$this->keyversiondemo = '1';
			$this->interface_version = 'HP_1.0';

			$this->uploadloc = wp_upload_dir();
			$this->pluginloc = plugins_url();

			// Load the form fields.
			$this->init_form_fields();
	
			// Load the settings.
			$this->init_settings();

			// Define user set variables
			$this->title = !empty($this->settings['title']) ? $this->settings['title'] : 'Credit Card, iDEAL, Mister Cash, V-PAY, MiniTix';
			$this->description = !empty($this->settings['description']) ? $this->settings['description'] : 'Pay securely with your Credit Card, iDeal, Mister Cash, V-PAY, or MiniTix through Rabobank Omnikassa.';

			$this->merchantid = $this->settings['merchantid'];
			$this->secretkey = $this->settings['secretkey'];
			$this->keyversion = $this->settings['keyversion'];
			
	        $this->checkout_icon = $this->settings['checkout_icon'];
			$this->method_ideal = $this->settings['method_ideal'];
			$this->method_bcmc = $this->settings['method_bcmc'];
			$this->method_visa = $this->settings['method_visa'];
			$this->method_master = $this->settings['method_master'];
			$this->method_vpay = $this->settings['method_vpay'];
			$this->method_maestro = $this->settings['method_maestro'];
			$this->method_minitix = $this->settings['method_minitix'];
			$this->method_default = $this->settings['method_default'];

			$this->remote_language = !empty($this->settings['remote_language']) ? $this->settings['remote_language'] : 'en';
			$this->remote_session = !empty($this->settings['remote_session']) ? $this->settings['remote_session'] : '7200';
			$this->invoice_prefix = !empty($this->settings['invoice_prefix']) ? $this->settings['invoice_prefix'] = preg_replace("/[^a-z0-9.]+/i", "", $this->settings['invoice_prefix']) : '';

			$this->testmode = $this->settings['testmode'];
			$this->debugger = $this->settings['debug'];

			// Logs
			if($this->debugger=='yes') $this->log = new WC_Logger();

			// Actions
			add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));

			add_action('woocommerce_receipt_' . $this->id, array(&$this, 'receipt_page'));
			add_action('woocommerce_api_' . strtolower(get_class($this)), array($this, 'check_psp_response'));
			add_action('valid-omnikassa-psp-request', array(&$this, 'successful_request'));

			add_filter('woocommerce_gateway_icon', array(&$this, 'iconset'), 10, 2);

			if(!$this->currency_is_valid()) $this->enabled = false;
    	}

		/*-------------------------------------------------------------
		 Name:      iconset
		 Purpose:   Find out and format the markup for payment icons
		 Since:		1.0
		-------------------------------------------------------------*/
		public function iconset($icons = '', $id) {
			if($id == $this->id && $this->checkout_icon == 'yes') {
				$icon = array();
				if($this->settings['method_ideal'] == 'yes') $icon[] = $this->icon_image('ideal');
				if($this->settings['method_bcmc'] == 'yes') $icon[] = $this->icon_image('mistercash');
				if($this->settings['method_visa'] == 'yes') $icon[] = $this->icon_image('visa');
				if($this->settings['method_master'] == 'yes') $icon[] = $this->icon_image('mastercard');
				if($this->settings['method_vpay'] == 'yes') $icon[] = $this->icon_image('vpay');
				if($this->settings['method_maestro'] == 'yes') $icon[] = $this->icon_image('maestro');
				if($this->settings['method_minitix'] == 'yes') $icon[] = $this->icon_image('minitix');
				$icons = implode(" ", array_reverse($icon));
			}

			return $icons;
		}

		/*-------------------------------------------------------------
		 Name:      icon_image
		 Purpose:   Figure out which PNG file to use as checkout icon
		 Since:		1.0
		-------------------------------------------------------------*/
		private function icon_image($brand) {
			if(file_exists($this->uploadloc['basedir'].'/omnikassa-'.$brand.'.png')) {
				$icon = '<img src="'.$this->uploadloc['baseurl'].'/omnikassa-'.$brand.'.png" alt="'.$brand.'" />';
			} else {
				$icon = '<img src="'.$this->pluginloc.'/omnikassa/images/'.$brand.'.png" alt="'.$brand.'" />';
			}
			
			return $icon;
		}

		/*-------------------------------------------------------------
		 Name:      admin_options
		 Purpose:   Create and output admin settings
		 Since:		1.0
		-------------------------------------------------------------*/
		public function admin_options() {
	    	?>
	    	<h2><?php _e('OmniKassa', 'omnikassa'); ?></h2>

			<?php if(($this->method_ideal == "yes" || $this->method_bcmc == "yes" || $this->method_minitix == "yes") && get_woocommerce_currency() != "EUR") {
				echo '<div id="message" class="error"><p>'. __('iDEAL, Mister Cash and MiniTix can only accept payments in Euros. Your store uses: ', 'omnikassa') . get_woocommerce_currency() . '.</p></div>';
			}
			?>

			<div id="dashboard-widgets-wrap">
				<div id="dashboard-widgets" class="metabox-holder">
		
					<div id="postbox-container-1" class="postbox-container" style="width:50%;">
						<div id="normal-sortables" class="meta-box-sortables ui-sortable">
							
							<h3><?php _e('OmniKassa for WooCommerce by Arnan de Gans', 'omnikassa'); ?></h3>
							<div class="postbox-ajdg">
								<div class="inside">
							    	<p><?php _e('This plugin requires an activated Rabobank OmniKassa account. Fees for usage apply!', 'omnikassa'); ?> <?php _e('Visit the', 'omnikassa'); ?> <a href="https://www.rabobank.nl/bedrijven/betalen/geld-ontvangen/rabo-omnikassa/" target="_blank">Rabobank OmniKassa</a> <?php _e('website for more information.', 'omnikassa'); ?></p>

									<p><strong><?php _e('Support OmniKassa for WooCommerce', 'omnikassa'); ?></strong></p>
									<p><?php _e('Consider writing a review or making a donation if you like the plugin or if you find the plugin useful. Thanks for your support!', 'omnikassa'); ?><br />
									<center><a class="button-primary" href="https://paypal.me/arnandegans/10usd" target="_blank"><?php _e('Donate $10 via Paypal', 'omnikassa'); ?></a> <a class="button" target="_blank" href="https://wordpress.org/support/plugin/omnikassa/reviews/?rate=5#new-post"><?php _e('Write review on WordPress.org', 'omnikassa'); ?></a></center><br />
									<script>(function(d, s, id) {
									  var js, fjs = d.getElementsByTagName(s)[0];
									  if (d.getElementById(id)) return;
									  js = d.createElement(s); js.id = id;
									  js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
									  fjs.parentNode.insertBefore(js, fjs);
									}(document, 'script', 'facebook-jssdk'));</script>
									<p><center><div class="fb-page" 
										data-href="https://www.facebook.com/Arnandegans" 
										data-width="490" 
										data-adapt-container-width="true" 
										data-hide-cover="false" 
										data-show-facepile="false">
									</div></center></p>
								</div>
							</div>
						</div>
					</div>
		
					<div id="postbox-container-3" class="postbox-container" style="width:50%;">
						<div id="side-sortables" class="meta-box-sortables ui-sortable">
									
							<h3><?php _e('Arnan de Gans News & Updates', 'omnikassa'); ?></h3>
							<div class="postbox-ajdg">
								<div class="inside">
									<?php wp_widget_rss_output(array(
										'url' => array('http://ajdg.solutions/feed/'), 
										'items' => 3, 
										'show_summary' => 1, 
										'show_author' => 0, 
										'show_date' => 1)
									); ?>
								</div>
							</div>
			
						</div>	
					</div>
				</div>
			</div>

	    	<table class="form-table">
	    	<?php
	    		if($this->currency_is_valid()) {
	    			$this->generate_settings_html();
	    		} else {
	    		?>
           		<div class="inline error"><p><strong><?php _e('Gateway Disabled', 'omnikassa'); ?></strong>: Rabobank Omnikassa <?php _e('does not support your store currency.', 'omnikassa'); ?></p></div>
	       		<?php
	    		}
	    	?>
			</table>
	    
	    	<?php
	    }

		/*-------------------------------------------------------------
		 Name:      init_form_fields
		 Purpose:   Generate form field for the admin settings
		 Since:		1.0
		-------------------------------------------------------------*/
	    public function init_form_fields() {
	    	$this->form_fields = array(
	    		// BASIC SETTINGS
				'basic' => array(
					'title' => __('Basic Settings', 'omnikassa'),
					'type' => 'title'
				),
				'enabled' => array(
					'title' => __('Enable/Disable', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Enable the Rabobank Omnikassa Gateway', 'omnikassa'),
					'default' => 'no'
				),
				'title' => array(
					'title' => __('Title', 'omnikassa'),
					'type' => 'text',
					'description' => __('The title which the user sees during checkout; Make sure it matches your payment methods.', 'omnikassa'),
					'default' => 'Credit Card, iDEAL, MiniTix, V-PAY, Mister Cash',
					'css' => 'width:400px;'
				),
				'description' => array(
					'title' => __('Description', 'omnikassa'),
					'type' => 'textarea',
					'description' => __('The description which the user sees during checkout; Make sure it matches your payment methods.', 'omnikassa'),
					'default' => 'Pay securely with your Credit Card, V-PAY, iDeal, Mister Cash or MiniTix through Rabobank Omnikassa.',
					'css' => 'width:400px;'
				),
				'checkout_icon' => array(
					'title' => __('Icon', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Show payment icons in the gateway selection box', 'omnikassa'),
					'description' => __('Place your own logos sized approximately 32*32px in <code>wp-content/uploads/</code> named <code>omnikassa-(ideal|visa|mastercard|maestro|minitix|vpay|mistercash).png</code>.', 'omnikassa') . '<br />' . __('For iDEAL use: <code>wp-content/uploads/omnikassa-ideal.png</code> to replace the default logo.', 'omnikassa'),
					'default' => 'yes'
				),

				// MERCHANT DETAILS
				'merchant' => array(
					'title' => __('Merchant Details', 'omnikassa'),
					'type' => 'title',
					'description' => __('You can find your merchant details in 2 separate emails sent to you by the Rabobank after you signed your agreement.', 'omnikassa')
				),
				'merchantid' => array(
					'title' => __('Merchant ID', 'omnikassa'),
					'type' => 'text',
					'description' => __('This is needed in order to take payment.', 'omnikassa'),
					'default' => '',
					'css' => 'width:400px;'
				),
				'secretkey' => array(
					'title' => __('Secret Key', 'omnikassa'),
					'type' => 'text',
					'description' => __('This is needed in order to take payment.', 'omnikassa'),
					'default' => '',
					'css' => 'width:400px;'
				),
				'keyversion' => array(
					'title' => __('Key Version', 'omnikassa'),
					'type' => 'text',
					'description' => __('This is needed in order to take payment.', 'omnikassa'),
					'default' => '',
					'css' => 'width:400px;'
				),

				// PAYMENT METHODS
				'paymentmethods' => array(
					'title' => __('Accepted Payment Methods', 'omnikassa'),
					'type' => 'title',
					'description' => __('Each payment method requires approval from your bank and possibly an extension on your agreement with the Rabobank. Check with the Rabobank for details before activating new payment methods!', 'omnikassa')
				),
				'method_ideal' => array(
					'title' => __('iDEAL', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Receive iDEAL payments', 'omnikassa'),
					'description' => __('Instant bank transfer. Available to Dutch ATM Card holders.', 'omnikassa'),
					'default' => 'yes'
				),
				'method_bcmc' => array(
					'title' => __('Bancontact/Mister Cash', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Receive Bancontact Mister Cash payments', 'omnikassa'),
					'description' => __('Instant bank transfer. Available to Belgian ATM Card holders.', 'omnikassa'),
					'default' => 'no'
				),
				'method_visa' => array(
					'title' => __('Visa Card', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Receive Visa Card Payments', 'omnikassa'),
					'description' => __('International payments. Available worldwide.', 'omnikassa'),
					'default' => 'no'
				),
				'method_master' => array(
					'title' => __('MasterCard', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Receive MasterCard Payments', 'omnikassa'),
					'description' => __('International payments. Available worldwide.', 'omnikassa'),
					'default' => 'no'
				),
				'method_vpay' => array(
					'title' => __('V-PAY', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Receive V-PAY Payments', 'omnikassa'),
					'description' => __('European Debit Card. Available in Europe.', 'omnikassa'),
					'default' => 'no'
				),
				'method_maestro' => array(
					'title' => __('Maestro', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Receive Maestro Payments', 'omnikassa'),
					'description' => __('Direct bank transfer. Available in Europe.', 'omnikassa'),
					'default' => 'no'
				),
				'method_minitix' => array(
					'title' => __('MiniTix', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Receive MiniTix Payments', 'omnikassa'),
					'description' => __('Online wallet for payments up to &euro; 150 Euros. Available to Dutch bank accounts only.', 'omnikassa'),
					'default' => 'no'
				),
				'method_default' => array(
				     'title' => __('Default payment option', 'omnikassa'),
				     'description' => __('Default selected option on checkout. The chosen option here must be active in your contract or no selection can be made! (Only applicable if you use multiple payment methods.)', 'omnikassa'),
				     'type' => 'select',
				     'options' => array(
				          'ideal' => 'iDeal',
				          'bcmc' => 'Mister Cash',
				          'creditcard' => 'Visa or MasterCard',
				          'vpay' => 'V-PAY',
				          'maestro' => 'Maestro',
				          'minitix' => 'MiniTix'
				     )
				),

				// MISC SETTINGS
				'misc_settings' => array(
					'title' => __('Miscellaneous Settings', 'omnikassa'),
					'type' => 'title'
				),
				'remote_language' => array(
					'title' => __('Language', 'omnikassa'),
					'type' => 'select',
					'description' => __('Which language should the Rabobank Omnikassa Pages use for checkout.', 'omnikassa'),
					'default' => 'en',
					'options' => array(
						'en' => __('English', 'omnikassa'),
						'nl' => __('Dutch', 'omnikassa')
					)
				),
				'remote_session' => array(
					'title' => __('Expiration', 'omnikassa'),
					'type' => 'select',
					'description' => __('For added security you can add a timeout to the transaction. The transaction must be completed within this timeframe or the request will expire and has to be started over again.', 'omnikassa'),
					'default' => '21600',
					'options' => array(
						'0' => __('Disable', 'omnikassa'),
						'7200' => __('2 hours (Default)', 'omnikassa'),
						'14400' => __('4 hours', 'omnikassa'),
						'21600' => __('6 hours', 'omnikassa'),
						'28800' => __('8 hours', 'omnikassa'),
						'57600' => __('16 hours', 'omnikassa'),
						'86400' => __('24 hours', 'omnikassa')
					)
				),
				'invoice_prefix' => array(
					'title' => __('Invoice Prefix', 'omnikassa'),
					'type' => 'text',
					'description' => __('Enter a prefix for your order numbers. Only alphanumeric characters allowed. If you use your Omnikassa account for multiple stores ensure this prefix is unqiue to avoid confusion.', 'omnikassa') . '<br />' . __('This prefix is NOT added to WooCommerce orders but is shown on your bank statements as part of the transaction reference.', 'omnikassa'),
					'default' => 'wc'
				),

				// TEST MODE AND DEBUGGING
				'testing' => array(
					'title' => __('Gateway Testing', 'omnikassa'),
					'type' => 'title'
				),
				'testmode' => array(
					'title' => __('Simulator', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Enable the Omnikassa test mode', 'omnikassa'),
					'default' => 'yes',
					'description' => __('You can leave your "live" account details in place.', 'omnikassa'),
				),
				'debug' => array(
					'title' => __('Troubleshooting', 'omnikassa'),
					'type' => 'checkbox',
					'label' => __('Enable logging', 'omnikassa'),
					'default' => 'no',
					'description' => __('Log Omnikassa events, such as PSP requests and status updates, inside <code>wc-logs/omnikassa-*.log</code>.', 'omnikassa'),
				)
			);
	    }

		/*-------------------------------------------------------------
		 Name:      order_args
		 Purpose:   Build data to send to Payment Processor
		 Since:		1.0
		-------------------------------------------------------------*/
		protected function order_args($order_id, $brand) {

			$order = new WC_Order($order_id);
	
			if($this->debugger=='yes') $this->log->add('omnikassa', 'Generating payment data for order #' . $order_id . '.');

			if($this->testmode == 'yes') {
				$merchantID = $this->merchantiddemo;
				$keyVersion = $this->keyversiondemo;
			} else {
				$merchantID = $this->merchantid;
				$keyVersion = $this->keyversion;
			}

			// Define Payment Methods
			$brandList = array();
			if($this->method_ideal == "yes" && ($brand == 1 || $brand == 0)) $brandList[] = 'IDEAL';
			if($this->method_bcmc == "yes" && ($brand == 5 || $brand == 0)) $brandList[] = 'BCMC';
			if(($this->method_visa == "yes" || $this->method_master == "yes") && ($brand == 2 || $brand == 0)) $brandList[] = 'VISA,MASTERCARD';
			if($this->method_vpay == "yes" && ($brand == 6 || $brand == 0)) $brandList[] = 'VPAY';
			if($this->method_maestro == "yes" && ($brand == 3 || $brand == 0)) $brandList[] = 'MAESTRO';
			if($this->method_minitix == "yes" && ($brand == 4 || $brand == 0)) $brandList[] = 'MINITIX';
			$brands = implode(',', $brandList);

			// Omnikassa Args
			$omni_args = array();
			if(in_array('IDEAL', $brandList) || in_array('BCMC', $brandList) || in_array('MINITIX', $brandList)) {
				$omni_args['currencyCode'] = $this->supported_currencies('EUR');
			} else {
				$omni_args['currencyCode'] = $this->supported_currencies(get_woocommerce_currency());
			}
			$omni_args['amount'] = number_format($order->get_total(), 2, '', '');
			$omni_args['merchantId'] = substr($merchantID, 0, 15);
			$omni_args['orderId'] = substr($order_id, 0, 32);
			$omni_args['transactionReference'] = substr(uniqid($this->invoice_prefix), 0, 35);
			$omni_args['keyVersion'] = substr($keyVersion, 0, 10);
			$omni_args['customerLanguage'] = substr($this->remote_language, 0, 2);
			$omni_args['paymentMeanBrandList'] = $brands;
			$omni_args['normalReturnUrl'] = substr($this->get_return_url($order), 0, 512);
			$omni_args['automaticResponseUrl'] = substr(home_url('/') . '?wc-api=AJdG_Omnikassa&AJdG_Listener=AJdG_Omnikassa', 0, 512);

			if($this->remote_session > 0) {
				$omni_args['expirationDate'] = substr(date_i18n("c", current_time('timestamp') + $this->remote_session), 0, 25);
			}

			// Store Transaction reference
			update_post_meta($order_id, 'TransactionReference', $omni_args['transactionReference']);
			
			if($this->debugger == 'yes') $this->log->add('omnikassa', 'Generated payment data for order #' . $order_id . '. - ' . print_r($omni_args, true));

			unset($merchantID, $keyVersion, $brandList, $brands, $order, $brand);
			return $omni_args;
		}

		/*-------------------------------------------------------------
		 Name:      payment_fields
		 Purpose:   List available payment methods on checkout
		 Since:		1.0
		-------------------------------------------------------------*/
	    public function payment_fields() {
			
			$output = '';
			if($this->description) $output .= '<p>' . $this->description . '</p>';

			$active = 0;
			if($this->settings['method_ideal'] == 'yes') {
				$active++;
				$method = 1;
			}
			if($this->settings['method_bcmc'] == 'yes') {
				$active++;
				$method = 5;
			}
			if($this->settings['method_visa'] == 'yes' || $this->settings['method_master'] == 'yes') {
				$active++;
				$method = 2;
			}
			if($this->settings['method_vpay'] == 'yes') {
				$active++;
				$method = 6;
			}
			if($this->settings['method_maestro'] == 'yes') {
				$active++;
				$method = 3;
			}
			if($this->settings['method_minitix'] == 'yes') {
				$active++;
				$method = 4;
			}
			
			if($active > 1) {
				$output .= '<p>';
				if($this->settings['method_ideal'] == 'yes') {
					$output .= '<input type="radio" id="ideal" name="omnikassa_submethod" value="1"';
					if($this->method_default == 'ideal') $output .= ' checked="checked"';
					$output .= ' /> <label for="ideal">' . __('iDeal', 'omnikassa') . '</label><br />';
				}
				if($this->settings['method_bcmc'] == 'yes') {
					$output .= '<input type="radio" id="bcmc" name="omnikassa_submethod" value="5"';
					if($this->method_default == 'bcmc') $output .= ' checked="checked"';
					$output .= ' /> <label for="bcmc">' . __('Bancontact/Mister Cash', 'omnikassa') . '</label><br />';
				}
				if($this->settings['method_visa'] == 'yes' || $this->settings['method_master'] == 'yes') {
					$output .= '<input type="radio" id="creditcard" name="omnikassa_submethod" value="2"';
					if($this->method_default == 'creditcard') $output .= ' checked="checked"';
					$output .= ' /> <label for="creditcard">';
					if($this->settings['method_visa'] == 'yes' && $this->settings['method_master'] == 'yes') $output .= __('Visa or MasterCard', 'omnikassa');
					if($this->settings['method_visa'] == 'yes' && $this->settings['method_master'] == 'no') $output .= __('Visa Card', 'omnikassa');
					if($this->settings['method_visa'] == 'no' && $this->settings['method_master'] == 'yes') $output .= __('MasterCard', 'omnikassa');
					$output .= '</label><br />';
				}
				if($this->settings['method_vpay'] == 'yes') {
					$output .= '<input type="radio" id="vpay" name="omnikassa_submethod" value="6"';
					if($this->method_default == 'vpay') $output .= ' checked="checked"';
					$output .= ' /> <label for="vpay">' . __('V-PAY', 'omnikassa') . '</label><br />';
				}
				if($this->settings['method_maestro'] == 'yes') {
					$output .= '<input type="radio" id="maestro" name="omnikassa_submethod" value="3"';
					if($this->method_default == 'maestro') $output .= ' checked="checked"';
					$output .= ' /> <label for="maestro">' . __('Maestro', 'omnikassa') . '</label><br />';
				}
				if($this->settings['method_minitix'] == 'yes') {
					$output .= '<input type="radio" id="minitix" name="omnikassa_submethod" value="4"';
					if($this->method_default == 'minitix') $output .= ' checked="checked"';
					$output .= ' /> <label for="minitix">' . __('MiniTix', 'omnikassa') . '</label><br />';
				}			
				$output .= '</p>';
			} else if($active == 1) {
				$output .= '<input type="hidden" name="omnikassa_submethod" value="'. $method .'" />';
			} else {
				$output .= '<p>'.__('No payment methods activated - Check your settings or contact your administrator!', 'omnikassa').'</p>';
			}
			echo $output;
			unset($active, $method, $output);
		}

		/*-------------------------------------------------------------
		 Name:      process_payment
		 Purpose:   Initiate the payment process.
		 Since:		1.0
		-------------------------------------------------------------*/
		public function process_payment($order_id) {
		
			$order = new WC_Order($order_id);
			
			if(isset($_POST['omnikassa_submethod']) && is_numeric($_POST['omnikassa_submethod'])) {
 				update_post_meta($order_id, 'Payment brand', $_POST['omnikassa_submethod']);
 			} else {
 				update_post_meta($order_id, 'Payment brand', 0);
			}
		
			return array(
				'result' 	=> 'success',
				'redirect'	=> $order->get_checkout_payment_url(true)
			);
		}

		/*-------------------------------------------------------------
		 Name:      receipt_page
		 Purpose:   Output for the order received page
		 Since:		1.0
		-------------------------------------------------------------*/
		public function receipt_page($order_id) {
	
			if($this->testmode == 'yes') {
				$omni_address = $this->testurl . '?';
				$secretKey = $this->secretkeydemo;
			} else {
				$omni_address = $this->liveurl . '?';
				$secretKey = $this->secretkey;
			}
	
			$submethod = get_post_meta($order_id, 'Payment brand', 1);
			if(!is_numeric($submethod) && ($submethod < 1 || $submethod > 6)) {
				$submethod = 0;
			}

			$omniArgs = $this->order_args($order_id, $submethod);
			$omniData = '';
			foreach($omniArgs as $k => $v) {
				$v = str_replace('|', '', $v);
				$omniData .= (empty($omniData) ? '' : '|') . ($k . '=' . $v);
			}

			$omniSeal = hash('sha256', utf8_encode($omniData . $secretKey));;

			if($this->debugger == 'yes') $this->log->add('omnikassa', 'Redirecting to PSP gateway');

			wc_enqueue_js('
				jQuery.blockUI({
					message: "' . esc_js(__('Thank you for your order. We are now redirecting you to make payment.', 'omnikassa')) . '",
					baseZ: 99999,
					overlayCSS:	{ background: "#000", opacity: 0.6 },
					css: { padding: "20px", zindex: "9999", textAlign: "center", color: "#555", border: "3px solid #aaa", backgroundColor: "#fff", cursor: "wait", lineHeight: "32px" }
				});
				jQuery("#submit_omnikassa_payment_form").click();
			');
	
			echo '<h3>'.__('Please click the button below to complete your purchase.', 'omnikassa').'</h3>';
			echo '<form action="'.esc_url($omni_address).'" method="post" id="omnikassa_payment_form" target="_top">';
			echo '<input type="hidden" name="InterfaceVersion" value="'.esc_attr(htmlspecialchars($this->interface_version)).'" />';
			echo '<input type="hidden" name="Data" value="'.esc_attr(htmlspecialchars($omniData)).'" />';
			echo '<input type="hidden" name="Seal" value="'.esc_attr(htmlspecialchars($omniSeal)).'" />';
			echo '<input type="submit" class="button-alt" id="submit_omnikassa_payment_form" value="'.__('Continue', 'omnikassa').'" />';
			echo '</form>';
			unset($secretKey, $omniData, $omniSeal, $omniArgs, $order_id);
		}

		/*-------------------------------------------------------------
		 Name:      supported_currencies
		 Purpose:   List of supported currencies. Assume EUR if currency not listed.
		 Since:		1.0
		-------------------------------------------------------------*/
		protected function supported_currencies($currency) {
			// Extracted from http://www.currency-iso.org/dl_iso_table_a1.xml
			$currencies = array('AUD' => '036', 'CAD' => '124', 'DKK' => '208', 'EUR' => '978', 'GBP' => '826', 'NOK' => '578', 'SEK' => '752', 'USD' => '840', 'CHF' => '756');

			if(isset($currencies[$currency])) return $currencies[$currency];
			return 978;
		}

		/*-------------------------------------------------------------
		 Name:      currency_is_valid
		 Purpose:   Make sure the shop uses Euros for currency
		 Since:		1.0
		-------------------------------------------------------------*/
	    private function currency_is_valid() {
	        if(!in_array(get_woocommerce_currency(), array('AUD', 'CAD', 'DKK', 'EUR', 'GBP', 'JPY', 'NOK', 'SEK', 'USD', 'CHF'))) return false;
	        return true;
	    }

		/*-------------------------------------------------------------
		 Name:      transaction_status
		 Purpose:   Status returns on transactions
		 Since:		1.0
		-------------------------------------------------------------*/
		protected function transaction_status($code, $type) {
			if(in_array($code, array('00'))) {
				return 'SUCCESS';
			} elseif(in_array($code, array('60', '89', '90', '99', '05', '02', '14'))) {
				return 'PENDING';
			} elseif(in_array($code, array('97'))) {
				return 'EXPIRED';
			} elseif(in_array($code, array('17'))) {
				return 'CANCELLED';
			} elseif($type == "CARD" && in_array($code, array('03'))) {
				return 'NOCONTRACT';
			}
			return 'FAILED';
		}

		/*-------------------------------------------------------------
		 Name:      transaction_status_code
		 Purpose:   Status codes for failed transactions set to pending
		 Since:		1.0
		-------------------------------------------------------------*/
		protected function transaction_status_code($response) {
		
			$status = array(
				'02' => __('Creditcard authorizationlimit exceeded.', 'omnikassa'),
				'05' => __('Card declined; Insufficient funds, expired or not active.', 'omnikassa'),
				'14' => __('Invalid Card or Authorization failed. Check your card details.', 'omnikassa'),
				'17' => __('Transaction cancelled by user.', 'omnikassa'),
				'60' => __('Awaiting response from gateway. If you place another order you may be billed more than once.', 'omnikassa'),
				'75' => __('You have exceeded the maximum of 3 attempts to enter your card number. Transaction aborted.', 'omnikassa'),
				'89' => __('CVC/Security code invalid or empty. Please try again.', 'omnikassa'),
				'90' => __('Unable to reach payment gateway.', 'omnikassa'),
				'97' => __('Exceeded time limit. Transaction aborted. Please try again.', 'omnikassa'),
				'99' => __('Payment gateway unavailable.', 'omnikassa'),
			);

			return $status[$response];
		}

		/*-------------------------------------------------------------
		 Name:      check_psp_request_is_valid
		 Purpose:   Validate PSP response
		 Since:		1.0
		-------------------------------------------------------------*/
		protected function check_psp_request_is_valid() {
			global $woocommerce;
	
			if($this->debugger == 'yes') $this->log->add('omnikassa', 'Checking if PSP response is valid');
	
			$received_values = (array) stripslashes_deep($_POST);
	        $params = array(
	        	'body' 			=> 'Hello!',
	        	'sslverify' 	=> true,
	        	'timeout' 		=> 15,
	        	'user-agent'	=> 'AJdG OmniKassa/'.$this->version
	        );
	
			if($this->testmode == 'yes') {
				$omni_address = $this->testurl;
				$secretKey = $this->secretkeydemo;
			} else {
				$omni_address = $this->liveurl;
				$secretKey = $this->secretkey;
			}
	
	        $response = wp_remote_post($omni_address, $params);

	        if($this->debugger == 'yes') $this->log->add('omnikassa', 'PSP Response Code: ' . $response['response']['code']);

	        // check to see if the request was valid
	        if(!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300) {
	        	if(!empty($received_values['Data']) && !empty($received_values['Seal'])) {		        
					if(strcmp($received_values['Seal'], hash('sha256', utf8_encode($received_values['Data'] . $secretKey))) === 0) {
						$a = explode('|', $received_values['Data']);
	
						$omni_args = array();
						foreach($a as $d) {
							list($k, $v) = explode('=', $d);
							$omni_args[$k] = $v;
						}

						if($this->debugger == 'yes') $this->log->add('omnikassa', 'Received data verified and valid. - ' . print_r($omni_args, true));

						unset($received_values, $params, $omni_address, $secretKey, $response, $a);
						return array(
							'transaction_reference' => $omni_args['transactionReference'], 
							'transaction_status' => $this->transaction_status($omni_args['responseCode'], $omni_args['paymentMeanType']),
							'transaction_code' => $omni_args['responseCode'],
							'transaction_id' => (empty($omni_args['authorisationId']) ? '' : $omni_args['authorisationId']),
							'transaction_type' => (empty($omni_args['paymentMeanType']) ? 'Omnikassa' : $omni_args['paymentMeanType']), 
							'transaction_brand' => (empty($omni_args['paymentMeanBrand']) ? 'Rabobank' : $omni_args['paymentMeanBrand']), 
							'order_id' => $omni_args['orderId'],
							'amount' => $omni_args['amount']
						);
					} else {
		        		$this->log->add('omnikassa', 'Hash data mismatch! Check Secret Key!');
       			        return false;
					}
				}
	        }
	
	        if($this->debugger == 'yes') {
	        	$this->log->add('omnikassa', 'Received invalid response from PSP');
	        	if(is_wp_error($response)) $this->log->add('omnikassa', 'Error response: ' . $response->get_error_message());
	        }
	
	        return false;
	    }
	
	
		/*-------------------------------------------------------------
		 Name:      check_psp_response
		 Purpose:   Validate PSP response
		 Since:		1.0
		-------------------------------------------------------------*/
		public function check_psp_response() {
			if($this->debugger == 'yes') $this->log->add('omnikassa', 'OmniKassa PSP Response');

			if (isset($_GET['AJdG_Listener']) && $_GET['AJdG_Listener'] == 'AJdG_Omnikassa') {
				@ob_clean();

	        	$omniResponse = $this->check_psp_request_is_valid();
	        	if($omniResponse && is_array($omniResponse)) {
	        		header('HTTP/1.1 200 OK');
	            	do_action("valid-omnikassa-psp-request", $omniResponse);
				} else {
	        		if($this->debugger == 'yes') $this->log->add('omnikassa', 'OmniKassa PSP Request Failure');
					wp_die("OmniKassa PSP Request Failure");
	       		}
	       	}	
		}

		/*-------------------------------------------------------------
		 Name:      successful_request
		 Purpose:   Process response from PSP and update order accordingly
		 Since:		1.0
		-------------------------------------------------------------*/
		public function successful_request($omniResponse) {
			global $woocommerce;

			if($omniResponse && is_array($omniResponse)) {

				$omniReference = $omniResponse['transaction_reference'];
				$omniStatus = $omniResponse['transaction_status'];
				$omniStatusCode = $omniResponse['transaction_code'];
				$omniID = $omniResponse['transaction_id'];
				$omniType = $omniResponse['transaction_type'];
				$omniBrand = $omniResponse['transaction_brand'];
				$omniOrderID = $omniResponse['order_id'];
				$omniAmount = $omniResponse['amount'];

				$order = new WC_Order($omniOrderID);
				$order_id = $order->id;					

				if(strcmp($omniStatus, 'SUCCESS') === 0) {

	            	if($order->status == 'completed') { // Check order not already completed
	            		 if($this->debugger == 'yes') $this->log->add('omnikassa', 'Aborting, Order #' . $omniOrderID . ' is already complete.');
	            		 wp_redirect(add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, esc_url($order->get_checkout_payment_url()))));
	            		 exit;
	            	}

					$localReference = get_post_meta($order_id, 'TransactionReference', 1);
	            	if($localReference != $omniReference) { // Check order ID
	            		if($this->debugger == 'yes') $this->log->add('omnikassa', 'ID Mismatch: Order #' . $localReference . ' stored.  PSP provided: ' . $omniReference);
						$order->update_status('on-hold', sprintf(__('Issue with reference code. Should be: %s. PSP provided: %s.', 'omnikassa'), $localReference, $omniReference));
						wp_redirect(add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, esc_url($order->get_checkout_payment_url()))));
						exit;
	            	}

	            	// Check valid type and brand
	            	$accepted_types = array('CREDIT_TRANSFER', 'CARD', 'OTHER', 'Omnikassa');
	            	$accepted_brands = array('IDEAL', 'BCMC', 'VISA', 'MASTERCARD', 'VPAY', 'MAESTRO', 'MINITIX', 'Rabobank');
					if(!in_array($omniType, $accepted_types) || !in_array($omniBrand, $accepted_brands)) {
						if($this->debugger == 'yes') $this->log->add('omnikassa', 'Aborting, Invalid type or brand. Response from PSP - Type :' . $omniType . ', Brand: ' . $omniBrand . '.');
				    	$order->update_status('on-hold', sprintf(__('Issue with payment type or brand. Response from PSP - Type: %s, Brand: %s.', 'omnikassa'), $omniType, $omniBrand));
						wp_redirect(add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, esc_url($order->get_checkout_payment_url()))));
						exit;
					}
					
					// Validate Amount
				    if(number_format($order->get_total(), 2, '', '') != $omniAmount) {				    
				    	$omniAmountDec = number_format($omniAmount, get_option('woocommerce_price_num_decimals'), get_option('woocommerce_price_decimal_sep'), get_option('woocommerce_price_thousand_sep'));
				    	if($this->debugger == 'yes') $this->log->add('omnikassa', 'Payment error: Amounts do not match (gross ' . $omniAmountDec . ').');
				    	$order->update_status('on-hold', sprintf(__('Validation error: PSP amounts do not match with original order (gross %s).', 'omnikassa'), $omniAmountDec));
						wp_redirect(add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, esc_url($order->get_checkout_payment_url()))));
				    	exit;
				    }

	            	// Payment completed
	                $order->add_order_note(__('PSP payment completed', 'omnikassa'));
	                $order->payment_complete();

	                if($this->debugger=='yes') $this->log->add('omnikassa', 'Payment complete.');

				} elseif(strcmp($omniStatus, 'PENDING') === 0) {

	                if($this->debugger=='yes') $this->log->add('omnikassa', 'pending: Response from PSP: '.$omniStatusCode.'.');
					$order->add_order_note(__('Order set to PENDING. You can try again from your order through', 'omnikassa').' <a href="'.esc_url($order->get_checkout_payment_url()).'">'.__('Checkout', 'omnikassa') . '</a>. ' . sprintf(__('Error: %s.', 'omnikassa'), $omniStatusCode.' - '.$this->transaction_status_code($omniStatusCode)), 1);
	                $order->update_status('pending', sprintf(__('Awaiting %s payment. Order status changed to pending. Response from PSP: %s.', 'omnikassa'), $omniType, $omniStatusCode));

				} elseif(strcmp($omniStatus, 'CANCELLED') === 0) {

	                if($this->debugger=='yes') $this->log->add('omnikassa', 'Cancelled: Response from PSP: '.$omniStatusCode.'.');
	                $order->update_status('cancelled', __('Cancelled by user.', 'omnikassa'));
					unset($woocommerce->session->order_awaiting_payment);

				} elseif(strcmp($omniStatus, 'EXPIRED') === 0) {

	                if($this->debugger=='yes') $this->log->add('omnikassa', 'Expired: Response from PSP: '.$omniStatusCode.'.');
					$order->add_order_note(__('Payment session EXPIRED remotely. Please contact support.', 'omnikassa'), 1);
	                $order->update_status('failed', __('Payment session EXPIRED via PSP.', 'omnikassa'));

				} elseif(strcmp($omniStatus, 'NOCONTRACT') === 0) {

	                if($this->debugger=='yes') $this->log->add('omnikassa', 'No Contract: Response from PSP: '.$omniStatusCode.'.');
	                $order->update_status('on-hold', sprintf(__('Payment Method "%s" is not active for this shop. Response from PSP: %s.', 'omnikassa'), $omniType,  $omniStatusCode));

				} else { // FAILED & EVERYTHING ELSE

	                if($this->debugger=='yes') $this->log->add('omnikassa', 'Not completed: Response from PSP: '.$omniStatusCode.'.');
					$order->add_order_note(__('Payment session failed. Please contact support.', 'omnikassa'), 1);
	                $order->update_status('failed', sprintf(__('Payment session FAILED via PSP. Response from PSP: %s.', 'omnikassa'), $omniStatusCode));

				}

				 // Store PSP Details
	            if(!empty($omniID)) update_post_meta($order_id, 'Transaction ID', $omniID);
	            if(!empty($omniStatusCode)) update_post_meta($order_id, 'Response Code', $omniStatusCode);
	            if(!empty($omniType)) update_post_meta($order_id, 'Payment type', $omniType);
	            if(!empty($omniBrand)) update_post_meta($order_id, 'Payment brand', $omniBrand);
			}
			
			unset($order, $omniResponse, $omniReference, $omniStatus, $omniStatusCode, $omniID, $omniType, $omniBrand, $omniOrderID, $omniAmount, $localReference);
		}
    }
}

/*-------------------------------------------------------------
 Name:      omnikassa_action_links
 Purpose:   Add settings link to plugins page
 Since:		1.0
-------------------------------------------------------------*/
function omnikassa_action_links($links) {
  	$custom_actions = array();
	$custom_actions['settings'] = sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=wc-settings&tab=checkout&section=ajdg_omnikassa'), __('Settings', 'omnikassa'));
	$custom_actions['support'] = sprintf('<a href="%s">%s</a>', 'https://ajdg.solutions/support/', __('Support', 'omnikassa'));

    return array_merge($custom_actions, $links);
}

/*-------------------------------------------------------------
 Name:      omnikassa_nonce_error
 Purpose:   Display a formatted error if Nonce fails
 Since:		1.0
-------------------------------------------------------------*/
function omnikassa_nonce_error() {
	echo '	<h2 style="text-align: center;">'.__('Oh no! Something went wrong!', 'omnikassa').'</h2>';
	echo '	<p style="text-align: center;">'.__('WordPress was unable to verify the authenticity of the url you have clicked. Verify if the url used is valid or log in via your browser.', 'omnikassa').'</p>';
	echo '	<p style="text-align: center;">'.__('If you have received the url you want to visit via email, you are being tricked!', 'omnikassa').'</p>';
	echo '	<p style="text-align: center;">'.__('Contact support if the issue persists:', 'omnikassa').' <a href="https://ajdg.solutions/contact/?utm_campaign=contact&utm_medium=nonce-error&utm_source=omnikassa" title="AJdG Solutions Support" target="_blank">AJdG Solutions Support</a>.</p>';
}

/*-------------------------------------------------------------
 Name:      omnikassa_activate
 Purpose:   Set up licensing and firstrun status
 Since:		1.0
-------------------------------------------------------------*/
function omnikassa_activate() {
	if(!current_user_can('activate_plugins')) {
		deactivate_plugins(plugin_basename('omnikassa/omnikassa.php'));
		wp_die('You do not have appropriate access to activate this plugin! Contact your administrator!<br /><a href="'. get_option('siteurl').'/wp-admin/plugins.php">Back to plugins</a>.'); 
		return; 
	} else {
		// Set default settings and values
		add_option('ajdg_omnikassa_hide_review', current_time('timestamp'));
	}
}

/*-------------------------------------------------------------
 Name:      omnikassa_uninstall
 Purpose:   Clean up on uninstall
 Since:		1.0
-------------------------------------------------------------*/
function omnikassa_uninstall() {
	delete_option('ajdg_omnikassa_hide_review');
}

/*-------------------------------------------------------------
 Name:      omnikassa_notifications_dashboard
 Purpose:   Tell user to register copy
 Since:		1.0
-------------------------------------------------------------*/
function omnikassa_notifications_dashboard() {
	if(isset($_GET['hide']) AND $_GET['hide'] == 1) update_option('ajdg_omnikassa_hide_review', 1);

	$review_banner = get_option('ajdg_omnikassa_hide_review');
	if($review_banner != 1 AND $review_banner < (current_time('timestamp') - 2419200)) {
		echo '<div class="updated" style="padding: 0; margin: 0;">';
		echo '	<div class="ajdg_omnikassa_notification">';
		echo '		<div class="button_div"><a class="button" target="_blank" href="https://wordpress.org/support/view/plugin-reviews/omnikassa?rate=5#postform">Review Plugin</a></div>';
		echo '		<div class="text">Please write a review for <strong>OmniKassa for WooCommerce</strong> if you like the plugin.<br /><span>If you have questions, suggestions or something else that doesn\'t belong in a review, please <a href="https://ajdg.solutions/forums/forum/payment-gateways/omnikassa-for-woocommerce/" target="_blank">get in touch</a>!</span></div>';
		echo '		<a class="close_notification" href="admin.php?page=wc-settings&tab=checkout&section=ajdg_omnikassa&hide=1"><img title="Close" src="'.plugins_url('/images/icon-close.png', __FILE__).'" alt=""/></a>';
		echo '		<div class="icon"><img title="Logo" src="'.plugins_url('/images/ajdg-logo.png', __FILE__).'" alt=""/></div>';
		echo '	</div>';
		echo '</div>';
	}
}

/*-------------------------------------------------------------
 Name:      omnikassa_dashboard_styles
 Purpose:   Load file uploaded popup
 Since:		1.0
-------------------------------------------------------------*/
function omnikassa_dashboard_styles() {
	wp_enqueue_style('omnikassa-admin-stylesheet', plugins_url('library/dashboard.css', __FILE__));
}
?>