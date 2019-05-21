<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class GroupsTable extends Table
{
	 var $name = 'Group'; 

    public function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Acl.Acl', ['type' => 'requester']);
    }





}

?>