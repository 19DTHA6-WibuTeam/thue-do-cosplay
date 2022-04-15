<?php
include '../config.php';

function getStatusCodeMeeage($status)
{
	$codes = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => '(Unused)',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported'
	);
	return (isset($codes[$status])) ? $codes[$status] : '';
}
function sendResponse($status = 200, $body = '', $content_type = 'text/html')
{
	$status_header = 'HTTP/1.1 ' . $status . ' ' . getStatusCodeMeeage($status);
	header($status_header);
	header('Content-type: ' . $content_type);
	echo $body;
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$res['success'] = false;
$api = new API;
switch (strtolower(getREQUEST('action'))) {
	case 'post_cart':
		$res['success'] = $api->postCart(getREQUEST('user_id'), getREQUEST('product_id'), getREQUEST('cart_product_quantity'));
		break;
	case 'update_cart':
		$res['success'] = $api->updateCart(getREQUEST('user_id'), getREQUEST('product_id'), getREQUEST('cart_product_quantity'));
		break;
	case 'delete_cart':
		$res['success'] = $api->deleteCart(getREQUEST('user_id'), getREQUEST('product_id'));
		break;
	default:
		# code...
		break;
}
echo json_encode($res);
