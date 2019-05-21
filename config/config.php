<?php
//define('BASE_URL','http://localhost/kindplanner_dta/');
//getSalt()
use Cake\Routing\Router;
$start_date = date("d-m-Y");
$time = strtotime($start_date);
$final = date("d-m-Y", strtotime("+11 days", $time));
$url = Router::url("/", true);
define('BASE_URL', $url . 'development/');
define('USER_PICTURE_FOLDER_URL_PATH', '/uploads/users/');
define('USER_PICTURE_FOLDER_DIRECTORY_PATH', WWW_ROOT . 'uploads' . DS . 'users' . DS);
define('NUBER_OF_DAYS', 2);
define('DUE_DATE', $final);
define('CONTRACT_WEEK', 1);
define('CONTRACT_MONTH', 4);
define('CONTRACT_YEAR', 49);
define('STRNG_PAD', 5); //employe id//
define('INVOICE_DIGIT', 3); //employe id//
define('RECEPTION_TYPE', 'School care'); //@ CONTRACT//

define('ENCRYPTION_SLUG', '16a123a114ae114a4e980ac15fd3c2b2b35da2bc8e18a115a19a8218a15a19a');
define('jwt_token_key', '0382c09e590d7cd89a0a980ac15fd3c2b2b35da2bc83d9a38fd55e993085e88e');
define('DEFAULTRELATIONS', array('Please select', 'Son', 'Daughter', 'Other, Please specify below'));
$relation = array('Please select', 'Son', 'Daughter', 'Other, Please specify below');
define('RELATION', $relation);
$age_group = array('0' => 'select option', '1' => 'age 4-5 years', '2' => 'age 6-7 years', '3' => 'age 8 years and older');
define('AGEGROUP', $age_group);
$age_groupshow = array('0' => 'Min Age', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8');
define('AGEGROUPSHOW', $age_groupshow);
$maxage_groupshow = array('0' => 'Max Age', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10');
define('MAXAGEGROUPSHOW', $maxage_groupshow);

$servicefor = array('Please select', 'Day', 'Week', 'Month', 'Year');
define('SERVICE_FOR', $servicefor);

if (!defined('FROM_EMAIL')) {
	define('FROM_EMAIL', 'rtestoffshore@gmail.com');
}
return $config = [];
