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
class TimetoSecComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
		
	];
	
	public function timetosec($hour,$minutes)
    { 
        $hourstosec = $hour * 3600;
        $minutstosec = $minutes * 60;
        $difference = $hourstosec + $minutstosec;
        return $difference;
    }
    public function expireydate($plan_type,$service_day)
    { 
        $Createddate = date("Y-m-d");
        if($plan_type == 'Day'){
            if($service_day == 'maandag'){
                $day = 'next monday';
            } 
            if($service_day == 'dinsdag'){
                $day = 'next tuesday';
            }
            if($service_day == 'woensdag'){
                $day = 'next wednesday';
            }
            if($service_day == 'donderdag'){
                $day = 'next thursday';
            }
            if($service_day == 'vrijdag'){
                $day = 'next friday';
            }
            if($service_day == 'zaterdag'){
                $day = 'next saturday';
            }
            if($service_day == 'zondag'){
                $day = 'next sunday';
            }
            $expireydate  = date('Y-m-d', strtotime($day, strtotime($Createddate)));    
        }

        if($plan_type == 'Month'){
            $start_date = date("Y-m-d");
            $Createddate = strtotime($start_date);
            $expireydate = date("Y-m-d", strtotime("+1 month", $Createddate)); 
        }

        if($plan_type == 'Year'){
            $start_date = date("Y-m-d");
            $Createddate = strtotime($start_date);
            $expireydate = date("Y-m-d", strtotime("+1 year", $Createddate)); 
        }
        
        
        return $expireydate;
    }  	
    

}