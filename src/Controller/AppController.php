<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;
use mpdf;

//use mikehaertl\wkhtmlto\Pdf;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */

	public $components = [
		'Acl' => [
			'className' => 'Acl.Acl',
		],
	];
	public function initialize() {

		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('RequestHandler', [
			'enableBeforeRedirect' => false,
		]);
		if ($this->request->getParam('prefix') === 'api') {
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
			header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Requested-With");

			$this->loadComponent('Auth', [
				'storage' => 'Memory',
				'authenticate' => [
					'Form' => [
						'fields' => ['username' => 'email'],
					],
					'ADmad/JwtAuth.Jwt' => [
						'userModel' => 'Users',
						'fields' => [
							'username' => 'id',
						],
						// 'scope' => ['Users.status' => 1],
						'parameter' => 'token',
						'queryDatasource' => false,
					],
				],
				'loginAction' => false,
				'unauthorizedRedirect' => false,
				'checkAuthIn' => 'Controller.initialize',
				'authError' => 'You are not authorized to access that location.',
				// 'authorize' => 'isAuthorized'
			]);
			if ($this->request->is(['OPTIONS'])) {
				$this->Auth->allow();
			}
		} else {
			$this->loadComponent('Auth', [
				'authorize' => [
					'Acl.Actions' => ['actionPath' => 'controllers/'],
				],
				'loginAction' => [
					'plugin' => false,
					'controller' => 'Users',
					'action' => 'login',
					'prefix' => false,
				],
				'loginRedirect' => [
					'plugin' => false,
					'controller' => 'Users',
					'action' => 'dashboard',
					'prefix' => false,
				],
				'logoutRedirect' => [
					'plugin' => false,
					'controller' => 'Users',
					'action' => 'login',
					'prefix' => false,
				],
				'unauthorizedRedirect' => [
					'plugin' => false,
					'controller' => 'Users',
					'action' => 'login',
					'prefix' => false,
				],
				'authError' => 'You are not authorized to access that location.',
				'flash' => [
					'element' => 'error',
				],
				'authenticate' => [
					'Form' => [
						'fields' => [
							'username' => 'email',
							'password' => 'password',
						],
					],
				],
				'unauthorizedRedirect' => $this->referer(),
			]);

			$this->Auth->allow(array('login', 'forgotPassword', 'updatePassword', 'paymentPdf', 'sendInvoicecron'));
			//array('login', 'forgotPassword', 'updatePassword', 'paymentPdf', 'sendInvoicecron')
		}
		//pr();
		// $language = 'nl_NL';
		// $session = $this->request->session();
		//$session->write('Guest.language', $language);
		if ($this->request->query('language')) {
			$language = $this->request->query('language');
			I18n::setLocale($language);
			$session = $this->request->session();
			$session->write('Guest.language', $language);
			// pr($session);die;

			// add session
		} else {
			///read seesion
			$session = $this->request->session();
			$language = $this->request->getSession()->read('Guest.language');
			I18n::setLocale($language);
		}
	}

	public function beforeFilter(Event $event) {
		$this->loadModel('Users');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$action = $this->request->params['action'];
		if (!empty($dataid)) {
			$profile = $this->Users->get($dataid, ['contain' => []]);
			if ($profile['flag'] == '0' && $action != 'resetPassword') {
				if ($profile['role_id'] == '4') {
					return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => 'parent']);
				}
				// if($profile['role_id'] == '3'){
				//    return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);
				// }
				return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => false]);
			}

		}

		if ($this->request->param('prefix') == "api" && $this->request->param('_ext') != 'json') {
			$return = [
				'code' => 400,
				'status' => 'error',
				'message' => __('Extention Not Allowed.'),
				'data' => [],
				'_serialize' => ['code', 'status', 'message', 'data'],
			];
			$this->setJson($return, true);
		}
	}

	public function isAuthorized($user) {
		return true;

		// if ($user['role_id'] == "1") {
		// 	if ($this->request->getParam('prefix') === 'admin') {
		// 		return true;
		// 	} else {
		// 		return $this->redirect(['controller' => 'users', 'action' => 'index', 'prefix' => 'admin']);
		// 	}
		// } else if ($user['role_id'] == "2") {
		// 	// pr($user);die;
		// 	return $this->redirect(['controller' => 'users', 'action' => 'index', 'prefix' => false]);

		// } else if ($user['role_id'] == "3") {
		// 	// pr($user);die;
		// 	return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);

		// } else if ($user['role_id'] == "4") {
		// 	// pr($user);die;
		// 	if ($this->request->getParam('prefix') === 'parent') {
		// 		return true;
		// 		return $this->redirect(['controller' => 'users', 'action' => 'index', 'prefix' => 'parent']);
		// 	} else {
		// 		return true;
		// 	}

		// } else {
		// 	return false;
		// }
		// return false;
	}

	public function genratepdf($parent, $save, $difference, $amount, $school, $user, $parent_id, $bso, $child_id, $id, $pdfHtml) {
		// You can pass a filename, a HTML string, an URL or an options array to the constructor
		// echo $parent_id;
		// echo $child_id;
		// echo $id;die('qwe');
		//----------------------------2nd step------------------
		//$pdf = new Pdf(BASE_URL .'/Parent/Users/pdf/offline_payment.ctp');

		// $pdf = new Pdf('http://localhost/kindplanner_dta/parent/users/paymentpdf/'.$id);
		// $pdf->setOptions(array(
		//         'binary' => WWW_ROOT. 'wkhtmltox/bin/wkhtmltopdf',
		//     ));

		// if (!$pdf->saveAs(WWW_ROOT . 'uploads' . DS . 'invoices'. DS . 'invoice_receipt_'.$child_id.'.pdf')) {

		//     $error = $pdf->getError();
		//     pr($error);die('die error');
		//     return false;
		// }
		// return WWW_ROOT . 'uploads' . DS . 'invoices'. DS . 'invoice_receipt_'.$child_id.'.pdf';

		// pr($pdf);die('link');
		//pr(WWW_ROOT . 'uploads' . DS . 'invoices'. DS . 'invoice_receipt_'.$child_id.'.pdf');die('psdf');

		//<!----------------------------3rd step --------------------------------->
		$path = WWW_ROOT . 'uploads' . DS . 'invoices' . DS;
		// require_once (ROOT .DS. 'vendor' .DS. 'mpdf'.DS. 'mpdf'.DS.'src' .DS.'Mpdf.php');
		// echo ROOT .DS. 'vendor'.DS. 'autoload.php';
		// die;
		//require_once (ROOT .DS. 'vendor'.DS. 'autoload.php');
		// require_once ROOT . '/vendor/autoload.php';
		// $this->set('parent', $parent);
		// $this->set('save', $save);
		// $this->set('difference', $difference);
		// $this->set('amount', $amount);
		// $this->set('school', $school);
		// $this->set('user', $user);
		// $this->set('parent_id', $parent_id);
		// $this->set('bso', $bso);
		//require_once __DIR__ . '/vendor/autoload.php';

		// $mpdf = new \Mpdf\Mpdf();
		// $mpdf->WriteHTML('<h1>Hello world!</h1>');
		// $mpdf->Output();
		// pr($mpdf);die();
		// //Cakephp method to render the ctp file containing pdf html that needs to be converted.

		//pr($pdfHtml);die('printing html');
		// $pdfName = 'invoice_receipt_'.$child_id.'.pdf'; //name of the pdf file
		//pr($pdfName);die('pdf name');
		//$mpdf->SetAuthor('CustomGuide'); // author added to pdf file

		//pr($mpdf);die('pdf title');
		/*$mpdf = new \Mpdf\Mpdf([
	                            'debug' => true,
	                            'allow_output_buffering' => true
		*/
		$mpdf = new \Mpdf\Mpdf();
		//$stylesheet = file_get_contents('css/custom.css');
		//die;
		//$mpdf->WriteHTML($stylesheet,1);
		//echo $pdfHtml ;die;
		$mpdf->WriteHTML($pdfHtml); //function used to convert HTML to pdf
		ob_end_clean();
		$mpdf->Output();
		//pr($mpdf);die('pdf');
		//$mpdf->showImageErrors = true;    // show if any image errors are present

		//$mpdf->debug = false;    // Debug warning or errors if set true(false by default)
		// $mpdf->Output($pdfName, 'D');    //output the pdf file
		//<!----------------------------3rd step --------------------------------->

		// $pdf = new Pdf('http://18.232.170.235/development/webroot/portal-web/personal-home.php');
		//     $pdf->setOptions(array(
		//         'binary' => '/var/www/html/portal/extract/usr/local/bin/wkhtmltopdf',
		//     ));
		//     if (!$pdf->saveAs('/var/www/html/portal/page.pdf')) {
		//         $error = $pdf->getError();
		//         pr($error);
		//         // ... handle error here
		//     }
		// $CakePdf = new \CakePdf\Pdf\CakePdf();
		// $CakePdf->template('/Parent/Users/pdf/offline_payment', 'Parent');
		// //$CakePdf->viewVars(set(compact('parent','save','difference','amount','school','user','bso')));
		// $CakePdf->viewVars($this->viewVars);
		//  //$CakePdf->viewVars([$parent,$save,$difference,$amount,$school,$user,$bso]);
		// // Get the PDF string returned
		// $pdf = $CakePdf->output();
		//      //pr($parent);die;
		//     // // Or write it to file directly
		//  $pdf = $CakePdf->write(WWW_ROOT . 'uploads' . DS . 'invoices' . DS .$parent_id . DS . $child_id  . DS . 'tax_receipt_invoice.pdf');
		//  return WWW_ROOT . 'uploads' . DS . 'invoices' . DS . $parent_id . DS . $child_id . DS . 'tax_receipt_invoice.pdf';
	}
	public function downloadPdf($parent, $save, $difference, $amount, $school, $user, $parent_id, $bso, $child_id, $id, $pdfHtml) {
		$path = WWW_ROOT . 'uploads' . DS . 'invoices' . DS;
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($pdfHtml); //function used to convert HTML to pdf
		ob_end_clean();
		//$mpdf->Output();
		$mpdf->Output('MyPDF.pdf', 'D');

	}

	public function mc_encrypt($encrypt, $key) {
		$encrypt = serialize($encrypt);
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
		$key = pack('H*', $key);
		$mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
		$passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt . $mac, MCRYPT_MODE_CBC, $iv);
		$encoded = base64_encode($passcrypt) . '|' . base64_encode($iv);
		return $encoded;
	}

	public function mc_decrypt($decrypt, $key) {
		$decrypt = explode('|', $decrypt . '|');
		$decoded = base64_decode($decrypt[0]);
		$iv = base64_decode($decrypt[1]);
		if (strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)) {return false;}
		$key = pack('H*', $key);
		$decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
		$mac = substr($decrypted, -64);
		$decrypted = substr($decrypted, 0, -64);
		$calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
		if ($calcmac !== $mac) {return false;}
		$decrypted = unserialize($decrypted);
		return $decrypted;
	}

	public function apiResponce($data, $is_die = false) {
		$resultr = base64_encode(json_encode($data));
		$length = 32;
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$chars2 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$key = substr(str_shuffle($chars), 0, $length);
		$key2 = substr(str_shuffle($chars2), 0, $length);
		$rule = $key . $key2 . $resultr;
		$result = $rule;
		//pr(json_encode($data));die;

		$response = [
			'status' => $data['status'],
			'code' => $data['code'],
			'message' => $data['message'],
			'data' => $result,
			'_serialize' => ['status', 'code', 'message', 'data'],
		];

		if ($is_die) {
			header('Content-Type: application/json');
			unset($response['_serialize']);
			echo json_encode($response);
			die();
		}

		$this->set($response);
	}

	public function getBearerToken($headers) {
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

	public function setPagination($paging) {
		unset($paging['finder']);
		unset($paging['sort']);
		unset($paging['sortDefault']);
		unset($paging['directionDefault']);
		unset($paging['scope']);
		unset($paging['completeSort']);
		return $paging;
	}
}
