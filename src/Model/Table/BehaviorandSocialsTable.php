<?php
namespace App\Model\Table;

use Cake\ORM\Table;

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
class BehaviorandSocialsTable extends Table {
	var $name = 'BehaviorandSocials';

	public function initialize(array $config) {
		parent::initialize($config);
		$this->addBehavior('Acl.Acl', ['type' => 'requester']);
	}

	// public function beforeSave($event, $entity, $options) {
	// 	//pr($entity);die;
	// 	if (!empty($this->encryptionKey)) {

	// 		$keycode = $this->encryptionKey;

	// 	}
	// 	if (isset($this->encryptData) && $this->encryptData == "Yes") {
	// 		if (!empty($entity['childlike'])) {
	// 			$entity['childlike'] = $this->mc_encrypt($entity['childlike'], $keycode);
	// 		}

	// 		if (!empty($entity['childprefer'])) {
	// 			$entity['childprefer'] = $this->mc_encrypt($entity['childprefer'], $keycode);
	// 		}

	// 		if (!empty($entity['childbusy'])) {
	// 			$entity['childbusy'] = $this->mc_encrypt($entity['childbusy'], $keycode);
	// 		}

	// 		if (!empty($entity['childinterest_otherchildern'])) {
	// 			$entity['childinterest_otherchildern'] = $this->mc_encrypt($entity['childinterest_otherchildern'], $keycode);
	// 		}
	// 		if (!empty($entity['childhappypeers'])) {
	// 			$entity['childhappypeers'] = $this->mc_encrypt($entity['childhappypeers'], $keycode);
	// 		}
	// 		if (!empty($entity['childhavebfgif'])) {
	// 			$entity['childhavebfgif'] = $this->mc_encrypt($entity['childhavebfgif'], $keycode);
	// 		}
	// 		if (!empty($entity['childhappybrothersis'])) {
	// 			$entity['childhappybrothersis'] = $this->mc_encrypt($entity['childhappybrothersis'], $keycode);
	// 		}
	// 		if (!empty($entity['childmove'])) {
	// 			$entity['childmove'] = $this->mc_encrypt($entity['childmove'], $keycode);
	// 		}
	// 		if (!empty($entity['childargue'])) {
	// 			$entity['childargue'] = $this->mc_encrypt($entity['childargue'], $keycode);
	// 		}

	// 	}

	// 	return $entity;
	// }

}