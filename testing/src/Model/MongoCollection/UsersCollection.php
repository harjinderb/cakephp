<?php
namespace App\Model\MongoCollection;

use CakeMonga\MongoCollection\BaseCollection;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */

class UsersCollection extends BaseCollection
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

        $this->setTable('users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        // $validator
        //     ->allowEmpty('id', 'create');
        // $validator
        //     ->scalar('bsoname')
        //     ->notEmpty('bsoname');

        // $validator
        //     ->email('email')
        //     ->notEmpty('email');
        //   //  ->add('email', 'unique', ['provider' => 'Collection']);

        // $validator
        //     ->scalar('password')
        //     ->notEmpty('password');

        // $validator
        //     ->scalar('post_code')
        //     ->notEmpty('post_code');
        // $validator
        //     ->scalar('mobile_no')
        //     ->notEmpty('mobile_no');

        // $validator
        //     ->scalar('address')
        //     ->notEmpty('address');
        //  $validator
        //     ->scalar('residence')
        //     ->notEmpty('residence');
        // $validator
        //     ->scalar('token')
        //     ->allowEmpty('token');

        // $validator
        //     ->notEmpty('confirm_password');

        // $validator
        //     ->date('email_confirm_date')
        //     ->allowEmpty('email_confirm_date');

        // $validator
        //     ->requirePresence('is_active', 'create')
        //     ->notEmpty('is_active');

        return $validator;
    }

    public function getUser()
    {
        return $this->find();
    }
}
