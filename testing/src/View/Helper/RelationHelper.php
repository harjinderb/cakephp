<?php
namespace App\View\Helper;
 
use Cake\View\Helper;
 
class RelationHelper extends Helper {
 
 
     
    public function relationfunction($relationset)
    {       
    	//pr($relationset);die;
    	if($relationset == 'Son'){
    		$data = '1';
    	}elseif ($relationset == 'Daughter') {
				$data = '2';
		}else{

			$data = '3';
    	}
    return $data ;
    }
}
