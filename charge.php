<?php

// This is BAD
if( !function_exists('plugin_dir_path') ) {
    require_once('../../../wp-load.php');
}

require_once( plugin_dir_path( __FILE__ ) . '/stripe-config.php' );

$token  = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];
$amount = $_POST['amount'];
$subscription = $_POST['subscription'];
$plan = $_POST['plan'];
$description = $_POST['description'];

$customer_array = array(
    'email' => $email,
    'card' => $token
);

if($subscription == 'true' && $plan != '') {
    $customer_array['plan'] = $plan;
}

function attempt_transaction($customer_array, $amount, $description)
{
	$customer = \Stripe\Customer::create($customer_array);

    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $amount,
        'currency' => 'usd',
        'description'   => $description
    ));
}

// Send error message to /error
function catch_errors($message)
{
	if( isset($message) ) :
		header('Location: /error?message=' . $message);
		exit();
	endif;
}

function success()
{
	header('Location: /thank-you');
	exit();
}


try {

    attempt_transaction($customer_array, $amount, $description);

} catch (\Stripe\Error\ApiConnection $e) {

    try {
		attempt_transaction($customer_array, $amount, $description);
	} catch (Exception $e) {
		catch_errors('There was a network error, please contact us.');
	}

	success();

} catch (\Stripe\Error\InvalidRequest $e) {

    try {
		attempt_transaction($customer_array, $amount, $description);
	} catch (Exception $e){
		catch_errors('There was an unknown error, please contact us or try again.');
	}

	success();

} catch (\Stripe\Error\Api $e) {

	try {
		attempt_transaction($customer_array, $amount, $description);
	} catch (Exception $e){
		catch_errors('There was an error connecting to Stripe. Please contact us or try again');
	}

	success();

} catch (\Stripe\Error\Card $e) {

	catch_errors($e->getJsonBody()['error']['message']);

}

success();

?>