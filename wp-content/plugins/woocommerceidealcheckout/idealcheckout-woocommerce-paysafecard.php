<?php

	require_once(ABSPATH . 'idealcheckout/includes/library.php');

	class woocommerce_idealcheckout_paysafecard extends WC_Payment_Gateway
	{
		public function __construct()
		{
			global $woocommerce;

			$this->id = 'idealcheckout_paysafecard';
			$this->method_title = 'iDEAL Checkout - PaySafeCard';
			$this->icon = plugins_url('assets/images/paysafecard.png', __FILE__);
			$this->has_fields = false;
			$this->method_description = 'Let op: Door de WooCommerce instelling "Voorraad behouden" te gebruiken kunnen bestellingen onterecht geannuleerd worden. Houdt hier rekening mee!';

			// Load the form fields.
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();

			// Define user set variables
			$this->title = $this->settings['title'];
			$this->description = $this->settings['description'];
			$this->payment_success = $this->settings['payment_success'];
			$this->payment_pending = $this->settings['payment_pending'];
			$this->payment_cancelled = $this->settings['payment_cancelled'];
			$this->payment_failed = $this->settings['payment_failed'];
			$this->cancel_order_on_failure = $this->settings['cancel_order_on_failure'];

			// add_action('woocommerce_receipt_' . $this->id, array(&$this, 'receipt_page'));
			add_action('woocommerce_thankyou_' . $this->id, array(&$this, 'thankyou_page'));
			add_action('woocommerce_update_options_payment_gateways', array(&$this, 'process_admin_options'));
			add_action('woocommerce_update_options_payment_gateways_'.$this->id, array(&$this, 'process_admin_options')); 
		}

		public function init_form_fields()
		{
			$this->form_fields = array(
				'enabled' => array(
					'title' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Enable/Disable'),
					'type' => 'checkbox',
					'label' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Enable PaySafeCard Payment'),
					'default' => 'no'
				),
				'title' => array(
					'title' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Title'),
					'type' => 'text',
					'description' => '',
					'default' => 'PaySafeCard'
				),
				'description' => array(
					'title' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Description'),
					'type' => 'textarea',
					'description' => '',
					'default' => 'Betaal direct online via uw eigen bank.'
				),
				'cancel_order_on_failure' => array(
					'title' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Cancel order on payment failure'),
					'type' => 'checkbox',
					'label' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Yes'),
					'default' => 'yes'
				),
				'payment_success' => array(
					'title' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Payment success'),
					'type' => 'textarea',
					'description' => '',
					'default' => ''
				),
				'payment_pending' => array(
					'title' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Payment pending'),
					'type' => 'textarea',
					'description' => '',
					'default' => ''
				),
				'payment_cancelled' => array(
					'title' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Payment cancelled'),
					'type' => 'textarea',
					'description' => '',
					'default' => ''
				),
				'payment_failed' => array(
					'title' => idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Payment failed'),
					'type' => 'textarea',
					'description' => '',
					'default' => ''
				)
			);
		}

		public function admin_options()
		{
?>
<h3><?php echo idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'iDEAL Checkout - PaySafeCard'); ?></h3>
<table class="form-table">
<?php $this->generate_settings_html(); ?>
</table>
<?php
		}

		public function payment_fields()
		{
			if($this->description)
			{
				echo wpautop(wptexturize($this->description));
			}
		}

		public function getLanguageCode()
		{
			if(empty($this->sLanguageCode))
			{
				$this->sLanguageCode = strtolower(substr(get_bloginfo('language'), 0, 2));

				if(!in_array($this->sLanguageCode, array('nl', 'en', 'de')))
				{
					$this->sLanguageCode = 'nl';
				}
			}

			return $this->sLanguageCode;
		}


		public function process_payment($order_id)
		{
			global $wpdb, $woocommerce;

			// $oOrder = new WC_Order($order_id);
			$oOrder = wc_get_order($order_id); 

			// Get all order related data
			$aOrderData = $oOrder->get_data();
			
			
			$sSiteUrl = get_bloginfo('wpurl');

			$aDatabaseSettings = idealcheckout_getDatabaseSettings();

			$sStoreCode = '';
			$sGatewayCode = 'paysafecard';
			// $sLanguageCode = strtolower(substr(get_bloginfo('language'), 0, 2)); // nl|de|en
			$sLanguageCode = ''; // nl, de, en
			$sCountryCode = '';
			$sCurrencyCode = 'EUR';
		
			
			$sOrderId = $aOrderData['id'];
			$sOrderCode = idealcheckout_getRandomCode(32);
			
			$aOrderParams = array(
'order_id' => $aOrderData['id'], 
'order_key' => $aOrderData['order_key']);


			$sOrderParams = idealcheckout_serialize($aOrderParams);
			$sTransactionId = idealcheckout_getRandomCode(32);
			$sTransactionCode = idealcheckout_getRandomCode(32);
			$fTransactionAmount = $aOrderData['total'];

			$sTransactionDescription = idealcheckout_getTranslation($sLanguageCode, 'idealcheckout', 'Webshop order #{0}', array($sOrderId));
			$sTransactionPaymentUrl = '';

			$sTransactionSuccessUrl = $this->get_return_url($oOrder); 
			$sTransactionPendingUrl = '';
			$sTransactionFailureUrl = ((strcasecmp($this->cancel_order_on_failure, 'yes') === 0) ? $oOrder->get_cancel_order_url_raw() : $sTransactionSuccessUrl);

			
	
			
			$aShippingData = $aOrderData['shipping'];
			$aBillingData = $aOrderData['billing'];
			
			$sCustomerEmail = $aBillingData['email'];
			$sPhoneNumber = $aBillingData['phone'];
			
			$sShippingCountry = WC()->countries->countries[$aShippingData['country']];
			$sBillingCountry = WC()->countries->countries[$aBillingData['country']];

			
			$aOrderParams['customer'] = array();

			// Shipment data
			list($sStreetName, $sStreetNumber, $sExtension) = idealcheckout_mb_splitAddress($aShippingData['address_1'] . ' ' . $aShippingData['address_2']);

			$aOrderParams['customer']['shipment_company'] = $aShippingData['company'];
			$aOrderParams['customer']['shipment_name'] = $aShippingData['first_name'] . ' ' . $aShippingData['last_name'];
			$aOrderParams['customer']['shipment_first_name'] = $aShippingData['first_name'];
			$aOrderParams['customer']['shipment_last_name'] = $aShippingData['last_name'];
			$aOrderParams['customer']['shipment_gender'] = '';
			$aOrderParams['customer']['shipment_date_of_birth'] = '';
			$aOrderParams['customer']['shipment_phone'] = $sPhoneNumber;
			$aOrderParams['customer']['shipment_email'] = $sCustomerEmail;
			$aOrderParams['customer']['shipment_address'] = $aShippingData['address_1'] . (empty($aShippingData['address_2']) ? '' : ', ' . $aShippingData['address_2']);
			$aOrderParams['customer']['shipment_street_name'] = $sStreetName;
			$aOrderParams['customer']['shipment_street_number'] = $sStreetNumber;
			$aOrderParams['customer']['shipment_street_number_extensie'] = $sExtension;
			$aOrderParams['customer']['shipment_zipcode'] = $aShippingData['postcode'];
			$aOrderParams['customer']['shipment_city'] = $aShippingData['city'];
			$aOrderParams['customer']['shipment_country_code'] = $aShippingData['country'];
			$aOrderParams['customer']['shipment_country_name'] = $sShippingCountry;


			// Payment data
			list($sStreetName, $sStreetNumber, $sExtension) = idealcheckout_mb_splitAddress($aBillingData['address_1'] . ' ' . $aBillingData['address_2']);

			$aOrderParams['customer']['payment_company'] = $aBillingData['company'];
			$aOrderParams['customer']['payment_name'] = $aBillingData['first_name'] . ' ' . $aBillingData['last_name'];
			$aOrderParams['customer']['payment_first_name'] = $aBillingData['first_name'];
			$aOrderParams['customer']['payment_last_name'] = $aBillingData['last_name'];
			$aOrderParams['customer']['payment_gender'] = '';
			$aOrderParams['customer']['payment_date_of_birth'] = '';
			$aOrderParams['customer']['payment_phone'] = $sPhoneNumber;
			$aOrderParams['customer']['payment_email'] = $sCustomerEmail;
			$aOrderParams['customer']['payment_address'] = $aBillingData['address_1'] . (empty($aBillingData['address_2']) ? '' : ', ' . $aBillingData['address_2']);
			$aOrderParams['customer']['payment_street_name'] = $sStreetName;
			$aOrderParams['customer']['payment_street_number'] = $sStreetNumber;
			$aOrderParams['customer']['payment_street_number_extension'] = $sExtension;
			$aOrderParams['customer']['payment_zipcode'] = $aBillingData['postcode'];
			$aOrderParams['customer']['payment_city'] = $aBillingData['city'];
			$aOrderParams['customer']['payment_country_code'] = $aBillingData['country'];
			$aOrderParams['customer']['payment_country_name'] = $sBillingCountry;

			
			
			$aOrderParams['products'][] = array('code' => $sOrderId, 'description' => $sTransactionDescription, 'quantity' => 1, 'price_incl' => $fTransactionAmount, 'price_excl' => $fTransactionAmount, 'vat' => 0);

			

			// Insert into #_transactions
			$sql = "INSERT INTO `" . $aDatabaseSettings['table'] . "` SET 
`id` = NULL, 
`order_id` = '" . idealcheckout_escapeSql($sOrderId) . "', 
`order_code` = '" . idealcheckout_escapeSql($sOrderCode) . "', 
`order_params` = '" . idealcheckout_escapeSql(idealcheckout_serialize($aOrderParams)) . "', 
`store_code` = " . ($sStoreCode ? "'" . idealcheckout_escapeSql($sStoreCode) . "'" : "NULL") . ", 
`gateway_code` = '" . idealcheckout_escapeSql($sGatewayCode) . "', 
`language_code` = " . ($sLanguageCode ? "'" . idealcheckout_escapeSql($sLanguageCode) . "'" : "NULL") . ", 
`country_code` = " . ($sCountryCode ? "'" . idealcheckout_escapeSql($sCountryCode) . "'" : "NULL") . ", 
`currency_code` = " . ($sCurrencyCode ? "'" . idealcheckout_escapeSql($sCurrencyCode) . "'" : "NULL") . ", 
`transaction_id` = '" . idealcheckout_escapeSql(idealcheckout_getRandomCode(32)) . "', 
`transaction_code` = '" . idealcheckout_escapeSql(idealcheckout_getRandomCode(32)) . "', 
`transaction_params` = NULL, 
`transaction_date` = '" . idealcheckout_escapeSql(time()) . "', 
`transaction_amount` = '" . idealcheckout_escapeSql($fTransactionAmount) . "', 
`transaction_description` = '" . idealcheckout_escapeSql($sTransactionDescription ? $sTransactionDescription : idealcheckout_getRandomCode(32)) . "', 
`transaction_status` = NULL, 
`transaction_url` = NULL, 
`transaction_payment_url` = " . ($sTransactionPaymentUrl ? "'" . idealcheckout_escapeSql($sTransactionPaymentUrl) . "'" : "NULL") . ", 
`transaction_success_url` = " . ($sTransactionSuccessUrl ? "'" . idealcheckout_escapeSql($sTransactionSuccessUrl) . "'" : "NULL") . ", 
`transaction_pending_url` = " . ($sTransactionPendingUrl ? "'" . idealcheckout_escapeSql($sTransactionPendingUrl) . "'" : "NULL") . ", 
`transaction_failure_url` = " . ($sTransactionFailureUrl ? "'" . idealcheckout_escapeSql($sTransactionFailureUrl) . "'" : "NULL") . ", 
`transaction_log` = NULL;";

			idealcheckout_database_query($sql);


			// Return redirect
			return array(
				'result' 	=> 'success',
				'redirect'	=> $sSiteUrl . '/idealcheckout/setup.php?order_id=' . $sOrderId . '&order_code=' . $sOrderCode
			);
		}

		public function receipt_page()
		{
			// idealcheckout_log($_GET, __FILE__, __LINE__);
		}

		public function thankyou_page()
		{
			global $wpdb, $woocommerce;

			// Remove cart
			$woocommerce->cart->empty_cart();

			if(!empty($_GET['key']))
			{
				$sOrderId = wc_get_order_id_by_order_key($_GET['key']);

				$oOrder = new WC_Order($sOrderId);

				if(!empty($sOrderId))
				{
					$aDatabaseSettings = idealcheckout_getDatabaseSettings();

					$sql = "SELECT `transaction_status` FROM `" . $aDatabaseSettings['table'] . "` WHERE `order_id` = '" . idealcheckout_escapeSql($sOrderId) . "' ORDER BY `id` DESC LIMIT 1;";
					$aOrder = idealcheckout_database_getRecord($sql);


					if(strcasecmp($aOrder['transaction_status'], 'SUCCESS') === 0)
					{
						$oOrder->add_order_note(idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Payment success'));
						$oOrder->payment_complete();
						echo wpautop(wptexturize($this->payment_success));
					}
					elseif(strcasecmp($aOrder['transaction_status'], 'PENDING') === 0)
					{
						$oOrder->update_status('pending', idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Payment pending'));
						echo wpautop(wptexturize($this->payment_pending));
					}
					elseif(strcasecmp($aOrder['transaction_status'], 'CANCELLED') === 0)
					{
						$oOrder->update_status('cancelled', idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Payment cancelled'));
						echo wpautop(wptexturize($this->payment_cancelled));
					}
					else
					{
						$oOrder->update_status('failed', idealcheckout_getTranslation($this->getLanguageCode(), 'woocommerce', 'Payment failed'));
						echo wpautop(wptexturize($this->payment_failed));
					}
				}
			}
		}
	}


	function woocommerce_add_idealcheckout_paysafecard($methods) 
	{
		$methods[] = 'woocommerce_idealcheckout_paysafecard'; 
		return $methods;
	}

	add_filter('woocommerce_payment_gateways', 'woocommerce_add_idealcheckout_paysafecard');

?>