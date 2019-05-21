<?php
namespace App\View\Helper;
 
use Cake\View\Helper;
use Cake\ORM\TableRegistry; 
class HylitersidebarHelper extends Helper {
 
 
     
    public function hylitersidebarfunction($lastWord)
    {  
    $users = TableRegistry::get('users')
                ->find()
                ->where(['uuid' => $lastWord])
                ->first();
        
    	if($users['role_id'] == '1'){
    		$data = 'admin';
    	}elseif ($users['role_id'] == '2') {
				$data = 'bso';
		}elseif ($users['role_id'] == '3') {
                $data = 'employees';
        }elseif ($users['role_id'] == '4') {
                $data = 'parents';
        }
        else{

			$data = 'manage-services';
    	}
    return $data ;
    }
}
