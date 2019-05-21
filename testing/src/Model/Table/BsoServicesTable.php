<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
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
class BsoServicesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('bso_services');
        $this->hasMany('Contracts')
            ->setForeignKey('plan_id'); 
        $this->hasMany('TeachersAllotedJobs', [
            'foreignKey' => 'service_id'
        ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('service_day', 'Service Day should not be empty')
            ->requirePresence('service_day', 'create');
        $validator
            ->notEmpty('service_type', 'Service Type should not be empty')
            ->requirePresence('service_type', 'create');
        $validator
            ->notEmpty('start_time', 'Start Time should not be empty')
            ->requirePresence('start_time', 'create');
        $validator
            ->notEmpty('end_time', 'End Time should not be empty')
            ->requirePresence('end_time', 'create');
       
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */

}
