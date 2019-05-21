<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Paginator');
		$this->loadComponent('Flash');
		$this->loadComponent('EmailSend');
		$this->loadComponent('UuId');
		$this->loadComponent('Encryption');
		$this->loadComponent('Counterytworegion');
		$this->loadComponent('Counterytimezonecurrency');
		$this->loadComponent('Counterybyip');
		$this->loadComponent('Language');

		//$this->loadComponent('RequestHandler');
	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

	}
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */

	public function index($id = null) {
		$this->viewBuilder()->setLayout('supperadmin');

		if ($this->request->is('post') && $this->request->getData('id')) {
			$id = $this->request->getData('id');
			$dashboard = 'active';
			$this->paginate = [
				'limit' => 10,
				'contain' => [],
				'conditions' => [
					"CONCAT(firstname,'',lastname) LIKE" => "%" . $id . "%",
					'role_id' => "2",
				],
				'order' => [
					'Users.id' => 'DESC',
				],
			];

			$users = $this->paginate($this->Users);
		}

		$this->paginate = [
			'limit' => 10,
			'order' => [
				'Users.id' => 'DESC',
			],
			'contain' => [],
			'conditions' => [
				"CONCAT(firstname,'',lastname) LIKE" => "%" . $id . "%", 'role_id' => "2",
			],
		];

		$users = $this->paginate($this->Users);
		$this->set(compact('users'));
	}

	public function autoload() {
		$this->autoRender = false;
		$this->loadModel('Pcdatas');

		if ($this->request->is('get') && $this->request->query('term')) {
			$id = strtoupper($this->request->query('term'));
			$pcdata = $this->Pcdatas->find('all')
				->select([
					'Pcdatas.id',
					'Pcdatas.wijkcode',
					'Pcdatas.lettercombinatie',
					'Pcdatas.huisnr_van',
					'Pcdatas.straatnaam',
					'Pcdatas.plaatsnaam',
					'Pcdatas.gemeentenaam',
				])
				->where([
					"CONCAT(wijkcode,'-',lettercombinatie,'-',huisnr_van) LIKE" => "%" . $id . "%",
				])
				->limit(25);

		}

		$data = [];
		foreach ($pcdata as $key => $value) {
			$oyo = $value['wijkcode'] . '-' . $value['lettercombinatie'] . '-' . $value['huisnr_van'];
			$info = $value['wijkcode'] . '-' . $value['lettercombinatie'];
			$address = $value['straatnaam'] . ' ' . $value['plaatsnaam'] . ' ' . $value['huisnr_van'];
			$city = $value['gemeentenaam'];
			$infos = $value['wijkcode'] . '-' . $value['lettercombinatie'];

			$data[$infos] = array(
				'id' => $value['id'],
				'label' => $oyo,
				'value' => $info,
				'address' => $address,
				'city' => $city,
			);

		}

		$myJSON = json_encode($data);
		echo $myJSON;

	}
	public function globalsettings($purpose = "location", $deep_detect = TRUE) {
		//$this->viewBuilder()->setLayout('settings');
		$this->autoRender = false;
		$ip = $_SERVER["REMOTE_ADDR"];
		//global $sitepress;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				}

				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
					$ip = $_SERVER['HTTP_CLIENT_IP'];
				}

			}
		}
		$purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support = array("country", "countrycode", "state", "region", "city", "location", "address");
		//$continents = configure::read('continents');
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . '122.161.192.39' /*$ip*//*'89.18.172.65','122.161.192.39'*/));
			// if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
			$output['country_code'] = @$ipdat->geoplugin_countryCode;
			$output['currency_symbol'] = @$ipdat->geoplugin_currencySymbol_UTF8;
			$output['currency_converter'] = @$ipdat->geoplugin_currencyConverter;
			$output['currency_converter'] = @$ipdat->geoplugin_currencyConverter;
			$output['currency_code'] = @$ipdat->geoplugin_currencyCode;
			$output['timezone'] = @$ipdat->geoplugin_timezone;
			$output['countryName'] = @$ipdat->geoplugin_countryName;
			$output['currency_symbol'] = @$ipdat->geoplugin_currencySymbol;
			$output['currency_converte'] = @$ipdat->geoplugin_currencyConverte;
			$contientcode = strtolower(trim($ipdat->geoplugin_continentCode));
			$output['continent_code'] = $contientcode;
			$output['timezone'] = trim($ipdat->geoplugin_timezone);
			//}
		}
		$lang = $this->Language->country2locale($output['country_code']);
		$language_array = ['nl' => 'Dutch', 'en' => 'English', 'de' => 'German'];
		if ($output['currency_code'] == 'USD') {
			$currency_code = [$output['currency_symbol'] => $output['currency_code']];
			$currency_converter = '';
		} else {
			$currency_code = [$output['currency_symbol'] => $output['currency_code'], '$' => 'USD'];
			$currency_converter = $output['currency_converter'];
		}

		return $output;
		//pr($output);die;

		// $data = [
		// 	"country_code" => $output['country_code'],
		// 	"timezone" => $output['timezone'],
		// 	"currency_code" => $currency_code,
		// 	//"currency_symbol" => $currency_symbol,
		// 	"currency_converter" => $currency_converter,
		// 	"languages" => $language_array,
		// ];
		// //pr($data);die;

		// $this->set(compact('data'));
	}
	public function saveGblsettings() {
		$this->loadModel('GlobalSettings');
		$this->autoRender = false;
		$globalsetting = $this->GlobalSettings->newEntity();
		$id = $this->request->getSession()->read('Auth.User.id');
		$user = $this->Users->get($id);
		//
		if ($this->request->is(['patch', 'post', 'put'])) {
			$currency = $this->request->getData(['currency']);
			$language = $this->request->getData(['language']);
			$timezone = $this->request->getData(['timezone']);
			$bso_id = '0';
			$cur = explode('(', $currency);
			$cur_name = $cur[0];
			$cur_sym = rtrim($cur[1], ")");
			$lang = explode('_', $language);
			$lang_name = $lang[1];
			$lang_code = $lang[0];
			//$globalsetting = $this->GlobalSettings->patchEntity($globalsetting, $this->request->getData());

			if (!$globalsetting->getErrors()) {
				$globalsetting->bso_id = $bso_id;
				$globalsetting->language = $lang_name;
				$globalsetting->language_code = $lang_code;
				$globalsetting->currency = $cur_name;
				$globalsetting->currency_code = $cur_sym;
				$globalsetting->timezone = $timezone;
				$savedid = $this->GlobalSettings->save($globalsetting);
				$users = TableRegistry::get('Users');
				$query = $users->query();
				$query->update()
					->set([
						'global_setting' => 1,

					])
					->where(['id' => $id])
					->execute();
				echo json_encode($savedid);die;

			}

		}
	}

	public function counteryregion() {
		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			$userinfo = $this->request->getData();
			//pr($userinfo['countery_code']);
			$regions = $this->Counterytworegion->region($userinfo['countery_code']);
			echo json_encode($regions);die;
		}

	}

	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */

	public function view($id = null) {
		$user = $this->Users->get($id, ['contain' => []]);
		$this->set('user', $user);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	// public function edit($id = null)
	// {
	//     $user = $this->Users->get($id, [
	//         'contain' => []
	//     ]);
	//     if ($this->request->is(['patch', 'post', 'put'])) {
	//         $user = $this->Users->patchEntity($user, $this->request->getData());
	//         if ($this->Users->save($user)) {
	//             $this->Flash->success(__('The user has been saved.'));
	//             return $this->redirect(['action' => 'index']);
	//         }
	//         $this->Flash->error(__('The user could not be saved. Please, try again.'));
	//     }
	//     $this->set(compact('user'));
	// }
	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */

	public function delete($id = null) {

		$this->autoRender = false;
		$this->request->allowMethod(['post', 'delete']);
		$userid = $this->UuId->uuid($id);
		//pr($userid);die;
		$userdependid = $this->Users->find('all')->select(['id'])->where(['bso_id' => $userid])->hydrate(false)->toArray();
		foreach ($userdependid as $key => $value) {
			$user = $this->Users->get($value, ['contain' => []]);
			$this->Users->delete($user);
		}
		$user = $this->Users->get($userid, ['contain' => []]);
		if ($this->Users->delete($user)) {
			$this->Flash->success(__('Bso has been deleted.'));
		} else {
			$this->Flash->error(__('Bso could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}

	public function add($id = null) {
		$this->viewBuilder()->setLayout('supperadmin');
		$Createddate = date("Y-m-d H:i:s");
		$gsettings = $this->Counterybyip->databyip();
		$this->loadModel('GlobalSettings');
		$globalsetting = $this->GlobalSettings->newEntity();
		$user = $this->Users->newEntity();
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('relation1');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('confirm_password');
		$dataid = $this->request->getSession()->read('Auth.User.uuid');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		if ($this->request->is('post')) {

			// pr($this->request->getData('countery']);
			// pr($this->request->getData('region']);

			// die;
			$file = array();
			$dobnew = date('Y-m-d', strtotime($this->request->getData('dob')));
			$file = $this->request->getData('image');
			unset($this->request->data['image']);
			$emailkey = ENCRYPTION_SLUG;
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$length = 8;
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
			$password = substr(str_shuffle($chars), 0, $length);

			if (!$user->getErrors()) {
				$user->role_id = "2";
				$user->group_id = "2";
				$user->created = $Createddate;
				$user->dob = $dobnew;
				$user->is_active = '1';
				$user->password = $password;
				$user->uuid = Text::uuid();
				$encryptionKey = md5($dataid);
				$user->encryptionkey = $encryptionKey;
				$this->Users->encryptData = 'Yes';
				$this->Users->encryptionKey = $encryptionKey;

				if ($savedid = $this->Users->save($user)) {
					// $savedid = $this->Users->save($user);

					$regid = $this->Encryption->genrateInvoiceNumber($savedid->id);
					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['registration_id' => $regid])
						->where(['id' => $savedid->id])
						->execute();
					$regions = $this->Counterytimezonecurrency->countryregioncode($this->request->getData('countery'), $this->request->getData('region'));
					$globalsetting = $this->GlobalSettings->patchEntity($globalsetting, $this->request->getData());
					if (!$globalsetting->getErrors()) {
						$globalsetting->bso_id = $bso_id;
						$globalsetting->currency = $regions['currency'];
						$globalsetting->currency_code = $regions['currency_symbol'];
						$globalsetting->countery_code = $this->request->getData('countery');
						$globalsetting->timezone = $regions['timezone'];
						$globalsetting->user_id = $savedid->id;
						//pr($globalsetting);die;
						$savegblsetting = $this->GlobalSettings->save($globalsetting);
						//pr($savegblsetting);die;
					}
					if (isset($file['name']) && !empty($file['name'])) {
						$imageArray = $file;
						$allowdedImageExtension = array('jpg', 'jpeg', 'png');
						$image_ext = explode(".", $imageArray["name"]);
						$ext = end($image_ext);

						if (in_array($ext, $allowdedImageExtension)) {

							$this->loadComponent('Utility');
							$img_return = $this->Utility->saveImageToServer($savedid->uuid, $imageArray, USER_PICTURE_FOLDER_DIRECTORY_PATH, USER_PICTURE_FOLDER_URL_PATH);

							if ($img_return['status']) {
								$imageEntity = $this->Users->get($savedid->id);

								$imageEntity->image = $img_return['name'];

								$users = TableRegistry::get('Users');
								$query = $users->query();
								$query->update()
									->set(['image' => $img_return['name']])
									->where(['id' => $savedid->id])
									->execute();
								// $savedimage = $this->Users->save(array('image'=>$img_return['name']));

							}
						}
					}

					//$string = 'saasadmin@yopmail.com16a123a114ae114a4e980ac15fd3c2b2b35da2bc8e18a115a19a8218a15a19a';
					$sendmail = base64_decode($savedid['email']);
					// $user = strstr($string, '.com', true);
					// $sendmail = $user . '.com';
					//echo base64_decode($sendmail);die;
					$message = 'You are Register with BSO Portal' . '<br/>';
					$message .= 'Link:' . '' . '' . BASE_URL . '<br/>';
					$message .= 'Your Email:' . '' . '' . $sendmail . '<br/>';
					$message .= 'Your Password:' . '' . '' . $password . '<br/>';
					$to = $sendmail;
					$from = 'rtestoffshore@gmail.com';
					$title = 'BSO';
					$subject = 'You Register With BSO';

					$this->EmailSend->emailSend($from, $title, $to, $subject, $message);

					$this->Flash->success(__('BSO has been Created.'));
					return $this->redirect(['action' => 'index']);
				}

			}

			$this->Flash->error(__('BSO could not be created. Please, try again.'));
		}
		//$gsettings = $this->globalsettings();
		$countery_code = $gsettings['country_code'];
		$regions = $this->Counterytworegion->region($countery_code);
		if (!empty($regions)) {
			$regions = $regions;
		} else {
			$regions = ['Single timezone Available'];
		}
		$this->set(compact('user', 'countery_code', 'regions'));
	}

	public function checkPassword($value, $context) {

		if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $context['data']['password'])) {
			return false;
		} else {
			return true;
		}
	}
	public function edit($id = null) {
		$this->viewBuilder()->setLayout('supperadmin');
		$this->loadModel('GlobalSettings');
		$userid = $this->UuId->uuid($id);
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $userid])->first();
		//pr($GlobalSettings);
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$dataid = $this->request->getSession()->read('Auth.User.uuid');
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is(['patch', 'post', 'put'])) {

			$file = array();
			$imageinfo = $this->request->getData('image');

			if ($imageinfo['name'] != '') {
				$file = $this->request->getData('image');
			}

			if ($user->image == '') {
				unset($user->image);
			}
			unset($this->request->data['image']);

			if (!empty($this->request->data('password'))) {
				$user = $this->Users->patchEntity(
					$user,
					$this->request->getData(),
					['validate' => 'Profile']
				);
			} else {
				unset($this->request->data['password']);
				unset($this->request->data['confirm_password']);
				$user = $this->Users->patchEntity($user, $this->request->getData());
			}

			$Createddate = date("Y-m-d h:i:sa");
			$user->modified = $Createddate;
			$encryptionKey = md5($dataid);
			$this->Users->encryptData = 'Yes';
			$this->Users->encryptionKey = $encryptionKey;
			if ($savedid = $this->Users->save($user)) {
				$globalsetting = $this->GlobalSettings->patchEntity($GlobalSettings, $this->request->getData());
				$regions = $this->Counterytimezonecurrency->countryregioncode($this->request->getData('countery'), $this->request->getData('region'));
				if (!$globalsetting->getErrors()) {
					$globalsetting->bso_id = $dataid;
					$globalsetting->currency = $regions['currency'];
					$globalsetting->currency_code = $regions['currency_symbol'];
					$globalsetting->countery_code = $this->request->getData('countery');
					$globalsetting->timezone = $regions['timezone'];
					$globalsetting->user_id = $savedid->id;
					$savegblsetting = $this->GlobalSettings->save($globalsetting);
				}

				if (!empty($file)) {
					$imageArray = $file;
					$allowdedImageExtension = array(
						'jpg',
						'jpeg',
						'png',
					);
					$image_ext = explode(".", $imageArray["name"]);
					$ext = end($image_ext);

					if (in_array($ext, $allowdedImageExtension)) {
						$this->loadComponent('Utility');
						$img_return = $this->Utility->saveImageToServer($user->uuid, $imageArray, USER_PICTURE_FOLDER_DIRECTORY_PATH, USER_PICTURE_FOLDER_URL_PATH);

						if ($img_return['status']) {
							$imageEntity = $this->Users->get($user->id);
							$imageEntity->image = $img_return['name'];
							$users = TableRegistry::get('Users');
							$query = $users->query();
							$query->update()
								->set(['image' => $img_return['name']])
								->where(['id' => $user->id])
								->execute();
							// $this->Users->save($imageEntity);
						}
					}
				}
				$this->Flash->success(_('BSO profile has been updated.'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('There are some problem to update BSO profile. Please try again!'));
		}
		$regions = $this->Counterytworegion->region($GlobalSettings['countery_code']);
		if (!empty($regions)) {
			$regions = $regions;
		} else {
			$regions = ['Single timezone Available'];
		}
		$this->set(compact('user', 'GlobalSettings', 'regions'));
	}

	public function dashboard() {
		$this->viewBuilder()->setLayout('supperadmin');
		$user = $this->Auth->identify();

		if ($user) {
			$this->Auth->setUser($user);
			return $this->redirect($this->Auth->redirectUrl());
		}

		$this->Flash->error(__('Invalid username or password, try again'));
	}

	public function logout() {
		$this->autoRender = false;
		return $this->redirect($this->Auth->logout());
	}

	public function profile($id) {

		if ($userid = $this->UuId->uuid($id)) {

			$profile = $this->Users->get($userid, ['contain' => []]);
			$this->viewBuilder()->setLayout('supperadmin');
			$this->set('profile', $profile);
		}
	}

	public function profileEdit($id) {

		if ($userid = $this->UuId->uuid($id)) {
			$user = $this->Users->get($userid, ['contain' => []]);
			$this->viewBuilder()->setLayout('supperadmin');
			$this->Users->getValidator()->remove('image');
			$this->Users->getValidator()->remove('email');
			$this->Users->getValidator()->remove('gender');
			$this->Users->getValidator()->remove('dob');
			$this->Users->getValidator()->remove('lastname');
			$this->Users->getValidator()->remove('school');
			$this->Users->getValidator()->remove('relation');
			$this->Users->getValidator()->remove('relation1');
			$this->Users->getValidator()->remove('account');
			$this->Users->getValidator()->remove('bank_name');
			$this->Users->getValidator()->remove('password');
			$this->Users->getValidator()->remove('confirm_password');

			if ($this->request->is(['patch', 'post', 'put'])) {
				$file = array();
				$imageinfo = $this->request->getData('image');
				$file = array();
				$imageinfo = $this->request->getData('image');

				if ($imageinfo['name'] != '') {
					$file = $this->request->getData('image');
				}

				if ($user->image == '') {
					unset($user->image);
				}

				unset($this->request->data['image']);

				if (!empty($this->request->data('password'))) {
					$user = $this->Users->patchEntity(
						$user,
						$this->request->getData(),
						['validate' => 'Profile']
					);

				} else {
					unset($this->request->data['password']);
					unset($this->request->data['confirm_password']);
					$user = $this->Users->patchEntity($user, $this->request->getData());
				}

				$user->is_active = 1;
				$Createddate = date("Y-m-d h:i:sa");
				$user->modified = $Createddate;

				if ($this->Users->save($user)) {
					$session = $this->request->session();

					if (!empty($file)) {
						$imageArray = $file;
						$allowdedImageExtension = array(
							'jpg',
							'jpeg',
							'JPG',
							'PNG',
							'png',
						);
						$image_ext = explode(".", $imageArray["name"]);
						$ext = end($image_ext);

						if (in_array($ext, $allowdedImageExtension)) {
							$this->loadComponent('Utility');
							$img_return = $this->Utility->saveImageToServer($user->uuid, $imageArray, USER_PICTURE_FOLDER_DIRECTORY_PATH, USER_PICTURE_FOLDER_URL_PATH);

							if ($img_return['status']) {
								$imageEntity = $this->Users->get($user->id);
								$imageEntity->image = $img_return['name'];

								$users = TableRegistry::get('Users');

								$query = $users->query();

								$query->update()
									->set(['image' => $img_return['name']])
									->where(['id' => $user->id])
									->execute();

								//$this->Users->save($imageEntity);
							}
						}
						$img_return = $img_return['name'];
					} else {
						$img_return = $user->image;

					}

					$session->write('Auth.User.firstname', $user->firstname);
					$session->write('Auth.User.lastname', $user->lastname);
					$session->write('Auth.User.image', $img_return);
					$session->write('Auth.User.name', $user->firstname . ' ' . $user->lastname);

					$this->Flash->success(__('Your profile update successfuly.'));
					return $this->redirect(['action' => 'profile-edit', 'prefix' => 'admin', $id]);
				}

				$this->Flash->error(__('There are some problem to update profile. Please try again!'));

			}

			$this->set('user', $user);
		}
	}

	public function login() {
		$this->viewBuilder()->setLayout('login');

		if ($this->request->is('post')) {
			$user = $this->Auth->identify();

			if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}

			$this->Flash->error(__('Invalid username or password, try again'));
		}
	}

	public function activateBso($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($id);
			$user = $this->Users->get($userid, ['contain' => []]);
			$bso_id = $user['id'];
			$this->paginate = ['contain' => [],
				'conditions' => [
					'bso_id' => $bso_id,
				],
			];
			$parents = $this->paginate($this->Users);
			$user->is_active = "1";

			if ($this->Users->save($user)) {

				foreach ($parents as $key => $value) {

					$parent_id = $value['id'];
					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['is_active' => 1])
						->where(['id' => $parent_id])
						->execute();
				}

				$this->Flash->success(_('Bso has been activated.'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(_('Bso could not be activated.'));
		}

		$this->set(compact('user'));
	}

	public function deactivateBso($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($id);
			$user = $this->Users->get($userid, ['contain' => []]);
			echo $bso_id = $user['id'];
			$this->paginate = ['contain' => [],
				'conditions' => [
					'bso_id' => $bso_id,
				],
			];
			$parents = $this->paginate($this->Users);
			$user->is_active = "0";

			if ($this->Users->save($user)) {

				foreach ($parents as $key => $value) {
					$parent_id = $value['id'];
					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['is_active' => 0])
						->where(['id' => $parent_id])
						->execute();
					// $parents->is_active = "0";
					// $this->Users->save($parents);
				}

				$this->Flash->success(_('Bso has been deactivated.'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(_('Bso could not be deactivated.'));
		}

		$this->set(compact('user'));
	}

}