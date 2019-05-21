<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * UUID component
 *Get user id by uuid
 */
class TimetoSecComponent extends Component {

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [

	];

	public function timetosec($hour, $minutes) {
		$hourstosec = $hour * 3600;
		$minutstosec = $minutes * 60;
		$difference = $hourstosec + $minutstosec;
		return $difference;
	}
	public function expireydate($plan_type, $service_day, $start_dates) {
		$Createddate = date("Y-m-d");
		if ($plan_type == 'price_weekly') {
			if ($service_day == 'monday') {
				$day = 'next monday';
			}
			if ($service_day == 'tuesday') {
				$day = 'next tuesday';
			}
			if ($service_day == 'wednesday') {
				$day = 'next wednesday';
			}
			if ($service_day == 'thursday') {
				$day = 'next thursday';
			}
			if ($service_day == 'friday') {
				$day = 'next friday';
			}
			if ($service_day == 'saturday') {
				$day = 'next saturday';
			}
			if ($service_day == 'sunday') {
				$day = 'next sunday';
			}
			$expireydate = date('Y-m-d', strtotime($day, strtotime($start_dates)));
		}

		if ($plan_type == 'price_monthly') {
			$start_date = $start_dates;
			$Createddate = strtotime($start_date);
			$expireydate = date("Y-m-d", strtotime("+1 month", $Createddate));
		}

		if ($plan_type == 'price_yearly') {
			$start_date = $start_dates;
			$Createddate = strtotime($start_date);
			$expireydate = date("Y-m-d", strtotime("+1 year", $Createddate));
		}

		return $expireydate;
	}

}