<?php
//define('BASE_URL','http://localhost/kindplanner_dta/');
use Cake\Routing\Router;

$url = Router::url("/", true);
define('BASE_URL', $url . 'acceptance/');
define('USER_PICTURE_FOLDER_URL_PATH', '/uploads/users/');
define('USER_PICTURE_FOLDER_DIRECTORY_PATH', WWW_ROOT . 'uploads' . DS . 'users' . DS);
define('NUBER_OF_DAYS', 2);
define('CONTRACT_WEEK', 1);
define('CONTRACT_MONTH', 4);
define('CONTRACT_YEAR', 49);
define('STRNG_PAD', 5); //employe id//
define('RECEPTION_TYPE', 'School care'); //@ CONTRACT//
define('jwt_token_key', 'AK*(#JKLDJLK$(@#KMSLSJ#$()_FKLMFKLGJG)_@_@#_@_)#KLDJFJ');
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

return $config = [];
