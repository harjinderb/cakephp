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
class ContractsTable extends Table {
	var $name = 'Contracts';

	public function initialize(array $config) {
		parent::initialize($config);
		$this->addBehavior('Acl.Acl', ['type' => 'requester']);
		$this->belongsTo('Users')
			->setForeignKey('child_id');
		//$this->belongsTo('BsoServices')->setForeignKey('plan_id');
		$this->belongsTo('BsoServices', [
			'foreignKey' => 'plan_id',
			'bindingKey' => 'uuid',
			'joinType' => 'LEFT',
		]);
		$this->hasMany('TeachersAllotedJobs', [
			'foreignKey' => 'service_id',
			'bindingKey' => 'service_id',

		]);
		$this->hasMany('Attendances', [
			'foreignKey' => 'contract_id',
		]);

		$this->addBehavior('CounterCache', [
			'BsoServices' => [
				'total_plans_counts' => [
					'conditions' => [
						'OR' => [
							['Contracts.status' => 1],
							['Contracts.status' => 2],
						],
					],
				],
			],
		]);
	}

}