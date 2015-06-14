<?
/* This file outputs necessary code for the front end:
 * Shortcode functions
 * wp_enqueueing files etc
 */

require_once( plugin_dir_path( __FILE__ ) . '/stripe-config.php' );

function acw_ca_enqueue()
{
	// $handle, $src, $dependencies, $version, $in_footer
	wp_register_script( 'stripe', 'https://checkout.stripe.com/checkout.js', array('jquery'), '', true );
	wp_enqueue_script( 'stripe' );
}

add_action( 'wp_enqueue_scripts', 'acw_ca_enqueue' ); 

function acw_ca_checkout_shortcode($atts) 
{

	$atts = shortcode_atts(
		array(
			'amount' => '',
			'description' => '',
			'zip-code' => 'false',
			'subscription' => 'false',
			'plan' => '',
			'allow-remember-me' => 'false'
		), $atts, 'acw-ca-checkout' );

	$data_atts = '';

	foreach($atts as $att => $val) {
		$data_atts .= 'data-' . $att . '="' . $val . '" ';
	}

	$key = get_option( 'acw_ca_options' );

	if( is_array($key) ) {
		$key = $key['acw_ca_toggle'] == 'on' ? $key['acw_ca_live_publishable'] : $key['acw_ca_test_publishable'];
	} else {
		$key = 'null';
	}

	$form = '<form action="' . plugin_dir_url( __FILE__ ) . 'charge.php" method="post">';
	$form .= '<script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="' . $key. '" data-image="https://s3.amazonaws.com/stripe-uploads/acct_16BdJsJq4pVoKUPwmerchant-icon-1433820435855-acw-icon.png" data-name="Andrew Carlson Web" ' . $data_atts . '></script>';
	$form .= '<input type="hidden" name="amount" value="' . $atts['amount'] . '" />';
	$form .= '<input type="hidden" name="subscription" value="' . $atts['subscription'] . '" />';
	$form .= '<input type="hidden" name="plan" value="' . $atts['plan'] . '" />';
	$form .= '<input type="hidden" name="description" value="' . $atts['description'] . '" />';
	$form .= '</form>';

	return $form;
};

add_shortcode('acw-ca-checkout', 'acw_ca_checkout_shortcode');

function acw_ca_parse_request($wp) {

    if (array_key_exists('acw-ca', $wp->query_vars) && $wp->query_vars['acw-ca'] == 'checkout') {

        //require_once( plugin_dir_path( __FILE__ ) . '/stripe-config.php' );

    }
}

add_action('parse_request', 'acw_ca_parse_request');

function acw_ca_plugin_query_vars($vars) {
    $vars[] = 'acw-ca';
    return $vars;
}

add_filter('query_vars', 'acw_ca_plugin_query_vars'); ?>