<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table {
	public $name = 'User';

	public $displayField = array('firstname', 'lastname');
	public function initialize(array $config) {
		parent::initialize($config);
		$this->addBehavior('Acl.Acl', ['type' => 'requester']);

		$this->table('users');
		$this->primaryKey('id');
		$this->addBehavior('Josegonzalez/Upload.Upload', [
			'image' => [

			],
		]);
		$this->hasMany('Employees', [
			'foreignKey' => 'user_uuid',
		]);
		$this->hasMany('Contracts', [
			'foreignKey' => 'child_id',
		]);

		$this->hasMany('Attendances', [
			'foreignKey' => 'user_id',
		]);
		$this->hasMany('Recptions', [
			'foreignKey' => 'child_id',
		]);
	}

	public function validationDefault(Validator $validator) {

		$validator
			->notEmpty('firstname', 'FirstName should not be empty')
			->requirePresence('firstname', 'create');
		$validator
			->notEmpty('lastname', 'LastName should not be empty')
			->requirePresence('lastname', 'create');
		$validator
			->notEmpty('gender', 'Gender should not be empty')
			->requirePresence('gender', 'create');
		$validator
			->notEmpty('dob', 'Dob should not be empty')
			->requirePresence('dob', 'create');
		$validator
			->notEmpty('gender', 'Gender should not be empty')
			->requirePresence('gender', 'create');
		$validator
			->notEmpty('email', 'Email should not be empty')
			->requirePresence('email', 'create')
			->add('email', ['isUnique' => ['rule' => 'isUnique', 'provider' => 'table', 'message' => 'Email Already used by user.']]);
		$validator
			->notEmpty('mobile_no', 'Mobile No should not be empty')
			->requirePresence('mobile_no', 'create')
			->add('mobile_no', ['notEmptyCheck' => ['rule' => 'notEmptyCheck', 'provider' => 'table', 'message' => 'Mobile No should not contan Alphabet.']]);
		$validator
			->notEmpty('post_code', 'Post Code should not be empty')
			->requirePresence('post_code', 'create');
		$validator
			->notEmpty('school', 'School Name should not be empty')
			->requirePresence('school', 'create');
		$validator
			->notEmpty('relation', 'Relation should not be empty')
			->requirePresence('relation', 'create');
		$validator
			->notEmpty('relation1', 'Relation should not be empty')
			->requirePresence('relation1', 'create');
		$validator
			->notEmpty('account', 'Account No should not be empty')
			->requirePresence('account', 'create');
		$validator
			->notEmpty('post_code', 'Post Code should not be empty')
			->requirePresence('post_code', 'create');
		$validator
			->notEmpty('bank_name', 'Bank Name should not be empty')
			->requirePresence('bank_name', 'create');
		$validator
			->notEmpty('address', 'Address should not be empty')
			->requirePresence('address', 'create');
		$validator
			->notEmpty('residence', 'Residence should not be empty')
			->requirePresence('residence', 'create');
		$validator
			->notEmpty('password', 'Password should not be empty')
			->requirePresence('password', 'create')
			->add('password', ['checkPassword' => ['rule' => 'checkPassword', 'provider' => 'table', 'message' => 'Password must contain atleast one capital letter and alphanumeric characters.']]);
		$validator
			->notEmpty('confirm_password', 'Address should not be empty')
			->requirePresence('confirm_password', 'create')
			->sameAs('confirm_password', 'password', 'The passwords does not match!');
		// $validator
		// //->notEmpty('image', 'Residence should not be empty')
		// ->requirePresence('image', 'create');

		return $validator;
	}

	public function notEmptyCheck($value, $context) {
		if (!preg_match("/^[0-9_~\-!@#\$%\^&*\(\)+\/-]+$/", $context['data']['mobile_no'])) {
			//if(empty($context['data']['mobile_no'])) {
			return false;
		} else {
			return true;
		}
	}

	public function checkPassword($value, $context) {
		if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $context['data']['password'])) {
			return false;
		} else {
			return true;
		}
	}

	public function isUnique($email) {
		$user = $this->find('all')
			->where([
				'Users.email' => $email,
			])
			->first();
		if ($user) {
			return false;
		}
		return true;
	}

	public function validationProfile(Validator $validator) {
		$validator
			->requirePresence('password')
			->add('password', ['checkPassword' => ['rule' => 'checkPassword', 'provider' => 'table', 'message' => 'Password must contain atleast one capital letter and alphanumeric characters.']]);
		$validator
			->requirePresence('confirm_password')
			->sameAs('confirm_password', 'password', 'The passwords does not match!');
		return $validator;

	}

	public function beforeSave($event, $entity, $options) {

		if (!empty($this->encryptionKey)) {
			//ENCRYPTION_SLUG dechex
			//$keycode = str_replace('-', 'B', $this->encryptionKey) . ENCRYPTION_SLUG;
			$keycode = $this->encryptionKey;
			//$emailkey = md5($entity['email']);
			//pr(dechex('1b05668-3ec7-4dde-9a2b-e38641cb1f0d'));die;
		}

		if (isset($this->encryptData) && $this->encryptData == "Yes") {
			if (!empty($entity['firstname'])) {
				$entity['firstname'] = $this->mc_encrypt($entity['firstname'], $keycode);
				$entity['name'] = $this->mc_encrypt($entity['firstname'], $keycode) . ' ' . $this->mc_encrypt($entity['lastname'], $keycode);
				//pr($entity['firstname']);
			}

			if (!empty($entity['lastname'])) {
				$entity['lastname'] = $this->mc_encrypt($entity['lastname'], $keycode);
			}

			if (!empty($entity['email'])) {
				$entity['email'] = base64_encode($entity['email'] . ENCRYPTION_SLUG);
				//pr($entity['email']);die;
			}

			if (!empty($entity['mobile_no'])) {
				$entity['mobile_no'] = $this->mc_encrypt($entity['mobile_no'], $keycode);
			}

			if (!empty($entity['dob'])) {
				$entity['dob'] = $this->mc_encrypt($entity['dob'], $keycode);
			}

			if (!empty($entity['bsn_no'])) {

				$entity['bsn_no'] = $this->mc_encrypt($entity['bsn_no'], $keycode);

			}

			if (!empty($entity['bank_name'])) {
				$entity['bank_name'] = $this->mc_encrypt($entity['bank_name'], $keycode);
			}

			if (!empty($entity['account'])) {
				$entity['account'] = $this->mc_encrypt($entity['account'], $keycode);
			}

			if (!empty($entity['address'])) {
				$entity['address'] = $this->mc_encrypt($entity['address'], $keycode);
			}

			if (!empty($entity['residence'])) {
				$entity['residence'] = $this->mc_encrypt($entity['residence'], $keycode);
			}

			if (!empty($entity['post_code'])) {
				$entity['post_code'] = $this->mc_encrypt($entity['post_code'], $keycode);
			}
		}

		return $entity;

		// if (!empty($entity['relation'])) {
		// 	$entity['relation'] = base64_encode($entity['relation']);
		// }
		//return $entity;

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
}
