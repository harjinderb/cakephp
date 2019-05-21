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
class AttendancesTable extends Table {
	var $name = 'AttendancesTable';

	public function initialize(array $config) {
		parent::initialize($config);
		$this->addBehavior('Acl.Acl', ['type' => 'requester']);
		$this->belongsTo('Users', [
		]);
		$this->belongsTo('Contracts', [
		]);
		$this->belongsTo('Employees', [
		]);
		// $this->belongsTo('BsoServices', [
		// 	'foreignKey' => 'service_id',
		// 	'bindingKey' => 'id',
		// 	'joinType' => 'LEFT',
		// ]);
		// $this->belongsTo('Employees', [
		// 	'foreignKey' => 'employee_id',
		// 	'bindingKey' => 'user_id',
		// 	'joinType' => 'LEFT',
		// ]);
	}
}