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
		$this->Auth->allow(['login', 'logout']);
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
					$user = $this->Auth->identify();
					if ($user) {
						if ($user['is_active'] == 1) {
							if ($user['role_id'] == '3' || $user['role_id'] == '4') {
								$this->loadComponent('JwtToken');
								$user_id = $user['id'];
								if ($user = $this->JwtToken->jwt($user)) {
									$users = $this->Users->get($user_id);
									$users->token = $user;
									$this->Users->getValidator()->remove('email');
									if ($this->Users->save($users)) {
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
		if ($this->request->is('post')) {
			if (array_key_exists('email', $this->request->getData())) {
				$userEmail = $this->request->getdata('email');
				$usersTable = TableRegistry::get('Users');

				$users = $usersTable
					->find()
					->where([
						'email' => $userEmail,
					])
					->first();

				if ($users) {
					$link = sha1($users->email) . rand();
					$newLink = $usersTable->get($users->id);
					$newLink->activation_link = $link;
					if ($usersTable->save($newLink)) {
						$link = BASE_URL . 'users/updatePassword/' . base64_encode($link . '_' . rand());

						$message = 'To update your password <a href="' . $link . '">click here</a>';
						$to = $userEmail;
						$from = FROM_EMAIL;
						$title = 'Kind Planner';
						$subject = 'Change Password';

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
				'code' => '400',
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
										->set(['password' => $updatePassword])
										->where(['token' => $auth_token])
										->execute();

									$message = 'Your Password Has Been Changed' . '<br/>';
									$message .= 'Your Password:' . '' . $confirm_password . '<br/>';
									$to = $users['email'];
									$from = FROM_EMAIL;
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
				'code' => '400',
				'message' => 'Invalid request method, use POST Only',
				'data' => NULL,
			];
		}
		$this->apiResponce($data);
	}

	public function getChildList() {
		if ($this->request->is('post')) {
			$key = jwt_token_key;
			$token = $this->request->header('Authorization');
			$auth_token = $this->getBearerToken($token);
			$datadecode = JWT::decode($auth_token, $key, array('HS256'));

			$userinfo = $this->request->getData();
			$parentId = $datadecode->data->user->id;
			$limit = $userinfo['limit'];
			$page = $userinfo['page'];

			try {

				$this->paginate = [
					'limit' => $limit,
					'page' => $page,
					'contain' => [],
					'conditions' => [
						'parent_id' => $parentId,
						'role_id' => 5,
					],
					'order' => [
						'Users.id' => 'DESC',
					],

				];

				$users = $this->paginate($this->Users);

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
						'data' => $usersData,

					];
				} else {
					$data = [
						'status' => 'error',
						'code' => '400',
						'message' => 'No recode found.',
						'data' => NULL,

					];
				}

			} catch (\Exception $e) {
				$data = [
					'status' => 'error',
					'code' => '400',
					'message' => 'Invalid token',
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

	public function addChild() {
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('mobile_no');
		$this->Users->getValidator()->remove('confirm_password');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');

		if ($this->request->is('post')) {

			$userinfo = $this->request->getData();

			try {
				$Createddate = date("Y-m-d h:i:sa");
				$user = $this->Users->newEntity();
				$this->loadModel('Schools');
				$school = $this->Schools->newEntity();

				$dobnew = $userinfo['dob'];
				$bsoID = $userinfo['bso_id'];

				if ($userinfo['relation1'] == '3') {
					$relation = $userinfo['relation'];
				} elseif ($userinfo['relation1'] == '2') {
					$relation = 'Daughter';
				} elseif ($userinfo['relation1'] == '1') {
					$relation = 'Son';
				}
				$file = array();
				$imageinfo = $this->request->getData('image');

				if ($imageinfo['name'] != '') {
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
						$user->bso_id = $bsoID;
						$user->created = $Createddate;
						$user->relation = $relation;
						$user->dob = $dobnew;
						$user->school = $schoolid;
						$user->uuid = Text::uuid();

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
					'code' => '400',
					'message' => 'Invalid token',
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

				$dobnew = $userinfo['dob'];

				if ($userinfo['relation1'] == '3') {
					$relation = $userinfo['relation'];
				} elseif ($userinfo['relation1'] == '2') {
					$relation = 'Daughter';
				} elseif ($userinfo['relation1'] == '1') {
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
							'message' => __('Client data could not be updated.'),
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
					'code' => '400',
					'message' => 'Invalid token',
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