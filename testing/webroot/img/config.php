<?php
//define('BASE_URL','http://localhost/kindplanner_dta/');
use Cake\Routing\Router;

 $url = Router::url("/", true);
define('BASE_URL',$url.'development/');
define('USER_PICTURE_FOLDER_URL_PATH','/uploads/users/');
define('USER_PICTURE_FOLDER_DIRECTORY_PATH',WWW_ROOT.'uploads'.DS.'users'.DS);
define('NUBER_OF_DAYS',2);
define('CONTRACT_WEEK',1);
define('CONTRACT_MONTH',4);
define('CONTRACT_YEAR',49);
define('STRNG_PAD',5);//employe id//
define('RECEPTION_TYPE','School care');//@ CONTRACT//
define('jwt_token_key','AK*(#JKLDJLK$(@#KMSLSJ#$()_FKLMFKLGJG)_@_@#_@_)#KLDJFJ');
define('DEFAULTRELATIONS', array('Please select','Son','Daughter','Other, Please specify below'));
$relation = array('Please select','Son','Daughter','Other, Please specify below');
define('RELATION',$relation);
$servicefor = array('Please select','Day','Week','Month', 'Year');
define('SERVICE_FOR',$servicefor);

return $config = [];
