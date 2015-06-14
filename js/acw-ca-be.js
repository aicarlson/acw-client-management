jQuery(document).ready(function($) {
	// Admin area shortcode generator

	$('.acw-ca-shortcode-generator input').on('keyup change', function() {
		var amount = $('.acw-ca-shortcode-generator').find('.amount').val();
			description = $('.acw-ca-shortcode-generator').find('.description').val();
			button = $('.acw-ca-shortcode-generator').find('.plan-text').val();
			subscription = $('.acw-ca-shortcode-generator').find('.subscription').is(':checked') ? 'true' : 'false';
			remember = $('.acw-ca-shortcode-generator').find('.remember').is(':checked') ? 'true' : 'false';
			zip = $('.acw-ca-shortcode-generator').find('.zip').is(':checked') ? 'true' : 'false';

		$('code.acw-ca-shortcode .acw-ca-amount-out').text(amount);
		$('code.acw-ca-shortcode .acw-ca-description-out').text(description);
		$('code.acw-ca-shortcode .acw-ca-plan-out').text(button);
		$('code.acw-ca-shortcode .acw-ca-zip-out').text(zip);
		$('code.acw-ca-shortcode .acw-ca-remember-out').text(remember);
		$('code.acw-ca-shortcode .acw-ca-subscription-out').text(subscription);

	});
});