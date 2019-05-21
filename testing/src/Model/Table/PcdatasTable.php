<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PcdatasTable extends Table
{
    public $name = 'Pcdatas';

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('pcdatas');
        $this->primaryKey('id');
    }

    public function validationDefault(Validator $validator)
    {

        return $validator;
    }

}
