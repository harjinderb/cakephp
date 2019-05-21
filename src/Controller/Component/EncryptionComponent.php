<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * UUID component
 *Get user id by uuid
 */
class EncryptionComponent extends Component {

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [

	];

	public function encryption($data) {
		//pr($data);die;
		if (!empty($data['encryptionkey'])) {
			if (!empty($data['firstname'])) {
				$data['firstname'] = $this->mc_decrypt($data['firstname'], $data['encryptionkey']);

			}

			if (!empty($data['lastname'])) {
				$data['lastname'] = $this->mc_decrypt($data['lastname'], $data['encryptionkey']);
				//pr($data);die;
			}

			if (!empty($data['email'])) {
				$data['email'] = base64_decode($data['email']);
				//pr($data['email']);die;
			}

			if (!empty($data['mobile_no'])) {
				$data['mobile_no'] = $this->mc_decrypt($data['mobile_no'], $data['encryptionkey']);

			}

			if (!empty($data['dob'])) {
				$data['dob'] = $this->mc_decrypt($data['dob'], $data['encryptionkey']);

			}

			if (!empty($data['bank_name'])) {
				$data['bank_name'] = $this->mc_decrypt($data['bank_name'], $data['encryptionkey']);

			}

			if (!empty($data['bsn_no'])) {
				$data['bsn_no'] = $this->mc_decrypt($data['bsn_no'], $data['encryptionkey']);

			}

			if (!empty($data['account'])) {
				$data['account'] = $this->mc_decrypt($data['account'], $data['encryptionkey']);

			}

			if (!empty($data['address'])) {
				$data['address'] = $this->mc_decrypt($data['address'], $data['encryptionkey']);

			}

			if (!empty($data['residence'])) {
				$data['residence'] = $this->mc_decrypt($data['residence'], $data['encryptionkey']);

			}

			if (!empty($data['post_code'])) {
				$data['post_code'] = $this->mc_decrypt($data['post_code'], $data['encryptionkey']);

			}
			if (!empty($data['ingestion_date'])) {
				$data['ingestion_date'] = $this->mc_decrypt($data['ingestion_date'], $data['encryptionkey']);
				//pr($data['ingestion_date']);die;

			}
			if (!empty($data['reception'])) {
				$data['reception'] = $this->mc_decrypt($data['reception'], $data['encryptionkey']);

			}
			if (!empty($data['reception_date'])) {
				$data['reception_date'] = $this->mc_decrypt($data['reception_date'], $data['encryptionkey']);

			}
			return $data;
		}
		return Null;
		//$model = TableRegistry::get('Users');
		//$result= $model->find('all')->where(['uuid'=>$id])->first();
		//return $result->id ;
	}

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

	public function mc_encrypt($encrypt, $key) {
		$encrypt = serialize($encrypt);
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
		$key = pack('H*', $key);
		$mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
		$passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt . $mac, MCRYPT_MODE_CBC, $iv);
		$encoded = base64_encode($passcrypt) . '|' . base64_encode($iv);
		return $encoded;
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
	public function genrateInvoiceNumber($number = '', $digit = INVOICE_DIGIT) {
		//pr(INVOICE_DIGIT);die;
		return str_pad($number, $digit, "0", STR_PAD_LEFT);
	}

}