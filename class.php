<?php
class Recaptcha
{
	public static function Verify($token)
	{
		// call curl to POST request
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_SECRET_KEY, 'response' => $token)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$arrResponse = json_decode($response, true);
		if ($arrResponse["success"]) return true;
		else return false;
	}
}
class JWT
{
	/**
	 * Decodes a JWT string into a PHP object.
	 *
	 * @param string      $jwt    The JWT
	 * @param string|null $key    The secret key
	 * @param bool        $verify Don't skip verification process 
	 *
	 * @return object      The JWT's payload as a PHP object
	 * @throws UnexpectedValueException Provided JWT was invalid
	 * @throws DomainException          Algorithm was not provided
	 * 
	 * @uses jsonDecode
	 * @uses urlsafeB64Decode
	 */
	public static function decode($jwt, $key = null, $verify = true)
	{
		$tks = explode('.', $jwt);
		if (count($tks) != 3) {
			throw new UnexpectedValueException('Wrong number of segments');
		}
		list($headb64, $bodyb64, $cryptob64) = $tks;
		if (null === ($header = JWT::jsonDecode(JWT::urlsafeB64Decode($headb64)))) {
			throw new UnexpectedValueException('Invalid segment encoding');
		}
		if (null === $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64))) {
			throw new UnexpectedValueException('Invalid segment encoding');
		}
		$sig = JWT::urlsafeB64Decode($cryptob64);
		if ($verify) {
			if (empty($header->alg)) {
				throw new DomainException('Empty algorithm');
			}
			if ($sig != JWT::sign("$headb64.$bodyb64", $key, $header->alg)) {
				throw new UnexpectedValueException('Signature verification failed');
			}
		}
		return $payload;
	}
	/**
	 * Converts and signs a PHP object or array into a JWT string.
	 *
	 * @param object|array $payload PHP object or array
	 * @param string       $key     The secret key
	 * @param string       $algo    The signing algorithm. Supported
	 *                              algorithms are 'HS256', 'HS384' and 'HS512'
	 *
	 * @return string      A signed JWT
	 * @uses jsonEncode
	 * @uses urlsafeB64Encode
	 */
	public static function encode($payload, $key, $algo = 'HS256')
	{
		$header = array('typ' => 'JWT', 'alg' => $algo);

		$segments = array();
		$segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($header));
		$segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($payload));
		$signing_input = implode('.', $segments);

		$signature = JWT::sign($signing_input, $key, $algo);
		$segments[] = JWT::urlsafeB64Encode($signature);

		return implode('.', $segments);
	}
	/**
	 * Sign a string with a given key and algorithm.
	 *
	 * @param string $msg    The message to sign
	 * @param string $key    The secret key
	 * @param string $method The signing algorithm. Supported
	 *                       algorithms are 'HS256', 'HS384' and 'HS512'
	 *
	 * @return string          An encrypted message
	 * @throws DomainException Unsupported algorithm was specified
	 */
	public static function sign($msg, $key, $method = 'HS256')
	{
		$methods = array(
			'HS256' => 'sha256',
			'HS384' => 'sha384',
			'HS512' => 'sha512',
		);
		if (empty($methods[$method])) {
			throw new DomainException('Algorithm not supported');
		}
		return hash_hmac($methods[$method], $msg, $key, true);
	}
	/**
	 * Decode a JSON string into a PHP object.
	 *
	 * @param string $input JSON string
	 *
	 * @return object          Object representation of JSON string
	 * @throws DomainException Provided string was invalid JSON
	 */
	public static function jsonDecode($input)
	{
		$obj = json_decode($input);
		if (function_exists('json_last_error') && $errno = json_last_error()) {
			JWT::_handleJsonError($errno);
		} else if ($obj === null && $input !== 'null') {
			throw new DomainException('Null result with non-null input');
		}
		return $obj;
	}
	/**
	 * Encode a PHP object into a JSON string.
	 *
	 * @param object|array $input A PHP object or array
	 *
	 * @return string          JSON representation of the PHP object or array
	 * @throws DomainException Provided object could not be encoded to valid JSON
	 */
	public static function jsonEncode($input)
	{
		$json = json_encode($input);
		if (function_exists('json_last_error') && $errno = json_last_error()) {
			JWT::_handleJsonError($errno);
		} else if ($json === 'null' && $input !== null) {
			throw new DomainException('Null result with non-null input');
		}
		return $json;
	}
	/**
	 * Decode a string with URL-safe Base64.
	 *
	 * @param string $input A Base64 encoded string
	 *
	 * @return string A decoded string
	 */
	public static function urlsafeB64Decode($input)
	{
		$remainder = strlen($input) % 4;
		if ($remainder) {
			$padlen = 4 - $remainder;
			$input .= str_repeat('=', $padlen);
		}
		return base64_decode(strtr($input, '-_', '+/'));
	}
	/**
	 * Encode a string with URL-safe Base64.
	 *
	 * @param string $input The string you want encoded
	 *
	 * @return string The base64 encode of what you passed in
	 */
	public static function urlsafeB64Encode($input)
	{
		return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
	}
	/**
	 * Helper method to create a JSON error.
	 *
	 * @param int $errno An error number from json_last_error()
	 *
	 * @return void
	 */
	private static function _handleJsonError($errno)
	{
		$messages = array(
			JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
			JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
			JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON'
		);
		throw new DomainException(
			isset($messages[$errno])
				? $messages[$errno]
				: 'Unknown JSON error: ' . $errno
		);
	}
}
class Admin
{
	public function login($password)
	{
		if (strtolower($password) == strtolower(ADMIN_PASSWORD)) return true;
		else return false;
	}
	public function startSession()
	{
		$_SESSION['admin'] = true;
	}
	public static function endSession()
	{
		unset($_SESSION['admin']);
	}
}
class DB
{
	protected $conn;
	// public function __construct($conn)
	// {
	// 	$this->conn = $conn;
	// }
	function __construct()
	{
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Không thể kết nối tới database!');
		mysqli_set_charset($conn, "utf8");
		$this->conn = $conn;
	}
	public function getConnection()
	{
		return $this->conn;
	}
	function __destruct()
	{
		mysqli_close($this->conn);
	}
	public function Offset($page = 1, $limit = DATA_PER_PAGE)
	{
		$limit = mysqli_escape_string($this->conn, $limit);
		if ($limit == 0) return '';
		$page = mysqli_escape_string($this->conn, $page);
		if ($page < 1 || !is_numeric($page)) $page = 1;
		$offset = ' LIMIT ' . (($page - 1) *  $limit) . ',' .  $limit;
		return $offset;
	}
}
class User extends DB
{
	// $this->conn = $conn;
	public function getCount()
	{
		$total = mysqli_query($this->conn, "SELECT COUNT(user_id) AS total FROM users");
		$total = mysqli_fetch_assoc($total)['total'];
		return $total;
	}
	public function validUser($username)
	{
		$username = mysqli_escape_string($this->conn, $username);
		$a = mysqli_query($this->conn, "SELECT * FROM users WHERE `user_email`='$username'");
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a))
				$b = $row;
		else $b = false;
		mysqli_free_result($a);
		return $b;
	}
	public function encryptedPassword($password)
	{
		return sha1(SALT . '|' . $password);
	}
	public function login($email, $password)
	{
		$email = mysqli_escape_string($this->conn, $email);
		$pass = $this->encryptedPassword($password);
		$a = mysqli_query($this->conn, "SELECT * FROM users WHERE `user_email`='$email' AND `user_password`='$pass'");
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a))
				$b = $row;
		else $b = false;
		mysqli_free_result($a);
		return $b;
	}
	public function register($user_fullname, $user_email, $user_password)
	{
		$user_fullname = mysqli_escape_string($this->conn, $user_fullname);
		$a = $this->validUser($user_email);
		if ($a == false) {
			$user_password = $this->encryptedPassword($user_password);
			$user_created_at = time();
			$b = mysqli_query($this->conn, "INSERT INTO users (`user_fullname`, `user_email`, `user_password`, `user_created_at`) 
                                                        VALUES ('$user_fullname', '$user_email', '$user_password', '$user_created_at')");
			if ($b)
				return true;
			else
				return false;
		} else return false;
	}
	public function getUser($user_id)
	{
		$user_id = mysqli_escape_string($this->conn, $user_id);
		$a = mysqli_query($this->conn, "SELECT * FROM users WHERE `user_id`='$user_id'");
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a))
				$b = $row;
		else $b = false;
		mysqli_free_result($a);
		return $b;
	}
	public function updateUser($user_id, $user_fullname, $user_email, $user_phone_number, $user_address, $user_bank_account_number = '', $user_bank_name = '')
	{
		$a = $this->getUser($user_id);
		if ($a != false) {
			$user_id = mysqli_escape_string($this->conn, $user_id);
			$user_fullname = mysqli_escape_string($this->conn, $user_fullname);
			$user_email = mysqli_escape_string($this->conn, $user_email);
			$user_phone_number = mysqli_escape_string($this->conn, $user_phone_number);
			$user_address = mysqli_escape_string($this->conn, $user_address);
			$user_bank_account_number = mysqli_escape_string($this->conn, $user_bank_account_number);
			$user_bank_name = mysqli_escape_string($this->conn, $user_bank_name);
			$b = mysqli_query($this->conn, "UPDATE users SET `user_fullname` = '$user_fullname', `user_email` = '$user_email', `user_phone_number` = '$user_phone_number', `user_address` = '$user_address',
															`user_bank_account_number` = '$user_bank_account_number', `user_bank_name` = '$user_bank_name' WHERE user_id = $user_id");
			if ($b) return true;
			else return false;
		} else return false;
	}
	public function changePassword($user_id, $user_password)
	{
		$a = $this->getUser($user_id);
		if ($a != false) {
			$user_id = mysqli_escape_string($this->conn, $user_id);
			$user_password = $this->encryptedPassword($user_password);
			$b = mysqli_query($this->conn, "UPDATE users SET `user_password` = '$user_password' WHERE user_id = $user_id");
			if ($b) return true;
			else return false;
		} else return false;
	}
	public function startSession($user)
	{
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['user_fullname'] = $user['user_fullname'];
		$_SESSION['user_email'] = $user['user_email'];
		$_SESSION['user_token'] = $this->Token($user['user_id']);
		return true;
	}
	public function updateSession($user_fullname = '', $user_email = '')
	{
		if ($user_fullname != '') $_SESSION['user_fullname'] = $user_fullname;
		if ($user_email != '') $_SESSION['user_email'] = $user_email;
		return true;
	}
	public static function endSession()
	{
		// session_destroy();
		unset($_SESSION['user_id']);
		unset($_SESSION['user_fullname']);
		unset($_SESSION['user_email']);
		unset($_SESSION['user_token']);
	}
	public static function Token($user)
	{
		return JWT::encode(['uid' => encode_id($user['user_id']), 'iat' => time()], SALT, 'HS512');
	}
	public static function parseToken($user_token)
	{
		try {
			$a = JWT::decode($user_token, SALT);
			$a = json_decode(json_encode($a), true);
			return $a;
			// if (time() < $a->exp && $a->usr == $_COOKIE['usr']) return $a;
			// else return false;
		} catch (Exception $e) {
			return false;
		}
	}
}
class ProductTypes extends DB
{
	public function getProductTypes()
	{
		$a = mysqli_query($this->conn, "SELECT PT.product_type_id, product_type_name, COUNT(P.product_type_id) AS product_type_quantity FROM product_types PT LEFT JOIN products P ON PT.product_type_id = P.product_type_id GROUP BY PT.product_type_id");
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
}
class Products extends DB
{
	private $productWithProductType = 'SELECT product_id, product_name, P.product_type_id, PT.product_type_name, product_price, product_rental_price, product_img, product_quantity, product_sizes, product_weight, product_description FROM products P LEFT JOIN product_types PT ON P.product_type_id = PT.product_type_id';
	private function orderBy($order_by)
	{
		$order_by = mysqli_escape_string($this->conn, $order_by);
		switch ($order_by) {
			case 1:
				return 'product_id DESC';
				break;
			case 2:
				return 'product_rental_price ASC';
				break;
			case 3:
				return 'product_rental_price DESC';
				break;
			default:
				return 'product_id DESC';
				break;
		}
	}
	public function getCount()
	{
		$total = mysqli_query($this->conn, "SELECT COUNT(product_id) AS total FROM products");
		$total = mysqli_fetch_assoc($total)['total'];
		return $total;
	}
	public function validProduct($product_id)
	{
		$product_id = mysqli_escape_string($this->conn, $product_id);
		$a = mysqli_query($this->conn,  "SELECT product_id WHERE `product_id` = '$product_id'");
		if (mysqli_num_rows($a)) $b = true;
		else $b = false;
		mysqli_free_result($a);
		return $b;
	}
	public function getProducts($order_by = 1, $page = 1, $limit = DATA_PER_PAGE)
	{
		$order_by = $this->orderBy($order_by);
		$offset = $this->Offset($page, $limit);
		$a = mysqli_query($this->conn, $this->productWithProductType . ' ORDER BY ' . $order_by . ' ' . $offset);
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
	public function getProductById($product_id)
	{
		$product_id = mysqli_escape_string($this->conn, $product_id);
		$a = mysqli_query($this->conn, $this->productWithProductType . " WHERE `product_id` = '$product_id'");
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = $row;
		else $b = false;
		mysqli_free_result($a);
		return $b;
	}
	public function getProductsByProductTypeId($product_type_id, $order_by = 1, $page = 1, $limit = DATA_PER_PAGE)
	{
		$product_type_id = mysqli_escape_string($this->conn, $product_type_id);
		$order_by = $this->orderBy($order_by);
		$offset = $this->Offset($page, $limit);
		$a = mysqli_query($this->conn,  $this->productWithProductType . " WHERE P.product_type_id = '$product_type_id' ORDER BY $order_by " . $offset);
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
	public function getCountProductsByProductTypeId($product_type_id)
	{
		$product_type_id = mysqli_escape_string($this->conn, $product_type_id);
		$total = mysqli_query($this->conn, "SELECT COUNT(product_id) AS total FROM products WHERE product_type_id = '$product_type_id'");
		$total = mysqli_fetch_assoc($total)['total'];
		return $total;
	}
	public function postProduct($product_name, $product_type_id, $product_price, $product_rental_price, $product_img, $product_quantity, $product_sizes, $product_weight, $product_description)
	{
		$product_name = mysqli_escape_string($this->conn, $product_name);
		$product_type_id = mysqli_escape_string($this->conn, $product_type_id);
		$product_price = mysqli_escape_string($this->conn, $product_price);
		$product_rental_price = mysqli_escape_string($this->conn, $product_rental_price);
		$product_img = mysqli_escape_string($this->conn, $product_img);
		$product_quantity = mysqli_escape_string($this->conn, $product_quantity);
		$product_sizes = mysqli_escape_string($this->conn, $product_sizes);
		$product_weight = mysqli_escape_string($this->conn, $product_weight);
		$product_description = mysqli_escape_string($this->conn, $product_description);

		$b = mysqli_query($this->conn, "INSERT INTO products (`product_name`, `product_type_id`, `product_price`, `product_rental_price`, `product_img`, `product_quantity`, `product_sizes`, `product_weight`, `product_description`) 
													VALUES ('$product_name', '$product_type_id', '$product_price', '$product_rental_price', '$product_img', '$product_quantity', '$product_sizes', '$product_weight', '$product_description')");
		// var_dump(mysqli_error($this->conn));
		if ($b) return true;
		else return false;
	}
	public function updateProduct($product_id, $product_name, $product_type_id, $product_price, $product_rental_price, $product_img, $product_quantity, $product_sizes, $product_weight, $product_description)
	{
		$a = $this->getProductById($product_id);
		if ($a != false) {
			$product_id = mysqli_escape_string($this->conn, $product_id);
			$product_name = mysqli_escape_string($this->conn, $product_name);
			$product_type_id = mysqli_escape_string($this->conn, $product_type_id);
			$product_price = mysqli_escape_string($this->conn, $product_price);
			$product_rental_price = mysqli_escape_string($this->conn, $product_rental_price);
			$product_img = mysqli_escape_string($this->conn, $product_img);
			$product_quantity = mysqli_escape_string($this->conn, $product_quantity);
			$product_sizes = mysqli_escape_string($this->conn, $product_sizes);
			$product_weight = mysqli_escape_string($this->conn, $product_weight);
			$product_description = mysqli_escape_string($this->conn, $product_description);

			$b = mysqli_query($this->conn, "UPDATE products SET `product_name` = '$product_name', `product_type_id` = '$product_type_id', `product_price` = '$product_price', `product_rental_price` = '$product_rental_price', `product_img` = '$product_img',
				`product_quantity` = '$product_quantity', `product_sizes` = '$product_sizes', `product_weight` = '$product_weight', `product_description` = '$product_description' WHERE product_id = $product_id");
			if ($b) return true;
			else return false;
		} else return false;
	}
	public function search($keyword, $order_by = 1, $page = 1, $limit = DATA_PER_PAGE)
	{
		$keyword = mysqli_escape_string($this->conn, $keyword);
		$order_by = $this->orderBy($order_by);
		$offset = $this->Offset($page, $limit);
		$a = mysqli_query($this->conn, $this->productWithProductType . " WHERE MATCH(product_name) AGAINST ('$keyword') OR product_name LIKE ('%$keyword%') ORDER BY $order_by " . $offset);
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		else $b = false;
		mysqli_free_result($a);
		return $b;
	}
	public function getCountSearch($keyword)
	{
		$keyword = mysqli_escape_string($this->conn, $keyword);
		$total = mysqli_query($this->conn, "SELECT COUNT(product_id) AS total FROM products WHERE MATCH(product_name) AGAINST ('$keyword') OR product_name LIKE ('%$keyword%')");
		$total = mysqli_fetch_assoc($total)['total'];
		return $total;
	}
}
class Product extends Products
{
}
class Cart extends DB
{
	public function getCount($user_id)
	{
		$user_id = mysqli_escape_string($this->conn, $user_id);
		$total = mysqli_query($this->conn, "SELECT COUNT(user_id) AS total FROM carts WHERE `user_id` = $user_id");
		$total = mysqli_fetch_assoc($total)['total'];
		return $total;
	}
	public function getCart($user_id)
	{
		$user_id = mysqli_escape_string($this->conn, $user_id);
		$a = mysqli_query($this->conn, "SELECT C.product_id, P.product_name, P.product_rental_price, P.product_img, P.product_quantity, P.product_weight, cart_product_quantity FROM carts C LEFT JOIN products P ON C.product_id = P.product_id WHERE `user_id` = '$user_id'");
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
	public function postCart($user_id, $product_id, $cart_product_quantity)
	{
		$user_id = mysqli_escape_string($this->conn, $user_id);
		$product_id = mysqli_escape_string($this->conn, $product_id);
		$cart_product_quantity = mysqli_escape_string($this->conn, $cart_product_quantity);
		$b = mysqli_query($this->conn, "INSERT INTO carts VALUES ('$user_id', '$product_id', '$cart_product_quantity') ON DUPLICATE KEY UPDATE cart_product_quantity = cart_product_quantity + $cart_product_quantity");
		if ($b) return true;
		else return false;
	}
	public function updateCart($user_id, $product_id, $cart_product_quantity)
	{
		$user_id = mysqli_escape_string($this->conn, $user_id);
		$product_id = mysqli_escape_string($this->conn, $product_id);
		$cart_product_quantity = mysqli_escape_string($this->conn, $cart_product_quantity);
		$b = mysqli_query($this->conn, "UPDATE carts SET `cart_product_quantity` = '$cart_product_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'");
		if ($b) return true;
		else return false;
	}
	public function deleteCart($user_id, $product_id)
	{
		$user_id = mysqli_escape_string($this->conn, $user_id);
		$product_id = mysqli_escape_string($this->conn, $product_id);
		$b = mysqli_query($this->conn, "DELETE FROM carts WHERE user_id = $user_id AND product_id = $product_id");
		if ($b) return true;
		else return false;
	}
	public function deleteCartsByUserId($user_id)
	{
		$user_id = mysqli_escape_string($this->conn, $user_id);
		$b = mysqli_query($this->conn, "DELETE FROM carts WHERE user_id = $user_id");
		if ($b) return true;
		else return false;
	}
}
class InvoiceStatus extends DB
{
	public function getInvoiceStatus()
	{
		$a = mysqli_query($this->conn, "SELECT IST.invoice_status_id, invoice_status_name, COUNT(I.invoice_status_id) AS invoice_status_quantity FROM invoice_status IST LEFT JOIN invoices I ON IST.invoice_status_id = I.invoice_status_id GROUP BY IST.invoice_status_id");
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
}
class Invoice extends DB
{
	private $invoiceWithInvoiceStatus = 'SELECT invoice_id, invoice_user_fullname, invoice_user_phone_number, invoice_user_email, invoice_subtotal, invoice_fee_transport, invoice_fee_bond, IST.*, invoice_num_rental_days, invoice_created_at FROM invoices I LEFT JOIN invoice_status IST ON I.invoice_status_id = IST.invoice_status_id';
	public function getCountInvoicesByInvoiceStatusId($invoice_status_id)
	{
		$invoice_status_id = mysqli_escape_string($this->conn, $invoice_status_id);
		$total = mysqli_query($this->conn, "SELECT COUNT(invoice_id) AS total FROM invoices WHERE invoice_status_id = '$invoice_status_id'");
		$total = mysqli_fetch_assoc($total)['total'];
		return $total;
	}
	public function getInvoicesByInvoiceStatusId($invoice_status_id, $page = 1, $limit = DATA_PER_PAGE)
	{
		$invoice_status_id = mysqli_escape_string($this->conn, $invoice_status_id);
		$offset = $this->Offset($page, $limit);
		$a = mysqli_query($this->conn, $this->invoiceWithInvoiceStatus . " WHERE I.invoice_status_id = '$invoice_status_id' ORDER BY invoice_id DESC " . $offset);
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
	public function getCount()
	{
		$total = mysqli_query($this->conn, "SELECT COUNT(invoice_id) AS total FROM invoices");
		$total = mysqli_fetch_assoc($total)['total'];
		return $total;
	}
	public function getInvoices($page = 1, $limit = DATA_PER_PAGE)
	{
		$offset = $this->Offset($page, $limit);
		$a = mysqli_query($this->conn, $this->invoiceWithInvoiceStatus . " ORDER BY invoice_id DESC " . $offset);
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
	public function getInvoice($invoice_id)
	{
		$invoice_id = mysqli_escape_string($this->conn, $invoice_id);
		$a = mysqli_query($this->conn, "SELECT I.*, IST.invoice_status_name FROM invoices I LEFT JOIN invoice_status IST ON I.invoice_status_id = IST.invoice_status_id WHERE `invoice_id` = '$invoice_id'");
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = $row;
		else $b = false;
		mysqli_free_result($a);
		return $b;
	}
	public function getInvoicesByUserId($user_id, $page = 1, $limit = DATA_PER_PAGE)
	{
		$user_id = mysqli_escape_string($this->conn, $user_id);
		$offset = $this->Offset($page, $limit);
		$a = mysqli_query($this->conn, $this->invoiceWithInvoiceStatus . " WHERE user_id = '$user_id' ORDER BY invoice_id DESC " . $offset);
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
	public function getInvoiceDetails($invoice_id)
	{
		$invoice_id = mysqli_escape_string($this->conn, $invoice_id);
		$a = mysqli_query($this->conn, "SELECT ID.product_id, P.product_name, P.product_img, invd_product_quantity, invd_product_rental_price FROM invoice_details ID LEFT JOIN products P ON ID.product_id = P.product_id WHERE `invoice_id` = '$invoice_id'");
		$b = array();
		if (mysqli_num_rows($a))
			while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
		mysqli_free_result($a);
		return $b;
	}
	public function postInvoice($user_id, $invoice_user_fullname, $invoice_user_phone_number, $invoice_user_email, $invoice_user_address, $invoice_num_rental_days, $invoice_note)
	{
		$cart_subtotal = 0;
		$cart_weight = 0;
		$carts = new Cart;
		$cart = $carts->getCart($user_id);
		foreach ($cart as $k => $v) {
			$product_id = $v['product_id'];
			if ($v['cart_product_quantity'] > $v['product_quantity']) {
				$cart_product_quantity = $v['product_quantity'];
				$carts->updateCart($user_id, $product_id, $cart_product_quantity);
			} else $cart_product_quantity = $v['cart_product_quantity'];
			$cart_subtotal += $cart_product_quantity * $v['product_rental_price'];
			$cart_weight += $cart_product_quantity * $v['product_weight'];
		}
		$fee = new Fee;
		$fee_transport = $fee->transport($cart_weight);
		$fee_bond = $fee->bond($cart_subtotal);

		$user_id = mysqli_escape_string($this->conn, $user_id);
		$invoice_user_fullname = mysqli_escape_string($this->conn, $invoice_user_fullname);
		$invoice_user_phone_number = mysqli_escape_string($this->conn, $invoice_user_phone_number);
		$invoice_user_email = mysqli_escape_string($this->conn, $invoice_user_email);
		$invoice_user_address = mysqli_escape_string($this->conn, $invoice_user_address);
		$invoice_num_rental_days = mysqli_escape_string($this->conn, $invoice_num_rental_days);
		$invoice_note = mysqli_escape_string($this->conn, $invoice_note);

		$invoice_created_at = time();
		$a = mysqli_query($this->conn, "INSERT INTO invoices (user_id, invoice_user_fullname, invoice_user_phone_number, invoice_user_email, invoice_user_address, invoice_num_rental_days, invoice_note, invoice_subtotal, invoice_fee_transport, invoice_fee_bond, invoice_created_at)
												VALUES ('$user_id', '$invoice_user_fullname', '$invoice_user_phone_number', '$invoice_user_email', '$invoice_user_address', '$invoice_num_rental_days', '$invoice_note', '$cart_subtotal', '$fee_transport', '$fee_bond', '$invoice_created_at')");
		if ($a) {
			$invoice_id = mysqli_insert_id($this->conn);
			foreach ($cart as $k => $v) {
				$product_id = $v['product_id'];
				$invd_product_quantity = $v['cart_product_quantity'];
				$invd_product_rental_price = $v['product_rental_price'];
				mysqli_query($this->conn, "INSERT INTO invoice_details (invoice_id, product_id, invd_product_quantity, invd_product_rental_price)
																VALUES ('$invoice_id', '$product_id', '$invd_product_quantity', '$invd_product_rental_price')");
				mysqli_query($this->conn, "UPDATE products SET product_quantity = CASE WHEN product_quantity-$invd_product_quantity < 0 THEN 0 ELSE product_quantity-$invd_product_quantity END WHERE product_id = $product_id");
			}
			$carts->deleteCartsByUserId($user_id);
			return true;
		} else return false;
	}
	public function updateStatus($invoice_id, $invoice_status_id)
	{
		$invoice_id = mysqli_escape_string($this->conn, $invoice_id);
		$invoice_status_id = mysqli_escape_string($this->conn, $invoice_status_id);
		mysqli_query($this->conn, "UPDATE invoices SET invoice_status_id = '$invoice_status_id' WHERE invoice_id = $invoice_id");
	}
}
class Fee
{
	// Phí vận chuyển
	public static function transport($weight)
	{
		// Gram
		$cost = 0;
		if ($weight <= 1000) $cost = 15000;
		else if (1000 < $weight && $weight <= 2000) $cost = 22000;
		else $cost = $weight * 10; // 1.000đ mỗi 0.1kg = 100 gram
		return $cost;
	}
	// Phí thế chân (phí đảm bảo tài sản)
	public static function bond($price)
	{
		$cost = 0;
		if ($price <= 1000000) $cost = 500000;
		else $cost = 1000000 + $price * 35 / 100;
		return $cost;
	}
}
class Statistic extends DB
{
	public function totalUsers()
	{
		$a = new User();
		return $a->getCount();
	}
	public function totalProducts()
	{
		$a = new Products();
		return $a->getCount();
	}
	public function totalInvoices()
	{
		$a = new Invoice();
		return $a->getCount();
	}
	public function totalInvoicesByInvoiceStatusId($invoice_status_id)
	{
		$a = new Invoice();
		return $a->getCountInvoicesByInvoiceStatusId($invoice_status_id);
	}
	public function totalRevenue()
	{
		$total = mysqli_query($this->conn, "SELECT (SUM(invoice_subtotal) + SUM(invoice_fee_transport) + SUM(invoice_fee_bond)) AS total FROM invoices WHERE invoice_status_id = 3 OR invoice_status_id = 4");
		$total = mysqli_fetch_assoc($total)['total'];
		return $total;
	}
}
