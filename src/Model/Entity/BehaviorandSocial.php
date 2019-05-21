<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
/**
 * ClientInfo Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 */
class BehaviorandSocial extends Entity
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
        'childlike' => true,
        'childprefer' => true,
        'childbusy' => true,
        'childinterest_otherchildern' => true,
        'childhappypeers' => true,
        'childhavebfgif' => true,
        'childhappybrothersis' => true,
        'childhappyparent' => true,
        'childmove' => true,
        'childargue' => true,

      
    ];


    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [];

    public function parentNode()
    {
        return null;
    }
}
