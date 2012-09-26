<?php
function verify()
{
	require_once COMMON_PATH.'/Image.class.php';
	Image::buildImageVerify(4, 1, 'gif');
}

function setSessionCookie($user_id, $user_name, $days) {
	$_SESSION[APP_PREFIX.'user_id'] = $user_id;
	$_SESSION[APP_PREFIX.'user_name'] = $user_name;
	setcookie('user_id', $user_id, time() + (60 * 60 * 24 * $days), SESSION_COOKIE_PATH);
	setcookie('user_name', $user_name, time() + (60 * 60 * 24 * $days), SESSION_COOKIE_PATH);
}

function clearSessionCookie() {
	if (isset($_SESSION[APP_PREFIX.'user_id'])) {
		// 清空session
		$_SESSION = array();
		// 删除session cookie
		if (isset($_COOKIE[session_name()])) {
		  setcookie(session_name(), '', time() - 3600, SESSION_COOKIE_PATH);
		}
		// 销毁session
		session_destroy();
	}
	// 删除user_id和username cookies
	setcookie('user_id', '', time() - 3600, SESSION_COOKIE_PATH);
	setcookie('user_name', '', time() - 3600, SESSION_COOKIE_PATH);
}

function isLogin() {
	if (isset($_SESSION[APP_PREFIX.'user_id']) && isset($_SESSION[APP_PREFIX.'user_name'])) {
		return true;
	} else {
		if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])){
			$_SESSION[APP_PREFIX.'user_id'] = $_COOKIE['user_id'];
			$_SESSION[APP_PREFIX.'user_name'] = $_COOKIE['user_name'];
			return true;
		} else {
			return false;
		}
	}
}

function encryptNumToAlphabet($numStr)
{
	$output = "";
	$NumMapping = "abcdefghijklmnopqrstuvwxyz";
	for ($i = 0; $i < strlen($numStr); $i++) {
		$char = $numStr[$i];
		if (is_numeric($char)) {
			$output .= $NumMapping[intval($char)];
		} else {
			$output .= $char;
		}		
	}
	return $output;
}

function decryptAlphabetToNum($alphabetStr)
{
	$alphabetStr = strtolower($alphabetStr);
	$output = "";
	$Alphabets = "abcdefghijklmnopqrstuvwxyz";
	for ($i = 0; $i < strlen($alphabetStr); $i++) {
		$char = $alphabetStr[$i];
		if (false === strrpos($Alphabets, $char)) {
			$output .= $char;
		} else {
			$output .= strval(ord($char) - ord('a'));
		}		
	}		
	
	return $output;
}

function encryptId($id)
{
	$idStr = (string)$id;
	$len = strlen($idStr);
	if ($len > 1) {
		$loopCount = rand(1, $len);
		for ($i = 0; $i < $loopCount; $i++) {
			$poz = rand(0, $len - 1);
			$idStr[$poz] = encryptNumToAlphabet($idStr[$poz]);
		}
	}
	
	$shaStr = sha1(($id*3+1).$idStr);
	$beginStr = substr($shaStr, 7, 10);
	$endStr = substr($shaStr, 23, 10);
	
	return $beginStr.$idStr.$endStr;
}

function decryptToken($token)
{
	$idStr = decryptAlphabetToNum(substr($token, 10, strlen($token)-20));
	if (encryptId($idStr) == $token) {
		return $idStr;
	} else {
		return false;
	}
}

function isObsoleteIE() {
	$ieTag = 'MSIE';
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$iePos = strpos($user_agent, $ieTag);
	if ($iePos === false) {
		return false;
	} else {
		$ieVersion = substr($user_agent, $iePos + strlen($ieTag) + 1, 3);
		if (is_numeric($ieVersion) && floatval($ieVersion) < 9.0) {
			return true;
		} else {
			return false;
		}
	}
}
?>