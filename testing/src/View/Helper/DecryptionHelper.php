<?php
namespace App\View\Helper;

use Cake\View\Helper;

class DecryptionHelper extends Helper {

	public function mc_decrypt($decrypt, $key) {

		$decrypt = explode('|', $decrypt . '|');
		$decoded = base64_decode($decrypt[0]);
		$iv = base64_decode($decrypt[1]);
		if (strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)) {return false;}
		$key = pack('H*', $key);
		$decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
		$mac = substr($decrypted, -64);
		$decrypted = substr($decrypted, 0, -64);
		$calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
		if ($calcmac !== $mac) {return false;}
		$decrypted = unserialize($decrypted);

		return $decrypted;
	}
	public function emailDecode($savedid) {
		//pr($savedid);die;
		if (!empty($savedid)) {
			$string = base64_decode($savedid);
			$user = strstr($string, '.com', true);
			$sendmail = $user . '.com';
			return $sendmail;
		}
		return null;
	}
	public function genrateInvoiceNumber($number = '', $digit = '', $date = '') {
		// pr($number);
		// pr($digit);
		// pr($date);
		// die;
		// pr(str_pad($number, $digit, $date, "0"));
		// die;
		return str_pad($number, $digit, $date, "0");
	}

}
