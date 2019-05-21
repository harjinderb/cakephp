<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientInfo Model
 *
 * @method \App\Model\Entity\ClientInfo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientInfo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientInfo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientInfo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientInfo|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientInfo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientInfo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientInfo findOrCreate($search, callable $callback = null, $options = [])
 */
class RecptionsTable extends Table {
	var $name = 'Recptions';

	public function initialize(array $config) {
		parent::initialize($config);
		$this->addBehavior('Acl.Acl', ['type' => 'requester']);

		//$this->belongsTo('Users', [
		//]);
		$this->belongsTo('Users', [
			'foreignKey' => 'child_id',
		]);
		//$this->belongsTo('Users')->setForeignKey('child_id');
		//->setForeignKey('child_id');
	}

	public function validationDefault(Validator $validator) {

		$validator
			->notEmpty('ingestion_date', 'Ingestion date should not be empty')
			->requirePresence('ingestion_date', 'create');

		return $validator;
	}
	public function beforeSave($event, $entity, $options) {
		//pr($this->encryptData);die;
		if (!empty($this->encryptionKey)) {

			$keycode = $this->encryptionKey;

		}

		if (isset($this->encryptData) && $this->encryptData == "Yes") {
			if (!empty($entity['ingestion_date'])) {
				$entity['ingestion_date'] = $this->mc_encrypt($entity['ingestion_date'], $keycode);
				//pr($entity['firstname']);
			}

			if (!empty($entity['mobile_no'])) {
				$entity['mobile_no'] = $this->mc_encrypt($entity['mobile_no'], $keycode);
			}

			if (!empty($entity['reception'])) {
				$entity['reception'] = $this->mc_encrypt($entity['reception'], $keycode);
			}

			if (!empty($entity['reception_date'])) {
				$entity['reception_date'] = $this->mc_encrypt($entity['reception_date'], $keycode);
			}

		}

		return $entity;

		// if (!empty($entity['relation'])) {
		//  $entity['relation'] = base64_encode($entity['relation']);
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