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
class InvoicePayment extends Entity {

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
		'child_id' => true,
		'bso_id' => true,
		'invoice_group	' => true,
		'invoice_payment' => true,
		'paied_amt' => true,
		'invpaid_date	' => true,

	];

	/**
	 * Fields that are excluded from JSON versions of the entity.
	 *
	 * @var array
	 */
	protected $_hidden = [];

	public function parentNode() {
		return null;
	}
}
