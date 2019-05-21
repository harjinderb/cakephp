<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
//use App\Controller\Api\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use \Firebase\JWT\JWT;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Paginator');
		$this->loadComponent('EmailSend');
		$this->loadComponent('UuId');
		$this->loadComponent('Encryption');
		// $this->Auth->allow();
		$this->Auth->allow(['login', 'logout', 'forgotPassword']);
	}

	public function index() {
		$users = $this->Users->find('all');
		$this->set([
			'users' => $users,
			'_serialize' => ['users'],
		]);

	}

	public function autherror() {
		$data = [
			'status' => '403',
			'message' => 'Your token expired, try login again',
			'data' => NULL,
		];

		$this->set([
			'data' => $data,
			'_serialize' => ['data'],
		]);
	}

	public function logout() {
		if ($this->request->is('post')) {
			$userinfo = $this->request->getData();
			$id = $userinfo['id'];
			try {
				$users = $this->Users->get($id);
				if ($users) {
					$users->token = '';
					if ($this->Users->save($users)) {
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'User Logout Sucessfully',
							'data' => NULL,
						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '400',
							'message' => 'Already LogedOut!',
							'data' => NULL,
						];
					}
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '404',
					'message' => 'User not Found',
					'data' => NULL,
				];
			}
		}
		$this->apiResponce($data);
	}
	public function login() {
		if ($this->request->is('post')) {

			if (array_key_exists('email', $this->request->getData())) {
				if (array_key_exists('password', $this->request->getData())) {
					$this->request->data['email'] = base64_encode($this->request->getdata('email') . ENCRYPTION_SLUG);
					//pr($this->request->getData());die;
					$user = $this->Auth->identify();
					//pr($user);die;
					if ($user) {
						if ($user['is_active'] == 1) {
							if ($user['role_id'] == '3' || $user['role_id'] == '4' || $user['role_id'] == '2') {
								$this->loadComponent('JwtToken');
								$user_id = $user['id'];
								$encryptionKey = $user['encryptionkey'];
								$user = $this->Encryption->encryption($user);

								if ($user = $this->JwtToken->jwt($user)) {
									$usersdata = $this->Users->get($user_id);

									$users = $this->Encryption->encryption($usersdata);

									$users->token = $user;

									$this->Users->getValidator()->remove('email');
									$this->Users->encryptData = 'Yes';
									$this->Users->encryptionKey = $encryptionKey;
									if ($this->Users->save($users)) {

										$usersdata = $this->Users->get($user_id);
										if ($usersdata['role_id'] == 4) {
											$bsodata = $this->Users->get($usersdata['bso_id']);
											$usersdata->bsouuid = $bsodata['uuid'];
										} else {
											$usersdata->bsouuid = $usersdata['uuid'];
										}
										$users = $this->Encryption->encryption($usersdata);

										$data = [
											'status' => 'sucess',
											'code' => '200',
											'message' => __('You are logged in sucessfully'),
											'data' => $users,
										];
									} else {
										$data = [
											'status' => 'error',
											'code' => '400',
											'message' => __('Unable to save token, try login again.'),
											'data' => NULL,
										];
									}
								} else {
									$data = [
										'status' => 'error',
										'code' => '400',
										'message' => __('Unable to generate token, try login again.'),
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '400',
									'message' => __('Invalid user role, you are not allowed to login.'),
									'data' => NULL,
								];
							}
						} else {
							$data = [
								'status' => 'error',
								'code' => '400',
								'message' => __('Your account is not active yet, please check your email and activate your account.'),
								'data' => NULL,
							];
						}
					} else {
						$data = [
							'status' => 'error',
							'code' => '400',
							'message' => __('Invalid login credentials, try again!'),
							'data' => NULL,
						];
					}
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Password is required.'),
						'data' => NULL,
					];
				}
			} else {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Email is required.'),
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '400',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}

		$this->apiResponce($data);
	}

	public function forgotPassword() {
		//pr("qwer");die;
		if ($this->request->is('post')) {

			if (array_key_exists('email', $this->request->getData())) {
				$userEmail = $this->request->getdata('email');
				$usersTable = TableRegistry::get('Users');

				$users = $usersTable
					->find()
					->where([
						'email' => base64_encode($userEmail . ENCRYPTION_SLUG),
					])
					->first();

				if ($users) {
					$link = sha1($this->Encryption->emailDecode($users->email)) . rand();
					$newLink = $usersTable->get($users->id);
					$newLink->activation_link = $link;
					if ($usersTable->save($newLink)) {
						$link = BASE_URL . 'users/updatePassword/' . $link . '_' . rand();
						//pr($link);die;
						$message = 'To update your password <a href="' . $link . '">click here</a>';
						$to = $userEmail;
						//$from = FROM_EMAIL;
						$from = 'rtestoffshore@gmail.com';
						$title = 'Kind Planner';
						$subject = 'Change Password';
						//$email = $this->EmailSend->emailSend($from, $title, $to, $subject, $message);
						if ($this->EmailSend->emailSend($from, $title, $to, $subject, $message)) {
							$data = [
								'status' => 'sucess',
								'code' => '200',
								'message' => 'Reset password instructions sent in your email, follow steps in email to reset password.',
								'data' => NULL,
							];
						} else {
							$data = [
								'status' => 'error',
								'code' => '400',
								'message' => 'Unable to send email, try again later.',
								'data' => NULL,
							];
						}
					} else {
						$data = [
							'status' => 'error',
							'code' => '400',
							'message' => __('Unable to generate reset password link, try again later.'),
							'data' => NULL,
						];
					}
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('No user is associated with this email, enter your right email.'),
						'data' => NULL,
					];
				}
			} else {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Email is required.'),
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}

		$this->apiResponce($data);
	}

	public function updatePassword() {
		if ($this->request->is('post')) {
			if (array_key_exists('current_password', $this->request->getData())) {
				if (array_key_exists('new_password', $this->request->getData())) {
					if (array_key_exists('confirm_password', $this->request->getData())) {
						//pr($this->request->getData());die;
						$new_password = $this->request->getdata('new_password');
						$confirm_password = $this->request->getdata('confirm_password');
						if ($new_password === $confirm_password) {
							$token = $this->request->header('Authorization');
							$auth_token = $this->getBearerToken($token);
							$current_password = $this->request->getdata('current_password');
							$password = (new DefaultPasswordHasher)->hash($current_password);

							$users = TableRegistry::get('Users')
								->find()
								->where(['token' => $auth_token])
								->first();

							if ($users) {
								if (password_verify($current_password, $users['password'])) {
									$updatePassword = (new DefaultPasswordHasher)->hash($confirm_password);
									$user = TableRegistry::get('Users');
									$query = $user->query();
									$query->update()
										->set(['password' => $updatePassword, 'flag' => '1'])
										->where(['token' => $auth_token])
										->execute();

									$message = 'Your Password Has Been Changed' . '<br/>';
									$message .= 'Your Password:' . '' . $confirm_password . '<br/>';
									$to = $this->Encryption->emailDecode($users['email']);
									//$from = FROM_EMAIL;
									$from = 'rtestoffshore@gmail.com';
									$title = 'BSO';
									$subject = 'Password Changed';
									$this->EmailSend->emailSend($from, $title, $to, $subject, $message);

									$data = [
										'status' => 'sucess',
										'code' => '200',
										'message' => 'Password Updated Sucessfully',
										'data' => NULL,
									];
								} else {
									$data = [
										'status' => 'error',
										'code' => '400',
										'message' => 'Current Password Did Not Match, try again!',
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '400',
									'message' => 'Invalid User, try again!',
									'data' => NULL,
								];
							}
						} else {
							$data = [
								'status' => 'error',
								'code' => '400',
								'message' => __('New password and confirm password are not matching.'),
								'data' => NULL,
							];
						}
					} else {
						$data = [
							'status' => 'error',
							'code' => '400',
							'message' => __('Confirm password is required.'),
							'data' => NULL,
						];
					}
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('New password is required.'),
						'data' => NULL,
					];
				}
			} else {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Current password is required.'),
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	//BSO /Parent App
	// 30 01 2019
	// To Rajan /Sumit
	// By Rakesh
	// public function getSearch() {
	// 	if ($this->request->is('post')) {
	// 		$datadecode = $this->Auth->user();
	// 		$userdata = $datadecode['data']['user'];
	// 		$encryptionKey = $userdata['encryptionkey'];
	// 		$userinfo = $this->request->getData();
	// 		//pr($datadecode);die;
	// 		$limit = $userinfo['limit'];
	// 		$page = $userinfo['page'];
	// 		$role_id = $userinfo['role_id'];
	// 		$searchkey = $userinfo['searchkey'];
	// 		$validationError = array();
	// 		$conditions = [];
	// 		$values = '';
	// 		$email = '';

	// 		if ($searchkey == '') {
	// 			$validationError['searchkey'] = ['searchkey field is required.'];
	// 		} else {
	// 			echo $values = $this->Encryption->mc_encrypt($searchkey, $encryptionKey);
	// 			die;
	// 			$values = $this->Encryption->mc_encrypt($searchkey, $encryptionKey);
	// 			//die;

	// 			$email = base64_encode($searchkey . ENCRYPTION_SLUG);

	// 		}
	// 		if ($limit == '') {
	// 			$validationError['limit'] = ['Limit field is required.'];
	// 		} else if (!is_numeric($limit)) {
	// 			$validationError['limit'] = ['Please enter numeric value of limit.'];
	// 		}
	// 		if ($page == '') {
	// 			$validationError['page'] = ['Page field is required.'];
	// 		} else if (!is_numeric($page)) {
	// 			$validationError['page'] = ['Please enter numeric value of page.'];
	// 		}
	// 		if ($role_id == '') {
	// 			$validationError['role_id'] = ['role_id field is required.'];
	// 		} else if (!is_numeric($role_id)) {
	// 			$validationError['role_id'] = ['Please enter numeric value of page.'];
	// 		}

	// 		if ($validationError) {
	// 			$data = [
	// 				'status' => 'error',
	// 				'code' => '400',
	// 				'message' => __('Validation error occurs!.'),
	// 				'data' => $validationError,
	// 			];
	// 			return $this->apiResponce($data);
	// 		}
	// 		try {
	// 			$conditions['AND'] = ["Users.role_id" => $role_id];
	// 			$conditions['OR'][] = ["CONCAT(Users.firstname,' ',Users.lastname) LIKE" => "%$values%"];
	// 			// $conditions['OR'][] = ["Users.name LIKE" => "%$values%"];
	// 			// $conditions['OR'][] = ["Users.email LIKE" => "%$email%"];
	// 			// $conditions['OR'][] = ["Users.bsn_no LIKE" => "%$values%"];
	// 			//pr($conditions);die;
	// 			$users = $this->Users->find('all', [
	// 				'conditions' => $conditions, 'limit' => $limit,
	// 				'page' => $page, 'order' => [
	// 					'Users.id' => 'DESC',
	// 				],
	// 			])->toArray();
	// 			//pr($users);die;
	// 			$newUserData = array();
	// 			foreach ($users as $key => $userdata) {
	// 				$newUserData[] = $this->Encryption->encryption($userdata);

	// 			}
	// 		} catch (\Exception $e) {
	// 			$data = [
	// 				'status' => 'error',
	// 				'code' => '401',
	// 				'message' => 'Invalid token',
	// 				'data' => NULL,
	// 			];
	// 		}

	// 	} else {
	// 		$data = [
	// 			'status' => 'error',
	// 			'code' => '402',
	// 			'message' => __('Method not allowed'),
	// 			'data' => NULL,
	// 		];
	// 	}
	// 	$this->apiResponce($data);
	// }
	//BSO App
	// To Rajan
	// By Rakesh
	public function getparentList() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			//($datadecode);die;
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];
			$bso_id = $datadecode['data']['user']['id'];
			$userinfo = $this->request->getData();

			$parentId = $datadecode['data']['user']['id'];
			$limit = $userinfo['limit'];
			$page = $userinfo['page'];
			$validationError = array();

			if ($limit == '') {
				$validationError['limit'] = ['Limit field is required.'];
			} else if (!is_numeric($limit)) {
				$validationError['limit'] = ['Please enter numeric value of limit.'];
			}
			if ($page == '') {
				$validationError['page'] = ['Page field is required.'];
			} else if (!is_numeric($page)) {
				$validationError['page'] = ['Please enter numeric value of page.'];
			}

			if ($validationError) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Validation error occurs!.'),
					'data' => $validationError,
				];
				return $this->apiResponce($data);
			}

			try {

				$users = $this->Users->find('all', [
					'conditions' => ['role_id' => 4, 'bso_id' => $bso_id, 'parent_id' => '0'], 'limit' => $limit,
					'page' => $page, 'order' => [
						'Users.id' => 'DESC',
					],
				])->toArray();
				//pr($users);
				$newUserData = array();
				foreach ($users as $key => $userdata) {
					$newUserData[] = $this->Encryption->encryption($userdata);

				}
				/*pr($newUserData);die;*/
				$query = $this->Users->find('all', [
					'conditions' => ['bso_id' => $bso_id, 'role_id' => 4],
				]);
				$number = $query->count();

				if ($users) {
					$usersData = array('client_data' => $users);

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Parent List',
						'data' => $newUserData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}
	//BSO App
	// 21 01 2019
	// To Rajan
	// By Rakesh
	public function userActivate() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$usergetdata = $this->request->getData();
			$userid = $this->UuId->uuid($usergetdata['uuid']);

			try {
				$user = $this->Users->find('all')->where(['id' => $userid])->first();
				if ($user) {

					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['is_active' => 1])
						->where(['id' => $userid])
						->execute();

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'User Activate sucessfully',
						'data' => NULL,

					];

				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	//BSO App
	// 21 01 2019
	// To Rajan
	// By Rakesh
	public function userDeactivate() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$usergetdata = $this->request->getData();
			$userid = $this->UuId->uuid($usergetdata['uuid']);

			try {
				$user = $this->Users->find('all')->where(['id' => $userid])->first();
				if ($user) {

					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['is_active' => 0])
						->where(['id' => $userid])
						->execute();

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'User Deactivate sucessfully',
						'data' => NULL,

					];

				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	//BSO App -Guardian Section
	// 21 01 2019
	// To Rajan
	// By Rakesh
	public function bsoGuardianList() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$bso_id = $userdata['id'];
			$userinfo = $this->request->getData();
			$parentId = $userinfo['parent_uuid'];
			$userid = $this->UuId->uuid($parentId);
			$limit = $userinfo['limit'];
			$page = $userinfo['page'];
			$validationError = array();

			if ($limit == '') {
				$validationError['limit'] = ['Limit field is required.'];
			} else if (!is_numeric($limit)) {
				$validationError['limit'] = ['Please enter numeric value of limit.'];
			}
			if ($page == '') {
				$validationError['page'] = ['Page field is required.'];
			} else if (!is_numeric($page)) {
				$validationError['page'] = ['Please enter numeric value of page.'];
			}

			if ($validationError) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Validation error occurs!.'),
					'data' => $validationError,
				];
				return $this->apiResponce($data);
			}

			try {

				$users = $this->Users->find('all', [
					'conditions' => ['parent_id' => $userid, 'role_id' => 4, 'bso_id' => $bso_id], 'limit' => $limit,
					'page' => $page, 'order' => [
						'Users.id' => 'DESC',
					],
				])->hydrate(false)->toArray();

				$newUserData = array();
				foreach ($users as $key => $userdata) {
					$newUserData[] = $this->Encryption->encryption($userdata);

				}
				//pr($newUserData);die;
				$query = $this->Users->find('all', [
					'conditions' => ['parent_id' => $parentId, 'role_id' => 4],
				]);
				$number = $query->count();

				if ($users) {
					$usersData = array('totalRedord' => $number, 'client_data' => $users);

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Guardian List',
						'data' => $newUserData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '405',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}
	//BSO App -Guardian Section
	// 21 01 2019
	// To Rajan
	// By Rakesh
	public function bsoaddGuardian() {
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is('post')) {

			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$usergetdata = $this->request->getData();

			try {
				$Createddate = date("Y-m-d h:i:sa");
				$user = $this->Users->newEntity();

				$dobnew = $this->request->getData('dob');
				$parentId = $usergetdata['parent_uuid'];
				$userid = $this->UuId->uuid($parentId);
				$bsoID = $userdata['id'];
				$bsouuid = $userdata['uuid'];
				$encryptionKey = md5($bsouuid);

				if ($this->request->getData('relation1') == '3') {
					$relation = $this->request->getData('relation');
				} elseif ($this->request->getData('relation1') == '2') {
					$relation = 'Daughter';
				} elseif ($this->request->getData('relation1') == '1') {
					$relation = 'Son';
				}

				$file = array();
				$file = $this->request->getData('image');
				unset($this->request->data['image']);
				$user = $this->Users->patchEntity($user, $this->request->getData());

				if (!$user->getErrors()) {
					$user->parent_id = $userid;
					$user->bso_id = $bsoID;
					$user->role_id = "4";
					$user->group_id = "4";
					$user->dob = $dobnew;
					$user->is_active = '1';
					$user->relation = $relation;
					$user->created = $Createddate;
					$user->uuid = Text::uuid();
					$user->encryptionkey = $encryptionKey;
					//pr($user);die;
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					if ($savedid = $this->Users->save($user)) {
						$regid = $this->Encryption->genrateInvoiceNumber($savedid->id);
						$users = TableRegistry::get('Users');
						$query = $users->query();
						$query->update()
							->set(['registration_id' => $regid])
							->where(['id' => $savedid->id])
							->execute();
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
									// $this->Users->save($imageEntity);
								} else {
									$data = [
										'status' => 'error',
										'code' => '403',
										'message' => __('Image did not successfully saved!'),
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '404',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
							}
						}
						$usersave = $this->Users->find('all')->where(['id' => $savedid->id])->first();
						//pr($usersave);die('iop');
						$newUserData = $this->Encryption->encryption($usersave);
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Guardian has been created',
							'data' => $newUserData,
						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '408',
							'message' => __('Guardian Information Not Saved!'),
							'data' => NULL,
						];
					}
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs!'),
						'data' => $user->getErrors(),
					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed!'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	//BSO App -Guardian Section
	// 21 01 2019
	// To Rajan
	// By Rakesh
	public function bsoGuardianEdit() {
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');
		if ($this->request->is(['patch', 'post', 'put'])) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$user_getdata = $this->request->getData();
			try {
				$user = $this->Users->find('all')->where(['uuid' => $user_getdata['guardian_uuid']])->first();
				//pr($user);die;
				$encryptionKey = $user['encryptionkey'];
				$Createddate = date("Y-m-d h:i:sa");
				$dobnew = $this->request->getData('dob');

				if ($this->request->getData('relation1') == '3') {
					$relation = $this->request->getData('relation');
				} elseif ($this->request->getData('relation1') == '2') {
					$relation = 'Daughter';
				} elseif ($this->request->getData('relation1') == '1') {
					$relation = 'Son';
				}

				$file = array();
				$file = $this->request->getData('image');
				unset($this->request->data['image']);
				$user = $this->Users->patchEntity($user, $this->request->getData());

				if (!$user->getErrors()) {

					$user->dob = $dobnew;
					$user->relation = $relation;
					$user->modified = $Createddate;
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;

					if ($savedid = $this->Users->save($user)) {
						//pr($savedid);die;
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
									// $this->Users->save($imageEntity);
								} else {
									$data = [
										'status' => 'error',
										'code' => '403',
										'message' => __('Image did not successfully Updated!'),
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '404',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
							}
						}
						$usersave = $this->Users->find('all')->where(['id' => $savedid->id])->first();
						//pr($usersave);die('iop');
						$newUserData = $this->Encryption->encryption($usersave);
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Guardian has been Updated',
							'data' => $newUserData,
						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '408',
							'message' => __('Guardian Information Not Updated!'),
							'data' => NULL,
						];
					}
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs!'),
						'data' => $user->getErrors(),
					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed!'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	//BSO App
	// To Rajan
	// By Rakesh
	public function viewparentProfile() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			//pr($userinfo);die;
			//$newUserData[] = $this->Encryption->encryption($userdata);
			if ($userdata) {

				$user = $this->Users->find('all')->where(['uuid' => $userinfo['user_uuid']])->first();
				$user = $this->Encryption->encryption($user);
				//pr($user);die;
				$data = [
					'status' => 'sucess',
					'code' => '200',
					'message' => 'Parent Profile',
					'data' => $user,

				];
			} else {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}

		$this->apiResponce($data);
	}
	//BSO App
	// To Rajan
	// By Rakesh
	public function editparentProfile() {
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');
		$datadecode = $this->Auth->user();
		$userdata = $datadecode['data']['user'];
		$userinfo = $this->request->getData();
		if ($this->request->is('post')) {
			try {
				$user = $this->Users->find('all')->where(['uuid' => $userinfo['user_uuid']])->first();
				$user = $this->Encryption->encryption($user);
				$encryptionKey = $user['encryptionkey'];
				$Createddate = date("Y-m-d h:i:sa");
				$dobnew = $this->request->getData('dob');
				$file = array();
				$file = $this->request->getData('image');
				unset($this->request->data['image']);
				unset($this->request->data['relation']);
				unset($this->request->data['password']);
				$user = $this->Users->patchEntity($user, $this->request->getData());

				if (!$user->getErrors()) {
					//pr($user);die;
					$user->dob = $dobnew;
					//$user->relation = $relation;
					$user->modified = $Createddate;
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					if ($savedid = $this->Users->save($user)) {
						//pr($savedid->id);die;

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
									// $this->Users->save($imageEntity);

								} else {
									$data = [
										'status' => 'error',
										'code' => '403',
										'message' => __('Image did not successfully Updated!'),
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '404',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
							}
						}
						$usersave = $this->Users->find('all')->where(['id' => $savedid->id])->first();
						//pr($usersave);die('iop');
						$newUserData = $this->Encryption->encryption($usersave);
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Parent Profile has been Updated',
							'data' => $newUserData,
						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '408',
							'message' => __('Parent Profile Information Not Updated!'),
							'data' => NULL,
						];
					}

				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs!'),
						'data' => $user->getErrors(),
					];
				}
				//pr($user);die;
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token!',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}
	//PARENT App
	// To Sumit
	// By Rakesh
	public function parentProfile() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];

			//$newUserData[] = $this->Encryption->encryption($userdata);
			try {
				$user = $this->Users->find('all')->where(['uuid' => $userinfo])->first();
				$user = $this->Encryption->encryption($user);
				$data = [
					'status' => 'sucess',
					'code' => '200',
					'message' => 'Parent Profile',
					'data' => $user,

				];
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	//PARENT App
	// To Rajan
	// By Rakesh
	public function gettingChildList() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];
			//pr($userdata);die;
			$userinfo = $this->request->getData();
			$parentId = $userid = $this->UuId->uuid($userinfo['uuid']);

			$limit = $userinfo['limit'];
			$page = $userinfo['page'];
			$validationError = array();

			if ($limit == '') {
				$validationError['limit'] = ['Limit field is required.'];
			} else if (!is_numeric($limit)) {
				$validationError['limit'] = ['Please enter numeric value of limit.'];
			}
			if ($page == '') {
				$validationError['page'] = ['Page field is required.'];
			} else if (!is_numeric($page)) {
				$validationError['page'] = ['Please enter numeric value of page.'];
			}

			if ($validationError) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Validation error occurs.'),
					'data' => $validationError,
				];
				return $this->apiResponce($data);
			}

			// try {
			$users = $this->Users->find('all', [
				'conditions' => ['parent_id' => $parentId, 'role_id' => 5], 'limit' => $limit,
				'page' => $page, 'order' => [
					'Users.id' => 'DESC',
				],
			])->toArray();
			$newUserData = array();
			foreach ($users as $key => $userdata) {
				$newUserData[] = $this->Encryption->encryption($userdata);

			}
			$query = $this->Users->find('all', [
				'conditions' => ['parent_id' => $parentId, 'role_id' => 5],
			]);
			$number = $query->count();

			if ($users) {
				$usersData = array('totalRedord' => $number, 'client_data' => $users);

				$data = [
					'status' => 'sucess',
					'code' => '200',
					'message' => 'Child List',
					'data' => $newUserData,

				];
			} else {
				$data = [
					'status' => 'error',
					'code' => '200',
					'message' => 'No recode found.',
					'data' => NULL,

				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}
	//PARENT App
	// To Rajan
	// By Rakesh
	public function editChildbso() {
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');
		$schoolId = '';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$userinfo = $this->request->getData();
			$userid = $this->UuId->uuid($userinfo['child_uuid']);

			try {
				$user = $this->Users->find('all')->where(['id' => $userid])->first();
				$encryptionKey = $user['encryptionkey'];
				$this->loadModel('Schools');
				if (!empty($userinfo['school'])) {

					$school = $this->Schools->find('all')->where(['name LIKE' => '%' . $userinfo['school'] . '%'])->first();

					if ($school) {
						$schoolId = $school->id;
					} else {
						$school = $this->Schools->newEntity();
						$schoolspostdata = array(
							'name' => $userinfo['school'],
						);
						$schooldata = $this->Schools->patchEntity($school, $schoolspostdata);
						$saveSchool = $this->Schools->save($schooldata);
						$schoolId = $saveSchool['id'];
					}
				}

				$dobnew = $this->request->getData('dob');

				if ($this->request->getData('relation1') == '3') {
					$relation = $this->request->getData('relation');
				} elseif ($this->request->getData('relation1') == '2') {
					$relation = 'Daughter';
				} elseif ($this->request->getData('relation1') == '1') {
					$relation = 'Son';
				}
				$file = array();
				$imageinfo = $this->request->getData('image');

				if ($imageinfo != '') {
					$file = $this->request->getData('image');
				}
				unset($this->request->data['image']);

				$user = $this->Users->patchEntity($user, $this->request->getData());
				$Createddate = date("Y-m-d h:i:sa");
				$user->modified = $Createddate;
				$user->relation = $relation;
				$user->school = $schoolId;
				$user->dob = $dobnew;

				if (!$user->getErrors()) {
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					$savedid = $this->Users->save($user);
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
								$saveImage['image'] = $img_return['name'];

								$imageEntity = $this->Users->get($user->id);
								$patchImageEntity = $this->Users->patchEntity($imageEntity, $saveImage);
								$users = TableRegistry::get('Users');
								$query = $users->query();
								$query->update()
									->set(['image' => $img_return['name']])
									->where(['id' => $savedid->id])
									->execute();
							}

						} else {

							$data = [
								'status' => 'error',
								'code' => '400',
								'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
								'data' => NULL,
							];
							return $this->apiResponce($data);
						}

					}

					if ($savedid) {
						$usersave = $this->Users->find('all')->where(['id' => $savedid->id])->first();
						//pr($usersave);die('iop');
						$newUserData = $this->Encryption->encryption($usersave);
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Child has been updated',
							'data' => $newUserData,

						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '400',
							'message' => __('Child data could not be updated.'),
							'data' => $user->getErrors(),
						];
					}

				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs'),
						'data' => $user->getErrors(),
					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}

		$this->apiResponce($data);
	}
	//BSO App
	// To Rajan
	// By Rakesh
	public function addChildbso() {
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('mobile_no');
		$this->Users->getValidator()->remove('confirm_password');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');

		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			$userid = $this->UuId->uuid($userinfo['parent_uuid']);
			$childinfo = $this->Users->find('all')->where(['id' => $userid])->first();
			//pr($childinfo);die;
			try {
				$Createddate = date("Y-m-d h:i:sa");
				$user = $this->Users->newEntity();
				$this->loadModel('Schools');
				$school = $this->Schools->newEntity();

				$parentId = $userid;
				$bsoID = $childinfo['bso_id'];
				$bsouuid = $this->Users->find('all')->where(['id' => $bsoID])->first();
				$encryptionKey = md5($bsouuid['uuid']);

				$dobnew = $this->request->getData('dob');

				if ($this->request->getData('relation1') == '3') {
					$relation = $this->request->getData('relation');
				} elseif ($this->request->getData('relation1') == '2') {
					$relation = 'Daughter';
				} elseif ($this->request->getData('relation1') == '1') {
					$relation = 'Son';
				}

				$file = array();
				$imageinfo = $this->request->getData('image');

				if ($imageinfo != '') {
					$file = $this->request->getData('image');
				}

				unset($this->request->data['image']);

				$user = $this->Users->patchEntity($user, $this->request->getData());
				//pr($user);die;
				if (!$user->getErrors()) {

					$schoolspostdata = array(
						'name' => $userinfo['school'],
					);
					$schooldata = $this->Schools->patchEntity($school, $schoolspostdata);

					if ($result = $this->Schools->save($schooldata)) {

						$schoolid = $result['id'];

						$user->created = $Createddate;
						$user->role_id = "5";
						$user->group_id = "5";
						$user->parent_id = $parentId;
						$user->bso_id = $bsoID;
						$user->is_active = '1';
						$user->created = $Createddate;
						$user->relation = $relation;
						$user->dob = $dobnew;
						$user->school = $schoolid;
						$user->uuid = Text::uuid();
						$user->encryptionkey = $encryptionKey;

						$encryptionKey = $user['encryptionkey'];
						$this->Users->encryptData = 'Yes';
						$this->Users->encryptionKey = $encryptionKey;
						$savedid = $this->Users->save($user);
						$regid = $this->Encryption->genrateInvoiceNumber($savedid->id);
						$users = TableRegistry::get('Users');
						$query = $users->query();
						$query->update()
							->set(['registration_id' => $regid])
							->where(['id' => $savedid->id])
							->execute();

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
								$img_return = $this->Utility->saveImageToServer(
									$savedid->uuid,
									$imageArray,
									USER_PICTURE_FOLDER_DIRECTORY_PATH,
									USER_PICTURE_FOLDER_URL_PATH
								);

								if ($img_return['status']) {
									$saveImage['image'] = $img_return['name'];
								}

								$imageEntity = $this->Users->get($savedid->id);
								$patchImageEntity = $this->Users->patchEntity($imageEntity, $saveImage);
								$users = TableRegistry::get('Users');
								$query = $users->query();
								$query->update()
									->set(['image' => $img_return['name']])
									->where(['id' => $savedid->id])
									->execute();
								//$this->Users->save($patchImageEntity);

							} else {
								$data = [
									'status' => 'error',
									'code' => '400',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
								return $this->apiResponce($data);
							}

						}
						$usersave = $this->Users->find('all')->where(['id' => $savedid->id])->first();
						//pr($usersave);die('iop');
						$newUserData = $this->Encryption->encryption($usersave);

						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Child has been created',
							'data' => $newUserData,

						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '400',
							'message' => __('School name not found.'),
							'data' => NULL,
						];
					}

				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs'),
						'data' => $user->getErrors(),
					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}
	//BSO App
	// To Rajan
	// By Rakesh
	public function addParent() {
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('relation1');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is('post')) {
			//pr($this->request->getData());die;
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];

			try {
				$Createddate = date("Y-m-d h:i:sa");
				$user = $this->Users->newEntity();

				$dobnew = $this->request->getData('dob');
				$parentId = $datadecode['data']['user']['id'];
				$bsoID = $datadecode['data']['user']['id'];
				$bsouuid = $datadecode['data']['user']['uuid'];
				$encryptionKey = md5($bsouuid);

				// if ($this->request->getData('relation1') == '3') {
				// 	$relation = $this->request->getData('relation');
				// } elseif ($this->request->getData('relation1') == '2') {
				// 	$relation = 'Daughter';
				// } elseif ($this->request->getData('relation1') == '1') {
				// 	$relation = 'Son';
				// }

				$file = array();
				$file = $this->request->getData('image');
				unset($this->request->data['image']);
				$user = $this->Users->patchEntity($user, $this->request->getData());
				//pr($user);die;
				if (!$user->getErrors()) {
					$user->parent_id = 0;
					$user->bso_id = $bsoID;
					$user->role_id = "4";
					$user->group_id = "4";
					$user->dob = $dobnew;
					$user->is_active = '1';
					// $user->relation = $relation;
					$user->created = $Createddate;
					$user->uuid = Text::uuid();
					$user->encryptionkey = $encryptionKey;

					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					if ($savedid = $this->Users->save($user)) {
						$newUserData = $this->Encryption->encryption($savedid);
						$regid = $this->Encryption->genrateInvoiceNumber($savedid->id);
						$users = TableRegistry::get('Users');
						$query = $users->query();
						$query->update()
							->set(['registration_id' => $regid])
							->where(['id' => $savedid->id])
							->execute();
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
									// $this->Users->save($imageEntity);

								} else {
									$data = [
										'status' => 'error',
										'code' => '403',
										'message' => __('Image did not successfully saved!'),
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '404',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
							}
						}
						$usersave = $this->Users->find('all')->where(['id' => $savedid->id])->first();
						//pr($usersave);die('iop');
						$newUserData = $this->Encryption->encryption($usersave);
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Parent has been created',
							'data' => $newUserData,
						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '408',
							'message' => __('Parent Information Not Saved!'),
							'data' => NULL,
						];
					}
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs!'),
						'data' => $user->getErrors(),
					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token!',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed!'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function decodeToken() {
		if ($this->request->is('post')) {
			$key = jwt_token_key;
			$token = $this->request->header('Authorization');
			$auth_token = $this->getBearerToken($token);
			$datadecode = JWT::decode($auth_token, $key, array('HS256'));
			$userdata = $datadecode->data->user;
			$userinfo = $datadecode->data->user->uuid;

			try {
				$user = $this->Users->find('all')->where(['uuid' => $userinfo])->first();
				$data = [
					'status' => 'sucess',
					'code' => '200',
					'message' => 'Parent Profile',
					'data' => $userdata,

				];
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	public function parentProfileEdit() {
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');
		$datadecode = $this->Auth->user();
		$userdata = $datadecode['data']['user'];
		$userinfo = $datadecode['data']['user']['uuid'];
		if ($this->request->is('post')) {
			try {
				$user = $this->Users->find('all')->where(['uuid' => $userinfo])->first();
				$user = $this->Encryption->encryption($user);
				$encryptionKey = $user['encryptionkey'];
				$Createddate = date("Y-m-d h:i:sa");
				$dobnew = $this->request->getData('dob');
				$file = array();
				$file = $this->request->getData('image');
				unset($this->request->data['image']);
				unset($this->request->data['relation']);
				unset($this->request->data['password']);
				$user = $this->Users->patchEntity($user, $this->request->getData());

				if (!$user->getErrors()) {
					//pr($user);die;
					$user->dob = $dobnew;
					//$user->relation = $relation;
					$user->modified = $Createddate;
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					if ($savedid = $this->Users->save($user)) {
						//pr($savedid);die;
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
									// $this->Users->save($imageEntity);
								} else {
									$data = [
										'status' => 'error',
										'code' => '403',
										'message' => __('Image did not successfully Updated!'),
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '404',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
							}
						}
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Parent Profile has been Updated',
							'data' => Null,
						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '408',
							'message' => __('Parent Profile Information Not Updated!'),
							'data' => NULL,
						];
					}

				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs!'),
						'data' => $user->getErrors(),
					];
				}
				//pr($user);die;
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token!',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}

	/// CHILD API'S

	public function getChildList() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];
			//pr($userdata);die;
			$userinfo = $this->request->getData();
			$parentId = $datadecode['data']['user']['id'];

			$limit = $userinfo['limit'];
			$page = $userinfo['page'];
			$validationError = array();

			if ($limit == '') {
				$validationError['limit'] = ['Limit field is required.'];
			} else if (!is_numeric($limit)) {
				$validationError['limit'] = ['Please enter numeric value of limit.'];
			}
			if ($page == '') {
				$validationError['page'] = ['Page field is required.'];
			} else if (!is_numeric($page)) {
				$validationError['page'] = ['Please enter numeric value of page.'];
			}

			if ($validationError) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Validation error occurs.'),
					'data' => $validationError,
				];
				return $this->apiResponce($data);
			}

			// try {
			$users = $this->Users->find('all', [
				'conditions' => ['parent_id' => $parentId, 'role_id' => 5], 'limit' => $limit,
				'page' => $page, 'order' => [
					'Users.id' => 'DESC',
				],
			])->toArray();
			$newUserData = array();
			foreach ($users as $key => $userdata) {
				$newUserData[] = $this->Encryption->encryption($userdata);

			}
			$query = $this->Users->find('all', [
				'conditions' => ['parent_id' => $parentId, 'role_id' => 5],
			]);
			$number = $query->count();

			if ($users) {
				$usersData = array('totalRedord' => $number, 'client_data' => $users);

				$data = [
					'status' => 'sucess',
					'code' => '200',
					'message' => 'Client List',
					'data' => $newUserData,

				];
			} else {
				$data = [
					'status' => 'error',
					'code' => '200',
					'message' => 'No recode found.',
					'data' => NULL,

				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}

	public function addChild() {
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('mobile_no');
		$this->Users->getValidator()->remove('confirm_password');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');

		if ($this->request->is('post')) {

			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];

			$userinfo = $this->request->getData();

			try {
				$Createddate = date("Y-m-d h:i:sa");
				$user = $this->Users->newEntity();
				$this->loadModel('Schools');
				$school = $this->Schools->newEntity();

				$parentId = $datadecode['data']['user']['id'];
				$bsoID = $datadecode['data']['user']['bso_id'];
				$bsouuid = $this->Users->find('all')->where(['id' => $bsoID])->first();
				$encryptionKey = md5($bsouuid['uuid']);

				$dobnew = $this->request->getData('dob');

				if ($this->request->getData('relation1') == '3') {
					$relation = $this->request->getData('relation');
				} elseif ($this->request->getData('relation1') == '2') {
					$relation = 'Daughter';
				} elseif ($this->request->getData('relation1') == '1') {
					$relation = 'Son';
				}

				$file = array();
				$imageinfo = $this->request->getData('image');

				if ($imageinfo != '') {
					$file = $this->request->getData('image');
				}

				unset($this->request->data['image']);

				$user = $this->Users->patchEntity($user, $this->request->getData());

				if (!$user->getErrors()) {

					$schoolspostdata = array(
						'name' => $userinfo['school'],
					);
					$schooldata = $this->Schools->patchEntity($school, $schoolspostdata);

					if ($result = $this->Schools->save($schooldata)) {

						$schoolid = $result['id'];

						$user->created = $Createddate;
						$user->role_id = "5";
						$user->group_id = "5";
						$user->parent_id = $parentId;
						$user->bso_id = $bsoID;
						$user->is_active = '1';
						$user->created = $Createddate;
						$user->relation = $relation;
						$user->dob = $dobnew;
						$user->school = $schoolid;
						$user->uuid = Text::uuid();
						$user->encryptionkey = $encryptionKey;

						$encryptionKey = $user['encryptionkey'];
						$this->Users->encryptData = 'Yes';
						$this->Users->encryptionKey = $encryptionKey;
						$savedid = $this->Users->save($user);
						$regid = $this->Encryption->genrateInvoiceNumber($savedid->id);
						$users = TableRegistry::get('Users');
						$query = $users->query();
						$query->update()
							->set(['registration_id' => $regid])
							->where(['id' => $savedid->id])
							->execute();

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
								$img_return = $this->Utility->saveImageToServer(
									$savedid->uuid,
									$imageArray,
									USER_PICTURE_FOLDER_DIRECTORY_PATH,
									USER_PICTURE_FOLDER_URL_PATH
								);

								if ($img_return['status']) {
									$saveImage['image'] = $img_return['name'];
								}

								$imageEntity = $this->Users->get($savedid->id);
								$patchImageEntity = $this->Users->patchEntity($imageEntity, $saveImage);
								$users = TableRegistry::get('Users');
								$query = $users->query();
								$query->update()
									->set(['image' => $img_return['name']])
									->where(['id' => $savedid->id])
									->execute();
								//$this->Users->save($patchImageEntity);
							} else {
								$data = [
									'status' => 'error',
									'code' => '400',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
								return $this->apiResponce($data);
							}

						}

						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Child has been created',
							'data' => null,

						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '400',
							'message' => __('School name not found.'),
							'data' => NULL,
						];
					}

				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs'),
						'data' => $user->getErrors(),
					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}

	public function childEdit() {

		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is(['patch', 'post', 'put'])) {
			$userinfo = $this->request->getData();
			try {
				$user = $this->Users->find('all')->where(['uuid' => $userinfo['id']])->first();
				$encryptionKey = $user['encryptionkey'];
				$this->loadModel('Schools');
				$school = $this->Schools->find('all')->where(['name LIKE' => '%' . $userinfo['school'] . '%'])->first();

				if ($school) {
					$schoolId = $school->id;
				} else {
					$school = $this->Schools->newEntity();
					$schoolspostdata = array(
						'name' => $userinfo['school'],
					);
					$schooldata = $this->Schools->patchEntity($school, $schoolspostdata);
					$saveSchool = $this->Schools->save($schooldata);
					$schoolId = $saveSchool['id'];
				}

				$dobnew = $this->request->getData('dob');

				if ($this->request->getData('relation1') == '3') {
					$relation = $this->request->getData('relation');
				} elseif ($this->request->getData('relation1') == '2') {
					$relation = 'Daughter';
				} elseif ($this->request->getData('relation1') == '1') {
					$relation = 'Son';
				}

				$file = array();
				$imageinfo = $this->request->getData('image');

				if ($imageinfo['name'] != '') {
					$file = $this->request->getData('image');
				}

				if ($user->image == '') {
					unset($user->image);
				}

				unset($this->request->data['image']);
				$user = $this->Users->patchEntity($user, $this->request->getData());
				$Createddate = date("Y-m-d h:i:sa");
				$user->modified = $Createddate;
				$user->relation = $relation;
				$user->school = $schoolId;
				$user->dob = $dobnew;

				if (!$user->getErrors()) {

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
								$saveImage['image'] = $img_return['name'];

								$imageEntity = $this->Users->get($user->id);
								$patchImageEntity = $this->Users->patchEntity($imageEntity, $saveImage);
								$users = TableRegistry::get('Users');
								$query = $users->query();
								$query->update()
									->set(['image' => $img_return['name']])
									->where(['id' => $user->id])
									->execute();
							}

						} else {

							$data = [
								'status' => 'error',
								'code' => '400',
								'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
								'data' => NULL,
							];
							return $this->apiResponce($data);
						}

					}

					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					if ($this->Users->save($user)) {

						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Child has been updated',
							'data' => null,

						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '400',
							'message' => __('Child data could not be updated.'),
							'data' => $user->getErrors(),
						];
					}

				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs'),
						'data' => $user->getErrors(),
					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}

		$this->apiResponce($data);
	}
	/// Child Basic Info
	public function addPersonaldata() {
		$this->loadModel('Recptions');
		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->Users->getValidator()->remove('email');
			$this->Users->getValidator()->remove('password');
			$this->Users->getValidator()->remove('mobile_no');
			$this->Users->getValidator()->remove('confirm_password');
			//$this->Users->getValidator()->remove('relation');
			$this->Users->getValidator()->remove('account');
			$this->Users->getValidator()->remove('bank_name');
			$this->Users->getValidator()->remove('gender');
			$this->Users->getValidator()->remove('dob');
			$this->Users->getValidator()->remove('post_code');
			$this->Users->getValidator()->remove('address');
			$this->Users->getValidator()->remove('residence');
			$this->Users->getValidator()->remove('lastname');
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];

			//pr($userdata);die;
			$bso_id = $datadecode['data']['user']['bso_id'];
			$parent_id = $datadecode['data']['user']['id'];
			$userinfo = $this->request->getData();
			$userid = $this->UuId->uuid($userinfo['child_uuid']);
			$child_id = $userid;

			$count = count($this->request->getData(['data']));
			$bsouuid = $this->Users->find('all')->where(['id' => $bso_id])->first();
			$encryptionKey = md5($bsouuid['uuid']);
			$Createddate = date("Y-m-d h:i:sa");
			for ($i = 0; $i < $count; $i++) {
				$user = $this->Users->newEntity();
				$id = $userinfo['data'][$i]['ids'];
				//die;

				if ($userinfo['data'][$i]['ids'] == '-1') {
					$name = $userinfo['data'][$i]['name'];
					$relation1 = $userinfo['data'][$i]['relation1'];
					$relation = $userinfo['data'][$i]['relation'];

					if ($relation1 == 1) {
						$relation = 'Son';
					} elseif ($relation1 == 2) {
						$relation = 'Daughter';
					} elseif ($relation1 == 3) {
						$relation = $userinfo['data'][$i]['relation'];
					}
					$user->firstname = $name;
					$user->created = $Createddate;
					$user->role_id = "4";
					$user->group_id = "4";
					$user->parent_id = $parent_id;
					$user->bso_id = $bso_id;
					$user->relation = $relation;
					$user->uuid = Text::uuid();
					$user->encryptionkey = $encryptionKey;
					//pr($user);die;.
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					$savedid = $this->Users->save($user);
				}
				//$newUserData[] = $this->Encryption->encryption($savedid);
			}
			$count2 = count($userinfo['dataInfo']);
			$recptiondata = $this->Recptions->find('all')->where(['child_id' => $child_id])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('Recptions');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $child_id])
					->execute();

			}

			for ($i = 0; $i < count($userinfo['dataInfo']); $i++) {
				$recption = $this->Recptions->newEntity();
				$recption->ingestion_date = date('Y-m-d', strtotime($userinfo['ingestion_date']));
				$recption->mobile_no = $userinfo['mobile_no'];
				$recption->child_id = $child_id;
				$recption->reception = $userinfo['dataInfo'][$i]['reception'];
				$recption->parent_id = $parent_id;
				$recption->bso_id = $bso_id;
				$recption->reception_date = date('Y-m-d', strtotime($userinfo['dataInfo'][$i]['reception_date']));
				$this->Recptions->encryptData = 'Yes';
				$this->Recptions->encryptionKey = $encryptionKey;
				//$savedreception = $this->Recptions->save($recption);
				if ($savedreception = $this->Recptions->save($recption)) {

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'personal Info Saved Sucessfully',
						'data' => Null,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'personal Info Not Saved Sucessfully.',
						'data' => NULL,

					];
				}

				//pr($userinfo);die('personal info');
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function getPersonaldata() {
		$this->loadModel('Recptions');
		if ($this->request->is(['patch', 'post', 'put'])) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			$userid = $this->UuId->uuid($userinfo['child_uuid']);
			//pr($userid);die;
			$childinfo = $this->Users->find('all')->where(['id' => $userid])->first();
			$childparent = $childinfo['parent_id'];
			$bsoid = $childinfo['bso_id'];
			$encryptionkey = $childinfo['encryptionkey'];
			try {
				$recption = $this->Recptions->find('all')->select(['ingestion_date', 'reception', 'reception_date', 'mobile_no'])->where(['child_id	' => $userid])->hydrate(false)->toArray();
				$guardian = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'relation', 'id', 'encryptionkey'])->where(['parent_id' => $childparent, 'role_id' => '4', 'bso_id' => $bsoid])->hydrate(false)->toArray();
				$data = array();
				$dataInfo = array();
				$newrecptionData = array();
				$finalData = array();
				$newUserData = array();
				foreach ($guardian as $key => $guardiandata) {
					$newUserData[] = $this->Encryption->encryption($guardiandata);
					//pr($newUserData);die;
					if ($newUserData[$key]['relation'] == 'Son') {
						$relation1 = 1;
					} elseif ($newUserData[$key]['relation'] == 'Daughter') {
						$relation1 = 2;
					} else {
						$relation1 = 3;
					}
					$data[] = array(
						"name" => $newUserData[$key]['firstname'] . ' ' . $newUserData[$key]['lastname'],
						"relation1" => $relation1,
						"ids" => $newUserData[$key]['id'],
						"relation" => $newUserData[$key]['relation'],
					);
				}
				//pr($data);die;

				foreach ($recption as $key => $recptiondata) {
					$recptiondata['encryptionkey'] = $encryptionkey;
					$newrecptionData[] = $this->Encryption->encryption($recptiondata);

					$dataInfo[] = array(
						"reception" => $newrecptionData[$key]['reception'],
						"reception_date" => $newrecptionData[$key]['reception_date'],
					);

				}
				//pr($dataInfo);die;
				//pr($newrecptionData);die;
				if (empty($newrecptionData)) {

					$newrecptionData[] = array(
						"reception" => null,
						"reception_date" => null,
					);
					$finalData = array(
						"data" => $data,
						"dataInfo" => $newrecptionData,
						"ingestion_date" => null,
						"mobile_no" => null,
					);
				} else {
					$finalData = array(
						"data" => $data,
						"dataInfo" => $dataInfo,
						"ingestion_date" => $newrecptionData[0]['ingestion_date'],
						"mobile_no" => $newrecptionData[0]['mobile_no'],
					);

				}

				//pr($finalData);die;
				if ($guardian) {
					//$usersData = array('totalRedord' => $number, 'client_data' => $users);

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Personal Info List',
						'data' => $finalData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}

				//pr($recption);die;
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	public function addSocialbehavior() {
		$this->loadModel('BehaviorandSocials');
		$savedBehaviorandSocial = array("failed");
		if ($this->request->is(['patch', 'post', 'put'])) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			$user = $this->Users->find('all')->where(['uuid' => $userinfo['child_uuid']])->first();
			$bso_id = $user['bso_id'];
			$bsouuid = $this->Users->find('all')->where(['id' => $bso_id])->first();
			$encryptionKey = md5($bsouuid['uuid']);
			$userid = $this->UuId->uuid($userinfo['child_uuid']);
			$BehaviorSocial = $this->BehaviorandSocials->find('all')->where(['child_id' => $userinfo['child_uuid']])->first();
			//pr($BehaviorSocial);die;
			if (!empty($BehaviorSocial)) {
				$BehaviorandSocials = TableRegistry::get('BehaviorandSocials');
				$query = $BehaviorandSocials->query();
				$query->delete()
					->where(['child_id' => $userinfo['child_uuid']])
					->execute();
			}
			$BehaviorandSocial = $this->BehaviorandSocials->newEntity();
			$BehaviorandSocial->childlike = $userinfo['childlike'];

			if ($userinfo['group5'] == 2) {
				$BehaviorandSocial->childlike = "2";
			} elseif ($userinfo['group5'] == 1) {
				$BehaviorandSocial->childlike = "1";
			}

			$BehaviorandSocial->childprefer = $userinfo['childprefer'];
			$BehaviorandSocial->childbusy = $userinfo['childbusy'];

			if ($userinfo['allergy'] == 2) {
				$BehaviorandSocial->childbusy = "2";
			} elseif ($userinfo['allergy'] == 1) {
				$BehaviorandSocial->childbusy = "1";
			}

			$BehaviorandSocial->childhappypeers = $userinfo['childhappypeers'];
			$BehaviorandSocial->childhavebfgif = $userinfo['childhavebfgif'];
			$BehaviorandSocial->childhappybrothersis = $userinfo['childhappybrothersis'];
			$BehaviorandSocial->childhappyparent = $userinfo['childhappyparent'];
			$BehaviorandSocial->childmove = $userinfo['childmove'];
			$BehaviorandSocial->childargue = $userinfo['childargue'];
			$BehaviorandSocial->child_id = $userinfo['child_uuid'];
			$BehaviorandSocial->childinterest_otherchildern = $userinfo['childinterest_otherchildern'];

			if ($userinfo['argue'] == 2) {
				$BehaviorandSocial->childargue = "2";
			} elseif ($userinfo['argue'] == 1) {
				$BehaviorandSocial->childargue = "1";
			}
			if (!$BehaviorandSocial->getErrors()) {
				$savedBehaviorandSocial = $this->BehaviorandSocials->save($BehaviorandSocial);
				$data = [
					'status' => 'sucess',
					'code' => '200',
					'message' => 'Social behavior Info Saved Sucessfully',
					'data' => Null,

				];
			} else {
				$data = [
					'status' => 'error',
					'code' => '200',
					'message' => 'Social behavior Info Not Saved Sucessfully.',
					'data' => NULL,

				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function getSocialbehavior() {
		$this->loadModel('BehaviorandSocials');
		if ($this->request->is(['patch', 'post', 'put'])) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			$group5 = 2;
			$allergy = 2;
			$argue = 2;
			try {
				$BehaviorandSocials = $this->BehaviorandSocials->find('all')->where(['child_id' => $userinfo['child_uuid']])->hydrate(false)->first();
				//pr($BehaviorandSocials);die;
				if ($BehaviorandSocials['childlike'] == '') {
					$group5 = '';
				} elseif ($BehaviorandSocials['childlike'] != $group5) {
					$group5 = 1;
				}
				if ($BehaviorandSocials['childbusy'] == '') {
					$allergy = '';
				} elseif ($BehaviorandSocials['childbusy'] != $allergy) {
					$allergy = 1;
				}
				if ($BehaviorandSocials['childargue'] == '') {
					$argue = '';
				} elseif ($BehaviorandSocials['childargue'] != $argue) {
					$argue = 1;
				}

				$finalData = array(
					"group5" => $group5,
					"childlike" => $BehaviorandSocials['childlike'],
					"childprefer" => $BehaviorandSocials['childprefer'],
					"allergy" => $allergy,
					"childbusy" => $BehaviorandSocials['childbusy'],
					"childinterest_otherchildern" => $BehaviorandSocials['childinterest_otherchildern'],
					"childhappypeers" => $BehaviorandSocials['childhappypeers'],
					"childhavebfgif" => $BehaviorandSocials['childhavebfgif'],
					"childhappybrothersis" => $BehaviorandSocials['childhappybrothersis'],
					"childhappyparent" => $BehaviorandSocials['childhappyparent'],
					"childmove" => $BehaviorandSocials['childmove'],
					"argue" => $argue,
					"childargue" => $BehaviorandSocials['childargue'],

				);
				//pr($finalData);die;
				if ($BehaviorandSocials) {
					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Social Behavior Info of Child',
						'data' => $finalData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	public function addmedicalemotional() {
		$this->loadModel('MedicalEmotionals');
		if ($this->request->is(['patch', 'post', 'put'])) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			//pr($userinfo);die;
			$child_id = $userinfo['child_uuid'];
			try {
				$medicalemotional = $this->MedicalEmotionals->find('all')->where(['child_id' => $child_id])->first();
				if (!empty($medicalemotional)) {
					$medical = TableRegistry::get('MedicalEmotionals');
					$query = $medical->query();
					$query->delete()
						->where(['child_id' => $child_id])
						->execute();
				}

				$MedicalEmotional = $this->MedicalEmotionals->newEntity();
				$MedicalEmotional->specialdiseases = $userinfo['specialdiseases'];

				if ($userinfo['group15'] == 2) {
					$MedicalEmotional->specialdiseases = "2";
				} elseif ($userinfo['group15'] == 1) {
					$MedicalEmotional->specialdiseases = "1";
				}

				$MedicalEmotional->allergies = $userinfo['allergies'];

				if ($userinfo['group16'] == 2) {
					$MedicalEmotional->allergies = "2";
				} elseif ($userinfo['group16'] == 1) {
					$MedicalEmotional->allergies = "1";
				}

				$MedicalEmotional->senses = $userinfo['senses'];

				if ($userinfo['group17'] == 2) {
					$MedicalEmotional->senses = "2";
				} elseif ($userinfo['group17'] == 1) {
					$MedicalEmotional->senses = "1";
				}

				$MedicalEmotional->motordevelopment = $userinfo['motordevelopment'];
				$MedicalEmotional->childsick = $userinfo['childsick'];
				$MedicalEmotional->differentemotions = $userinfo['differentemotions'];
				$MedicalEmotional->anxiety = $userinfo['anxiety'];
				$MedicalEmotional->blijheid = $userinfo['blijheid'];
				$MedicalEmotional->boosheid = $userinfo['boosheid'];
				$MedicalEmotional->verdriet = $userinfo['verdriet'];
				$MedicalEmotional->child_id = $child_id;
				//	pr($MedicalEmotional);die;
				if (!$MedicalEmotional->getErrors()) {
					if ($savedMedicalEmotional = $this->MedicalEmotionals->save($MedicalEmotional)) {

						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'medicalemotional Info Saved Sucessfully',
							'data' => Null,

						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '200',
							'message' => 'medicalemotional Info Not Saved Sucessfully.',
							'data' => NULL,

						];
					}

					//pr($userinfo);die('personal info');
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'Social behavior Info Not Saved Sucessfully.',
						'data' => NULL,

					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}
	public function getmedicalemotional() {
		$this->loadModel('MedicalEmotionals');
		if ($this->request->is(['patch', 'post', 'put'])) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();

			$group15 = 2;
			$group16 = 2;
			$group17 = 2;
			try {
				$MedicalEmotionals = $this->MedicalEmotionals->find('all')->where(['child_id' => $userinfo['child_uuid']])->hydrate(false)->first();
				//pr($MedicalEmotionals);die;

				if ($MedicalEmotionals['specialdiseases'] == '') {
					$group15 = '';
				} elseif ($MedicalEmotionals['specialdiseases'] != $group15) {
					$group15 = 1;
				}
				if ($MedicalEmotionals['allergies'] == '') {
					$group16 = '';
				} elseif ($MedicalEmotionals['allergies'] != $group15) {
					$group16 = 1;
				}
				if ($MedicalEmotionals['senses'] == '') {
					$group17 = '';
				} elseif ($MedicalEmotionals['senses'] != $group15) {
					$group17 = 1;
				}

				$finalData = array(
					"group15" => $group15,
					"specialdiseases" => $MedicalEmotionals['specialdiseases'],
					"group16" => $group16,
					"allergies" => $MedicalEmotionals['allergies'],
					"group17" => $group17,
					"senses" => $MedicalEmotionals['senses'],
					"motordevelopment" => $MedicalEmotionals['motordevelopment'],
					"childsick" => $MedicalEmotionals['childsick'],
					"differentemotions" => $MedicalEmotionals['differentemotions'],
					"anxiety" => $MedicalEmotionals['anxiety'],
					"blijheid" => $MedicalEmotionals['blijheid'],
					"boosheid" => $MedicalEmotionals['boosheid'],
					"verdriet" => $MedicalEmotionals['verdriet'],

				);
				//pr($finalData);die;
				if ($MedicalEmotionals) {
					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Social Behavior Info of Child',
						'data' => $finalData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function addeducationallanguage() {
		$this->loadModel('EducationalLanguages');
		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($this->request->getData());die;
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			$child_id = $userinfo['child_uuid'];

			try {
				$EducationalLanguages = $this->EducationalLanguages->find('all')->where(['child_id' => $child_id])->first();

				if (!empty($EducationalLanguages)) {
					$Educational = TableRegistry::get('EducationalLanguages');
					$query = $Educational->query();
					$query->delete()
						->where(['child_id' => $child_id])
						->execute();

				}
				$EducationalLanguage = $this->EducationalLanguages->newEntity();
				$EducationalLanguage->upbringing = $userinfo['upbringing'];
				$EducationalLanguage->childunderstandable = $userinfo['childunderstandable'];
				$EducationalLanguage->childalwaysunderstand = $userinfo['childalwaysunderstand'];

				if ($userinfo['group23'] == 2) {
					$EducationalLanguage->childalwaysunderstand = "2";
				} elseif ($userinfo['group23'] == 1) {
					$EducationalLanguage->childalwaysunderstand = "1";
				}

				$EducationalLanguage->enoughvocabulary = $userinfo['enoughvocabulary'];
				$EducationalLanguage->childspeakeasily = $userinfo['childspeakeasily'];
				$EducationalLanguage->stutteryourchild = $userinfo['stutteryourchild'];
				$EducationalLanguage->child_id = $child_id;

				if (!$EducationalLanguage->getErrors()) {
					$savedEducationalLanguage = $this->EducationalLanguages->save($EducationalLanguage);
					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Educational and Languages Info of Child Saved Sucessfully',
						'data' => NULL,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'Educational and Languages Info Not Saved Sucessfully.',
						'data' => NULL,

					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function geteducationallanguage() {
		$this->loadModel('EducationalLanguages');
		if ($this->request->is(['patch', 'post', 'put'])) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			$group23 = 2;
			try {
				$EducationalLanguages = $this->EducationalLanguages->find('all')->where(['child_id' => $userinfo['child_uuid']])->hydrate(false)->first();
				//pr($EducationalLanguages);die;
				if ($EducationalLanguages['childalwaysunderstand'] == '') {
					$group23 = '';
				} elseif ($EducationalLanguages['childalwaysunderstand'] != $group23) {
					$group23 = 1;
				}

				$finalData = array(
					"upbringing" => $EducationalLanguages['upbringing'],
					"group23" => $group23,
					"childalwaysunderstand" => $EducationalLanguages['childalwaysunderstand'],
					"childunderstandable" => $EducationalLanguages['childunderstandable'],
					"enoughvocabulary" => $EducationalLanguages['enoughvocabulary'],
					"childspeakeasily" => $EducationalLanguages['childspeakeasily'],
					"stutteryourchild" => $EducationalLanguages['stutteryourchild'],

				);
				//pr($finalData);die;
				if ($EducationalLanguages) {
					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Social Behavior Info of Child',
						'data' => $finalData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function addotherinformation() {
		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('Otherinformations');
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			$child_id = $userinfo['child_uuid'];
			//pr($userinfo);die;
			try {
				$Otherinformation = $this->Otherinformations->find('all')->where(['child_id' => $child_id])->first();
				//pr($Otherinformations);die;
				if (!empty($Otherinformation)) {
					$recptions = TableRegistry::get('Otherinformations');
					$query = $recptions->query();
					$query->delete()
						->where(['child_id' => $child_id])
						->execute();

				}
				$Otherinformation = $this->Otherinformations->newEntity();

				$Otherinformation->additionalinformation = $userinfo['additionalinformation'];

				if ($userinfo['group29'] == 2) {
					$Otherinformation->additionalinformation = "2";
				} elseif ($userinfo['group29'] == 1) {
					$Otherinformation->additionalinformation = "1";
				}

				$Otherinformation->whomwithchild_likestoplay = $userinfo['whomwithchild_likestoplay'];

				if ($userinfo['group30'] == 2) {
					$Otherinformation->whomwithchild_likestoplay = "2";
				} elseif ($userinfo['group30'] == 1) {
					$Otherinformation->whomwithchild_likestoplay = "1";
				}

				$Otherinformation->contactwithschool = $userinfo['contactwithschool'];

				if ($userinfo['group31'] == 2) {
					$Otherinformation->contactwithschool = "2";
				} elseif ($userinfo['group31'] == 1) {
					$Otherinformation->contactwithschool = "1";
				}
				$Otherinformation->nationality_child = $userinfo['nationality_child'];
				$Otherinformation->socmed_indicatie = $userinfo['socmed_indicatie'];
				$Otherinformation->general_practitioner = $userinfo['general_practitioner'];
				$Otherinformation->dentist = $userinfo['dentist'];
				$Otherinformation->wantto_gobso = $userinfo['wantto_gobso'];
				$Otherinformation->visitaplayroom = $userinfo['visitaplayroom'];
				$Otherinformation->seeatransfer = $userinfo['seeatransfer'];
				$Otherinformation->parentsexpect = $userinfo['parentsexpect'];
				$Otherinformation->child_id = $child_id;
				//pr($Otherinformation);die;
				if (!$Otherinformation->getErrors()) {
					$savedOtherinformation = $this->Otherinformations->save($Otherinformation);
					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Otherinformation of Child Saved Sucessfully',
						'data' => NULL,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'Otherinformation Not Saved Sucessfully.',
						'data' => NULL,

					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	public function getotherinformation() {
		$this->loadModel('Otherinformations');
		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($this->request->getData());die;
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $this->request->getData();
			$child_id = $userinfo['child_uuid'];
			$group29 = 2;
			$group30 = 2;
			$group31 = 2;
			try {
				$Otherinformation = $this->Otherinformations->find('all')->where(['child_id' => $child_id])->hydrate(false)->first();
				//pr($Otherinformation);die;
				if ($Otherinformation['additionalinformation'] == '') {
					$group29 = '';
				} elseif ($Otherinformation['additionalinformation'] != $group29) {
					$group29 = 1;
				}
				if ($Otherinformation['whomwithchild_likestoplay'] == '') {
					$group30 = '';
				} elseif ($Otherinformation['whomwithchild_likestoplay'] != $group30) {
					$group30 = 1;
				}
				if ($Otherinformation['contactwithschool'] == '') {
					$group31 = '';
				} elseif ($Otherinformation['contactwithschool'] != $group31) {
					$group31 = 1;
				}

				$finalData = array(
					"nationality_child" => $Otherinformation['nationality_child'],
					"socmed_indicatie" => $Otherinformation['socmed_indicatie'],
					"general_practitioner" => $Otherinformation['general_practitioner'],
					"dentist" => $Otherinformation['dentist'],
					"wantto_gobso" => $Otherinformation['wantto_gobso'],
					"seeatransfer" => $Otherinformation['seeatransfer'],
					"visitaplayroom" => $Otherinformation['visitaplayroom'],
					"group29" => $group29,
					"additionalinformation" => $Otherinformation['additionalinformation'],
					"group30" => $group30,
					"whomwithchild_likestoplay" => $Otherinformation['whomwithchild_likestoplay'],
					"group31" => $group31,
					"contactwithschool" => $Otherinformation['contactwithschool'],
					"parentsexpect" => $Otherinformation['parentsexpect'],

				);
				//pr($finalData);die;
				if ($Otherinformation) {
					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Other Informations of Child',
						'data' => $finalData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => $e->getMessage(),
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	/// Guardian API'S
	public function getGuardianList() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			//pr($datadecode);die;
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];
			$bso_id = $datadecode['data']['user']['bso_id'];
			$userinfo = $this->request->getData();
			$parentId = $datadecode['data']['user']['id'];
			$limit = $userinfo['limit'];
			$page = $userinfo['page'];
			$validationError = array();

			if ($limit == '') {
				$validationError['limit'] = ['Limit field is required.'];
			} else if (!is_numeric($limit)) {
				$validationError['limit'] = ['Please enter numeric value of limit.'];
			}
			if ($page == '') {
				$validationError['page'] = ['Page field is required.'];
			} else if (!is_numeric($page)) {
				$validationError['page'] = ['Please enter numeric value of page.'];
			}

			if ($validationError) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Validation error occurs!.'),
					'data' => $validationError,
				];
				return $this->apiResponce($data);
			}

			try {

				$users = $this->Users->find('all', [
					'conditions' => ['parent_id' => $parentId, 'role_id' => 4, 'bso_id' => $bso_id], 'limit' => $limit,
					'page' => $page, 'order' => [
						'Users.id' => 'DESC',
					],
				])->toArray();
				$newUserData = array();
				foreach ($users as $key => $userdata) {
					$newUserData[] = $this->Encryption->encryption($userdata);

				}

				$query = $this->Users->find('all', [
					'conditions' => ['parent_id' => $parentId, 'role_id' => 4],
				]);
				$number = $query->count();

				if ($users) {
					$usersData = array('totalRedord' => $number, 'client_data' => $users);

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Guardian List',
						'data' => $newUserData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}

	public function addGuardian() {
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is('post')) {

			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];

			try {
				$Createddate = date("Y-m-d h:i:sa");
				$user = $this->Users->newEntity();

				$dobnew = $this->request->getData('dob');
				$parentId = $datadecode['data']['user']['id'];
				$bsoID = $datadecode['data']['user']['bso_id'];
				$bsouuid = $datadecode['data']['user']['uuid'];
				$encryptionKey = md5($bsouuid);

				if ($this->request->getData('relation1') == '3') {
					$relation = $this->request->getData('relation');
				} elseif ($this->request->getData('relation1') == '2') {
					$relation = 'Daughter';
				} elseif ($this->request->getData('relation1') == '1') {
					$relation = 'Son';
				}

				$file = array();
				$file = $this->request->getData('image');
				unset($this->request->data['image']);
				$user = $this->Users->patchEntity($user, $this->request->getData());

				if (!$user->getErrors()) {
					$user->parent_id = $parentId;
					$user->bso_id = $bsoID;
					$user->role_id = "4";
					$user->group_id = "4";
					$user->dob = $dobnew;
					$user->is_active = '1';
					$user->relation = $relation;
					$user->created = $Createddate;
					$user->uuid = Text::uuid();
					$user->encryptionkey = $encryptionKey;

					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					if ($savedid = $this->Users->save($user)) {
						$regid = $this->Encryption->genrateInvoiceNumber($savedid->id);
						$users = TableRegistry::get('Users');
						$query = $users->query();
						$query->update()
							->set(['registration_id' => $regid])
							->where(['id' => $savedid->id])
							->execute();
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
									// $this->Users->save($imageEntity);
								} else {
									$data = [
										'status' => 'error',
										'code' => '403',
										'message' => __('Image did not successfully saved!'),
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '404',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
							}
						}
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Guardian has been created',
							'data' => null,
						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '408',
							'message' => __('Guardian Information Not Saved!'),
							'data' => NULL,
						];
					}
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs!'),
						'data' => $user->getErrors(),
					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token!',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed!'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function guardianEdit() {
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');
		if ($this->request->is(['patch', 'post', 'put'])) {

			//Posted  data
			$user_data = $this->request->getData();
			try {
				$user = $this->Users->find('all')->where(['uuid' => $user_data['id']])->first();
				$encryptionKey = $user['encryptionkey'];
				$Createddate = date("Y-m-d h:i:sa");
				$dobnew = $this->request->getData('dob');

				if ($this->request->getData('relation1') == '3') {
					$relation = $this->request->getData('relation');
				} elseif ($this->request->getData('relation1') == '2') {
					$relation = 'Daughter';
				} elseif ($this->request->getData('relation1') == '1') {
					$relation = 'Son';
				}

				$file = array();
				$file = $this->request->getData('image');
				unset($this->request->data['image']);
				// $user->lastname = base64_decode($user['lastname']);
				// $user->firstname = base64_decode($user['firstname']);
				// $user->email = base64_decode($user['email']);
				// $user->mobile_no = base64_decode($user['mobile_no']);
				$user = $this->Users->patchEntity($user, $this->request->getData());
				if (!$user->getErrors()) {

					$user->dob = $dobnew;
					$user->relation = $relation;
					$user->modified = $Createddate;
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;

					if ($savedid = $this->Users->save($user)) {

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
									// $this->Users->save($imageEntity);
								} else {
									$data = [
										'status' => 'error',
										'code' => '403',
										'message' => __('Image did not successfully Updated!'),
										'data' => NULL,
									];
								}
							} else {
								$data = [
									'status' => 'error',
									'code' => '404',
									'message' => __('Only allowed (jpg,jpeg,png) file type image..'),
									'data' => NULL,
								];
							}
						}
						$data = [
							'status' => 'sucess',
							'code' => '200',
							'message' => 'Guardian has been Updated',
							'data' => null,
						];
					} else {
						$data = [
							'status' => 'error',
							'code' => '408',
							'message' => __('Guardian Information Not Updated!'),
							'data' => NULL,
						];
					}
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => __('Form validation error occurs!'),
						'data' => $user->getErrors(),
					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token!',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed!'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function deleteUser() {
		if ($this->request->is(['patch', 'post', 'put'])) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$user_data = $this->request->getData();
			//pr($user_data);die;
			try {
				$userid = $this->UuId->uuid($user_data['id']);
				$user = $this->Users->get($userid);

				if ($this->Users->delete($user)) {
					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'User delete sucessfully',
						'data' => Null,
					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => 'User can not delete!',
						'data' => NULL,
					];
				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token!',
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed!'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}
	public function guardianActivate() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];

			$usergetdata = $this->request->getData();
			$userid = $this->UuId->uuid($usergetdata['id']);

			try {
				$user = $this->Users->find('all')->where(['uuid' => $userinfo])->first();
				if ($user) {

					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['is_active' => 1])
						->where(['id' => $userid])
						->execute();

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Guardian Activate sucessfully',
						'data' => NULL,

					];

				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function guardianDeactivate() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];
			$usergetdata = $this->request->getData();
			$userid = $this->UuId->uuid($usergetdata['id']);

			try {
				$user = $this->Users->find('all')->where(['uuid' => $userinfo])->first();
				if ($user) {

					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['is_active' => 0])
						->where(['id' => $userid])
						->execute();

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Guardian Deactivate sucessfully',
						'data' => NULL,

					];

				}
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}
		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function jwtdecode() {
		$key = jwt_token_key;
		if ($this->request->is('post')) {

			$userinfo = $this->request->getData();
			$jwt = $userinfo['token'];

			try {
				$datadecode = JWT::decode($jwt, $key, array('HS256'));

				$data = [
					'status' => 'sucess',
					'code' => '200',
					'message' => 'User  Sucessfully',
					'data' => $datadecode,

				];
			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}

		}
		$this->apiResponce($data);

	}
	//   Check IN/OUT API'S
	public function attendance() {
		if ($this->request->is('post')) {
			//pr($this->request->getData());die;
			$this->loadModel('Attendances');
			$this->loadModel('Settings');
			$this->loadModel('Contracts');
			$datadecode = $this->Auth->user();
			$days = ['Sunday' => 'zondag', 'Monday' => 'maandag', 'Tuesday' => 'dinsdag', 'Wednesday' => 'woensdag', 'Thursday' => 'donderdag', 'Friday' => 'vrijdag', 'Saturday' => 'zaterdag'];
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];
			$bso_id = $datadecode['data']['user']['id'];
			$Createddate = /*date("Y-m-d h:i:sa")*/'2018-12-18 11:30:35';
			//pr($Createddate);die;
			$currenttime = strtotime(date("h:i:s"));
			$Createddate;
			$dateday = date('l', strtotime($Createddate));
			//die;
			$days[$dateday];
			$userinfo = $this->request->getData();
			$user_id = $this->UuId->uuid($userinfo['user_uuid']);
			$Contracts = $this->Contracts->find('all')->where(['child_id' => $user_id, 'service_day' => $days[$dateday]])->toArray();
			//pr($Contracts);die;
			$Settings = $this->Settings->find('all')->where(['bso_id' => $bso_id])->first();
			$attendance_relif_time = $Settings['attendance_relif_time'];
			$attendance = $this->Attendances->newEntity();
			$attendance = $this->Attendances->patchEntity($attendance, $this->request->getData());

			if (!empty($Contracts)) {
				//pr($Contracts);die;
				foreach ($Contracts as $key => $value) {

					$end_time = date('h:i:s', strtotime($value['end_time']));
					$planend_time = strtotime(date($end_time));
					if ($planend_time <= $currenttime) {

						if (!$attendance->getErrors()) {
							$attendance->user_id = $user_id;
							$attendance->date_time = $Createddate;
							$attendance->bso_id = $bso_id;
							$attendance->contract_id = $value['id'];
							if ($savedid = $this->Attendances->save($attendance)) {
								$data = [
									'status' => 'sucess',
									'code' => '200',
									'message' => 'Attendances has been saved',
									'data' => NULL,
								];
							}
						} else {
							$data = [
								'status' => 'error',
								'code' => '400',
								'message' => __('Form validation error occurs!'),
								'data' => $user->getErrors(),
							];
						}
					} else {
						$data = [
							'status' => 'error',
							'code' => '418',
							'message' => __('User has not buy any plan for this time!'),
							'data' => NULL,
						];
					}

				}
			} else {
				$data = [
					'status' => 'error',
					'code' => '418',
					'message' => __('User has not buy any plan for Today!'),
					'data' => NULL,
				];
			}

			// } catch (\Exception $e) {
			// 	$data = [
			// 		'status' => 'error',
			// 		'code' => '401',
			// 		'message' => 'Invalid token!',
			// 		'data' => NULL,
			// 	];
			// }

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed!'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function getAttendanceStatus() {
		if ($this->request->is('post')) {
			$this->loadModel('Attendances');
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$userinfo = $datadecode['data']['user']['uuid'];
			$bso_id = $datadecode['data']['user']['id']; //pr($datadecode);die;
			$userinfo = $this->request->getData();
			$user_id = $this->UuId->uuid($userinfo['user_uuid']);
			$userdatainfo = $this->Users->find('all')->where(['id' => $user_id])->first();
			$newUserData = $this->Encryption->encryption($userdatainfo);
			//$userinfo['user_uuid']
			$Auth_status = 'Null';
			$Break_status = 'Null';
			$Lunch_status = 'Null';
			$Createddate = date("Y-m-d h:i:sa");
			$users = array();

			$validationError = array();

			if ($user_id == '') {
				$validationError['user_id'] = ['Limit field is required.'];
			} else if (!is_numeric($user_id)) {
				$validationError['user_id'] = ['Please enter numeric value of limit.'];
			}
			if ($validationError) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Validation error occurs!.'),
					'data' => $validationError,
				];
				return $this->apiResponce($data);
			}

			try {
				$Auth_status = $this->Attendances->find('all', [
					'conditions' => ['type' => 'Auth', 'user_id' => $user_id, 'bso_id' => $bso_id, 'date_time >=' => date('Y-m-d')],
					'order' => [
						'id' => 'DESC',
					],
				])->hydrate(false)->first();

				$Break_status = $this->Attendances->find('all', [
					'conditions' => ['type' => 'Break', 'user_id' => $user_id, 'bso_id' => $bso_id, 'date_time >=' => date('Y-m-d')],
					'order' => [
						'id' => 'DESC',
					],
				])->hydrate(false)->first();

				$Lunch_status = $this->Attendances->find('all', [
					'conditions' => ['type' => 'Lunch', 'user_id' => $user_id, 'bso_id' => $bso_id, 'date_time >=' => date('Y-m-d')],
					'order' => [
						'id' => 'DESC',
					],
				])->hydrate(false)->first();

				//pr($Auth);

				$users = array(
					'Auth' => $Auth_status,
					'Break' => $Break_status,
					'Lunch' => $Lunch_status,
					'user_info' => $newUserData,
				);

				if ($users) {
					//$usersData = array('totalRedord' => $number, 'client_data' => $users);

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'User Attendance Status',
						'data' => $users,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '200',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}
	//BSO App -Employees Section
	// 21 01 2019
	// To Rajan
	// By Rakesh
	public function getEmployeeList() {
		if ($this->request->is('post')) {
			$datadecode = $this->Auth->user();
			$userdata = $datadecode['data']['user'];
			$bso_id = $userdata['id'];
			$userinfo = $this->request->getData();
			$limit = $userinfo['limit'];
			$page = $userinfo['page'];
			$validationError = array();

			if ($limit == '') {
				$validationError['limit'] = ['Limit field is required.'];
			} else if (!is_numeric($limit)) {
				$validationError['limit'] = ['Please enter numeric value of limit.'];
			}
			if ($page == '') {
				$validationError['page'] = ['Page field is required.'];
			} else if (!is_numeric($page)) {
				$validationError['page'] = ['Please enter numeric value of page.'];
			}

			if ($validationError) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => __('Validation error occurs!.'),
					'data' => $validationError,
				];
				return $this->apiResponce($data);
			}
			try {

				$users = $this->Users->find('all', [
					'conditions' => [
						'role_id' => 3,
						'bso_id' => $bso_id,
						'parent_id' => '0',
					], 'limit' => $limit,
					'page' => $page,
					'order' => [
						'Users.id' => 'DESC',
					],
				])->hydrate(false)->toArray();

				$newUserData = array();
				foreach ($users as $key => $userdata) {
					$newUserData[] = $this->Encryption->encryption($userdata);

				}
				//	pr($newUserData);die;
				if ($users) {
					$usersData = array('client_data' => $users);

					$data = [
						'status' => 'sucess',
						'code' => '200',
						'message' => 'Employee List',
						'data' => $newUserData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '405',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '401',
					'message' => 'Invalid token',
					'data' => NULL,
				];
			}

		} else {
			$data = [
				'status' => 'error',
				'code' => '402',
				'message' => __('Method not allowed'),
				'data' => NULL,
			];
		}
		$this->apiResponce($data);

	}
	// End Employee Section
	public function view($id) {
		$users = $this->Users->get($id);
		$this->set([
			'users' => $users,
			'_serialize' => ['users'],
		]);
	}

	public function add() {
		$users = $this->Users->newEntity($this->request->getData());
		if ($this->Users->save($users)) {
			$message = 'Saved';
		} else {
			$message = 'Error';
		}
		$this->set([
			'message' => $message,
			'users' => $users,
			'_serialize' => ['message', 'users'],
		]);
	}

	public function edit($id) {
		$users = $this->Users->get($id);
		if ($this->request->is(['post', 'put'])) {
			$users = $this->Users->patchEntity($users, $this->request->getData());
			if ($this->Users->save($users)) {
				$message = 'Saved';
			} else {
				$message = 'Error';
			}
		}
		$this->set([
			'message' => $message,
			'_serialize' => ['message'],
		]);
	}

	public function delete($id) {
		$users = $this->Users->get($id);
		$message = 'Deleted';
		if (!$this->Users->delete($users)) {
			$message = 'Error';
		}
		$this->set([
			'message' => $message,
			'_serialize' => ['message'],
		]);
	}
}