<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public $name = 'User';

    public $displayField = array('firstname', 'lastname');
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Acl.Acl', ['type' => 'requester']);

        $this->table('users');
        $this->primaryKey('id');


        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'image' => [


            ],
         ]);

    }

    public function validationDefault(Validator $validator)
    {

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
        $validator
        //->notEmpty('image', 'Residence should not be empty')
        ->requirePresence('image', 'create');

        return $validator;
    }

    public function notEmptyCheck($value, $context)
    {
        if (!preg_match("/^[0-9_~\-!@#\$%\^&*\(\)+\/-]+$/", $context['data']['mobile_no'])) {
            //if(empty($context['data']['mobile_no'])) {
            return false;
        } else {
            return true;
        }
    }

    public function checkPassword($value, $context)
    {
        if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $context['data']['password'])) {
            return false;
        } else {
            return true;
        }
    }

    public function isUnique($email)
    {
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

    public function validationProfile(Validator $validator)
    {
        $validator
            ->requirePresence('password')
            ->add('password', ['checkPassword' => ['rule' => 'checkPassword', 'provider' => 'table', 'message' => 'Password must contain atleast one capital letter and alphanumeric characters.']]);
        $validator
            ->requirePresence('confirm_password')
            ->sameAs('confirm_password', 'password', 'The passwords does not match!');
        return $validator;

    }

}
