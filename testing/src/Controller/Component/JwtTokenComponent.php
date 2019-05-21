<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use \Firebase\JWT\JWT;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;
use Cake\Validation\Validator;

/**
 * JwtToken component
 */
class JwtTokenComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
		
		];
	
	public function jwt($user)
    { 
         $id = $user['id'];
         //

        //$users = $this->Users->get($id);
       // pr($users);die;
        $time = time();
        $key = jwt_token_key;
        $exptime= $time + NUBER_OF_DAYS * (60*60*24);
        $user['token'] = NULL;

        $domain = parse_url(Router::url('/', true));
        $domain['host'];
        $token = array(
            "iss" => $domain['host'],
            "aud" => $domain['host'],
            "iat" => $time,
            "nbf" => $time,
            "exp" => $exptime,
            "data" => [
                "user" => $user
            ]
        );
        $jwt = JWT::encode($token, $key);
        	return $jwt;
        	
    } 	

}
