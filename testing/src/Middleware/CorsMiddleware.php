<?php
namespace App\Middleware;

use Cake\Http\Middleware\CsrfProtectionMiddleware;

//class CsrfProtection extends CsrfProtectionMiddleware {
	$options = [
    			'Access-Control-Allow-Origin: *',
                'Access-Control-Allow-Methods: GET, POST, PUT, DELETE,OPTIONS',
                'Access-Control-Allow-Headers: Accept, Content-Type'
				];
$csrf = new CsrfProtectionMiddleware($options);
//$middlewareQueue->add($csrf);

public function middleware($middlewareQueue)
{
    $middlewareQueue->add(function($request, $response, $next) {
            return $next($request, $response)
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
                ->withHeader('Access-Control-Allow-Methods', '*')
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With')
                ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
                ->withHeader('Access-Control-Allow-Type', 'application/json');
        });

    return $middlewareQueue;
}

$this->middleware($csrf);