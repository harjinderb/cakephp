<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * ClientInfo Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected function _getName()
    {
        if(isset($this->_properties['firstname'])){
            return $this->_properties['firstname'] . '  ' .$this->_properties['lastname'];
        }
    }
    protected $_accessible = [
        'firstname' => true,
        'lastname' => true,
        'email' => true,
        'gender' => true,
        'dob' => true,
        'password' => true,
        'post_code' => true,
        'address' => true,
        'residence' => true,
        'image' => true,
        'joining_date' => true,
        'mobile_no' => true,
        'role_id' => true,
        'bsn_no' => true,
        'bank_name' => true,
        'relation' => true,
        'registration_id' => true,
        'school' => true,
        'account' => true,
        'bso_id'=> true,
        'parent_id' =>true,
        'clint_sign' =>true,
        'token' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }


    public function parentNode()
    {
        if (!$this->id) {
            return null;
        }
        if (isset($this->role_id)) {
            $roleId = $this->role_id;
        } else {
            $Users = TableRegistry::get('Users');
            $user = $Users->find('all', ['fields' => ['role_id']])->where(['id' => $this->id])->first();
            $roleId = $user->role_id;
        }
        if (!$roleId) {
            return null;
        }
        return ['Roles' => ['id' => $roleId]];
    }
}
