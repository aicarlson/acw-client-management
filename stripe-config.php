<?php

// This is BAD

if( !function_exists('plugin_dir_path') ) {
	require_once('../../../wp-load.php');
}

require_once( plugin_dir_path( __FILE__ ) . '/stripe-php/init.php' );

$keys = get_option( 'acw_ca_options' );

if( is_array($keys) ) {

	$sk = $keys['acw_ca_toggle'] == 'on' ? $keys['acw_ca_live_secret'] : $keys['acw_ca_test_secret'];
	$pk = $keys['acw_ca_toggle'] == 'on' ? $keys['acw_ca_live_publishable'] : $keys['acw_ca_test_publishable'];

	$stripe = array(
		"secret_key"      => $sk,
		"publishable_key" => $pk
	);

	\Stripe\Stripe::setApiKey($stripe['secret_key']);

}
?>