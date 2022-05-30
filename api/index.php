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
// $api = new API;
$users = new User;
$products = new Products;
$product_types = new ProductTypes;
$carts = new Cart;
$invoices = new Invoice;

switch (strtolower(getREQUEST('action'))) {
	case 'login':
		$a = $users->login(getREQUEST('email'), getREQUEST('password'));
		if ($a != false) {
			unset($a['user_password']);
			unset($a['user_bank_account_number']);
			unset($a['user_bank_name']);
			$a['user_token'] = $users->Token($user);
			$res['success'] = true;
		} else $a = null;
		$res['data'] = $a;
		break;
	case 'register':
		$res['success'] = $users->register(getREQUEST('fullname'), getREQUEST('email'), getREQUEST('password'));
		$res['user'] = $a;
		break;
	case 'get_user':
		$a = $users->getUser(getREQUEST('user_id'));
		if ($a != false) {
			unset($a['user_password']);
			$a['user_token'] = $users->Token($user);
			$res['success'] = true;
		} else $a = null;
		$res['data'] = $a;
		break;
	case 'update_user':
		$res['success'] = $users->updateUser(getREQUEST('user_id'), getREQUEST('user_fullname'), getREQUEST('user_email'), getREQUEST('user_phone_number'), getREQUEST('user_address'), getREQUEST('user_bank_account_number'), getREQUEST('user_bank_name'));
		break;
	case 'get_product_types':
		$res['success'] = true;
		$res['data'] = $product_types->getProductTypes();
		break;
	case 'get_products':
		$res['success'] = true;
		$res['data'] = $products->getProducts(1, getREQUEST('page'), getREQUEST('limit'));
		break;
	case 'search_products':
		$res['success'] = true;
		$res['data'] = $products->search(getREQUEST('keyword'), 1, getREQUEST('page'), getREQUEST('limit'));
		break;
	case 'get_carts':
		$res['success'] = true;
		$res['data'] = $carts->getCart(getREQUEST('user_id'));
		break;
	case 'post_cart':
		$res['success'] = $carts->postCart(getREQUEST('user_id'), getREQUEST('product_id'), getREQUEST('cart_product_quantity'));
		break;
	case 'update_cart':
		$res['success'] = $carts->updateCart(getREQUEST('user_id'), getREQUEST('product_id'), getREQUEST('cart_product_quantity'));
		break;
	case 'delete_cart':
		$res['success'] = $carts->deleteCart(getREQUEST('user_id'), getREQUEST('product_id'));
		break;
	case 'get_invoices':
		$res['success'] = true;
		$res['data'] = $invoices->getInvoicesByUserId(getREQUEST('user_id'), getREQUEST('page'), getREQUEST('limit'));
		break;
	case 'post_invoice':
		$res['success'] = $invoices->postInvoice(getREQUEST('user_id'), getREQUEST('user_fullname'), getREQUEST('user_phone_number'), getREQUEST('user_email'), getREQUEST('user_address'), getREQUEST('order_note'));
		break;
	case 'get_invoice_details':
		$res['success'] = true;
		$res['data'] = $invoices->getInvoiceDetails(getREQUEST('invoice_id'));
		break;
	default:
		# code...
		break;
}
echo json_encode($res);
