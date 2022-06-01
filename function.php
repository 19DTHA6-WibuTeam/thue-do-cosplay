<?php
function generateRandomString($length = 10)
{
	$characters = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function str_replace_first($from, $to, $content)
{
	$from = '/' . preg_quote($from, '/') . '/';
	return preg_replace($from, $to, $content, 1);
}
function decode_id($id)
{
	$id = str_replace('/', '', $id);
	$id = str_replace_first('w', 5, $id);
	$id = str_replace_first('y', 4, $id);
	$id = str_replace_first('o', 3, $id);
	$id = str_replace_first('t', 2, $id);
	$id = str_replace_first('i', 1, $id);
	$id = hexdec($id);
	$id = $id - 123456;
	return strtolower($id);
}
function encode_id($id)
{
	$id = str_replace('/', '', $id);
	$id = dechex($id + 123456);
	$id = str_replace_first(1, 'i', $id);
	$id = str_replace_first(2, 't', $id);
	$id = str_replace_first(3, 'o', $id);
	$id = str_replace_first(4, 'y', $id);
	$id = str_replace_first(5, 'w', $id);
	return strtolower($id);
}

function strposa(string $haystack, array $needles, int $offset = 0): bool
{
	foreach ($needles as $needle) {
		if (strpos($haystack, $needle, $offset) !== false) {
			return true; // stop on first true result
		}
	}
	return false;
}

function fixSqlInjection($str)
{
	// abc\okok -> abc\\okok
	//abc\okok (user) -> abc\okok (server) -> sql (abc\okok) -> xuat hien ky tu \ -> ky tu dac biet -> error query
	//abc\okok (user) -> abc\okok (server) -> convert -> abc\\okok -> sql (abc\\okok) -> chinh xac
	$str = str_replace('\\', '\\\\', $str);
	//abc'okok -> abc\'okok
	//abc'okok (user) -> abc'okok (server) -> sql (abc'okok) -> xuat hien ky tu \ -> ky tu dac biet -> error query
	//abc'okok (user) -> abc'okok (server) -> convert -> abc\'okok -> sql (abc\'okok) -> chinh xac
	$str = str_replace('\'', '\\\'', $str);

	return $str;
}
function getPOST($key)
{
	$key = strtolower($key);
	$value = '';
	if (isset($_POST[$key])) {
		$value = $_POST[$key];
	}
	// return fixSqlInjection($value);
	return $value;
}
function getCOOKIE($key)
{
	$key = strtolower($key);
	$value = '';
	if (isset($_COOKIE[$key])) {
		$value = $_COOKIE[$key];
	}
	// return fixSqlInjection($value);
	return $value;
}
function getGET($key)
{
	$key = strtolower($key);
	$value = '';
	if (isset($_GET[$key])) {
		$value = $_GET[$key];
	}
	// return fixSqlInjection($value);
	return $value;
}
function getREQUEST($key)
{
	$key = strtolower($key);
	$value = '';
	if (isset($_REQUEST[$key])) {
		$value = $_REQUEST[$key];
	}
	// return fixSqlInjection($value);
	return $value;
}

function formatPrice($price)
{
	return number_format($price, 0, ',', '.');
}
