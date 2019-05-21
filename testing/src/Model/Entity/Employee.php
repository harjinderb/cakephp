<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employee Entity
 *
 * @property int $id
 * @property string $firstname
 * @property string $email
 * @property string $address
 * @property string $residence
 * @property string $token
 * @property string $image
 * @property string $mobile_no
 * @property string $post_code
 * @property int $is_active
 * @property string $password
 * @property string $role_id
 * @property string $created
 * @property string $modified
 * @property int $flag
 * @property int $bso_id
 * @property int $parent_id
 * @property int $group_id
 * @property string $lastname
 * @property int $gender
 * @property string $dob
 * @property string $joining_date
 * @property int $bsn_no
 * @property string $uuid
 * @property string $name
 * @property string $bank_name
 * @property string $account
 * @property string $relation
 * @property string $school
 * @property \Cake\I18n\FrozenTime $workstart_date
 * @property \Cake\I18n\FrozenTime $workend_date
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Bso $bso
 * @property \App\Model\Entity\ParentEmployee $parent_employee
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\ChildEmployee[] $child_employees
 */
class Employee extends Entity
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
    protected $_accessible = [
   
        'workstart_time' => true,
        'workend_time' => true,
        'uuid' => true,
        'created' => true,
        'event_name' => true,
        'start_overtime' => true,
        'end_overtime' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
        'password'
    ];
}
