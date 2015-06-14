<?

// This is BAD
if( !function_exists('plugin_dir_path') ) {
    require_once('../../../wp-load.php');
}

require_once( plugin_dir_path( __FILE__ ) . '/stripe-config.php' );

$input = @file_get_contents("php://input");
$event_json = json_decode($input);

var_dump($event_json);

http_response_code(200); ?>