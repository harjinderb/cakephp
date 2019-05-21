<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientInfo Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 */
class Applyleave extends Entity {

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
		'bso_id' => true,
		'userid' => true,
		'parent_id' => true,
		'leavetitle' => true,
		'leavestartdate' => true,
		'leaveenddate' => true,
		'leavedescription' => true,
		'role_id' => true,

	];

	/**
	 * Fields that are excluded from JSON versions of the entity.
	 *
	 * @var array
	 */
	protected $_hidden = [];

	public $actsAs = array('Acl' => array('type' => 'requester'));

	public function parentNode() {
		return null;
	}

	// public function parentNode() {
	// 	return null;
	// }
}
