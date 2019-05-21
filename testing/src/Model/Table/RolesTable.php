<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class RolesTable extends Table
{
	 var $name = 'Role'; 

    public function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Acl.Acl', ['type' => 'requester']);
    }





}

?>