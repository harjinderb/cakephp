<?php
namespace App\View\Helper;
 
use Cake\View\Helper;
use Cake\ORM\TableRegistry; 
class ParentsideHelper extends Helper {
 
 
     
    public function parentsidefunction($lastWord)
    {  
    $users = TableRegistry::get('users')
                ->find()
                ->where(['uuid' => $lastWord])
                ->first();
        
    	if($users['role_id'] == '1'){
    		$data = 'admin';
    	}elseif ($users['role_id'] == '2') {
				$data = 'bso';
		}elseif ($users['role_id'] == '5') {
                $data = 'manage-children';
        }elseif ($users['role_id'] == '4') {
                $data = 'manage-guardian';
        }
        else{

			$data = 'buy-services';
    	}
    return $data ;
    }
}
