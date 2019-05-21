<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 *
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\BsosTable|\Cake\ORM\Association\BelongsTo $Bsos
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $ParentEmployees
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\HasMany $ChildEmployees
 *
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeesTable extends Table
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

        $this->setTable('employees');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
        $this->belongsTo('Bsos', [
            'foreignKey' => 'bso_id'
        ]);
        $this->belongsTo('ParentEmployees', [
            'className' => 'Employees',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_uuid',
            'bindingKey' => 'uuid'
        ]);
        $this->hasMany('TeachersAllotedJobs', [
            'foreignKey' => 'employee_id',
            'bindingKey' => 'user_id'
        ]);
        $this->hasMany('ChildEmployees', [
            'className' => 'Employees',
            'foreignKey' => 'parent_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('firstname')
            ->maxLength('firstname', 100)
            ->allowEmpty('firstname');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmpty('address');

        $validator
            ->scalar('residence')
            ->maxLength('residence', 255)
            ->allowEmpty('residence');

        $validator
            ->scalar('token')
            ->allowEmpty('token');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmpty('image');

        $validator
            ->scalar('mobile_no')
            ->maxLength('mobile_no', 20)
            ->allowEmpty('mobile_no');

        $validator
            ->scalar('post_code')
            ->maxLength('post_code', 20)
            ->allowEmpty('post_code');

        $validator
            ->integer('is_active')
            ->allowEmpty('is_active');

        $validator
            ->scalar('password')
            ->maxLength('password', 300)
            ->allowEmpty('password');

        $validator
            ->integer('flag')
            ->allowEmpty('flag');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 255)
            ->allowEmpty('lastname');

        $validator
            ->integer('gender')
            ->allowEmpty('gender');

        $validator
            ->scalar('dob')
            ->maxLength('dob', 255)
            ->allowEmpty('dob');

        $validator
            ->scalar('joining_date')
            ->maxLength('joining_date', 255)
            ->allowEmpty('joining_date');

        $validator
            ->integer('bsn_no')
            ->allowEmpty('bsn_no');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 50)
            ->allowEmpty('uuid');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->allowEmpty('name');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 25)
            ->allowEmpty('bank_name');

        $validator
            ->scalar('account')
            ->maxLength('account', 255)
            ->allowEmpty('account');

        $validator
            ->scalar('relation')
            ->maxLength('relation', 255)
            ->allowEmpty('relation');

        $validator
            ->scalar('school')
            ->maxLength('school', 255)
            ->allowEmpty('school');

        $validator
            ->time('workstart_date')
            ->allowEmpty('workstart_date');

        $validator
            ->time('workend_date')
            ->allowEmpty('workend_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
       // $rules->add($rules->existsIn(['bso_id'], 'Bsos'));
        //$rules->add($rules->existsIn(['parent_id'], 'ParentEmployees'));
        $rules->add($rules->existsIn(['group_id'], 'Groups'));

        return $rules;
    }
}
