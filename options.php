<?php

/*
 * Add the Stripe settings page under the general 'Settings' Top Level Menu
 */

add_action( 'admin_menu', 'acw_ca_settings_menu' );
add_action( 'admin_init', 'acw_ca_admin_init' );
add_action( 'admin_enqueue_scripts', 'acw_ca_admin_enqueue' );

function acw_ca_admin_enqueue( $hook ) 
{
	if( $hook == 'settings_page_client-area') {
		wp_register_style( 'acw_ca_admin_style', plugin_dir_url( __FILE__ ) . 'css/acw-ca-be-styles.css', false, '1.0.0' );
        wp_enqueue_style( 'acw_ca_admin_style' );
        wp_register_script( 'acw_ca_admin_script', plugin_dir_url( __FILE__ ) . 'js/acw-ca-be.js', array('jquery'), '1.0.0' );
        wp_enqueue_script( 'acw_ca_admin_script' );
	} else {
		return;
	}
}

function acw_ca_settings_menu()
{
	// $page_title, $menu_title, $capability, $slug, $callback
	add_options_page( 'Client Management', 'Client Management', 'manage_options', 'client-area', 'acw_ca_options_pg');
}

function acw_ca_admin_init()
{
	// $option_group, $option_name, $sanitation_callback
	register_setting( 'acw_ca_options', 'acw_ca_options' );

	// $id, $title, $callback, $page
	// Settings Section that contains Stripe keys and settings.
	add_settings_section( 'acw_ca_options', 'Stripe Settings', 'acw_ca_options_text', 'acw_ca_options_pg' );

	// $id, $title, $callback, $page, $section
	add_settings_field( 'acw_ca_toggle', 'Live Mode', 'acw_ca_toggle', 'acw_ca_options_pg', 'acw_ca_options' );
	add_settings_field( 'acw_ca_live_publishable', 'Live Publishable Key', 'acw_ca_live_publishable', 'acw_ca_options_pg', 'acw_ca_options' );
	add_settings_field( 'acw_ca_live_secret', 'Live Secret Key', 'acw_ca_live_secret', 'acw_ca_options_pg', 'acw_ca_options' );
	add_settings_field( 'acw_ca_test_publishable', 'Test Publishable Key', 'acw_ca_test_publishable', 'acw_ca_options_pg', 'acw_ca_options' );
	add_settings_field( 'acw_ca_test_secret', 'Test Secret Key', 'acw_ca_test_secret', 'acw_ca_options_pg', 'acw_ca_options' );

}

// Settings Section Text Callback (add_settings_section())
function acw_ca_options_text()
{
	echo '<p>The following settings may be found by logging into your Stripe Account and navigating to "My Account -> API Keys"</p>';
}

// State toggle option output.
function acw_ca_toggle()
{
	$options = get_option( 'acw_ca_options' );

	if( is_array($options) ) {
		$value = $options['acw_ca_toggle'] == 'on' ? 'checked' : '';
	} ?>

	<input id="acw_ca_toggle" name="acw_ca_options[acw_ca_toggle]" type="checkbox" <?= $value; ?>>

	<?
}

// Live Publishable option output.
function acw_ca_live_publishable()
{ ?>

	<input id="acw_ca_live_publishable" name="acw_ca_options[acw_ca_live_publishable]" type="text" value="<?= get_option_values('acw_ca_live_publishable'); ?>">

<?
}

// Live Secret option output.
function acw_ca_live_secret()
{ ?>

	<input id="acw_ca_live_secret" name="acw_ca_options[acw_ca_live_secret]" type="text" value="<?= get_option_values('acw_ca_live_secret'); ?>">

<?
}

// Test Publishable option output.
function acw_ca_test_publishable()
{ ?>

	<input id="acw_ca_test_publishable" name="acw_ca_options[acw_ca_test_publishable]" type="text" value="<?= get_option_values('acw_ca_test_publishable'); ?>">

<?
}

// Test Secret option output.
function acw_ca_test_secret()
{ ?>

	<input id="acw_ca_test_secret" name="acw_ca_options[acw_ca_test_secret]" type="text" value="<?= get_option_values('acw_ca_test_secret'); ?>">

<?
}

function shortcode_generator() 
{ ?>
	<table class="form-table">
		<tr>
			<th>New Checkout</th>
			<td>
				<div class="acw-ca-shortcode-generator">
					<label class="acw-ca-checkout-label" for="acw_ca_checkout_amount">Amount</label>
					<input id="acw_ca_checkout_amount" placeholder="Amount" class="amount" type="text" value="">
					<label class="acw-ca-checkout-label" for="acw_ca_checkout_description">Description</label>
					<input id="acw_ca_checkout_description" placeholder="Description" class="description" type="text" value="">
					<label class="acw-ca-checkout-label" for="acw_ca_checkout_plan">Subscription Plan</label>
					<input id="acw_ca_checkout_plan" placeholder="hosting_premium_yearly" class="plan-text" type="text" value="">
					<label class="acw-ca-checkout-label" for="acw_ca_checkout_zip">Require Zip Code</label>
					<input id="acw_ca_checkout_zip" placeholder="Zip Code" class="zip" type="checkbox">
					<label class="acw-ca-checkout-label" for="acw_ca_checkout_subscription">Subscription</label>
					<input id="acw_ca_checkout_subscription" class="subscription" type="checkbox">
					<label class="acw-ca-checkout-label" for="acw_ca_checkout_remember">Allow Remember Me</label>
					<input id="acw_ca_checkout_remember" class="remember" type="checkbox">
				</div>
				<div class="acw-ca-shortcode-result">
					<p>Paste this shortcode wherever you would like the checkout to appear</p>
					<code class="acw-ca-shortcode">[acw-ca-checkout amount="<span class='acw-ca-amount-out'></span>" description="<span class='acw-ca-description-out'></span>" button="<span class='acw-ca-plan-out'></span>" zip="<span class='acw-ca-zip-out'></span>" remember="<span class='acw-ca-remember-out'></span>" subcription="<span class='acw-ca-subscription-out'></span>"]</code>
				</div>
			</td>
		</tr>
	</table>

<?	
}

function get_option_values($key)
{
	if( isset($key) ) {
		$options = get_option( 'acw_ca_options' );

		if( is_array($options) ) {
			return $options[$key];
		}
	}
}

function acw_ca_options_pg()
{ ?>

	<h2>Client Area</h2>

	<form action="options.php" method="post">
		<? settings_fields( 'acw_ca_options' ); ?>
		<? do_settings_sections( 'acw_ca_options_pg' ); ?>
		<? submit_button(); ?>
	</form>

	<h3>Checkout Shortcode Generator</h3>
	<? shortcode_generator(); ?>

<?
} ?>