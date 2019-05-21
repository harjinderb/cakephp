<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
/**
 * UUID component
 *Get user id by uuid
 */
class UuIdComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
		
		];
	
	public function uuid($id)
    { 
        $model = TableRegistry::get('Users');
    	$result= $model->find('all')->where(['uuid'=>$id])->first();
        return $result->id ;
    } 	

}