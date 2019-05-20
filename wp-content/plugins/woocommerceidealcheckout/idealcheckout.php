<?php

	require_once(ABSPATH . 'idealcheckout/includes/library.php');



	// Admin menu script
	function idealcheckout_admin_menu()
	{
		add_menu_page('iDEAL Checkout', 'iDEAL Checkout', 'manage_options', 'idealcheckout-about', 'idealcheckout_about_html', get_bloginfo('wpurl') . '/idealcheckout/images/ideal_16x16.png');
		add_submenu_page('idealcheckout-about', 'Transacties', 'Transacties', 'manage_options', 'idealcheckout-records', 'idealcheckout_records_html');
	}


	function idealcheckout_records_html()
	{
		if(!current_user_can('manage_options'))
		{
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}

		global $wpdb;
		$aDatabaseSettings = idealcheckout_getDatabaseSettings();

		$sql = "SELECT `order_id`, `gateway_code`, `transaction_id`, `transaction_date`, `transaction_amount`, `transaction_status`, `transaction_params`, `order_params` FROM `" . $aDatabaseSettings['table'] . "` ORDER BY `transaction_date` DESC LIMIT 100;";
		$oRecordset = $wpdb->get_results($sql);

		$sHtml = '
<div class="wrap">
	<h2>Transacties</h2>
	<p>Overzicht van ge&iuml;nitieerde transacties via iDEAL. Alleen de transacties met status "SUCCESS" zijn volledig afgerond.</p>
	<table class="widefat">
		<thead>
			<tr>
				<th>Datum</th>
				<th>Order ID</th>
				<th>Naam</th>
				<th>E-mail</th>
				<th>Bedrag</th>
				<th>Betaalmethode</th>
				<th>Transactie ID</th>
				<th>Transactie Status</th>
			</tr>
		</thead>
		<tbody>';

		if(sizeof($oRecordset))
		{
			foreach($oRecordset as $oRecord)
			{
				$aParams = idealcheckout_unserialize($oRecord->order_params);

				$sHtml .= '
			<tr>
				<td>' . htmlspecialchars(date('d-m-Y', $oRecord->transaction_date)) . '</td>
				<td>' . htmlspecialchars($oRecord->order_id) . '</td>';

				if(empty($aParams['last_name']))
				{
					if(empty($aParams['first_name']))
					{
						$sHtml .= '
				<td>-</td>';
					}
					else
					{
						$sHtml .= '
				<td>' . htmlspecialchars($aParams['last_name']) . '</td>';
					}
				}
				else
				{
					if(empty($aParams['first_name']))
					{
						$sHtml .= '
				<td>' . htmlspecialchars($aParams['last_name'] . ', ' . $aParams['first_name']) . '</td>';
					}
					else
					{
						$sHtml .= '
				<td>' . htmlspecialchars($aParams['first_name']) . '</td>';
					}
				}

				$sHtml .= '
				<td>' . (empty($aParams['email']) ? '-' : '<a href="mailto:' . htmlspecialchars($aParams['email']) . '">' . htmlspecialchars($aParams['email']) . '</a>') . '</td>
				<td>' . htmlspecialchars(number_format($oRecord->transaction_amount, 2, ',', '.')) . '</td>
				<td>' . htmlspecialchars($oRecord->gateway_code) . '</td>
				<td>' . htmlspecialchars($oRecord->transaction_id) . '</td>
				<td>' . htmlspecialchars($oRecord->transaction_status) . '</td>
			</tr>';
			}
		}
		else
		{
			$sHtml .= '
			<tr>
				<td colspan="7">Geen transacties gevonden!</td>
			</tr>';
		}

		$sHtml .= '
		</tbody>
	</table>';



		$aGatewaySettings = idealcheckout_getGatewaySettings(false, 'ideal');

		if($aGatewaySettings['GATEWAY_VALIDATION'])
		{
			$sHtml .= '
		<h2>Transacties Controleren</h2>
		<p>Controleer de status van alle openstaande transacties bij uw Payment Service Provider.<br><br><input type="button" value="Controleer openstaande transacties." onclick="javascript: window.open(\'' . get_option('siteurl') . '/idealcheckout/validate.php\', \'popup\', \'directories=no,height=550,location=no,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no,width=750\');"></p>';
		}

		$sHtml .= '
</div>';

		echo $sHtml;
	}

	function idealcheckout_about_html()
	{
		if(!current_user_can('manage_options'))
		{
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		
		$sHtml = '
<div class="wrap">
	<h2>iDEAL Checkout</h2>
	<p>Via onze plugins kunt u o.a. iDEAL, MisterCash, Direct E-Banking, CreditCard, MiniTix, Paypal en PaySafeCard betalingen ontvangen in uw webshop via diverse Payment Service Providers.</p>
	<p>&nbsp;</p>
	<h2>Over deze plugin</h2>
	<p>Deze iDEAL plugin is ontwikkeld door <a href="http://www.ideal-checkout.nl" target="_blank">iDEAL Checkout</a> en is GRATIS te downloaden via <a href="http://www.ideal-checkout.nl" target="_blank">http://www.ideal-checkout.nl</a>.<br><br>- Feedback en donaties worden zeer op prijs gesteld.<br>- Het gebruik van onze plugins/scripts is geheel op eigen risico.</p>
</div>';
	
		echo $sHtml;
	}

	// Hook for adding admin menus
	add_action('admin_menu', 'idealcheckout_admin_menu');



	// Include WooCommerce gateways
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-afterpay.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-authorizedtransfer.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-creditcard.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-directebanking.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-ideal.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-klarnaaccount.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-klarnainvoice.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-maestro.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-manualtransfer.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-mastercard.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-mistercash.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-paypal.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-paysafecard.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-visa.php');
	require_once(dirname(__FILE__) . '/idealcheckout-woocommerce-vpay.php');

?>