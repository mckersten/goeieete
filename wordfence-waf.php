<?php
// Before removing this file, please verify the PHP ini setting `auto_prepend_file` does not point to this.

// This file was the current value of auto_prepend_file during the Wordfence WAF installation (Thu, 07 Feb 2019 22:16:28 +0000)
if (file_exists('/home/dkuzhwbn/domains/goeieete.nl/public_html/wordfence-waf.php')) {
	include_once '/home/dkuzhwbn/domains/goeieete.nl/public_html/wordfence-waf.php';
}
if (file_exists('/home/dkuzhwbn/domains/goeieete.nl/public_html/wp-content/plugins/wordfence/waf/bootstrap.php')) {
	define("WFWAF_LOG_PATH", '/home/dkuzhwbn/domains/goeieete.nl/public_html/wp-content/wflogs/');
	include_once '/home/dkuzhwbn/domains/goeieete.nl/public_html/wp-content/plugins/wordfence/waf/bootstrap.php';
}
?>