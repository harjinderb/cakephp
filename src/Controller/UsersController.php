<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
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
		$this->loadComponent('GenratePdf');
		$this->loadComponent('TimetoSec');
		$this->loadComponent('Encryption');
		$this->loadComponent('Cookie');

	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		if ($this->request->is('post') && $this->request->getData('id')) {

			$role = $this->request->getData('role');
			if ($role == 3) {

				return $this->redirect(['action' => 'employees', $this->request->getData('role'), $this->request->getData('id')]);
			}
			if ($role == 4) {

				return $this->redirect(['action' => 'parents', $this->request->getData('role'), $this->request->getData('id')]);
			}

		}

	}
/**
 * Index method
 *
 * @return \Cake\Http\Response|void
 */

	public function login() {

		if ($this->Auth->user()) {
			return $this->redirect(['action' => 'dashboard']);
		}
		$this->viewBuilder()->setLayout('login');

		if (!empty($this->Cookie->read('email'))) {
			$emailcookie = $this->Cookie->read('email');
			$passwordcookie = $this->Cookie->read('password');
		} else {
			$emailcookie = '';
			$passwordcookie = '';
		}
		if ($this->request->is('post')) {
			//pr($this->request->getData);die;
			$this->request->data['email'] = base64_encode($this->request->getData('email'));
			//pr($this->request->getData());die;
			$user = $this->Auth->identify();
			if (empty($user)) {
				$this->request->data['email'] = $this->emailDecode($this->request->data['email']);
			}
			$postdata = $this->request->getData();
			if ($this->request->getData('remember') == '1') {
				$this->Cookie->write('email', base64_decode($postdata['email']));
				$this->Cookie->write('password', $postdata['password']);
			}

			///pr($user);die;
			if ($user) {
				$this->Auth->setUser($user);

				if ($user['role_id'] == '1') {
					if ($user['flag'] == 0 || $user['flag'] == '') {
						return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => false]);
						// } elseif ($user['global_setting'] == 0 || $user['global_setting'] == '') {
						// 	return $this->redirect(['controller' => 'Users', 'action' => 'globalsettings', 'prefix' => 'admin']);
					} else {
						return $this->redirect(['controller' => 'Users', 'action' => 'dashboard', 'prefix' => 'admin']);
					}

				} elseif ($user['role_id'] == '2' && $user['is_active'] == '1') {

					if ($user['flag'] == 0 || $user['flag'] == '') {
						return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => false]);
					} else {
						return $this->redirect(['controller' => 'Users', 'action' => 'index']);
					}
				} elseif ($user['role_id'] == '4' && $user['is_active'] == '1') {

					if ($user['flag'] == 0 || $user['flag'] == '') {

						return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => 'parent']);
					} else {
						return $this->redirect(['controller' => 'Users', 'action' => 'index', 'prefix' => 'parent']);

					}

				} elseif ($user['role_id'] == '3' && $user['is_active'] == '1') {
					// pr($user);die;
					if ($user['flag'] == 0 || $user['flag'] == '') {

						return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => 'parent']);
					} else {

						return $this->redirect(['controller' => 'Employees', 'action' => 'dashboard', 'prefix' => 'employee']);

					}

				} else {
					$this->Flash->error(__('Not Activated username or password, Contact BSO'));
				}

			} else {
				$this->Flash->error(__('Invalid username or password, try again'));
			}
		}
		$this->set(compact('emailcookie', 'passwordcookie'));
	}

	public function attendance($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$created = date('Y-m-d');
		$this->loadModel('Schools');
		$this->loadModel('Attendances');
		$this->loadModel('Contracts');
		$parent_id = $this->request->getSession()->read('Auth.User.uuid');
		$bsoid = $this->request->getSession()->read('Auth.User.bso_id');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$user = $this->Encryption->encryption($user);
		$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'clint_sign', 'encryptionkey', 'mobile_no'])->where(['uuid' => $parent_id, 'role_id' => '4'])->first();
		$parent = $this->Encryption->encryption($parent);
		$Schools = $this->Schools->find('all')->where(['id' => $user['school']])->first();
		$data = [];

		if ($this->request->is('post')) {
			$id = $this->request->getData('id');
			$month = $this->request->getData('month');
			$userid = $this->UuId->uuid($id);
			$data = [];
			$alldates = [];
			$childAttandance = [];
			$userdata = $this->Users->find('all')->contain([
				'Contracts.Attendances' => [
					'conditions' => [
						'Attendances.type' => 'Auth',
						'Attendances.user_id' => $userid,
					],
				],
			])->where([
				'Users.id' => $userid,
			])->first();
			//pr($userdata);die;
			// foreach ($userdata['contracts'] as $key => $plan) {
			// 	$alldates = [];
			// 	$plandate = date('Y-' . $month . '-01');
			// 	$pday = date('l', strtotime($plandate));
			// 	$plandateday = strtolower($pday);
			// 	$planday = $plan['service_day'];

			// 	$next = 'next' . ' ' . $planday;
			// 	$nextdate = date('Y-m-d', strtotime($next, strtotime($plandate)));
			// 	$date1 = date('Y-m-d', strtotime($nextdate));
			// 	$date = new \DateTime($date1);
			// 	$createddate = date("Y-m-d");
			// 	$currentdate = strtotime($createddate);
			// 	$thisMonth = $date->format('m');
			// 	while ($date->format('m') === $thisMonth) {
			// 		$alldates[] = strtotime($date->format('Y-m-d'));
			// 		$date->modify($next);
			// 	}
			// 	if ($plandateday == $planday) {
			// 		$stmplandate = strtotime($plandate);
			// 		array_push($alldates, $stmplandate);

			// 	}

			// 	$keyc = $key;
			// 	//pr($userdata['contracts'][$keyc]['attendances']);die;
			// 	if (!empty($userdata['contracts'][$keyc]['attendances'])) {
			// 		foreach ($userdata['contracts'][$keyc]['attendances'] as $key => $attendtt) {
			// 			$dateday = date('l', strtotime($attendtt['date_time']));
			// 			if ($attendtt['type'] == 'Auth') {
			// 				$childAttandance[$key] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
			// 			}
			// 			$childAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
			// 		}

			// 		if (!empty($userdata['contracts'][$keyc]['attendances'])) {
			// 			$result = array_diff($alldates, $childAttandance);
			// 		} else {
			// 			$result = $alldates;
			// 		}
			// 		$resultmerge = array_merge($result, $childAttandance);
			// 		$finalAttendanceArray = array_unique($resultmerge);
			// 		sort($finalAttendanceArray);

			// 		foreach ($finalAttendanceArray as $key => $finalData) {
			// 			if (in_array($finalData, $childAttandance)) {
			// 				$eventdate = '';
			// 				$eventdate = $childAttandanceDatesheet[$finalData][0]['date_time'];
			// 				$data[] = [
			// 					"title" => "Present",
			// 					"start" => $eventdate,
			// 					"backgroundColor" => '#43dcdc', //red
			// 					"borderColor" => '#43dcdc',
			// 				];
			// 			} else {
			// 				$eventdate = '';
			// 				$eventdate = date('Y-m-d', $finalData);
			// 				if ($finalData < $currentdate) {
			// 					$title = "Absent";
			// 					$backgroundColor = "#ff9360";
			// 					$borderColor = "#ff9360";
			// 				} else {
			// 					$title = "N/A";
			// 					$backgroundColor = "#7ccdef";
			// 					$borderColor = "#7ccdef";
			// 				}
			// 				$data[] = [
			// 					"title" => $title,
			// 					"start" => $eventdate,
			// 					"backgroundColor" => $backgroundColor, //red
			// 					"borderColor" => $borderColor,
			// 				];

			// 			}

			// 		}

			// 	}

			// }
			// $attendance = $this->Attendances->find('all')
			// 	->select([
			// 		'user_id',
			// 		'status',
			// 		'date_time',
			// 		'mon' => 'EXTRACT(MONTH from Attendances.date_time)',
			// 	])
			// 	->where([
			// 		'user_id' => $userid,
			// 		'bso_id' => $bsoid,
			// 		'type' => 'Auth',
			// 		'EXTRACT(MONTH from Attendances.date_time) = ' => $month,
			// 		// 'EXTRACT(MONTH from Attendances.date_time) = ' => date('m'),
			// 	])->toArray();
			// foreach ($attendance as $key => $value) {
			// 	$data[] = [
			// 		"title" => "Present",
			// 		"start" => date('Y-m-d', strtotime($value['date_time'])),
			// 		"backgroundColor" => '#43dcdc', //red
			// 		"borderColor" => '#43dcdc',
			// 	];
			// }
			//$unique[] = array_unique($data);
			//pr($data);die;
			//echo json_encode($data);die;

		}

		$this->set(compact('user', 'Schools', 'parent', 'attendance'));
	}
	public function markchildAttendance() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('TeachersAllotedJobs');
		$this->loadModel('Contracts');
		$this->loadModel('Users');
		$this->loadModel('Attendances');

	}

	public function emailDecode($savedid) {

		if (!empty($savedid)) {
			$string = base64_decode($savedid);
			$user = strstr($string, '.com', true);
			$sendmail = $user . '.com';
			return $string;
		}
		return null;
	}

	public function usersetup() {
		$this->autoRender = false;
		$ids = '';
		$dataid = $this->request->getSession()->read('Auth.User.id');

		if ($this->request->is('post')) {
			$action = $this->request->getData('action');
			$role = $this->request->getData('role');
			$parent_id = $this->request->getData('parent_id');

			if ($this->request->getData('bso_id') !== null) {
				$dataid = $this->request->getData('bso_id');
			}

			if ($this->request->getData('role') == 7) {

				if ($this->request->getData('ids') !== null) {
					$ids = $this->request->getData('ids');

					$this->loadModel('BsoServices');
					switch ($action) {
					case "1":
						$this->BsoServices->updateAll(
							[ // fields
								'service_status' => 0,

							],
							[ // conditions
								'id IN' => $ids,
							]
						);
						$this->paginate = [
							'limit' => 10,
							'contain' => [],
							'conditions' => [
								//$servicesCondition,
								//'role_id' => 5,
								'bso_id' => $dataid,
								//'parent_id' => $userid,

							],
							'order' => [
								'Users.id' => 'DESC',
							],
						];

						$users = $this->paginate($this->BsoServices);

						$this->set(compact('users'));
						echo $this->render('/Element/Users/services');

						die();
						break;

					case "2":
						$this->BsoServices->updateAll(
							[ // fields
								'service_status' => 1,

							],
							[ // conditions
								'id IN' => $ids,
							]
						);
						$this->paginate = [
							'limit' => 10,
							'contain' => [],
							'conditions' => [
								// conditions,
								//'role_id' => 5,
								'bso_id' => $dataid,
								//'parent_id' => $userid,

							],
							'order' => [
								'Users.id' => 'DESC',
							],
						];

						$users = $this->paginate($this->BsoServices);
						$this->set(compact('users'));
						echo $this->render('/Element/Users/services');
						die();
						break;

					case "3":
						$this->BsoServices->deleteAll(['id IN' => $ids]);

						$this->paginate = [
							'limit' => 10,
							'contain' => [],
							'conditions' => [
								// $servicesCondition,
								//'role_id' => 5,
								'bso_id' => $dataid,
								//'parent_id' => $userid,

							],
							'order' => [
								'Users.id' => 'DESC',
							],
						];

						$users = $this->paginate($this->BsoServices);

						$this->set(compact('users'));
						echo $this->render('/Element/Users/services');
						die();
						break;
					default:
						$this->Flash->error(__('You have not selected action'));
						//echo "Your favorite color is neither red, blue, nor green!";
						break;
					}
				}

			} else {

				if ($this->request->getData('ids') !== null) {
					$ids = $this->request->getData('ids');
					switch ($action) {
					case "1":
						$this->Users->updateAll(
							[ // fields
								'is_active' => 0,

							],
							[ // conditions
								'id IN' => $ids,
							]
						);

						$this->paginate = [
							'limit' => 10,
							'order' => [
								'Users.id' => 'DESC',
							],
							'contain' => [],
							'conditions' => [
								'role_id' => $role,
								'bso_id' => $dataid,
								'parent_id' => $parent_id,
							],
						];
						$users = $this->paginate($this->Users);

						$this->set(compact('users'));
						if ($role == 4 && $parent_id != 0) {

							echo $this->render('/Element/Users/manageguardian');
							die();
							break;
						} elseif ($role == 4 && $parent_id == 0) {

							echo $this->render('/Element/Users/parent');
							die();
							break;
						} elseif ($role == 3) {

							echo $this->render('/Element/Users/employee');
							die();
							break;
						}
						echo $this->render('/Element/Users/index');
						die();
						break;

					case "2":
						$this->Users->updateAll(
							[ // fields
								'is_active' => 1,

							],
							[ // conditions
								'id IN' => $ids,
							]
						);

						$this->paginate = [
							'limit' => 10,
							'order' => [
								'Users.id' => 'DESC',
							],
							'contain' => [],
							'conditions' => [
								'role_id' => $role,
								'bso_id' => $dataid,
								'parent_id' => $parent_id,
							],
						];
						$users = $this->paginate($this->Users);
						$this->set(compact('users'));
						if ($role == 4 && $parent_id != 0) {

							echo $this->render('/Element/Users/manageguardian');
							die();
							break;
						} elseif ($role == 4 && $parent_id == 0) {

							echo $this->render('/Element/Users/parent');
							die();
							break;
						} elseif ($role == 3) {

							echo $this->render('/Element/Users/employee');
							die();
							break;
						}

						echo $this->render('/Element/Users/index');
						die();
						break;

					case "3":
						$this->Users->deleteAll(['id IN' => $ids]);
						$this->paginate = ['limit' => 10, 'order' => ['Users.id' => 'DESC'], 'contain' => [], 'conditions' => ['role_id' => $role, 'bso_id' => $dataid, 'parent_id' => $parent_id]];
						$users = $this->paginate($this->Users);

						//$childs = $users;
						//r($users);die;
						// $this->set(compact('childs'));
						$this->set(compact('users'));
						if ($role == 5) {

							echo $this->render('/Element/Users/managechild');
							die();
							break;
						} elseif ($role == 4 && $parent_id != 0) {

							echo $this->render('/Element/Users/manageguardian');
							die();
							break;
						} elseif ($role == 4 && $parent_id == 0) {

							echo $this->render('/Element/Users/parent');
							die();
							break;
						} elseif ($role == 3) {

							echo $this->render('/Element/Users/employee');
							die();
							break;
						}
						echo $this->render('/Element/Users/index');
						die();
						break;
					default:
						$this->Flash->error(__('You have not selected action'));
						break;
					}

				} else {
					$this->Flash->error(__('Please try again!'));
				}

			}
		}

	}

	public function logout() {
		$this->autoRender = false;
		$this->Auth->logout();
		return $this->redirect(['controller' => 'users', 'action' => 'login', 'prefix' => false]);
	}

	public function profile($id) {
		if ($userid = $this->UuId->uuid($id)) {
			$profile = $this->Users->get($userid, ['contain' => []]);
			$this->viewBuilder()->setLayout('admin');
			$this->set('profile', $profile);
		}

	}

	public function dashboard() {
		$this->viewBuilder()->setLayout('admin');
	}

	public function profileEdit($id) {

		if ($userid = $this->UuId->uuid($id)) {
			$this->viewBuilder()->setLayout('admin');
			$user = $this->Users->get($userid, ['contain' => []]);
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
				$newdob = explode(' ', $this->request->getData('dob'));
				$idob = implode('/', $newdob);
				$var = ltrim($idob, '/');
				$date = str_replace('/', '-', $var);
				$newdob = explode(' ', $this->request->getData('dob'));
				$idob = implode('/', $newdob);
				$var = ltrim($idob, '/');
				$date = str_replace('/', '-', $var);
				$dobnew = date('Y-m-d', strtotime($date));
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
					unset($this->request->data['relation']);
					$user = $this->Users->patchEntity($user, $this->request->getData());
				}

				if (!$user->getErrors()) {
					$Createddate = date("Y-m-d h:i:sa");
					$user->modified = $Createddate;
					$user->dob = $dobnew;
					$encryptionKey = $user['encryptionkey'];
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					$user->is_active = 1;

					//pr($user);die;
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
						return $this->redirect(['action' => 'profile-edit', 'prefix' => false, $id]);
					}
				}
				$this->Flash->error(__('There are some problem to update profile. Please try again!'));

			}
			$user = $this->Encryption->encryption($user);
			$this->set(compact('user'));
			//$this->set('user',$user);
		}
	}
	public function newPassword() {
		$this->autoRender = false;
		$this->loadModel('Users');
		if ($this->request->is(['patch', 'post', 'put'])) {

			$userinfo = $this->request->getData();
			$user = $this->Users->get($userinfo['user_id']);
			$emal = $user['email'];
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$password = $this->request->getData('password');
			if (!$user->getErrors()) {
				if ($this->Users->save($user)) {
					$message = 'Your Password Has Been Changed' . '<br/>';
					$message .= 'Your Email:' . '' . base64_decode($emal) . '<br/>';
					$message .= 'Your Password:' . '' . $password . '<br/>';

					$to = base64_decode($emal);
					$from = 'rtestoffshore@gmail.com';
					$title = 'BSO';
					$subject = 'Password Changed';

					$this->EmailSend->emailSend($from, $title, $to, $subject, $message);
				}

				$this->Flash->success(_('Password has been Updated.'));
				return $this->redirect(['action' => 'index', 'prefix' => false]);

			} else {
				$this->Flash->error(_('Password could not be Updated. Please, try again.'));
			}
		}
	}

	public function index($role = null, $id = null) {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('BsoServices');
		$this->loadModel('Attendances');
		$this->loadModel('Holidaycalendars');
		$currentday = date('d');
		$bsoid = $this->request->getSession()->read('Auth.User.id');
		$this->paginate = [
			'contain' => [],
			'conditions' => [
				'role_id' => 5,
				'bso_id' => $bsoid,
			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];
		$childern = $this->paginate($this->Users);
		$BsoServices = $this->BsoServices->find('all')->where(['bso_id' => $bsoid])->toArray();

		$this->paginate = [
			'contain' => [],
			'conditions' => [
				'role_id' => 3,
				'bso_id' => $bsoid,
			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];
		$employees = $this->paginate($this->Users);
		$attendance = $this->Attendances->find('all')->select([
			//'date' => 'EXTRACT(DAY from Attendances.date_time)',
		])->where([
			'EXTRACT(DAY from Attendances.date_time) = ' => $currentday,
			'bso_id' => $bsoid,
		])->toArray();

		$this->set(compact('childern', 'BsoServices', 'employees', 'attendance'));
	}

	/* View method
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
		$userdata = $this->Users->find('all')->where(['id' => $userid])->hydrate(false)->first();

		if ($userdata['role_id'] == '4' && $userdata['parent_id'] == 0) {
			$userdependid = $this->Users->find('all')->select(['id'])->where(['parent_id' => $userid])->hydrate(false)->toArray();
			foreach ($userdependid as $key => $value) {
				$user = $this->Users->get($value, ['contain' => []]);
				$this->Users->delete($user);
			}
		}

		$user = $this->Users->get($userid);

		if ($this->Users->delete($user)) {
			$this->Flash->success(__('student has been deleted.'));
		} else {
			$this->Flash->error(__('student could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'parents']);

	}

	public function resetPassword() {

		$id = $this->request->getSession()->read('Auth.User.id');
		$emal = $this->request->getSession()->read('Auth.User.email');
		$user = $this->Users->get($id);
		$this->viewBuilder()->setLayout('updatepdw');

		if ($this->request->is(['patch', 'post', 'put'])) {
			// $user->lastname = base64_decode($user['lastname']);aa
			// $user->firstname = base64_decode($user['firstname']);
			// $user->email = base64_decode($user['email']);
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$password = $this->request->getData('password');
			//	pr($user);die("user");
			if (!$user->getErrors()) {
				$user->flag = "1";

				if ($this->Users->save($user)) {
					$message = 'Your Password Has Been Changed' . '<br/>';
					$message .= 'Your Email:' . '' . $this->Encryption->emailDecode($emal) . '<br/>';
					$message .= 'Your Password:' . '' . $password . '<br/>';

					$to = $this->Encryption->emailDecode($emal);
					$from = 'rtestoffshore@gmail.com';
					$title = 'BSO';
					$subject = 'Password Changed';

					$this->EmailSend->emailSend($from, $title, $to, $subject, $message);
				}

				$this->Flash->success(_('Password has been Updated.'));
				return $this->redirect(['action' => 'logout']);

			} else {
				$this->Flash->error(_('Password could not be Updated. Please, try again.'));
			}
		}
		$this->set(compact('user'));
	}

	public function updatePassword() {

		$params = $this->request->getAttribute('params');

		//$link = $params['pass'][0];
		$link = base64_decode($params['pass'][0]);
		list($ActivationLink, $trash) = mbsplit('[_.-]', $link);
		//pr($ActivationLink);die;
		$users = TableRegistry::get('users')
			->find()
			->where(['activation_link' => $ActivationLink])
			->first();

		if (empty($users)) {
			$this->Flash->error(_('The activation link has been expired.'));
			return $this->redirect(['action' => 'login']);
		}

		$user = $this->Users->get($users->id, ['contain' => []]);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity(
				$user,
				$this->request->getData(),
				['validate' => 'Default']
			);

			$user->activation_link = sha1($this->request->getdata('password')) . rand();

			if ($this->Users->save($user)) {

				$message = 'Your Password Has Been Changed' . '<br/>';
				$message .= 'Email:' . '' . $this->Encryption->emailDecode($user->email) . '<br/>';
				$message .= 'New Password:' . 'As per you selected.<br/>';

				$to = $this->Encryption->emailDecode($user->email);
				$from = 'rtestoffshore@gmail.com';
				$title = 'Kind Planner';
				$subject = 'New Password';

				$this->EmailSend->emailSend($from, $title, $to, $subject, $message);

				$this->Flash->success(_('Password has been saved .'));
				return $this->redirect(['action' => 'login']);
			}

		}

		$this->viewBuilder()->setLayout('login');
		$this->set('user', $user);
	}

	public function updatePasswordApp() {

		$params = $this->request->getAttribute('params');
		$link = base64_decode($params['pass'][0]);
		list($ActivationLink, $trash) = mbsplit('[_.-]', $link);

		$users = TableRegistry::get('users')
			->find()
			->where(['activation_link' => $ActivationLink])
			->first();

		if (empty($users)) {
			$this->Flash->error(_('The activation link has been expired.'));
			return $this->redirect(['action' => 'login']);
		}

		$user = $this->Users->get($users->id, ['contain' => []]);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity(
				$user,
				$this->request->getData(),
				['validate' => 'Default']
			);

			$user->activation_link = sha1($this->request->getdata('password')) . rand();

			if ($this->Users->save($user)) {

				$message = 'Your Password Has Been Changed' . '<br/>';
				$message .= 'Email:' . '' . base64_encode($user->email) . '<br/>';
				$message .= 'New Password:' . 'As per you selected.<br/>';

				$to = base64_decode($user->email);
				$from = 'rtestoffshore@gmail.com';
				$title = 'Kind Planner';
				$subject = 'New Password';

				$this->EmailSend->emailSend($from, $title, $to, $subject, $message);

				$this->Flash->success(_('Password has been saved .'));
				return $this->redirect(['action' => 'login']);
			}

		}

		$this->viewBuilder()->setLayout('login');
		$this->set('user', $user);
	}

	public function forgotPassword() {

		$this->viewBuilder()->setLayout('login');
		if ($this->request->is('post')) {
			$this->request->data['email'] = base64_encode($this->request->getData('email'));
			$userEmail = $this->request->getdata('email');
			//pr($userEmail);die;
			$users = TableRegistry::get('users')
				->find()
				->where(['email' => $userEmail])
				->first();
			$users = $this->Encryption->encryption($users);

			if ($users) {
				if (empty($users->activation_link) || $users->activation_link == '') {
					$link = sha1($users->email) . rand();

					$usersTable = TableRegistry::get('Users');
					$newLink = $usersTable->get($users->id);
					$newLink->activation_link = $link;
					$usersTable->save($newLink);
				} else {

					$link = $users->activation_link;

				}
				$link = BASE_URL . 'users/updatePassword/' . base64_encode($link . '_' . rand());

				$message = 'For update your password <a href="' . $link . '">Click here</a>';

				$to = $users['email'];
				$from = 'rtestoffshore@gmail.com';
				$title = 'Kind Planner';
				$subject = 'Change Password';

				$this->EmailSend->emailSend($from, $title, $to, $subject, $message);

				$this->Flash->success(_('password change link sent on your email.'));
				return $this->redirect(['action' => 'login']);

			}
			$this->Flash->error(__('Invalid email, try again'));
			return $this->redirect(['action' => 'login']);
		}
	}

	/*

		    PARENTS FUNCTIONALITY
		    STARTS
	*/
	public function parents($role = null, $id = null) {

		$this->viewBuilder()->setLayout('admin');
		$dataid = $this->request->getSession()->read('Auth.User.id');

		if ($this->request->is('post') && $this->request->getData('id')) {

			$id = $this->request->getData('id');
			$dataid = $this->request->getSession()->read('Auth.User.id');
			$this->paginate = [
				'limit' => 10,
				'contain' => [],
				'conditions' => [
					"CONCAT(firstname,'',lastname) LIKE" => "%" . $id . "%",
					'role_id' => $role,
					'bso_id' => $dataid,
					'parent_id' => 0,

				],
				'order' => [
					'Users.id' => 'DESC',
				],
			];
			$users = $this->paginate($this->Users);
		}

		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				"CONCAT(firstname,'',lastname) LIKE" => "%" . $id . "%",
				'role_id' => 4,
				'bso_id' => $dataid,
				'parent_id' => 0,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];

		$users = $this->paginate($this->Users);
		$this->set(compact('users'));
	}

	public function parentsdata($role = null, $id = null) {

		$this->viewBuilder()->setLayout('admin');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$record = [];
		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				//"CONCAT(firstname,'',lastname) LIKE" => "%" . $id . "%",
				'role_id' => 4,
				'bso_id' => $dataid,
				'parent_id' => 0,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];
		$users = $this->paginate($this->Users);
		foreach ($users as $key => $value) {
			$info = $this->Encryption->encryption($value);
			//pr($info);die;
			if ($info->gender == 1) {$gender = "Male";} else { $gender = "Female";}
			if ($info->is_active == 0) {$status = "Not Activated Yet";} else { $status = "Activated";}
			$record[] = array(
				'id' => $info['id'],
				'uuid' => $info['uuid'],
				'bsn_no' => $info['bsn_no'],
				'name' => $info['firstname'] . ' ' . $info['lastname'],
				'image' => ($info['image']) ? $info['image'] : '',
				'gender' => $gender,
				'dob' => date('d-m-Y', strtotime($info['dob'])),
				'relation' => $info['relation'],
				'status' => $status,
			);
		}
		$users = $this->paginate($this->Users);
		$countrecord = count($users);
		$detail = array(
			"draw" => 1,
			"recordsTotal" => $countrecord,
			"recordsFiltered" => $countrecord,
			"data" => $record,
		);
		echo json_encode($detail);die;
		//$this->set(compact('users'));
	}

	///Rakesh////
	///11 7 2018///
	public function parentProfile($id = null) {

		$this->viewBuilder()->setLayout('admin');
		$userid = $this->UuId->uuid($id);
		$section = isset($_GET['st']) ? $_GET['st'] : "";
		$search = isset($_GET['ids']) ? $_GET['ids'] : "";
		$role = isset($_GET['role']) ? $_GET['role'] : "";

		$childCondition = [];
		$parentCondition = [];

		if ($section == 'child-section') {
			$childCondition[] = ["CONCAT(firstname,'',lastname) LIKE" => "%" . $search . "%"];
		} elseif ($section == 'guardian-section') {
			$parentCondition[] = ["CONCAT(firstname,'',lastname) LIKE" => "%" . $search . "%"];
		}

		$dataid = $this->request->getSession()->read('Auth.User.id');
		$profile = $this->Users->get($userid, ['contain' => []]);
		$profile = $this->Encryption->encryption($profile);
		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				$childCondition,
				'role_id' => 5,
				'bso_id' => $dataid,
				'parent_id' => $userid,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];

		$childsdata = $this->paginate($this->Users);
		foreach ($childsdata as $key => $value) {
			$childs[] = $this->Encryption->encryption($value);
		}

		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				$parentCondition,
				'role_id' => 4,
				'bso_id' => $dataid,
				'parent_id' => $userid,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];
		$guardiandata = $this->paginate($this->Users);
		//pr($guardiandata);die;
		foreach ($guardiandata as $key => $value) {
			$guardian[] = $this->Encryption->encryption($value);
		}

		$this->set(compact('profile', 'childs', 'guardian'));
	}

	public function addparents($id = null) {

		$this->viewBuilder()->setLayout('admin');
		$Createddate = date("Y-m-d h:i:sa");
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('confirm_password');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('relation1');
		$user = $this->Users->newEntity();

		if ($this->request->is('post')) {
			$newdob = explode(' ', $this->request->getData('dob'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));
			$file = array();
			$imageinfo = $this->request->getData('image');

			if ($imageinfo['name'] != '') {
				$file = $this->request->getData('image');
			}

			unset($this->request->data['image']);

			$user = $this->Users->patchEntity($user, $this->request->getData());
			$dataid = $this->request->getSession()->read('Auth.User.id');
			$bsouuid = $this->request->getSession()->read('Auth.User.uuid');
			$encryptionKey = md5($bsouuid);
			$user->parent_id = 0;
			$length = 8;
			$length2 = 5;
			$chars1 = "0123456789";
			$registration_id = substr(str_shuffle($chars1), 0, $length2);
			$chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$password = substr(str_shuffle($chars), 0, $length);
			$user->created = $Createddate;
			$user->registration_id = $registration_id;
			$user->role_id = "4";
			$user->group_id = "4";
			$user->bso_id = $dataid;
			$user->is_active = '1';
			$user->password = $password;
			$user->created = $Createddate;
			$user->dob = $dobnew;
			$user->uuid = Text::uuid();
			$user->encryptionkey = $encryptionKey;

			if (!$user->getErrors()) {
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
					}

				}
				$sendmail = base64_decode($savedid['email']);
				$message = 'You are Register with BSO Portal' . '<br/>';
				$message .= 'Link:' . '' . '' . BASE_URL . '<br/>';
				$message .= 'Your Email:' . '' . $sendmail . '<br/>';
				$message .= 'Your Password:' . '' . $password . '<br/>';

				$to = $sendmail;
				$from = 'rtestoffshore@gmail.com';
				$title = 'Bso';
				$subject = 'You Register With BSO';

				$this->EmailSend->emailSend($from, $title, $to, $subject, $message);

				$this->Flash->success(__('Parent has been created.'));
				return $this->redirect(['action' => 'parents']);

			}
			$this->Flash->error(__('Parent could not be saved. Please, try again.'));
		}
		$this->set(compact('user'));
	}

	public function editParents($id = null) {

		$this->viewBuilder()->setLayout('admin');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is(['patch', 'post', 'put'])) {

			$newdob = explode(' ', $this->request->getData('dob'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));
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

			$user->dob = $dobnew;
			$bsouuid = $this->request->getSession()->read('Auth.User.uuid');
			$encryptionKey = md5($bsouuid);
			$this->Users->encryptData = 'Yes';
			$this->Users->encryptionKey = $encryptionKey;
			if ($this->Users->save($user)) {

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
							//$this->Users->save($imageEntity);
						}
					}
				}
				$this->Flash->success(_('Parents profile has been updated.'));
				return $this->redirect(['action' => 'parents']);
			}

			$this->Flash->error(__('There are some problem to update Parents. Please try again!'));
		}
		$user = $this->Encryption->encryption($user);
		$this->set(compact('user'));
	}

	public function addGuardian($id = null) {

		$this->viewBuilder()->setLayout('admin');
		$userid = $this->UuId->uuid($id);
		$parents = $this->Users->get($userid, ['contain' => []]);
		$Createddate = date("Y-m-d h:i:sa");
		$user = $this->Users->newEntity();
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is('post')) {
			$file = array();
			$imageinfo = $this->request->getData('image');

			// if ($imageinfo['name'] != '') {
			//     $file = $this->request->getData('image');
			// }
			$newdob = explode(' ', $this->request->getData('dob'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));

			if ($this->request->getData('relation_dropdown') == 'other') {
				$relation = $this->request->getData('relation');
			} else {
				$relation = $this->request->getData('relation_dropdown');
			}

			$file = $this->request->getData('image');
			unset($this->request->data['image']);

			$user = $this->Users->patchEntity($user, $this->request->getData());

			$dataid = $this->request->getSession()->read('Auth.User.id');
			//$password = $this->request->getParam('password');

			if (!$user->getErrors()) {

				$user->bso_id = $dataid;
				$user->role_id = "4";
				$user->group_id = "4";
				$user->dob = $dobnew;
				$user->is_active = '1';
				$user->relation = $relation;
				$user->parent_id = $userid;
				$user->created = $Createddate;
				$user->uuid = Text::uuid();
				$bsouuid = $this->request->getSession()->read('Auth.User.uuid');
				$encryptionKey = md5($bsouuid);
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
							}
						}
					}

					// $emailsend = $savedid['email'];
					// $message = 'You are Register with BSO Portal' . '<br/>';
					// $message .= 'Your Email:' . '' . $savedid['email'] . '<br/>';
					// $message .= 'Your Password:' . '' . $password . '<br/>';

					// $to = $emailsend;
					// $from = 'rtestoffshore@gmail.com';
					// $title = 'Bso';
					// $subject = 'You Register With BSO';

					// $this->EmailSend->emailSend($from, $title, $to, $subject, $message);

					$this->Flash->success(__('Guardian has been saved.'));
					return $this->redirect(['action' => 'parentProfile', $id, '#' => 'guardian-section', 'prefix' => false]);
				}
			}
			$this->Flash->error(__('Guardian could not be saved. Please, try again.'));

		}

		$this->set(compact('user', 'parents'));
	}

	public function guardianEdit($id = null) {

		$this->viewBuilder()->setLayout('admin');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();

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
			$parant = $this->Users->find('all')->where(['id' => $user->parent_id])->first();
			//pr($parant);die;
			$newdob = explode(' ', $this->request->getData('dob'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));
			$file = array();

			if ($this->request->getData('relation_dropdown') == 'other') {
				$relation = $this->request->getData('relation');
			} else {
				$relation = $this->request->getData('relation_dropdown');
			}
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
			$user->relation = $relation;
			$user->dob = $dobnew;
			$bsouuid = $this->request->getSession()->read('Auth.User.uuid');
			$encryptionKey = md5($bsouuid);
			$user->encryptionkey = $encryptionKey;
			$this->Users->encryptData = 'Yes';
			$this->Users->encryptionKey = $encryptionKey;
			if ($this->Users->save($user)) {

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
								->where(['id' => $savedid->id])
								->execute();
							//$this->Users->save($imageEntity);
						}
					}
				}
				$this->Flash->success(_('Child profile has been updated.'));
				return $this->redirect(['action' => 'parentProfile', $parant['uuid'], '#' => 'guardian-section', 'prefix' => false]);
			}

			$this->Flash->error(__('There are some problem to update Child. Please try again!'));
		}
		$user = $this->Encryption->encryption($user);
		$this->set(compact('user'));
	}

	public function parentDeactivate($id = null) {

		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($id);
			$user = $this->Users->get($userid, ['contain' => []]);
			$this->paginate = ['contain' => [],
				'conditions' => [
					'parent_id' => $userid,
				],
			];
			$guardian = $this->paginate($this->Users);
			$user->is_active = "0";

			if ($this->Users->save($user)) {
				foreach ($guardian as $key => $value) {
					$parent_id = $value['id'];
					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['is_active' => 0])
						->where(['id' => $parent_id])
						->execute();
				}
				$this->Flash->success(_('Parent has been deactivated.'));
				return $this->redirect(['action' => 'parents', 'prefix' => false]);
			}

			$this->Flash->error(_('Parent could not be deactivated.'));
		}
		$this->set(compact('user'));

	}

	public function parentActivate($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($id);
			$user = $this->Users->get($userid, ['contain' => []]);
			$this->paginate = ['contain' => [],
				'conditions' => [
					'parent_id' => $userid,
				],
			];
			$guardian = $this->paginate($this->Users);
			$user->is_active = "1";

			if ($this->Users->save($user)) {
				foreach ($guardian as $key => $value) {
					$parent_id = $value['id'];
					$users = TableRegistry::get('Users');
					$query = $users->query();
					$query->update()
						->set(['is_active' => 1])
						->where(['id' => $parent_id])
						->execute();
				}
				$this->Flash->success(_('Parent has been deactivated.'));
				return $this->redirect(['action' => 'parents', 'prefix' => false]);
			}

			$this->Flash->error(_('Parent could not be deactivated.'));
		}

		$this->set(compact('user'));

	}

	/*
		            END OF
		            PARENTS FUNCTIONALITY
	*/
	public function childview($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$userid = $this->UuId->uuid($id);
		$this->loadModel('Recptions');
		$this->loadModel('BehaviorandSocials');
		$this->loadModel('MedicalEmotionals');
		$this->loadModel('EducationalLanguages');
		$this->loadModel('Otherinformations');
		$this->loadModel('Schools');
		$this->loadModel('Contracts');
		$this->loadModel('InvoicePayments');
		$this->loadModel('GlobalSettings');
		$guardiandata[] = array();
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$user = $this->Encryption->encryption($user);
		$Schools = $this->Schools->find('all')->where(['id' => $user['school']])->first();
		$recption = $this->Recptions->find('all')->where(['child_id' => $userid])->toArray();
		//$recption = $this->Encryption->encryption($recption);
		$contracts = $this->Contracts->find('all')->where(['child_id' => $userid])->toArray();
		//pr($recption);die("i died");
		if (empty($recption)) {
			$recption = $this->Recptions->newEntity();
		}

		$behaviorandSocial = $this->BehaviorandSocials->find('all')->where(['child_id' => $id])->first();

		if (empty($behaviorandSocial)) {
			$behaviorandSocial = $this->BehaviorandSocials->newEntity();
		}
		$medicalemotionals = $this->MedicalEmotionals->find('all')->where(['child_id' => $id])->first();

		if (empty($medicalemotionals)) {
			$medicalemotionals = $this->MedicalEmotionals->newEntity();
		}

		$educationallanguages = $this->EducationalLanguages->find('all')->where(['child_id' => $id])->first();

		if (empty($educationallanguages)) {
			$educationallanguages = $this->EducationalLanguages->newEntity();
		}

		$otherinformations = $this->Otherinformations->find('all')->where(['child_id' => $id])->first();

		if (empty($otherinformations)) {
			$otherinformations = $this->Otherinformations->newEntity();
		}

		$childparent = $user['parent_id'];
		$bsoid = $user['bso_id'];
		$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'clint_sign', 'encryptionkey', 'mobile_no'])->where(['id' => $childparent, 'role_id' => '4', 'bso_id' => $bsoid])->first();
		$parent = $this->Encryption->encryption($parent);
		if (empty($parent)) {
			$parent = $this->Users->newEntity();
		}
		//pr($parent);die;
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $bsoid])->first();

		$guardian = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'relation', 'id', 'encryptionkey'])->where(['parent_id' => $childparent, 'role_id' => '4', 'bso_id' => $bsoid])->toArray();

		foreach ($guardian as $key => $value) {
			//pr($value);die;

			$guardiandata[] = $this->Encryption->encryption($value);
		}

		$child = $this->Users->find('all')->contain([
			'InvoicePayments' => function ($q) {
				return $q
					->order('id DESC')
					->limit(1);
			},

		])->where(['id' => $user['id'], 'role_id' => 5])->first();
		if (!empty($child['invoice_payments'])) {

			$invicebal = $child['invoice_payments'][0];
		} else {
			$invicebal = [];
		}
		//pr($guardiandata);die;
		$this->set(compact('guardian', 'user', 'recption', 'behaviorandSocial', 'otherinformations', 'educationallanguages', 'medicalemotionals', 'childparent', 'bsoid', 'id', 'Schools', 'parent', 'contracts', 'invicebal', 'GlobalSettings'));
	}
	public function viewGuardian($id = null) {

		$bsoid = $this->request->getSession()->read('Auth.User.bso_id');
		$guardian = $this->Users->find('all')->where(['uuid' => $id, 'bso_id' => $bsoid])->first();
		$guardian = $this->Encryption->encryption($guardian);
		echo json_encode($guardian);die;
		//$this->set(compact('guardian'));
	}
	/*
		            START OF
		            CHILD FUNCTIONALITY
	*/

	public function addChild($id = null) {
		$parents = $this->Users->find('all')->where(['uuid' => $id])->first();
		$bsouuid = $this->request->getSession()->read('Auth.User.uuid');

		$this->viewBuilder()->setLayout('admin');
		$Createddate = date("Y-m-d h:i:sa");
		$user = $this->Users->newEntity();
		$this->loadModel('Schools');
		$school = $this->Schools->newEntity();
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('mobile_no');
		$this->Users->getValidator()->remove('confirm_password');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');

		if ($this->request->is('post')) {
			$newdob = explode(' ', $this->request->getData('dob'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));

			if ($this->request->getData('relation_dropdown') == 'other') {
				$relation = $this->request->getData('relation');
			} else {
				$relation = $this->request->getData('relation_dropdown');
			}
			$file = array();
			$imageinfo = $this->request->getData('image');

			if ($imageinfo['name'] != '') {
				$file = $this->request->getData('image');
			}

			unset($this->request->data['image']);
			$schoolspostdata = array(
				'name' => $this->request->getData('school'),
			);
			$schooldata = $this->Schools->patchEntity($school, $schoolspostdata);

			if ($result = $this->Schools->save($schooldata)) {

				$schoolid = $result['id'];

				$user = $this->Users->patchEntity($user, $this->request->getData());

				$dataid = $this->request->getSession()->read('Auth.User.id');
				$password = $this->request->getParam('password');

				if (!$user->getErrors()) {

					$user->created = $Createddate;
					$user->role_id = "5";
					$user->group_id = "5";
					$user->bso_id = $dataid;
					$user->created = $Createddate;
					$user->relation = $relation;
					$user->dob = $dobnew;
					$user->school = $schoolid;
					$user->uuid = Text::uuid();
					$bsouuid = $this->request->getSession()->read('Auth.User.uuid');
					$encryptionKey = md5($bsouuid);
					$user->encryptionkey = $encryptionKey;
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
							$regid = $this->Encryption->genrateInvoiceNumber($savedid->id);
							//pr($regid);die;
							$imageEntity = $this->Users->get($savedid->id);
							$patchImageEntity = $this->Users->patchEntity($imageEntity, $saveImage);
							$users = TableRegistry::get('Users');
							$query = $users->query();
							$query->update()
								->set(['image' => $img_return['name']])
								->where(['id' => $savedid->id])
								->execute();
							//$this->Users->save($patchImageEntity);
						}

						// $emailsend = $savedid['email'];
						// $message = 'You are Register with BSO Portal' . '<br/>';
						// $message .= 'Your Email:' . '' . $savedid['email'] . '<br/>';
						// $message .= 'Your Password:' . '' . $password . '<br/>';

						// $to = $emailsend;
						// $from = 'rtestoffshore@gmail.com';
						// $title = 'Bso';
						// $subject = 'You Register With BSO';

						// $this->EmailSend->emailSend($from, $title, $to, $subject, $message);

					}

					$this->Flash->success(__('Child has been created.'));
					return $this->redirect(['action' => 'parentProfile', $parents['uuid'], '#' => 'child-section', 'prefix' => false]);

				}
			}
			$this->Flash->error(__('Child could not be created. Please, try again.'));
		} else {

			$userid = $this->UuId->uuid($id);
			$parents = $this->Users->get($userid, ['contain' => []]);
		}

		$this->set(compact('user', 'parents'));
	}

	public function childEdit($id = null) {

		$this->loadModel('Schools');
		$this->viewBuilder()->setLayout('admin');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$Schools = $this->Schools->find('all')->where(['id' => $user['id']])->first();
		$parents = $this->Users->find('all')->where(['id' => $user['parent_id']])->first();
		//pr($parants);die;
		if ($Schools) {
			$Schools = $this->Schools->get($user['id']);
			$this->Schools->delete($Schools);
		}
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is(['patch', 'post', 'put'])) {

			//pr($parant);die;
			$newdob = explode(' ', $this->request->getData('dob'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$newdob = explode(' ', $this->request->getData('dob'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));

			if ($this->request->getData('relation_dropdown') == 'other') {
				$relation = $this->request->getData('relation');
			} else {
				$relation = $this->request->getData('relation_dropdown');
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
			$school = $this->Schools->newEntity();
			$schoolspostdata = array(
				'name' => $this->request->getData('school'),
			);
			$schooldata = $this->Schools->patchEntity($school, $schoolspostdata);
			$result = $this->Schools->save($schooldata);
			$schoolid = $result['id'];
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
			$user->relation = $relation;
			$user->dob = $dobnew;
			$user->school = $schoolid;
			// pr($user);die;
			$bsouuid = $this->request->getSession()->read('Auth.User.uuid');
			$encryptionKey = md5($bsouuid);
			$user->encryptionkey = $encryptionKey;
			$this->Users->encryptData = 'Yes';
			$this->Users->encryptionKey = $encryptionKey;
			if ($this->Users->save($user)) {

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
							//$this->Users->save($imageEntity);
						}
						// if ($img_return['status']) {
						// 	$imageEntity = $this->Users->get($user->id);
						// 	$imageEntity->image = $img_return['name'];
						// 	$this->Users->save($imageEntity);
						// }
					}
				}

				$this->Flash->success(_('Child profile has been updated.'));
				return $this->redirect(['action' => 'parentProfile', $parents['uuid'], '#' => 'child-section', 'prefix' => false]);
			}

			$this->Flash->error(__('There are some problem to update Child. Please try again!'));
		}
		$user = $this->Encryption->encryption($user);

		$this->autoRender = false;
		$this->set(compact('user', 'Schools', 'parents'));
		$this->render('add_child');
	}

	public function childServices($id = null) {
		$parentid = $this->UuId->uuid($id);
		$uuid = $id;
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->loadModel('GlobalSettings');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $dataid])->first();
		$Currentdate = date("Y-m-d");
		$plandata = $this->Contracts->find('all')->where(['Contracts.child_id' => $parentid, 'expirey_date >=' => $Currentdate])->toArray();
		//pr($plandata);die;
		$this->set(compact('plandata', 'uuid', 'GlobalSettings'));
	}

	public function stopService($id = null, $parent_id = null, $uuid = null) {
		//pr($uuid);die;
		$this->loadModel('Contracts');
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$parant = $this->Users->find('all')->where(['id' => $parent_id])->first();
			$userid = $parant['uuid'];
			$Contract = $this->Contracts->get($id, ['contain' => []]);
			$Contract->status = "2";

			if ($save = $this->Contracts->save($Contract)) {

				$this->Flash->success(_('Service has been Stoped.'));
				return $this->redirect(['action' => 'childServices', $uuid, 'prefix' => false]);
			}

			$this->Flash->error(_('Service could not be Stoped.'));
		}

		$this->set(compact('user'));

	}

	public function resumeService($id = null, $parent_id = null, $uuid = null) {
		$this->loadModel('Contracts');
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$parant = $this->Users->find('all')->where(['id' => $parent_id])->first();
			$userid = $parant['uuid'];
			$Contract = $this->Contracts->get($id, ['contain' => []]);
			$Contract->status = "1";

			if ($save = $this->Contracts->save($Contract)) {

				$this->Flash->success(_('Service has been Resumed.'));
				return $this->redirect(['action' => 'childServices', $uuid, 'prefix' => false]);
			}

			$this->Flash->error(_('Service could not be Resumed.'));
		}

		$this->set(compact('user'));

	}

	/*
		    END OF
		    CHILD FUNCTIONALITY

	*/

	public function checkPassword($value, $context) {
		if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $context['data']['password'])) {
			return false;
		} else {
			return true;
		}
	}
	/*********Add services of bso ************/

	public function addServices() {
		$this->loadModel('BsoServices');
		$this->loadModel('TeachersAllotedJobs');
		$this->loadModel('ChildGroups');
		$this->loadModel('Settings');
		$this->loadModel('GlobalSettings');
		$this->viewBuilder()->setLayout('admin');
		$Createddate = date("Y-m-d");
		$service = $this->BsoServices->newEntity();
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $dataid])->first();
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		$employee = $this->Users->find('all')->where(['bso_id' => $dataid, 'role_id' => 3])->toArray();
		$days = ['sunday' => 'zondag', 'monday' => 'maandag', 'tuesday' => 'dinsdag', 'wednesday' => 'woensdag', 'thursday' => 'donderdag', 'friday' => 'vrijdag', 'saturday' => 'zaterdag'];

		if ($this->request->is('post')) {
			$day = $this->request->getData('service_day');
			$saveday = array_search($day, $days);
			$whichday = "previous" . " " . $day;
			$startdate = date("Y-m-d", strtotime($whichday));
			//if (!empty($this->request->getData('to'])) {
			$teachers = '';
			$day = $this->request->getData('service_day');
			$Starttime = date('H:i:00', strtotime($this->request->getData('start_time')));
			$endtime = date('H:i:00', strtotime($this->request->getData('end_time')));
			// pr($Starttime);
			// pr($endtime);
			$the_datestart = date('H:i:s', strtotime($Createddate . ' ' . $Starttime));
			$the_dateend = date('H:i:s', strtotime($Createddate . ' ' . $endtime));
			// pr($the_datestart);
			// pr($the_dateend);
			// date_default_timezone_set('Asia/Calcutta');
			// $datetime = $the_datestart;
			// $asia_timestamp = strtotime($datetime);
			// echo date_default_timezone_get() . "<br>"; // Asia/Calcutta
			// date_default_timezone_set('UTC');
			// echo date_default_timezone_get() . "<br>"; //UTC
			// echo $utcDateTime = date("Y-m-d H:i:s", $asia_timestamp);
			//die;

			$savestart_time = $the_datestart;
			$saveend_time = $the_dateend;
			// $savestart_times = date("H:i:s", strtotime($Starttime));
			// $saveend_times = date("H:i:s", strtotime($endtime));
			$start_eventdate = $startdate . ' ' . $Starttime;
			$end_eventdate = $startdate . ' ' . $endtime;
			$user = $this->BsoServices->find('all')->where([
				'bso_id' => $dataid,
				'service_day' => $day,
				'end_time >=' => $savestart_time,
				'start_time <=' => $saveend_time,
				'min_age' => $this->request->getData('min_age'),
				'max_age' => $this->request->getData('max_age'),
			])->toArray();
			//pr($user);die;
			if (empty($user)) {

				$service = $this->BsoServices->patchEntity($service, $this->request->getData());
				//pr($service);die;
				if (!$service->getErrors()) {

					$service->bso_id = $dataid;
					$service->created = $Createddate;
					$service->start_time = $savestart_time;
					$service->start_eventdate = $start_eventdate;
					$service->end_eventdate = $end_eventdate;
					$service->end_time = $saveend_time;
					$service->service_status = 1;
					$service->total_plans_counts = 0;
					$service->min_age = $this->request->getData('min_age');
					$service->max_age = $this->request->getData('max_age');
					$service->add_teacher_no = $this->request->getData('add_teacher_no');
					$service->add_teacher = $teachers;
					$service->uuid = Text::uuid();

					$savedid = $this->BsoServices->save($service);
					if ($savedid) {

						if (!empty($this->request->getData('child_group_name'))) {

							for ($i = 0; $i < count($this->request->getData('child_group_name')); $i++) {
								$childgroup = $this->ChildGroups->newEntity();
								$childgroup->service_id = $savedid['id'];
								$childgroup->child_group_name = $this->request->getData('child_group_name')[$i];
								$childgroup->no_of_childs = $this->request->getData('no_of_childs')[$i];
								$childgroup->no_of_teachers = $this->request->getData('no_of_teachers')[$i];
								$result = $this->ChildGroups->save($childgroup);

							}
						}
						// pr($savedid);die('qwe');

						// for ($i = 0; $i < count($this->request->getData('to']); $i++) {

						// 	$teachersallotedjob = $this->TeachersAllotedJobs->newEntity();
						// 	$teachersallotedjob->service_id = $savedid['id'];
						// 	$teachersallotedjob->employee_id = $this->request->getData('to'][$i];
						// 	$result = $this->TeachersAllotedJobs->save($teachersallotedjob);
						// }

						$this->Flash->success(__('Service has been saved.'));

					}

					return $this->redirect(['action' => 'manageServices']);
				}

				$this->Flash->error(__('This service could not be saved. Please, try again.'));
			} else {
				$this->Flash->error(__('Time slot or Age Group is not valid so it could not be saved. Please, try again.'));

			}
			// } else {
			// 	$this->Flash->error(__('No Teacher Avalable For Job, try again.'));

			// }
		}
		//pr($GlobalSettings);die;
		$this->set(compact('service', 'employee', 'Setting', 'GlobalSettings'));
	}

	public function editServices($id = null) {
		$this->loadModel('BsoServices');
		$this->loadModel('Employees');
		$this->loadModel('TeachersAllotedJobs');
		$this->loadModel('ChildGroups');
		$this->loadModel('Users');
		$this->loadModel('GlobalSettings');
		$this->loadModel('Settings');
		$this->viewBuilder()->setLayout('admin');
		$Createddate = date("Y-m-d");
		$service = $this->BsoServices->find('all')->where(['uuid' => $id])->first();
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $dataid])->first();
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		$start = date("H:i:s", strtotime($service['start_time']));
		$end = date("H:i:s", strtotime($service['end_time']));
		$service_day = $service['service_day'];
		$connection = ConnectionManager::get('default');
		$employees = $this->Users->find('all')->where(['bso_id' => $dataid, 'role_id' => 3])->toArray();
		$teachersallotedjob = $this->TeachersAllotedJobs->find('all')->where(['service_id' => $service['id']])->toArray();
		$groups = $this->ChildGroups->find('all')->where(['service_id' => $service['id']])->toArray();
		$teachers = explode(',', $service['add_teacher']);
		$dataid = $this->request->getSession()->read('Auth.User.id');

		for ($i = 0; $i < count($teachers); $i++) {

			$employee[] = $this->Users->find('all')->where(['id' => $teachers[$i]])->toArray();
		}

		if ($this->request->is(['patch', 'post', 'put'])) {

			$day = $this->request->getData('service_day');
			$Starttime = $this->request->getData('start_time');
			$endtime = $this->request->getData('end_time');
			$start_eventdate = date("d-m-Y", strtotime($service['start_eventdate'])) . ' ' . $Starttime;
			$end_eventdate = date("d-m-Y", strtotime($service['start_eventdate'])) . ' ' . $endtime;
			$savestart_time = date("H:i:s", strtotime($Starttime));
			$saveend_time = date("H:i:s", strtotime($endtime));

			$user = $this->BsoServices->find('all')->where([
				'bso_id' => $dataid,
				'service_day' => $day,
				'end_time >=' => $savestart_time,
				'start_time <=' => $saveend_time,
				'min_age' => $this->request->getData('min_age'),
				'max_age' => $this->request->getData('max_age'),
			])->toArray();
			$service = $this->BsoServices->patchEntity($service, $this->request->getData());

			if (!$service->getErrors()) {
				$service->bso_id = $dataid;
				$service->created = $Createddate;
				$service->start_time = $savestart_time;
				$service->end_time = $saveend_time;
				$service->start_eventdate = date("Y-m-d H:i:s", strtotime($start_eventdate));
				$service->end_eventdate = date("Y-m-d H:i:s", strtotime($end_eventdate));
				$service->min_age = $this->request->getData('min_age');
				$service->max_age = $this->request->getData('max_age');
				$service->add_teacher_no = $this->request->getData('add_teacher_no');

				$savedid = $this->BsoServices->save($service);

				if ($savedid) {

					for ($i = 0; $i < count($this->request->getData('group')); $i++) {

						if (isset($this->request->getData('group')[$i]['id']) && !empty($this->request->getData('group')[$i]['child_group_name'])) {
							$groups = $this->ChildGroups->get($this->request->getData('group')[$i]['id']);
							$groups = $this->ChildGroups->patchEntity($groups, $this->request->getData('group')[$i]);

						} else {
							$groups = $this->ChildGroups->newEntity($this->request->getData('group')[$i]);
						}

						$result = $this->ChildGroups->save($groups);

					}
					// $teachers = array();
					// for ($i = 0; $i < count($this->request->getData('to']); $i++) {
					// 	$this->TeachersAllotedJobs->deleteAll(array('TeachersAllotedJobs.service_id' => $service['id'], 'TeachersAllotedJobs.employee_id' => $this->request->getData('to'][$i]));

					// }

					// for ($i = 0; $i < count($this->request->getData('to']); $i++) {

					// 	$teachersallotedjob = $this->TeachersAllotedJobs->newEntity();
					// 	$teachersallotedjob->service_id = $savedid['id'];
					// 	$teachersallotedjob->employee_id = $this->request->getData('to'][$i];
					// 	$result = $this->TeachersAllotedJobs->save($teachersallotedjob);

					// }
					$this->Flash->success(__('Service has been saved.'));
					return $this->redirect(['action' => 'manageServices']);

				}

			}
			$this->Flash->error(__('This service could not be saved. Please, try again.'));

		}

		$this->set(compact('service', 'employee', 'avalableemployee', 'groups', 'employees', 'Setting', 'GlobalSettings'));

	}

	public function getservices() {
		$this->autoRender = false;
		$this->loadModel('BsoServices');
		$dataid = $this->request->getSession()->read('Auth.User.id');

		if ($this->request->is('post')) {

			$day = $this->request->getData('day');
			$services = TableRegistry::get('bso_services')
				->find()
				->select([
					'start_time',
					'end_time',
					'min_age',
					'max_age',
				])
				->where(['bso_id' => $dataid, 'service_day' => $day])
				->toArray();
			$service_array = array();

			foreach ($services as $key => $value) {
				$start = date("H:i a", strtotime($value['start_time']));
				$end = date("H:i a", strtotime($value['end_time']));
				$service_array[] = array('start_time' => $start, 'end_time' => $end, 'min_age' => $value['min_age'], 'max_age' => $value['max_age']);
			}

			print_r(json_encode($service_array));die();

			$this->set(compact('services'));
		}
	}

	public function manageServices($search = null) {
		$this->loadModel('BsoServices');
		$this->viewBuilder()->setLayout('admin');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$search = $this->request->query('ids');
		$servicesCondition[] = ["service_day   LIKE" => "%" . $search . "%"];

		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				$servicesCondition,
				//'role_id' => 5,
				'bso_id' => $dataid,
				//'parent_id' => $userid,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];

		$users = $this->paginate($this->BsoServices);

		$this->set(compact('users'));
	}
	public function manageServicesdata($search = null) {
		$this->loadModel('BsoServices');
		$this->viewBuilder()->setLayout('admin');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$search = $this->request->query('ids');
		$servicesCondition[] = ["service_day   LIKE" => "%" . $search . "%"];
		$record = [];
		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				$servicesCondition,
				//'role_id' => 5,
				'bso_id' => $dataid,
				//'parent_id' => $userid,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];

		$users = $this->paginate($this->BsoServices);
		foreach ($users as $key => $value) {
			if (!empty($value['add_teacher_no'])) {
				$status = "Assigned";
			} else {
				$status = "Not Assigned";
			}
			$record[] = array(
				'id' => $value['id'],
				'uuid' => $value['uuid'],
				'service_day' => $value['service_day'],
				'start_time' => date('H:i:s', strtotime($value['start_time'])),
				'end_time' => date('H:i:s', strtotime($value['end_time'])),
				'status' => $status,

			);
		}
		//pr($users);die;
		$countrecord = count($users);
		$detail = array(
			"draw" => 1,
			"recordsTotal" => $countrecord,
			"recordsFiltered" => $countrecord,
			"data" => $record,
		);
		echo json_encode($detail);die;

		//$this->set(compact('users'));
	}

	public function servicesDeactivate($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('BsoServices');
			$this->viewBuilder()->setLayout('admin');
			$service = $this->BsoServices->find('all')->where(['uuid' => $id])->first();
			$userid = $service['id'];
			$user = $this->BsoServices->get($userid, ['contain' => []]);
			$user->service_status = "0";

			if ($this->BsoServices->save($user)) {
				$this->Flash->success(_('Service has been deactivated.'));
				return $this->redirect(['action' => 'manageServices', 'prefix' => false]);
			}

			$this->Flash->error(_('Service could not be deactivated.'));
		}
		$this->set(compact('user'));

	}

	public function servicesTeacher($id = null) {
		$this->loadModel('BsoServices');
		$this->loadModel('Employees');
		$this->loadModel('TeachersAllotedJobs');
		$this->viewBuilder()->setLayout('admin');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$start = date("H:m:s", strtotime($this->request->getData('start')));
		$end = date("H:m:s", strtotime($this->request->getData('end')));
		$service_day = $this->request->getData('service_day');

		$connection = ConnectionManager::get('default');
		$employee = $connection->execute("SELECT user_id,firstname,lastname,encryptionkey
                                                        FROM   employees
                                                        LEFT JOIN USERS on USERS.id = employees.user_id
                                                        WHERE  week_day = '" . $service_day . "' AND employees.bso_id = '" . $dataid . "'
                                                        AND workstart_time <= '" . $start . "' AND workend_time >= '" . $end . "'
                                                        AND user_id NOT IN(SELECT
                                                                            teachers_alloted_jobs.employee_id
                                                                            FROM teachers_alloted_jobs
                                                                            LEFT JOIN bso_services on bso_services.id = teachers_alloted_jobs.service_id
                                                                            WHERE service_day = '" . $service_day . "'
                                                                            AND ((start_time BETWEEN '" . $start . "' AND '" . $end . "') OR (end_time BETWEEN '" . $start . "' AND '" . $end . "')))")->fetchAll('assoc');

		$valid_employees = array();

		foreach ($employee as $key => $value) {

			$valid_employees[] = $this->Encryption->encryption($value);

		}
		//pr($valid_employees);die;
		echo json_encode($valid_employees);
		die;

	}
	public function overtimeserviceTeacher() {
		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			$employees = $this->Users->find('all')->where(['role_id' => 3, 'bso_id' => $this->request->getData('bso_id')])->toArray();
			//pr($users);die;
		}
		foreach ($employees as $key => $value) {

			$valid_employees[] = $this->Encryption->encryption($value);

		}
		echo json_encode($valid_employees);
		die;
	}
	public function assignTeacher($id = null) {
		$this->autoRender = false;
		//$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->loadModel('TeachersAllotedJobs');
		$teachers = [];
		if ($this->request->is('post')) {
			$service = $this->BsoServices->find('all')->where(['uuid' => $this->request->getData('bsouuid')])->first();

			if (!empty($service['add_teacher'])) {
				//pr($service);die('empty');
				array_push($teachers, $service['add_teacher']);
				array_push($teachers, $this->request->getData('id'));
				$addnew_teacher = implode(',', $teachers);
				$users = TableRegistry::get('BsoServices');
				$query = $users->query();
				$query->update()
					->set([
						'add_teacher' => $addnew_teacher,
					])
					->where(['uuid' => $this->request->getData('bsouuid')])
					->execute();
				$teachersallotedjob = $this->TeachersAllotedJobs->newEntity();
				$teachersallotedjob->service_id = $service['id'];
				$teachersallotedjob->employee_id = $this->request->getData('id');
				$result = $this->TeachersAllotedJobs->save($teachersallotedjob);

			} else {
				$add_teacher = $this->request->getData('id');
				$users = TableRegistry::get('BsoServices');
				$query = $users->query();
				$query->update()
					->set([
						'add_teacher' => $add_teacher,
					])
					->where(['uuid' => $this->request->getData('bsouuid')])
					->execute();
				$teachersallotedjob = $this->TeachersAllotedJobs->newEntity();
				$teachersallotedjob->service_id = $service['id'];
				$teachersallotedjob->employee_id = $this->request->getData('id');
				$result = $this->TeachersAllotedJobs->save($teachersallotedjob);
			}
			pr('sucess');die;
			// $this->Flash->success(__('Teacher has been assigned sucessfully.'));
			// return $this->redirect(['action' => 'servicesAssign', $this->request->getData('bsouuid'], 'prefix' => false]);

		}

	}

	public function deleteAsignteacher($serviceid = null, $empid = null) {
		$this->request->allowMethod(['post', 'delete']);
		$this->autoRender = false;
		$this->loadModel('BsoServices');
		$this->loadModel('TeachersAllotedJobs');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$userid = $empid;
		$service = $this->BsoServices->find('all')->where(['id' => $serviceid])->first();
		if ($service) {
			$addedteachers = explode(',', $service['add_teacher']);
			$teachers = array_diff($addedteachers, array($userid));
			$addnew_teacher = implode(',', $teachers);
			$users = TableRegistry::get('BsoServices');
			$query = $users->query();
			$query->update()
				->set([
					'add_teacher' => $addnew_teacher,
				])
				->where(['id' => $serviceid])
				->execute();
			$TeachersAllotedJobs = $this->TeachersAllotedJobs->find('all')->where(['service_id' => $service['id'], 'employee_id' => $userid])->toArray();
			if (!empty($TeachersAllotedJobs)) {
				foreach ($TeachersAllotedJobs as $key => $value) {
					$userid = $value['id'];
					$user = $this->TeachersAllotedJobs->get($userid);
					$this->TeachersAllotedJobs->delete($user);
				}

			}
			if ($this->request->is('ajax')) {
				echo json_encode([
					'status' => 'success',
					'message' => __('Teacher has been deleted from this service.'),
				]);
				die;
			}

			$this->Flash->success(__('Teacher has been deleted from this service.'));
			return $this->redirect(['action' => 'servicesAssign', $service['uuid'], 'prefix' => false]);
		}
		$this->Flash->error(__('Teacher could not be deleted. Please, try again.'));

	}

	public function servicesActivate($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('BsoServices');
			$this->viewBuilder()->setLayout('admin');
			$service = $this->BsoServices->find('all')->where(['uuid' => $id])->first();
			$userid = $service['id'];
			$user = $this->BsoServices->get($userid, ['contain' => []]);
			$user->service_status = "1";

			if ($this->BsoServices->save($user)) {
				$this->Flash->success(_('Service has been deactivated.'));
				return $this->redirect(['action' => 'manageServices', 'prefix' => false]);
			}
			$this->Flash->error(_('Service could not be deactivated.'));
		}
		$this->set(compact('user'));

	}

	public function servicesDelete($id) {
		$this->loadModel('BsoServices');
		$this->loadModel('Contracts');
		$this->autoRender = false;
		$this->request->allowMethod(['post', 'delete']);
		//pr($id);die;
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$service = $this->BsoServices->find('all')->where(['uuid' => $id])->first();
		$userid = $service['id'];
		$user = $this->BsoServices->get($userid);

		if ($user) {
			$this->request->allowMethod(['post', 'delete']);
			$service = $this->Contracts->find('all')->where(['plan_id' => $userid, 'bso_id' => $dataid])->first();

			if (!empty($service)) {
				$userid = $service['id'];
				$user = $this->Contracts->get($userid);

				$this->Contracts->delete($user);

			} else {

				$service2 = $this->BsoServices->find('all')->where(['uuid' => $id])->first();
				$userid2 = $service2['id'];
				$user2 = $this->BsoServices->get($userid2);

				$this->BsoServices->delete($user2);

			}

			$this->Flash->success(__('Service has been deleted.'));
		} else {
			$this->Flash->error(__('Service could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'manageServices', 'prefix' => false]);
	}

	/***********End****************/

	/*
		* Invoice Process
	*/
	public function invoices() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Contracts');

		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$users = $this->Users->find('all')->contain(['Contracts' => [
			'fields' => [
				'plan_type',
				'id',
				'child_id',
				'plan_id',
			],
		],
		])->where(['Users.bso_id' => $bso_id, 'Users.role_id' => 5])->toArray();
		//pr($users);die('users');
		$this->set(compact('users'));
	}

	public function invoicesdata() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Contracts');
		+$bso_id = $this->request->getSession()->read('Auth.User.id');
		$users = $this->Users->find('all')->contain(['Contracts' => [
			'fields' => [
				'plan_type',
				'id',
				'child_id',
				'plan_id',
			],
		],
		])->where(['Users.bso_id' => $bso_id, 'Users.role_id' => 5])->toArray();

		foreach ($users as $key => $value) {
			$info = $this->Encryption->encryption($value);
			$parent = $this->Users->find('all')->where(['id' => $info['parent_id']])->first();
			$parent = $this->Encryption->encryption($parent);
			if ($info->gender == 1) {$gender = "Male";} else { $gender = "Female";}
			if ($info->is_active == 0) {$status = "Not Activated Yet";} else { $status = "Activated";}
			$record[] = array(
				'id' => $info['id'],
				'uuid' => $info['uuid'],
				'bsn_no' => $info['bsn_no'],
				'name' => $info['firstname'] . ' ' . $info['lastname'],
				'parent_name' => $parent['firstname'] . ' ' . $parent['lastname'],
				'status' => '',
				'previousinvoice' => $info['created'],
				'plantype' => $gender,

			);
		}
		$users = $this->paginate($this->Users);
		$countrecord = count($users);
		$detail = array(
			"draw" => 1,
			"recordsTotal" => $countrecord,
			"recordsFiltered" => $countrecord,
			"data" => $record,
		);
		echo json_encode($detail);die;
		//pr($users);die('users');
		//$this->set(compact('users'));
	}
	public function invoiceHistory() {
		$this->viewBuilder()->setLayout('admin');

	}
	public function invoiceHistorydata() {
		$this->viewBuilder()->setLayout('ajax');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$record = [];
		$detail = [];
		$user = $this->Users->find('all')->where(['bso_id' => $bso_id, 'role_id' => 5])->toArray();
		foreach ($user as $key => $value) {
			$this->Encryption->encryption($value);
			if ($value->gender == 1) {$gender = "Male";} else { $gender = "Female";}
			$record[] = array(
				'id' => $value['id'],
				'uuid' => $value['uuid'],
				'name' => $value['firstname'] . ' ' . $value['lastname'],
				'image' => ($value['image']) ? $value['image'] : '',
				'gender' => $gender,
				'dob' => date('d-m-Y', strtotime($value['dob'])),
			);
		}
		$countrecord = count($record);
		$detail = array(
			"draw" => 1,
			"recordsTotal" => $countrecord,
			"recordsFiltered" => $countrecord,
			"data" => $record,
		);
		echo json_encode($detail);die;

	}
	public function payments() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('ParentpaymentInvoices');
		$this->loadModel('GlobalSettings');
		$this->loadModel('Contracts');
		$this->loadModel('Attendances');
		$this->loadModel('Schools');
		$this->loadModel('InvoicePayments');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $bso_id])->first();

	}
	public function paymentHistory() {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('Payments');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$record = [];
		$detail = [];
		$Payments = $this->Payments->find('all')
			->contain(['Users' =>
				['fields' =>
					['id',
						'uuid',
						'firstname',
						'lastname',
						'encryptionkey',
						'image',
						'gender',
					],
				],
				//'Payments' => [],
			])
			->where(['Payments.bso_id' => $bso_id])
			->order(['Payments.id' => 'DESC'])
			->toArray();
		foreach ($Payments as $key => $value) {
			$this->Encryption->encryption($value['user']);
			$record[] = array(
				'id' => $value['invoice_group'],
				'name' => $value->user['firstname'] . ' ' . $value->user['lastname'],
				'paid_date' => date('d-m-Y', strtotime($value['paid_date'])),
				'paied_amt' => $value['paied_amt'],
				'payment_mode' => $value['payment_mode'],
			);
		}

		$countrecord = count($record);
		$detail = array(
			"draw" => 1,
			"recordsTotal" => $countrecord,
			"recordsFiltered" => $countrecord,
			"data" => $record,
		);
		echo json_encode($detail);die;
	}
	///invoice & payments detail
	public function paymentsdata($id = null) {
		//pr($id);die;
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('ParentpaymentInvoices');
		$this->loadModel('GlobalSettings');
		$this->loadModel('Contracts');
		$this->loadModel('Attendances');
		$this->loadModel('Schools');
		$this->loadModel('Payments');
		$this->loadModel('InvoicePayments');
		if ($this->request->is('post')) {
			$id = $this->request->getData('user_id');
			$userid = $this->UuId->uuid($id);
		}
		$record = [];
		$detail = [];
		$paiedamyt = [];
		$payment_mode = [];
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $bso_id])->first();
		$InvoicePayments = $this->InvoicePayments->find('all')
			->contain(['Users' =>
				['fields' =>
					['id',
						'uuid',
						'firstname',
						'lastname',
						'encryptionkey',
						'image',
						'gender',
					],
				],
				'Payments' => [],
			])
			->where(['InvoicePayments.bso_id' => $bso_id, 'InvoicePayments.child_id' => $userid])
			->order(['InvoicePayments.id' => 'DESC'])
			->toArray();

		//pr($InvoicePayments);die;
		// $user = $this->Users->find('all')->contain(['InvoicePayments'])->where(['bso_id' => $bso_id, 'role_id' => 5])->toArray();
		foreach ($InvoicePayments as $key => $value) {
			$this->Encryption->encryption($value['user']);

			foreach ($value->payments as $key => $value2) {
				$paiedamyt[] = $value2->paied_amt;
				$payment_mode[] = $value2->payment_mode;
			}
			$paiedamyt = array_sum($paiedamyt);
			$paymentmode = implode(',', $payment_mode);
			if ($value->user->gender == 1) {$gender = "Male";} else { $gender = "Female";}
			if ($value->status == 1) {$payment_status = "<span class='label label-bg-green label-110 label-round __web-inspector-hide-shortcut__'>" . __('Paid') . "</span>";} elseif ($value->status == 2) {$payment_status = "<span class='label label-bg-green label-110 label-round __web-inspector-hide-shortcut__'>" . __('Balance Remaining') . "</span>";} else { $payment_status = "<span class='label label-bg-orange label-110 label-round'>" . __('Not Paid') . "</span>";}
			$record[] = array(
				'id' => $value['invoice_group'],
				'payment_id' => base64_encode($value['id']),
				'uuid' => $value->user['uuid'],
				'name' => $value->user['firstname'] . ' ' . $value->user['lastname'],
				'image' => ($value->user['image']) ? $value->user['image'] : '',
				'gender' => $gender,
				'invoice_date' => $value->created,
				'invoice_amount' => '(' . $GlobalSettings['currency'] . ' ' . $GlobalSettings['currency_code'] . ')' . $value->invoice_payment,
				'payment_status' => $payment_status,
				'paied_amt' => '(' . $GlobalSettings['currency'] . ' ' . $GlobalSettings['currency_code'] . ')' . $paiedamyt,
				'balance' => '(' . $GlobalSettings['currency'] . ' ' . $GlobalSettings['currency_code'] . ')' . $value->balance,
				'payment_mode' => $paymentmode,
			);
		}
		$countrecord = count($record);
		$detail = array(
			"draw" => 1,
			"recordsTotal" => $countrecord,
			"recordsFiltered" => $countrecord,
			"data" => $record,
		);
		echo json_encode($detail);die;
		// $this->set(compact('user'));
	}

	public function receivePayment($id = null, $paymentid = null) {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('ParentpaymentInvoices');
		$this->loadModel('GlobalSettings');
		$this->loadModel('Contracts');
		$this->loadModel('Attendances');
		$this->loadModel('Schools');
		$this->loadModel('InvoicePayments');
		$this->loadModel('Payments');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$userid = $this->UuId->uuid($id);
		$user = $this->Users->find('all')->where(['id' => $userid, 'bso_id' => $bso_id])->first();
		$parent = $this->Users->find('all')->where(['id' => $user['parent_id'], 'bso_id' => $bso_id])->first();
		$parent = $this->Encryption->encryption($parent);
		$user = $this->Encryption->encryption($user);
		$school_id = $user['school'];
		$totalpayment = [];
		$totalpayment = '';
		$invpayments = '';
		$paiedamyt = '';
		$Payment = '';
		$school = $this->Schools->find('all')->where(['id' => $school_id])->first();
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $bso_id])->first();
		$users = $this->Users->find('all')->contain([
			'Contracts.Attendances' => [
				'conditions' => [
					'Attendances.type' => 'Auth',
				],
			],
		])->where([
			'Users.id' => $userid,
		])->first();
		$limit = count($users['contracts']);
		$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $bso_id, 'child_id' => $userid])->order(['ParentpaymentInvoices.id' => 'DESC'])->limit($limit)->toArray();
		asort($invoives);
		if ($invoives) {

			$invpayments = $this->InvoicePayments->find('all')
				->where(['InvoicePayments.invoice_group' => $invoives[0]->invoice_group, 'bso_id' => $bso_id, 'child_id' => $userid])
				->order(['InvoicePayments.id' => 'DESC'])
				->first();
			$totalpayment = $invpayments['invoice_payment'];
			if ($invpayments) {
				$Payment = $this->Payments
					->find('all')
					->where([
						'bso_id' => $bso_id,
						'child_id' => $userid,
						'invoice_group' => $invpayments->invoice_group,
					])->order(['Payments.id' => 'DESC'])->toArray();
				foreach ($Payment as $key => $value) {
					$paiedamyt[] = $value->paied_amt;

				}
			}
			if ($Payment) {
				$paiedamyt = array_sum($paiedamyt);
			}
		}
		$totalpendingpayment = $totalpayment;
		$totalpendingpayment = $totalpendingpayment - $paiedamyt;
		$Payment = $this->Payments->newEntity();
		if ($this->request->is('post')) {
			$postdata = $this->request->getData();
			$Payment = $this->Payments->patchEntity($Payment, $this->request->getData());
			if (!$Payment->getErrors()) {
				$Payment->paid_date = date("Y-m-d h:i:sa");
				if ($this->Payments->save($Payment)) {
					// if (!empty($paiedamyt)) {
					// 	$paied_amt = $paiedamyt + $postdata['paied_amt'];
					// } else {
					// 	$paied_amt = $postdata['paied_amt'];
					// }
					$balance = $totalpendingpayment - $postdata['paied_amt'];
					if ($balance == 0) {$status = 1;} else { $status = 2;}
					$payments = TableRegistry::get('InvoicePayments');
					$query = $payments->query();
					$query->update()
						->set([
							'balance' => $balance,
							'status' => $status,
						])
						->where(['id' => $invpayments->id])
						->execute();

					return $this->redirect(['action' => 'receivePayment', $id, $paymentid]);
				}

			}
		}
		$this->set(compact('user', 'GlobalSettings', 'school', 'totalpendingpayment', 'invoives', 'invpayments', 'parent'));
	}
	public function servicesAssign($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('BsoServices');
		$this->loadModel('Employees');
		$this->loadModel('TeachersAllotedJobs');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$BsoServices = $this->BsoServices->find('all')->where(['uuid' => $id])->first();
		//pr($BsoServices);die;
		$teachers = explode(',', $BsoServices['add_teacher']);
		$employees = $this->Users->find('all')->where(['role_id' => 3, 'bso_id' => $bso_id])->toArray();
		foreach ($employees as $key => $value) {

			$valid_employees[] = $this->Encryption->encryption($value);

		}
		foreach ($teachers as $key => $value) {
			$users[] = $this->Users->find('all')->where(['id' => $value])->first();
		}

		$dataid = $bso_id;
		$start = date("H:m:s", strtotime($BsoServices['start_time']));
		$end = date("H:m:s", strtotime($BsoServices['end_time']));
		$service_day = $BsoServices['service_day'];

		$connection = ConnectionManager::get('default');
		$employee = $connection->execute("SELECT user_id,firstname,lastname,encryptionkey
                                                        FROM   employees
                                                        LEFT JOIN USERS on USERS.id = employees.user_id
                                                        WHERE  week_day = '" . $service_day . "' AND employees.bso_id = '" . $dataid . "'
                                                        AND workstart_time <= '" . $start . "' AND workend_time >= '" . $end . "'
                                                        AND user_id NOT IN(SELECT
                                                                            teachers_alloted_jobs.employee_id
                                                                            FROM teachers_alloted_jobs
                                                                            LEFT JOIN bso_services on bso_services.id = teachers_alloted_jobs.service_id
                                                                            WHERE service_day = '" . $service_day . "'
                                                                            AND ((start_time BETWEEN '" . $start . "' AND '" . $end . "') OR (end_time BETWEEN '" . $start . "' AND '" . $end . "')))")->fetchAll('assoc');

		$validemployees = array();

		foreach ($employee as $key => $value) {

			$validemployees[] = $this->Encryption->encryption($value);

		}
		//pr($validemployees);die;
		$this->set(compact('users', 'BsoServices', 'bso_id', 'valid_employees', 'validemployees'));
	}
	public function viewInvoice($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('ParentpaymentInvoices');
		$this->loadModel('GlobalSettings');
		$dataid = $this->request->getSession()->read('Auth.User.id');

		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $dataid])->first();

		$userid = $this->UuId->uuid($id);
		$this->loadModel('Contracts');
		$this->loadModel('Attendances');
		$this->loadModel('Schools');
		$this->loadModel('Settings');
		$this->loadModel('ParentpaymentInvoices');
		$users = $this->Users->find('all')->contain([
			'Contracts.Attendances' => [
				'conditions' => [
					'Attendances.type' => 'Auth',
				],
				// 'order' => [
				// 	'Attendances.id' => 'DESC',
				// ],
			],
		])->where([
			'Users.id' => $userid,
		])->first();

		$limit = count($users['contracts']);
		//pr($limit);die;
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'encryptionkey'])->where(['id' => $users['parent_id']])->first();
		$school_id = $users['school'];
		$school = $this->Schools->find('all')->where(['id' => $school_id])->first();
		$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid])->order(['ParentpaymentInvoices.id' => 'DESC'])->limit($limit)->toArray();
		asort($invoives);

		$this->set(compact('users', 'parent', 'school', 'Setting', 'invoives', 'GlobalSettings'));
	}

	public function sendInvoice($id = null) {

		$this->viewBuilder()->setLayout('ajax');
		$this->autoRender = false;
		$userid = $this->UuId->uuid($id);
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$this->loadModel('GlobalSettings');
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $dataid])->first();
		$Createddate = date("Y-m-d");
		$dateed = $Createddate;
		$test_final = '';
		$ftotal = [];
		$this->loadModel('Contracts');
		$this->loadModel('Attendances');
		$this->loadModel('Schools');
		$this->loadModel('Settings');
		$this->loadModel('ParentpaymentInvoices');
		$this->loadModel('InvoicePayments');
		$invoice = $this->ParentpaymentInvoices->newEntity();
		$users = $this->Users->find('all')->contain([
			'Contracts.Attendances' => [
				'conditions' => [
					'Attendances.type' => 'Auth',
				],
			],
		])->where([
			'Users.id' => $userid,
		])->first();
		$limit = count($users['contracts']);
		//pr($users);die('sggfg');
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'encryptionkey', 'email'])
			->where(['id' => $users['parent_id']])->first();
		$school_id = $users['school'];
		$school = $this->Schools->find('all')->where(['id' => $school_id])->first();
		$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid])->order(['ParentpaymentInvoices.id' => 'DESC'])->limit($limit)->toArray();
		asort($invoives);
		$builder = $this->viewBuilder();
		$builder->template('Users/send_invoice');
		$view = $builder->build(compact('users', 'parent', 'school', 'Setting', 'invoives', 'GlobalSettings'));
		// saving

		if ($Setting['calendarfrmt'] == 'School calendar') {
			$date1 = date('Y-m-d', strtotime($Setting['schooldatestart']));
			$date2 = date('Y-m-d', strtotime($Setting['schooldateend']));
			$diff = abs(strtotime($date2) - strtotime($date1));
			$years = floor($diff / (365 * 60 * 60 * 24));
			$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
			$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
		} else {
			$months = 12;
		}

		$createddate = date("Y-m-d");
		$start_date = date("d-m-Y");
		$time = strtotime($start_date);
		$final = DUE_DATE;
		$alldates = [];
		foreach ($users['contracts'] as $key => $plan) {
			// $alldates = [];
			$invodata = array_values($invoives);

			if (!empty($invoives)) {
				$plandate = date('Y-m-d', strtotime($invodata[$key]['invoicestart']));
				$planday = $plan['service_day'];
				$getplanday[] = $planday;
			} else {
				$plandate = date('Y-m-d', strtotime($plan['start_date']));
				$planday = $plan['service_day'];
				$getplanday[] = $planday;

			}
			//pr($plandate);die;
			$next = 'next' . ' ' . $planday;
			$nextdate = date('Y-m-d', strtotime($next, strtotime($plandate)));
			$date1 = date('Y-m-d', strtotime($nextdate));
			$date = new \DateTime($date1);
			if ($Setting['invoicetype'] == 'weekly') {
				$thisMonth = $date->format('m');
				if ($date->format('m') === $thisMonth) {
					$alldates[] = strtotime($date->format('Y-m-d'));
				}
			}
			if ($Setting['invoicetype'] == 'monthly') {
				$thisMonth = $date->format('m');
				while ($date->format('m') === $thisMonth) {
					$alldates[] = strtotime($date->format('Y-m-d'));
					$date->modify($next);
				}

			}
			//pr($alldates);die;
			$keyc = $key;
			$att = [];
			$final_charges = '';
			$total = '';
			$checkin_time = '';
			$checkout_time = '';
			$finalAttendanceArray = [];
			$childAttandance = [];
			$childAttandanceDatesheet = [];
			$i = 1;
			//$nextdate = date('Y-m-d', strtotime($next , strtotime($plan['start_date'])));
			//pr($users);die;
			if (!empty($plan['attendances'])) {
				foreach ($plan['attendances'] as $key => $attendtt) {

					$dateday = date('l', strtotime($attendtt['date_time']));

					//$alldates = [];
					if ($attendtt['type'] == 'Auth') {
						$childAttandance[] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
					}

					$childAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
				}
				if ($Setting['invoicetype'] == 'weekly') {
					//$thisMonth = $date->format('w');
					$dateweek = date('m', $alldates[$keyc]);
					$childAttandanceed = $childAttandance[$key];
					$week = date("m", $childAttandanceed);
					if ($dateweek == $week) {
						$childAttandance = $childAttandance;
						$result = array_diff($alldates, $childAttandance);
					} else {
						$childAttandance = [];
						$result = $alldates;
					}
				}
				//pr($childAttandance);
				if ($Setting['invoicetype'] == 'monthly') {
					//$thisMonth = $date->format('m');
					$datemonth = date('m', $alldates[$keyc]);
					$childAttandanceed = $childAttandance[$key];
					$month = date('m', $childAttandanceed);
					//die;
					if ($datemonth == $month) {
						$childAttandance = $childAttandance;
						$result = array_diff($alldates, $childAttandance);
						// $alldates[] = strtotime($date->format('Y-m-d'));
						// $date->modify($next);
					} else {
						$childAttandance = [];
						$result = $alldates;
					}
				}
				//$result = array_diff($alldates, $childAttandance);
				$resultmerge = array_merge($result, $childAttandance);
				$finalAttendanceArray = array_unique($resultmerge);

				sort($finalAttendanceArray);
				$currentdate = strtotime($createddate);

				$thisMonthcharges = 0;

				//pr($finalAttendanceArray);die;

				//pr('===================After loop================');
				$fullcharges = '';
				$Overtime1 = '00:00:00';
				$Overtime2 = '00:00:00';
				foreach ($finalAttendanceArray as $key => $finalData) {
					$plandaydate = date('Y-m-d', $finalData);

					$dateday = date('l', strtotime($plandaydate));

					if ($plan['service_day'] == strtolower($dateday)) {
						if (isset($childAttandanceDatesheet[$finalData])) {
							$checkin_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));

							if (!empty($childAttandanceDatesheet[$finalData][0]['date_time_end'])) {
								$checkout_time = date('h:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time_end']));
							}
						} else {
							$checkin_time = '00:00:00';
							$checkout_time = '00:00:00';
						}
						$planestart_time = date('H:i:s', strtotime($plan['start_time']));
						$planend_time = date('H:i:s', strtotime($plan['end_time']));
						$workingcheckout_time = (strtotime($checkout_time));
						$workingplanend_time = (strtotime($planend_time));
						$workingcheckin_time = (strtotime($checkin_time));
						$workingplanstart_time = (strtotime($planestart_time));
						$a = new \DateTime($checkout_time);
						$b = new \DateTime($planend_time);
						$e = new \DateTime($checkin_time);
						$f = new \DateTime($planestart_time);
						// pr($e);
						// pr($f);
						if ($workingcheckout_time > $workingplanend_time) {
							$Overtimes = $a->diff($b);
							$ovaf = new \DateTime($Overtimes->format("%H:%I:%S"));
							$ralaf = new \DateTime($Setting['relieftimeafterclass']);
							$Overtime = $ovaf->diff($ralaf);
							//$Overtime = $Overtime->diff($Setting['relieftimeafterclass']);
							$Overtime1 = $Overtime->format("%H:%I:%S");
						}
						if ($workingcheckin_time < $workingplanstart_time) {
							$Overtimebf = $f->diff($e);
							$ovbf = new \DateTime($Overtimebf->format("%H:%I:%S"));
							$ralbf = new \DateTime($Setting['relieftimebeforeclass']);
							$Overtime = $ovbf->diff($ralbf);
							$Overtime2 = $Overtime->format("%H:%I:%S");
						} else {
							$Overtime = '00:00:00';
						}
						$time = $Overtime1;
						$time2 = $Overtime2;
						$secs = strtotime($time2) - strtotime("00:00:00");
						$Overtime = date("H:i:s", strtotime($time) + $secs);

						$c = new \DateTime($planend_time);
						$d = new \DateTime($planestart_time);
						$classtime = $c->diff($d);
						$classtimehr = $classtime->format("%H");
						$classtimemin = $classtime->format("%I");
						$classtimehr = $classtimehr * 60 * 60;
						$classtimemin = $classtimemin * 60;
						$totaltimesec = $classtimehr + $classtimemin;
						if ($plan['plan_type'] == 'price_yearly') {
							$year = $plan['price'];
							$month = round($year / $months);
							$daycharges = round($month / 4);
							$persec_charges = $daycharges / $totaltimesec;
							$persec_overtimcharges = $Setting['overtimecost'] / 3600;
							if ($workingcheckout_time > $workingplanend_time) {
								$str_time = $Overtime;

								$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

								sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

								$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
								if (!empty($Setting['overtimecost'])) {
									$Overtime_charges = $persec_overtimcharges * $time_seconds;
								} else {
									$Overtime_charges = $persec_charges * $time_seconds;
								}
							} elseif ($workingcheckin_time < $workingplanstart_time) {
								//echo $str_time = $Overtime;die('awe');
								$str_time = $Overtime;
								$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

								sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

								$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
								if (!empty($Setting['overtimecost'])) {
									$Overtime_charges = $persec_overtimcharges * $time_seconds;
								} else {
									$Overtime_charges = $persec_charges * $time_seconds;
								}
							} else {
								$Overtime_charges = "00,00";
							}
						}
						if ($plan['plan_type'] == 'price_monthly') {
							$month = round($plan['price']);
							$daycharges = round($month / 4);
							$persec_charges = $daycharges / $totaltimesec;
							$persec_overtimcharges = $Setting['overtimecost'] / 3600;
							if ($workingcheckout_time > $workingplanend_time) {
								$str_time = $Overtime;

								$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

								sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

								$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

								if (!empty($Setting['overtimecost'])) {
									$Overtime_charges = $persec_overtimcharges * $time_seconds;
								} else {
									$Overtime_charges = $persec_charges * $time_seconds;
								}
							} elseif ($workingcheckin_time < $workingplanstart_time) {
								//echo $str_time = $Overtime;die('awe');
								$str_time = $Overtime;
								$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

								sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

								$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
								if (!empty($Setting['overtimecost'])) {
									$Overtime_charges = $persec_overtimcharges * $time_seconds;
								} else {
									$Overtime_charges = $persec_charges * $time_seconds;
								}
							} else {
								$Overtime_charges = "00,00";
							}
						}
						if ($plan['plan_type'] == 'price_weekly') {
							$daycharges = round($plan['price']);
							$persec_charges = $daycharges / $totaltimesec;
							$persec_overtimcharges = $Setting['overtimecost'] / 3600;
							if ($workingcheckout_time > $workingplanend_time) {
								$str_time = $Overtime;

								$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

								sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

								$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
								$Overtime_charges = $persec_charges * $time_seconds;
							} elseif ($workingcheckin_time < $workingplanstart_time) {
								//echo $str_time = $Overtime;die('awe');
								$str_time = $Overtime;
								$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

								sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

								$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
								if (!empty($Setting['overtimecost'])) {
									$Overtime_charges = $persec_overtimcharges * $time_seconds;
								} else {
									$Overtime_charges = $persec_charges * $time_seconds;
								}
							} else {
								$Overtime_charges = "00,00";
							}
						}
						$fullcharges = $daycharges + $Overtime_charges;

						if (in_array($finalData, $childAttandance)) {
						} else {
							//echo $daycharges;
							$fullcharges = $daycharges;
						}
						$total += $fullcharges;

					}

				}
			} else {
				$planestart_time = date('H:i:s', strtotime($plan['start_time']));
				$planend_time = date('H:i:s', strtotime($plan['end_time']));
				$c = new \DateTime($planend_time);
				$d = new \DateTime($planestart_time);
				$classtime = $c->diff($d);
				$classtimehr = $classtime->format("%H");
				$classtimemin = $classtime->format("%I");
				$classtimehr = $classtimehr * 60 * 60;
				$classtimemin = $classtimemin * 60;
				$totaltimesec = $classtimehr + $classtimemin;
				$currentdate = strtotime($createddate);

				if ($plan['plan_type'] == 'price_yearly') {
					$year = $plan['price'];
					$month = round($year / $months);
					$daycharges = round($month / 4);
					$persec_charges = $daycharges / $totaltimesec;

					$Overtime_charges = "00,00";
					//}
				}
				if ($plan['plan_type'] == 'price_monthly') {
					$month = round($plan['price']);
					$daycharges = round($month / 4);
					$persec_charges = $daycharges / $totaltimesec;

					$Overtime_charges = "00,00";
					//}
				}
				if ($plan['plan_type'] == 'price_weekly') {
					$daycharges = round($plan['price']);
					$persec_charges = $daycharges / $totaltimesec;

					$Overtime_charges = "00,00";
					// }
				}

				//$alldates = array_unique($alldates);
				//pr($alldates);
				$fullcharges = $daycharges;
				foreach ($alldates as $key => $finalData) {
					$plandaydate = date('Y-m-d', $finalData);
					$dateday = date('l', strtotime($plandaydate));
					if ($plan['service_day'] == strtolower($dateday)) {
						$total += $fullcharges;
					}
				}
			}
			$test_final += $total;

			//echo $previousinvoice;
			//pr($alldates);

			//}
			$ftotal[] = $test_final;

		}
		$totalpayment = array_sum($ftotal);

		$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid])->order(['ParentpaymentInvoices.id' => 'DESC'])->limit($limit)->toArray();
		asort($invoives);
		$invoicedata = array_values($invoives);
		$payments = $this->InvoicePayments->newEntity();
		if ($invoicedata) {
			$kke = count($invoicedata);
			$kke = $kke - 1;

			$invoice_group = $invoicedata[$kke]['id'];

			foreach ($invoicedata as $key => $value) {
				$invoice = $this->ParentpaymentInvoices->newEntity();
				$previousinvoic = date('Y-m-d', strtotime($value['invoicestart']));
				$planday = date('l', strtotime($value['invoicestart']));
				$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
				$invoicetype = $Setting['invoicetype'];
				if ($invoicetype == 'monthly') {

					$next = 'next' . ' ' . $planday;
					$nextdate = date('Y-m-d', strtotime($next, strtotime($previousinvoic)));
					$month = date('M', strtotime($nextdate));
					$year = date('Y', strtotime($nextdate));
					$next = 'last' . ' ' . $planday . ' ' . 'of' . ' ' . $month . ' ' . $year;
					// date('Y-m-d', strtotime("last Monday of Jan 2019"));
					$nextdate = date('Y-m-d', strtotime($next));
					$previousinvoice = date('Y-m-d', strtotime($nextdate));
					$maxDays = date('t');
					$firstday = date('d', strtotime($previousinvoic));
					$previous = date('Y-m-d', strtotime($previousinvoic));
					$remainingday = $maxDays - $firstday;
					$nodays = "+" . $remainingday . " days";
					$invoiceendDay = date("Y-m-d", strtotime($previous . $nodays));
					//die;
				}
				if ($invoicetype == 'weekly') {
					//echo $previousinvoice;die;
					$planday = date('l', strtotime($value['invoicestart']));
					$next = 'next' . ' ' . $planday;
					$nextdate = date('Y-m-d', strtotime($next, strtotime($previousinvoic)));
					$previousinvoice = date('Y-m-d', strtotime($nextdate));
					$nodays = "+6 days";
					$maxDays = strtotime(date('Y-m-t'));
					$previous = date('Y-m-d', strtotime($previousinvoice));
					$invoiceendDay = date("Y-m-d", strtotime($previous . $nodays));
				}

				$Createddate = date("Y-m-d");
				if (!$invoice->getErrors()) {
					$invoice->parent_id = $users['parent_id'];
					$invoice->totalpayment = $test_final;
					$invoice->bso_id = $dataid;
					$invoice->invoicestart = date('Y-m-d', strtotime($previousinvoice));
					$invoice->invoiceend = date('Y-m-d', strtotime($invoiceendDay));
					$invoice->due_date = date('Y-m-d', strtotime($final));
					$invoice->child_id = $userid;
					$invoice->createddate = $Createddate;
					$invoice->invoice_group = $invoice_group;
					$invoice->invoice_type = $invoicetype;
					//pr($invoice);die('total');
					$savedid = $this->ParentpaymentInvoices->save($invoice);

				}
			}

		} else {
			$payments = $this->InvoicePayments->newEntity();
			//$totalpayment = [];
			//$alldates = array_unique($alldates);
			//pr($alldates);
			//echo "foure";
			//$alldates = array_column($alldates, '0');
			$invoice_group = $userid . $users['parent_id'];
			//pr($alldates);die;
			foreach ($alldates as $key => $finalData) {
				//$totalpayment = [];
				//pr($finalData);
				$invoice = $this->ParentpaymentInvoices->newEntity();
				$previousinvoice = date('Y-m-d', $alldates[$key]);
				$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
				$invoicetype = $Setting['invoicetype'];
				if ($invoicetype == 'monthly') {

					$maxDays = date('t');
					$firstday = date('d', strtotime($previousinvoice));
					$previous = date('Y-m-d', strtotime($previousinvoice));
					$remainingday = $maxDays - $firstday;
					$nodays = "+" . $remainingday . " days";
					$invoiceendDay = date("Y-m-d", strtotime($previous . $nodays));
				}
				if ($invoicetype == 'weekly') {
					//echo $previousinvoice;die;
					$nodays = "+6 days";
					$maxDays = strtotime(date('Y-m-t'));
					$previous = date('Y-m-d', strtotime($previousinvoice));
					$invoiceendDay = date("Y-m-d", strtotime($previous . $nodays));
				}

				$Createddate = date("Y-m-d");
				if (!$invoice->getErrors()) {
					$invoice->parent_id = $users['parent_id'];
					$invoice->totalpayment = $test_final;
					//$totalpayment[] = $test_final;
					$invoice->bso_id = $dataid;
					$invoice->invoicestart = date('Y-m-d', strtotime($previousinvoice));
					$invoice->invoiceend = date('Y-m-d', strtotime($invoiceendDay));
					$invoice->due_date = date('Y-m-d', strtotime($final));
					$invoice->child_id = $userid;
					$invoice->createddate = $Createddate;
					$invoice->invoice_group = $invoice_group;
					$invoice->invoice_type = $invoicetype;

					$savedid = $this->ParentpaymentInvoices->save($invoice);

				}
			}

			if (!$payments->getErrors()) {
				// $totalinvbill = array_sum($totalpayment);
				$payments->parent_id = $users['parent_id'];
				$payments->bso_id = $dataid;
				$payments->child_id = $userid;
				$payments->invdue_date = date('Y-m-d', strtotime($final));
				$payments->invoice_group = $invoice_group;
				$payments->invoice_payment = $totalpayment;
				// $payments->paied_amt = '';
				// $payments->paymentrecive_date = date('Y-m-d 00:00:00');
				$payments->prevpaymt_added = '';
				$payments->status = '';
				// $payments->payment_mode = '';
				$payments->created = date('Y-m-d');
				$payments->balance = '';
				//pr($payments);die;
				//pr($payments);die('total');
				$savepayments = $this->InvoicePayments->save($payments);
			}
		}

		// end saving
		$html = $view->render();
		$pdfName = 'invoice_receipt_' . $userid . '.pdf'; //name of the pdf file
		$basePath = WWW_ROOT . 'uploads' . DS . 'invoices' . DS . $users['parent_id'] . DS . $userid . DS . $dateed . DS;
		//$basePath = WWW_ROOT . 'uploads' . DS . 'invoices' . DS;
		@chmod($basePath, 777);
		$path = $basePath . $pdfName;
		$attachment_path = $this->GenratePdf->genratepdf($html, $path, $basePath);
		$parent = $this->Encryption->encryption($parent);
		//pr($parent);die('pooi');
		if (!empty($attachment_path)) {
			$emal = $parent['email']; /*'rakesh.koul@offshoresolutions.nl';*/
			$message = 'Your  Invoice Please Check attachment.' . '<br/>';

			$to = $emal;
			$from = 'rtestoffshore@gmail.com';
			$title = 'BSO';
			$subject = 'Invoice Send';
			$attachment = $attachment_path;
			$sendmail = $this->EmailSend->emailSendwithattach($from, $title, $to, $subject, $attachment, $message);
			if ($sendmail) {
				return $this->redirect(['action' => 'view-invoice', $id]);
			} else {
				$this->Flash->error(__('E-mail not sent. Please, try again.'));
			}
		}
	}

	public function sendInvoicecron() {
		$this->viewBuilder()->setLayout('ajax');
		$this->autoRender = false;
		$this->loadModel('Contracts');
		$this->loadModel('Attendances');
		$this->loadModel('Schools');
		$this->loadModel('Settings');
		$this->loadModel('ParentpaymentInvoices');
		//$bso_id = $this->request->getSession()->read('Auth.User.id');
		$bsos = $this->Users->find('all', [
			'conditions' =>
			[
				'role_id' => 2,
			],
		])->toArray();
		$Createddate = date("Y-m-d");
		foreach ($bsos as $key => $value) {
			//pr($value);
			$bso_id = $value['id'];
			$invoice = $this->ParentpaymentInvoices->newEntity();
			$test_final = '';
			$Setting = $this->Settings->find('all')->where(['bso_id' => $bso_id])->first();
			//pr($Setting);
			$invoicetype = $Setting['invoicetype'];
			if ($invoicetype == 'monthly') {
				$nodays = "+30 days";
			}
			if ($invoicetype == 'weekly') {
				$nodays = "+7 days";
			}

			if ($Setting['invocesendfrmt'] == 'automatic') {
				$Createddate = date("Y-m-d");
				$dateed = $Createddate;
				$childparent = $this->Contracts->find('all')->select([
					'child_id',
				])->where(['bso_id' => $bso_id, 'status' => 1])->toArray();
				$childid = array_column($childparent, 'child_id');
				// foreach ($childid as $key => $value) {
				// 	$users[] = $this->Users->find('all', [
				// 		'conditions' =>
				// 		[
				// 			'id' => $value,
				// 			'bso_id' => $bso_id,

				// 		],
				// 	])->toArray();
				// }
				$childids = array_unique($childid);
				//pr($childids);
				foreach ($childids as $key => $value) {
					$users = $this->Users->find('all', [
						'conditions' =>
						[
							'id' => $value,
							'bso_id' => $bso_id,

						],
					])->toArray();
					//pr($users);
					$newUserData = $this->Encryption->encryption($users[0]);
					$users = $this->Users->find('all')->contain([
						'Contracts.Attendances' => [
							'conditions' => [
								'Attendances.type' => 'Auth',
							],
						],
					])->where([
						'Users.id' => $newUserData['id'],
					])->first();
					//pr($users);
					$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid])->order(['ParentpaymentInvoices.id' => 'DESC'])->limit($limit)->toArray();
					asort($invoives);
					//pr($invoives);
					$lastinvodate = date("Y-m-d", strtotime($invoives['invoiceend']));
					if (!empty($invoives)) {
						$invoiceDay = date("Y-m-d", strtotime($lastinvodate . $nodays));
					} else {
						//echo $users['contracts'][$key]['start_date'] . '<br/>';
						$userdate = date('Y-m-d', strtotime($users['contracts'][$key]['start_date']));
						$invoiceDay = date("Y-m-d", strtotime($userdate . $nodays));
					}
					//pr($invoiceDay);
					if (strtotime($invoiceDay) <= strtotime($Createddate)) {
						//pr($newUserData);die;
						$Setting = $this->Settings->find('all')->where(['bso_id' => $bso_id])->first();
						$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'encryptionkey', 'email'])->where(['id' => $users['parent_id']])->first();
						$school_id = $users['school'];
						$school = $this->Schools->find('all')->where(['id' => $school_id])->first();
						$builder = $this->viewBuilder();
						$builder->template('Users/send_invoice');
						$view = $builder->build(compact('users', 'parent', 'school', 'Setting', 'invoives'));
						// saving
						if ($Setting['calendarfrmt'] == 'School calendar') {
							$date1 = date('Y-m-d', strtotime($Setting['schooldatestart']));
							$date2 = date('Y-m-d', strtotime($Setting['schooldateend']));
							$diff = abs(strtotime($date2) - strtotime($date1));
							$years = floor($diff / (365 * 60 * 60 * 24));
							$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
							$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
						} else {
							$months = 12;
						}

						$createddate = date("Y-m-d");
						$start_date = date("d-m-Y");
						$time = strtotime($start_date);
						$final = date("d-m-Y", strtotime("+10 days", $time));
						$alldates = [];
						//pr($users['contracts']);die('month');
						foreach ($users['contracts'] as $key => $plan) {
							$invodata = array_values($invoives);
							if (!empty($invoives)) {
								$plandate = date('Y-m-d', strtotime($invoives[$key]['invoicestart']));
								$planday = $plan['service_day'];
								$getplanday[] = $planday;
							} else {
								$plandate = date('Y-m-d', strtotime($plan['start_date']));
								$planday = $plan['service_day'];
								$getplanday[] = $planday;

							}

							$next = 'next' . ' ' . $planday;
							$nextdate = date('Y-m-d', strtotime($next, strtotime($plandate)));
							$date1 = date('Y-m-d', strtotime($nextdate));
							$date = new \DateTime($date1);
							if ($Setting['invoicetype'] == 'weekly') {
								$thisMonth = $date->format('w');
								if ($date->format('w') === $thisMonth) {
									$alldates[$key] = strtotime($date->format('Y-m-d'));
								}
							}
							if ($Setting['invoicetype'] == 'monthly') {
								$thisMonth = $date->format('m');
								while ($date->format('m') === $thisMonth) {
									$alldates[$key] = strtotime($date->format('Y-m-d'));
									$date->modify($next);
								}

							}
							//pr($alldates);
							$keyc = $key;
							$att = [];

							$final_charges = '';
							$total = '';
							$checkin_time = '';
							$checkout_time = '';
							$finalAttendanceArray = [];
							$childAttandance = [];
							$childAttandanceDatesheet = [];
							$i = 1;
							//$nextdate = date('Y-m-d', strtotime($next , strtotime($plan['start_date'])));
							//pr($users);die;
							if (!empty($users['contracts'][$keyc]['attendances'])) {
								foreach ($users['contracts'][$keyc]['attendances'] as $key => $attendtt) {

									$dateday = date('l', strtotime($attendtt['date_time']));

									//$alldates = [];
									if ($attendtt['type'] == 'Auth' && $attendtt['status'] == '1') {
										$childAttandance[] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
									}

									$childAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
								}

								if ($Setting['invoicetype'] == 'weekly') {
									//$thisMonth = $date->format('w');
									$dateweek = date('m', $alldates[0]);
									$childAttandanceed = $childAttandance[$key];
									$week = date("m", $childAttandanceed);
									if ($dateweek == $week) {
										$childAttandance = $childAttandance;
										$result = array_diff($alldates, $childAttandance);
									} else {
										$childAttandance = [];
										$result = $alldates;
									}
								}
								//pr($childAttandance);
								if ($Setting['invoicetype'] == 'monthly') {
									//$thisMonth = $date->format('m');
									$datemonth = date('m', $alldates[0]);
									$childAttandanceed = $childAttandance[$key];
									$month = date('m', $childAttandanceed);
									//die;
									if ($datemonth == $month) {
										$childAttandance = $childAttandance;
										$result = array_diff($alldates, $childAttandance);
										// $alldates[] = strtotime($date->format('Y-m-d'));
										// $date->modify($next);
									} else {
										$childAttandance = [];
										$result = $alldates;
									}
								}

								//$result = array_diff($alldates, $childAttandance);
								$resultmerge = array_merge($result, $childAttandance);
								$finalAttendanceArray = array_unique($resultmerge);

								sort($finalAttendanceArray);
								$currentdate = strtotime($createddate);

								$thisMonthcharges = 0;

								//pr($finalAttendanceArray);die;

								//pr('===================After loop================');
								$fullcharges = '';
								$Overtime1 = '00:00:00';
								$Overtime2 = '00:00:00';
								foreach ($finalAttendanceArray as $key => $finalData) {
									$plandaydate = date('Y-m-d', $finalData);
									$dateday = date('l', strtotime($plandaydate));
									if ($plan['service_day'] == strtolower($dateday)) {
										if (isset($childAttandanceDatesheet[$finalData])) {
											$checkin_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));

											$checkout_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time_end']));
										} else {
											$checkin_time = '00:00:00';
											$checkout_time = '00:00:00';
										}
										$planestart_time = date('H:i:s', strtotime($plan['start_time']));
										$planend_time = date('H:i:s', strtotime($plan['end_time']));
										$workingcheckout_time = (strtotime($checkout_time));
										$workingplanend_time = (strtotime($planend_time));
										$workingcheckin_time = (strtotime($checkin_time));
										$workingplanstart_time = (strtotime($planestart_time));
										$a = new \DateTime($checkout_time);
										$b = new \DateTime($planend_time);
										$e = new \DateTime($checkin_time);
										$f = new \DateTime($planestart_time);
										// pr($e);
										// pr($f);
										if ($workingcheckout_time > $workingplanend_time) {
											$Overtimes = $a->diff($b);
											$ovaf = new \DateTime($Overtimes->format("%H:%I:%S"));
											$ralaf = new \DateTime($Setting['relieftimeafterclass']);
											$Overtime = $ovaf->diff($ralaf);
											//$Overtime = $Overtime->diff($Setting['relieftimeafterclass']);
											$Overtime1 = $Overtime->format("%H:%I:%S");
										}
										if ($workingcheckin_time < $workingplanstart_time) {
											$Overtimebf = $f->diff($e);
											$ovbf = new \DateTime($Overtimebf->format("%H:%I:%S"));
											$ralbf = new \DateTime($Setting['relieftimebeforeclass']);
											$Overtime = $ovbf->diff($ralbf);
											$Overtime2 = $Overtime->format("%H:%I:%S");
										} else {
											$Overtime = '00:00:00';
										}
										$time = $Overtime1;
										$time2 = $Overtime2;
										$secs = strtotime($time2) - strtotime("00:00:00");
										$Overtime = date("H:i:s", strtotime($time) + $secs);

										$c = new \DateTime($planend_time);
										$d = new \DateTime($planestart_time);
										$classtime = $c->diff($d);
										$classtimehr = $classtime->format("%H");
										$classtimemin = $classtime->format("%I");
										$classtimehr = $classtimehr * 60 * 60;
										$classtimemin = $classtimemin * 60;
										$totaltimesec = $classtimehr + $classtimemin;
										if ($plan['plan_type'] == 'price_yearly') {
											$year = $plan['price'];
											$month = round($year / $months);
											$daycharges = round($month / 4);
											$persec_charges = $daycharges / $totaltimesec;
											$persec_overtimcharges = $Setting['overtimecost'] / 3600;
											if ($workingcheckout_time > $workingplanend_time) {
												$str_time = $Overtime;

												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												if (!empty($Setting['overtimecost'])) {
													$Overtime_charges = $persec_overtimcharges * $time_seconds;
												} else {
													$Overtime_charges = $persec_charges * $time_seconds;
												}
											} elseif ($workingcheckin_time < $workingplanstart_time) {
												//echo $str_time = $Overtime;die('awe');
												$str_time = $Overtime;
												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												if (!empty($Setting['overtimecost'])) {
													$Overtime_charges = $persec_overtimcharges * $time_seconds;
												} else {
													$Overtime_charges = $persec_charges * $time_seconds;
												}
											} else {
												$Overtime_charges = "00,00";
											}
										}
										if ($plan['plan_type'] == 'price_monthly') {
											$month = round($plan['price']);
											$daycharges = round($month / 4);
											$persec_charges = $daycharges / $totaltimesec;
											$persec_overtimcharges = $Setting['overtimecost'] / 3600;
											if ($workingcheckout_time > $workingplanend_time) {
												$str_time = $Overtime;

												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

												if (!empty($Setting['overtimecost'])) {
													$Overtime_charges = $persec_overtimcharges * $time_seconds;
												} else {
													$Overtime_charges = $persec_charges * $time_seconds;
												}
											} elseif ($workingcheckin_time < $workingplanstart_time) {
												//echo $str_time = $Overtime;die('awe');
												$str_time = $Overtime;
												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												if (!empty($Setting['overtimecost'])) {
													$Overtime_charges = $persec_overtimcharges * $time_seconds;
												} else {
													$Overtime_charges = $persec_charges * $time_seconds;
												}
											} else {
												$Overtime_charges = "00,00";
											}
										}
										if ($plan['plan_type'] == 'price_weekly') {
											$daycharges = round($plan['price']);
											$persec_charges = $daycharges / $totaltimesec;
											$persec_overtimcharges = $Setting['overtimecost'] / 3600;
											if ($workingcheckout_time > $workingplanend_time) {
												$str_time = $Overtime;

												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												$Overtime_charges = $persec_charges * $time_seconds;
											} elseif ($workingcheckin_time < $workingplanstart_time) {
												//echo $str_time = $Overtime;die('awe');
												$str_time = $Overtime;
												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												if (!empty($Setting['overtimecost'])) {
													$Overtime_charges = $persec_overtimcharges * $time_seconds;
												} else {
													$Overtime_charges = $persec_charges * $time_seconds;
												}
											} else {
												$Overtime_charges = "00,00";
											}
										}
										$fullcharges = $daycharges + $Overtime_charges;

										if (in_array($finalData, $childAttandance)) {
										} else {
											//echo $daycharges;
											$fullcharges = $daycharges;
										}
										$total += $fullcharges;

									}

								}
							} else {
								$planestart_time = date('H:i:s', strtotime($plan['start_time']));
								$planend_time = date('H:i:s', strtotime($plan['end_time']));
								$c = new \DateTime($planend_time);
								$d = new \DateTime($planestart_time);
								$classtime = $c->diff($d);
								$classtimehr = $classtime->format("%H");
								$classtimemin = $classtime->format("%I");
								$classtimehr = $classtimehr * 60 * 60;
								$classtimemin = $classtimemin * 60;
								$totaltimesec = $classtimehr + $classtimemin;
								$currentdate = strtotime($createddate);

								if ($plan['plan_type'] == 'price_yearly') {
									$year = $plan['price'];
									$month = round($year / $months);
									$daycharges = round($month / 4);
									$persec_charges = $daycharges / $totaltimesec;

									$Overtime_charges = "00,00";
									//}
								}
								if ($plan['plan_type'] == 'price_monthly') {
									$month = round($plan['price']);
									$daycharges = round($month / 4);
									$persec_charges = $daycharges / $totaltimesec;

									$Overtime_charges = "00,00";
									//}
								}
								if ($plan['plan_type'] == 'price_weekly') {
									$daycharges = round($plan['price']);
									$persec_charges = $daycharges / $totaltimesec;

									$Overtime_charges = "00,00";
									// }
								}
								//pr($alldates);die;
								//$alldates = array_unique($alldates);
								$fullcharges = $daycharges;
								foreach ($alldates as $key => $finalData) {
									$plandaydate = date('Y-m-d', $finalData);
									$dateday = date('l', strtotime($plandaydate));
									if ($plan['service_day'] == strtolower($dateday)) {
										$total += $fullcharges;
									}
								}
							}
							$test_final += $total;

							//}
						}
						$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid])->order(['ParentpaymentInvoices.id' => 'DESC'])->limit($limit)->toArray();
						asort($invoives);
						$invoicedata = array_values($invoives);
						if ($invoicedata) {
							//pr($invoicedata);die;
							foreach ($invoicedata as $key => $value) {
								//pr($value);die;
								$invoice = $this->ParentpaymentInvoices->newEntity();
								$previousinvoic = date('Y-m-d', strtotime($value['invoicestart']));
								$planday = date('l', strtotime($value['invoicestart']));
								$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
								$invoicetype = $Setting['invoicetype'];
								if ($invoicetype == 'monthly') {

									$next = 'next' . ' ' . $planday;
									$nextdate = date('Y-m-d', strtotime($next, strtotime($previousinvoic)));
									$month = date('M', strtotime($nextdate));
									$year = date('Y', strtotime($nextdate));
									$next = 'last' . ' ' . $planday . ' ' . 'of' . ' ' . $month . ' ' . $year;
									// date('Y-m-d', strtotime("last Monday of Jan 2019"));
									$nextdate = date('Y-m-d', strtotime($next));
									$previousinvoice = date('Y-m-d', strtotime($nextdate));
									$maxDays = date('t');
									$firstday = date('d', strtotime($previousinvoic));
									$previous = date('Y-m-d', strtotime($previousinvoic));
									$remainingday = $maxDays - $firstday;
									$nodays = "+" . $remainingday . " days";
									$invoiceendDay = date("Y-m-d", strtotime($previous . $nodays));
									//die;
								}
								if ($invoicetype == 'weekly') {
									//echo $previousinvoice;die;
									$planday = date('l', strtotime($value['invoicestart']));
									$next = 'next' . ' ' . $planday;
									$nextdate = date('Y-m-d', strtotime($next, strtotime($previousinvoic)));
									$previousinvoice = date('Y-m-d', strtotime($nextdate));
									$nodays = "+6 days";
									$maxDays = strtotime(date('Y-m-t'));
									$previous = date('Y-m-d', strtotime($previousinvoice));
									$invoiceendDay = date("Y-m-d", strtotime($previous . $nodays));
								}

								$Createddate = date("Y-m-d");
								if (!$invoice->getErrors()) {
									$invoice->parent_id = $users['parent_id'];
									$invoice->totalpayment = $test_final;
									$invoice->bso_id = $dataid;
									$invoice->invoicestart = date('Y-m-d', strtotime($previousinvoice));
									$invoice->invoiceend = date('Y-m-d', strtotime($invoiceendDay));
									$invoice->due_date = date('Y-m-d', strtotime($final));
									$invoice->child_id = $userid;
									$invoice->createddate = $Createddate;
									//pr($invoice);die('total');
									$savedid = $this->ParentpaymentInvoices->save($invoice);

								}
							}

						} else {
							//$alldates = array_unique($alldates);
							//pr($alldates);
							//echo "foure";
							//$alldates = array_column($alldates, '0');

							foreach ($alldates as $key => $finalData) {
								//pr($finalData);
								$invoice = $this->ParentpaymentInvoices->newEntity();
								$previousinvoice = date('Y-m-d', $alldates[$key]);
								$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
								$invoicetype = $Setting['invoicetype'];
								if ($invoicetype == 'monthly') {

									$maxDays = date('t');
									$firstday = date('d', $previousinvoice);
									$previous = date('Y-m-d', strtotime($previousinvoice));
									$remainingday = $maxDays - $firstday;
									$nodays = "+" . $remainingday . " days";
									$invoiceendDay = date("Y-m-d", strtotime($previous . $nodays));
								}
								if ($invoicetype == 'weekly') {
									//echo $previousinvoice;die;
									$nodays = "+6 days";
									$maxDays = strtotime(date('Y-m-t'));
									$previous = date('Y-m-d', strtotime($previousinvoice));
									$invoiceendDay = date("Y-m-d", strtotime($previous . $nodays));
								}

								$Createddate = date("Y-m-d");
								if (!$invoice->getErrors()) {
									$invoice->parent_id = $users['parent_id'];
									$invoice->totalpayment = $test_final;
									$invoice->bso_id = $dataid;
									$invoice->invoicestart = date('Y-m-d', strtotime($previousinvoice));
									$invoice->invoiceend = date('Y-m-d', strtotime($invoiceendDay));
									$invoice->due_date = date('Y-m-d', strtotime($final));
									$invoice->child_id = $userid;
									$invoice->createddate = $Createddate;
									//pr($invoice);die('total');
									$savedid = $this->ParentpaymentInvoices->save($invoice);

								}
							}
						}

						// end saving
						$html = $view->render();
						$pdfName = 'invoice_receipt_' . $newUserData['id'] . '.pdf'; //name of the pdf file
						$basePath = WWW_ROOT . 'uploads' . DS . 'invoices' . DS . $users['parent_id'] . DS . $newUserData['id'] . DS . $dateed . DS;
						//$basePath = WWW_ROOT . 'uploads' . DS . 'invoices' . DS;
						@chmod($basePath, 777);
						$path = $basePath . $pdfName;
						$attachment_path = $this->GenratePdf->genratepdf($html, $path, $basePath);
						$parent = $this->Encryption->encryption($parent);
						//pr($parent);die('pooi');
						if (!empty($attachment_path)) {
							$emal = $parent['email']; /*'rakesh.koul@offshoresolutions.nl'*/;
							$message = 'Your  Invoice Please Check attachment.' . '<br/>';

							$to = $emal;
							$from = 'rtestoffshore@gmail.com';
							$title = 'BSO';
							$subject = 'Invoice Send';
							$attachment = $attachment_path;
							$sendmail = $this->EmailSend->emailSendwithattach($from, $title, $to, $subject, $attachment, $message);
							if ($sendmail) {

								//return $this->redirect(['action' => 'view-invoice', $id]);
							} else {
								//$this->Flash->error(__('E-mail not sent. Please, try again.'));
							}
						}
					}
					//pr($users);
					echo "In the function" . '<br/>';
					//die;
				}

			}
		}
		//die;

	}
	//

	/*****************End******************/

	/**
	 *Basic Info starts
	 **/
	public function basicInfo($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$userid = $this->UuId->uuid($id);
		$this->loadModel('Recptions');
		$this->loadModel('BehaviorandSocials');
		$this->loadModel('MedicalEmotionals');
		$this->loadModel('EducationalLanguages');
		$this->loadModel('Otherinformations');

		$user = $this->Users->find('all')->where(['uuid' => $id])->first();

		$recption = $this->Recptions->find('all')->where(['child_id' => $user['id']])->toArray();
		//pr($recption);die;
		if (empty($recption)) {
			$recption = $this->Recptions->newEntity();
		}

		$behaviorandSocial = $this->BehaviorandSocials->find('all')->where(['child_id' => $id])->first();

		if (empty($behaviorandSocial)) {
			$behaviorandSocial = $this->BehaviorandSocials->newEntity();
		}

		$medicalemotionals = $this->MedicalEmotionals->find('all')->where(['child_id' => $id])->first();

		if (empty($medicalemotionals)) {
			$medicalemotionals = $this->MedicalEmotionals->newEntity();
		}

		$educationallanguages = $this->EducationalLanguages->find('all')->where(['child_id' => $id])->first();

		if (empty($educationallanguages)) {
			$educationallanguages = $this->EducationalLanguages->newEntity();
		}

		$otherinformations = $this->Otherinformations->find('all')->where(['child_id' => $id])->first();

		if (empty($otherinformations)) {
			$otherinformations = $this->Otherinformations->newEntity();
		}

		$childparent = $user['parent_id'];
		$bsoid = $user['bso_id'];

		$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'clint_sign'])->where(['id' => $childparent, 'role_id' => '4', 'bso_id' => $bsoid])->first();

		if (empty($parent)) {
			$parent = $this->Users->newEntity();
		}

		$guardian = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'relation', 'id'])->where(['parent_id' => $childparent, 'role_id' => '4', 'bso_id' => $bsoid])->toArray();

		$this->set(compact('guardian', 'user', 'recption', 'behaviorandSocial', 'otherinformations', 'educationallanguages', 'medicalemotionals', 'childparent', 'bsoid', 'id'));
	}

	public function personaldata() {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('Recptions');
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
			$count = count($this->request->getData('data'));
			$Createddate = date("Y-m-d h:i:sa");

			for ($i = 0; $i < $count; $i++) {
				$user = $this->Users->newEntity();
				$id = $this->request->getData('ids')[$i];

				if ($this->request->getData('ids')[$i] == '-1') {
					$name = $this->request->getData('data')[$i]['name'];
					$relation1 = $this->request->getData('data')[$i]['relation1'];
					$relation = $this->request->getData('data')[$i]['relation'];

					if ($relation1 == 1) {
						$relation = 'Son';
					} elseif ($relation1 == 2) {
						$relation = 'Daughter';
					} elseif ($relation1 == 3) {
						$relation = $this->request->getData('data')[$i]['relation'];
					}

					$user->firstname = $name;
					$user->created = $Createddate;
					$user->role_id = "4";
					$user->group_id = "4";
					$user->parent_id = $this->request->getData('parent_id');
					$user->bso_id = $this->request->getData('bsoid');
					$user->relation = $relation;
					$user->uuid = Text::uuid();
					$savedid = $this->Users->save($user);

				}

			}
			$count2 = count($this->request->getData('reception'));

			$recptiondata = $this->Recptions->find('all')->where(['child_id' => $this->request->getData('child_id')])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('Recptions');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $this->request->getData('child_id')])
					->execute();

			}

			for ($i = 0; $i < count($this->request->getData('reception')); $i++) {
				$recption = $this->Recptions->newEntity();
				$recption->ingestion_date = date('Y-m-d', strtotime($this->request->getData('ingestion_date')));
				$recption->mobile_no = $this->request->getData('mobile_no');
				$recption->child_id = $this->request->getData('child_id');
				$recption->reception = $this->request->getData('reception')[$i];
				$recption->parent_id = $this->request->getData('parent_id');
				$recption->bso_id = $this->request->getData('bsoid');
				$recption->reception_date = date('Y-m-d', strtotime($this->request->getData('reception_date')[$i]));
				$savedreception = $this->Recptions->save($recption);
			}
			$responce = $this->Flash->success(__('success'));
			pr($responce);die;

		}

	}

	public function socialbehavior() {
		$this->autoRender = false;
		$savedBehaviorandSocial = array("failed");

		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('BehaviorandSocials');
			$recptiondata = $this->BehaviorandSocials->find('all')->where(['child_id' => $this->request->getData('child_id')])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('BehaviorandSocials');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $this->request->getData('child_id')])
					->execute();

			}

			$BehaviorandSocial = $this->BehaviorandSocials->newEntity();
			$BehaviorandSocial->childlike = $this->request->getData('childlike');

			if ($this->request->getData('group5') == 2) {
				$BehaviorandSocial->childlike = "2";
			}

			$BehaviorandSocial->childprefer = $this->request->getData('childprefer');
			$BehaviorandSocial->childbusy = $this->request->getData('childbusy');

			if ($this->request->getData('allergy') == 2) {
				$BehaviorandSocial->childbusy = "2";
			}

			$BehaviorandSocial->childhappypeers = $this->request->getData('childhappypeers');
			$BehaviorandSocial->childhavebfgif = $this->request->getData('childhavebfgif');
			$BehaviorandSocial->childhappybrothersis = $this->request->getData('childhappybrothersis');
			$BehaviorandSocial->childhappyparent = $this->request->getData('childhappyparent');
			$BehaviorandSocial->childmove = $this->request->getData('childmove');
			$BehaviorandSocial->childargue = $this->request->getData('childargue');
			$BehaviorandSocial->child_id = $this->request->getData('child_id');
			$BehaviorandSocial->childinterest_otherchildern = $this->request->getData('childinterest_otherchildern');

			if ($this->request->getData('argue') == 2) {
				$BehaviorandSocial->childargue = "2";
			}

			if (!$BehaviorandSocial->getErrors()) {
				$savedBehaviorandSocial = $this->BehaviorandSocials->save($BehaviorandSocial);

				if ($savedBehaviorandSocial) {
					pr($savedBehaviorandSocial);die;
				}
			}
		}

	}

	public function medicalemotional() {
		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('MedicalEmotionals');
			$recptiondata = $this->MedicalEmotionals->find('all')->where(['child_id' => $this->request->getData('child_id')])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('MedicalEmotionals');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $this->request->getData('child_id')])
					->execute();

			}

			$MedicalEmotional = $this->MedicalEmotionals->newEntity();
			$MedicalEmotional->specialdiseases = $this->request->getData('specialdiseases');

			if ($this->request->getData('group15') == 2) {
				$MedicalEmotional->specialdiseases = "2";
			}

			$MedicalEmotional->allergies = $this->request->getData('allergies');

			if ($this->request->getData('group16') == 2) {
				$MedicalEmotional->allergies = "2";
			}

			$MedicalEmotional->senses = $this->request->getData('senses');

			if ($this->request->getData('group17') == 2) {
				$MedicalEmotional->senses = "2";
			}

			$MedicalEmotional->motordevelopment = $this->request->getData('motordevelopment');
			$MedicalEmotional->childsick = $this->request->getData('childsick');

			$MedicalEmotional->differentemotions = $this->request->getData('differentemotions');
			$MedicalEmotional->anxiety = $this->request->getData('anxiety');
			$MedicalEmotional->blijheid = $this->request->getData('blijheid');
			$MedicalEmotional->boosheid = $this->request->getData('boosheid');
			$MedicalEmotional->verdriet = $this->request->getData('verdriet');
			$MedicalEmotional->child_id = $this->request->getData('child_id');

			if (!$MedicalEmotional->getErrors()) {
				$savedMedicalEmotional = $this->MedicalEmotionals->save($MedicalEmotional);

				if ($savedMedicalEmotional) {
					pr($savedMedicalEmotional);die;
				}
			}
		}

	}

	public function educationallanguage() {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('EducationalLanguages');
			$recptiondata = $this->EducationalLanguages->find('all')->where(['child_id' => $this->request->getData('child_id')])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('EducationalLanguages');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $this->request->getData('child_id')])
					->execute();

			}

			$EducationalLanguage = $this->EducationalLanguages->newEntity();
			$EducationalLanguage->upbringing = $this->request->getData('upbringing');
			$EducationalLanguage->childunderstandable = $this->request->getData('childunderstandable');
			$EducationalLanguage->childalwaysunderstand = $this->request->getData('childalwaysunderstand');

			if ($this->request->getData('group23') == 2) {
				$EducationalLanguage->childalwaysunderstand = "2";
			}

			$EducationalLanguage->enoughvocabulary = $this->request->getData('enoughvocabulary');
			$EducationalLanguage->childspeakeasily = $this->request->getData('childspeakeasily');
			$EducationalLanguage->stutteryourchild = $this->request->getData('Stutteryourchild');
			$EducationalLanguage->child_id = $this->request->getData('child_id');

			if (!$EducationalLanguage->getErrors()) {

				$savedEducationalLanguage = $this->EducationalLanguages->save($EducationalLanguage);

				if ($savedEducationalLanguage) {
					pr($savedEducationalLanguage);die;

				}
			}
		}

	}

	public function otherinformation() {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('Otherinformations');
			$recptiondata = $this->Otherinformations->find('all')->where(['child_id' => $this->request->getData('child_id')])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('Otherinformations');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $this->request->getData('child_id')])
					->execute();

			}
			$Otherinformation = $this->Otherinformations->newEntity();
			$Otherinformation->nationality_child = $this->request->getData('nationality_child');
			$Otherinformation->socmed_indicatie = $this->request->getData('socmed_indicatie');
			$Otherinformation->general_practitioner = $this->request->getData('general_practitioner');
			$Otherinformation->dentist = $this->request->getData('dentist');
			$Otherinformation->wantto_gobso = $this->request->getData('wantto_gobso');
			$Otherinformation->visitaplayroom = $this->request->getData('visitaplayroom');
			$Otherinformation->seeatransfer = $this->request->getData('seeatransfer');
			$Otherinformation->additionalinformation = $this->request->getData('additionalinformation');

			if ($this->request->getData('group29') == 2) {
				$Otherinformation->additionalinformation = "2";
			}

			$Otherinformation->whomwithchild_likestoplay = $this->request->getData('whomwithchild_likestoplay');

			if ($this->request->getData('group30') == 2) {
				$Otherinformation->whomwithchild_likestoplay = "2";
			}

			$Otherinformation->contactwithschool = $this->request->getData('contactwithschool');

			if ($this->request->getData('group31') == 2) {
				$Otherinformation->contactwithschool = "2";
			}

			$Otherinformation->parentsexpect = $this->request->getData('parentsexpect');
			$Otherinformation->child_id = $this->request->getData('child_id');

			if (!$Otherinformation->getErrors()) {

				$savedOtherinformation = $this->Otherinformations->save($Otherinformation);

				if ($savedOtherinformation) {
					pr($savedOtherinformation);die;

				}
			}
		}

	}
	public function calendarSettings() {

		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Settings');
		$this->loadModel('Holidaycalendars');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		$Holiday = $this->Holidaycalendars->find('all')->where(['bso_id' => $dataid])->toArray();
		if (!empty($Holiday)) {
			$Holiday = $Holiday;
		} else {
			$Holiday = '';
		}

		if ($this->request->is('ajax')) {
			$data = [];
			if ($this->request->is('post')) {
				$month = $this->request->getData('month');
				//pr($month);die;
				if ($this->request->getData('calsettings') == 'calsettings') {
					$Holiday = $this->Holidaycalendars->find('all')->where([
						'bso_id' => $dataid,
						'EXTRACT(MONTH from Holidaycalendars.holidaystartdate) = ' => $month,
					])->toArray();
					if (!empty($Holiday)) {
						$Holiday = $Holiday;
					} else {
						$Holiday = '';
					}

					foreach ($Holiday as $key => $value) {

						$data[] = [
							"title" => $value['holidayname'],
							"start" => date('Y-m-d', strtotime($value['holidaystartdate'])),
							"end" => date('Y-m-d', strtotime($value['holidayenddate'])),
							"description" => $value['holiday_description'],
							"backgroundColor" => '#df3f27', //red
							"borderColor" => '#df3f27',
						];
					}
				}
			}

			echo json_encode($data);die;
		}
		$this->set(compact('Setting', 'Holiday'));
	}
	public function viewcalendarholiday() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Settings');
		$this->loadModel('Holidaycalendars');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$result = array();
		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($this->request->getData);die;
			$Holiday = $this->Holidaycalendars->find('all')->where(['id' => $this->request->getData(['id'])])->first();
			//pr($Holiday);die;
			$result = array(
				"id" => $Holiday['id'],
				"holidayname" => $Holiday['holidayname'],
				"holidaystartdate" => date('Y-m-d', strtotime($Holiday['holidaystartdate'])),
				"holidaystarttime" => $Holiday['holidaystarttime'],
				"holidayenddate" => date('Y-m-d', strtotime($Holiday['holidayenddate'])),
				"holidayendtime" => $Holiday['holidayendtime'],
				"holiday_description" => $Holiday['holiday_description'],
			);
			echo json_encode($result);die;
		}
		//$this->set(compact('Holiday'));

	}
	public function viewcalendarholidayevents() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Settings');
		$this->loadModel('Holidaycalendars');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$result = array();
		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($this->request->getData);die;
			$Holiday = $this->Holidaycalendars->find('all')->where(['bso_id' => $dataid])->toArray();
			//pr($Holiday);die;
			//"holidaystarttime" => $Holiday['holidaystarttime'],
			//"holidayendtime" => $Holiday['holidayendtime'],
			//"holiday_description" => $Holiday['holiday_description'],
			//title          : 'New year',
			//     start          : new Date(y, m,  10),
			//     end            : new Date(y, m, 11),
			//     backgroundColor: '#f56954', //red
			//     borderColor    : '#f56954' //red
			$result = [];
			foreach ($Holiday as $key => $value) {
				# code...
				$result[] = array(

					"title" => $value['holidayname'],
					// "start" => date('Y-m-d', strtotime($value['holidaystartdate'])),
					// "end" => date('Y-m-d', strtotime($value['holidayenddate'])),
					"start" => date('Y,m,d', strtotime($value['holidaystartdate'])),
					"end" => date('Y,m,d', strtotime($value['holidayenddate'])),
					'backgroundColor' => '#f56954',
					'borderColor' => '#f56954',

				);
			}
			echo json_encode($result);die;
		}
		//$this->set(compact('Holiday'));

	}
	public function editcalendarholiday() {
		$this->autoRender = false;
		$this->loadModel('Holidaycalendars');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		if ($this->request->is(['post'])) {
			$holidaycalender = $this->Holidaycalendars->find('all')->where(['id' => $this->request->getData(['id'])])->first();
			$holidaystartdate = date('Y-m-d', strtotime($this->request->getData(['holidaystartdate'])));
			$holidayenddate = date('Y-m-d', strtotime($this->request->getData(['holidayenddate'])));
			$holidaycalender = $this->Holidaycalendars->patchEntity($holidaycalender, $this->request->getData());

			if (!$holidaycalender->getErrors()) {
				$holidaycalender->holidaystartdate = $holidaystartdate;
				$holidaycalender->holidayenddate = $holidayenddate;
				$holidaycalender->bso_id = $bso_id;
				if ($savedid = $this->Holidaycalendars->save($holidaycalender)) {
					echo json_encode($savedid);
					die;

				} else {
					pr("Not Saved");die;
				}

			}
		}
		$this->set(compact('Setting'));

	}
	public function deletecalendarholiday() {
		$this->autoRender = false;
		$this->loadModel('Holidaycalendars');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		if ($this->request->is(['post'])) {

			$Holidaycalendar = $this->Holidaycalendars->get($this->request->getData(['id']));

			if ($savedid = $this->Holidaycalendars->delete($Holidaycalendar)) {
				echo json_encode($savedid);
				die;
			} else {
				pr("Not Deleted");die;
			}

		}
		//$this->set(compact('Setting'));

	}

	public function addcalendarholiday() {
		$this->autoRender = false;
		$this->loadModel('Holidaycalendars');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		//$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		if ($this->request->is(['post'])) {
			//pr($this->request->getData());die;
			$holidaycalender = $this->Holidaycalendars->newEntity();
			$holidaystartdate = date('Y-m-d', strtotime($this->request->getData(['holidaystartdate'])));
			$holidayenddate = date('Y-m-d', strtotime($this->request->getData(['holidayenddate'])));
			$holidaycalender = $this->Holidaycalendars->patchEntity($holidaycalender, $this->request->getData());
			if (!$holidaycalender->getErrors()) {
				$holidaycalender->holidaystartdate = $holidaystartdate;
				$holidaycalender->holidayenddate = $holidayenddate;
				$holidaycalender->bso_id = $bso_id;
				if ($savedid = $this->Holidaycalendars->save($holidaycalender)) {
					pr("saved");die;

				} else {
					pr("Not Saved");die;
				}

			}
		}
		$this->set(compact('Setting'));

	}

	public function addinvoicetypeSettings() {
		$this->autoRender = false;
		$dataid = $this->request->getSession()->read('Auth.User.id');
		if ($this->request->is(['post'])) {
			$invoicetype = $this->request->getData('invoicetype');
			$this->loadModel('Settings');
			$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();

			if ($Setting) {
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->invoicetype = $this->request->getData(['invoicetype']);
				if ($savedid = $this->Settings->save($Setting)) {
					pr("save");die("update");
					// $this->Flash->success(_('Manage Invoice Setting has been Saved Sucessfully.'));
					// return $this->redirect(['action' => 'calendarSettings', 'prefix' => false]);
				}
			} else {
				$Setting = $this->Settings->newEntity();
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->bso_id = $dataid;
				$Setting->invoicetype = $this->request->getData(['invoicetype']);
				if (!$Setting->getErrors()) {
					$savedid = $this->Settings->save($Setting);
					//$this->Flash->success(_('Manage Invoice Setting has been Saved Sucessfully.'));
					pr("update");die("save");
					//return $this->redirect(['action' => 'calendarSettings', 'prefix' => false]);
				}
				//$this->Flash->error(__('Manage Invoice Setting has not been. Please, try again.'));
				pr("error");die();
			}
		}

	}
	public function addinvocesendfrmtSettings() {
		$this->autoRender = false;
		$dataid = $this->request->getSession()->read('Auth.User.id');
		if ($this->request->is(['post'])) {
			$invocesendfrmt = $this->request->getData('invocesendfrmt');
			$this->loadModel('Settings');
			$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
			//pr($Setting);die;
			if ($Setting) {
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->invocesendfrmt = $this->request->getData(['invocesendfrmt']);
				if ($savedid = $this->Settings->save($Setting)) {
					pr("update");die("update");
					// $this->Flash->success(_('Manage Invoice Setting has been Saved Sucessfully.'));
					// return $this->redirect(['action' => 'calendarSettings', 'prefix' => false]);
				}
			} else {
				$Setting = $this->Settings->newEntity();
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->bso_id = $dataid;
				$Setting->invocesendfrmt = $this->request->getData(['invocesendfrmt']);
				if (!$Setting->getErrors()) {
					$savedid = $this->Settings->save($Setting);
					//$this->Flash->success(_('Manage Invoice Setting has been Saved Sucessfully.'));
					pr("save");die("save");
					//return $this->redirect(['action' => 'calendarSettings', 'prefix' => false]);
				}
				//$this->Flash->error(__('Manage Invoice Setting has not been. Please, try again.'));
				pr("error");die();
			}
		}

	}
	public function addcalendarfrmtSettings() {
		$this->autoRender = false;
		if ($this->request->is(['post'])) {
			$dataid = $this->request->getSession()->read('Auth.User.id');
			//pr($this->request->getData);die;
			$calendarfrmt = $this->request->getData('calendarfrmt');
			$schooldatestart = date('Y-m-d', strtotime($this->request->getData(['schooldatepicker'])));
			$schooldateend = date('Y-m-d', strtotime($this->request->getData(['schooldatepickerEnd'])));
			$this->loadModel('Settings');
			$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();

			if ($Setting) {
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->calendarfrmt = $this->request->getData(['calendarfrmt']);
				$Setting->schooldatestart = $schooldatestart;
				$Setting->schooldateend = $schooldateend;

				if ($savedid = $this->Settings->save($Setting)) {
					pr("update");die("update");
					// $this->Flash->success(_('Manage Invoice Setting has been Saved Sucessfully.'));
					// return $this->redirect(['action' => 'calendarSettings', 'prefix' => false]);
				}
			} else {
				$Setting = $this->Settings->newEntity();
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->bso_id = $dataid;
				$Setting->calendarfrmt = $this->request->getData(['calendarfrmt']);
				$Setting->schooldatestart = $schooldatestart;
				$Setting->schooldateend = $schooldateend;

				if (!$Setting->getErrors()) {
					$savedid = $this->Settings->save($Setting);
					//$this->Flash->success(_('Manage Invoice Setting has been Saved Sucessfully.'));
					pr("save");die("save");
					//return $this->redirect(['action' => 'calendarSettings', 'prefix' => false]);
				}
				//$this->Flash->error(__('Manage Invoice Setting has not been. Please, try again.'));
				pr("error");die();
			}

		}

	}
	public function planSettings() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Contracts');

		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$users = $this->Users->find('all')->contain(['Contracts' => [
			'fields' => [
				'plan_type',
				'id',
				'child_id',
				'plan_id',
			],
		],
		])->where(['Users.bso_id' => $bso_id, 'Users.role_id' => 5])->toArray();
		//pr($users);die('users');
		$this->set(compact('users'));
	}
	public function selectPlan($uuid = null) {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('BsoServices');
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$user = $this->Users->find('all')->where(['uuid' => $uuid, 'role_id' => '5', 'bso_id' => $bso_id])->first();

		$userdata = $this->Encryption->encryption($user);

		$dob = $userdata['dob'];
		$from = new \DateTime($dob);
		$to = new \DateTime('today');
		$age = $from->diff($to)->y;
		//pr($age);die;
		$conditions = [];
		$conditions[] = ['BsoServices.bso_id' => $bso_id];
		$conditions[] = ['BsoServices.total_plans_counts < BsoServices.childin_batch'];

		if ($age) {
			$conditions[] = ['BsoServices.min_age <=' => $age];
		}

		if ($age) {
			$conditions[] = ['BsoServices.max_age >=' => $age];
		}

		$this->paginate = [
			'contain' => [],
			'conditions' => $conditions,

		];
		$BsoServices = $this->paginate($this->BsoServices);
		//pr($BsoServices);die;
		$this->set(compact('BsoServices'));
	}
	public function viewselectedplan() {
		$this->autoRender = false;
		$this->loadModel('BsoServices');

		if ($this->request->is(['post'])) {
			$Services = $this->BsoServices->find('all')->where(['uuid' => $this->request->getData('id')])->first();
			//$result = [];
			$result = array(
				"uuid" => $Services['uuid'],
				"service_day" => $Services['service_day'],
				"min_age" => $Services['min_age'],
				"max_age" => $Services['max_age'],
				"price_monthly" => $Services['price_monthly'],
				"price_weekly" => $Services['price_weekly'],
				"price_yearly" => $Services['price_yearly'],
				"add_teacher_no" => $Services['add_teacher_no'],
				"start" => date('h:i:s', strtotime($Services['start_time'])),
				"end" => date('h:i:s', strtotime($Services['end_time'])),

			);
			//pr($result);die;
		}
		echo json_encode($result);die;
	}

	public function saveselectedplan() {
		$this->autoRender = false;
		$this->loadModel('BsoServices');
		$this->loadModel('Schools');
		$this->loadModel('Recptions');
		$this->loadModel('Contracts');
		if ($this->request->is(['post'])) {
			$childinfo = $this->Users->find('all')->where(['uuid' => $this->request->getData('child_id')])->first();
			$childdata = $this->Encryption->encryption($childinfo);
			$parent_id = $childdata['parent_id'];
			$parentuuid = $childdata['uuid'];
			$bso_id = $childdata['bso_id'];
			$childid = $this->UuId->uuid($this->request->getData('child_id'));
			$joiningdate = $this->request->getData('joiningdate');
			$BsoServices = $this->BsoServices->find('all')->where(['uuid' => $this->request->getData('planname')])->first();
			$BsoServices->cost = $this->request->getData('cost');
			if ($BsoServices['total_plans_counts'] >= $BsoServices['childin_batch']) {
				$savestart_time = date("H:i:s", strtotime($BsoServices['start_time']));
				$saveend_time = date("H:i:s", strtotime($BsoServices['end_time']));
				$data = $BsoServices['service_day'] . '<br/>';
				$data .= $BsoServices['service_type'] . '<br/>';
				$data .= 'Time Slot' . ' ' . $savestart_time . ' ' . 'To' . ' ' . $saveend_time . '<br/>';
				$this->Flash->error(_($data . 'This plan has been SoldOut.'));
				return $this->redirect(['action' => 'selectPlan', 'prefix' => false]);
			}
			$costvalue = explode('-', $this->request->getData('cost'));
			$Contractsplan = $this->Contracts->find('all')->where(['plan_id' => $this->request->getData('planname'), 'bso_id' => $bso_id, 'child_id' => $childid])->first();
			if (!empty($Contractsplan)) {
				$plan_type = $costvalue[1];
				$service_day = $BsoServices['service_day'];
				$expireydate = $this->TimetoSec->expireydate($plan_type, $service_day, $joiningdate);
				$price = $costvalue[0];

				$status = 1;
				$start_date = $joiningdate;
				$expirey_date = $expireydate;
				$users = TableRegistry::get('Contracts');
				$query = $users->query();
				$query->update()
					->set([
						'plan_type' => $plan_type,
						'price' => $price,
						'status' => $status,
						'start_date' => $start_date,
						'expirey_date' => $expirey_date,
					])
					->where(['id' => $Contractsplan['id']])
					->execute();

			} else {
				$BsoServices = $this->BsoServices->find('all')->where(['uuid' => $this->request->getData('planname')])->first();
				//pr($BsoServices);die;
				$Contract = $this->Contracts->newEntity();
				$add_teacher_no = $BsoServices['add_teacher_no'];
				$Contract->parent_id = $parent_id;
				$Contract->child_id = $childid;
				$Contract->bso_id = $bso_id;
				$plan_type = $costvalue[1];
				$service_day = $BsoServices['service_day'];
				$expireydate = $this->TimetoSec->expireydate($plan_type, $service_day, $joiningdate);
				//pr($expireydate);die;
				$savestart_time = date("H:i:s", strtotime($BsoServices['start_time']));
				$saveend_time = date("H:i:s", strtotime($BsoServices['end_time']));
				$Contract->price = $costvalue[0];
				$Contract->service_day = $BsoServices['service_day'];
				$Contract->service_type = '';
				$Contract->status = 1;
				$Contract->plan_type = $plan_type;
				$Contract->start_time = $savestart_time;
				$Contract->end_time = $saveend_time;
				$Contract->start_date = $joiningdate;
				$Contract->min_age = $BsoServices['min_age'];
				$Contract->max_age = $BsoServices['max_age'];
				$Contract->add_teacher = $add_teacher_no;
				$Contract->expirey_date = $expireydate;
				$Contract->plan_id = $this->request->getData('planname');
				//pr($Contract);die('poi');
				$saved = $this->Contracts->save($Contract);
				$users = TableRegistry::get('Contracts');
				$query = $users->query();
				$query->update()
					->set(['registration_id' => $saved->id])
					->where(['id' => $saved->id])
					->execute();
			}
			echo json_encode($this->request->getData('child_id'));die;
			//$this->redirect(['action' => 'childServices', $this->request->getData('child_id'], 'prefix' => false]);
		}

	}
	public function attendanceSettings() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Settings');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$this->loadModel('GlobalSettings');
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $dataid])->first();
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		if ($this->request->is(['patch', 'post', 'put'])) {
			if ($Setting) {
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->relieftimebeforeclass = $this->request->getData(['relieftimebeforeclass']);
				$Setting->relieftimeafterclass = $this->request->getData(['relieftimeafterclass']);
				$Setting->overtimecost = $this->request->getData(['overtimecost']);
				//pr($Setting);die;
				if ($savedid = $this->Settings->save($Setting)) {
					$this->Flash->success(_('Attendances Saved Sucessfully.'));
					//pr("save");die("save");
					return $this->redirect(['action' => 'attendanceSettings', 'prefix' => false]);
				}
			} else {
				$Setting = $this->Settings->newEntity();
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->bso_id = $dataid;
				$Setting->relieftimebeforeclass = $this->request->getData(['relieftimebeforeclass']);
				$Setting->relieftimeafterclass = $this->request->getData(['relieftimeafterclass']);
				$Setting->overtimecost = $this->request->getData(['overtimecost']);
				//pr($Setting);die;
				if (!$Setting->getErrors()) {
					$savedid = $this->Settings->save($Setting);
					$this->Flash->success(_('Attendances Saved Sucessfully.'));
					//pr("save");die("save");
					return $this->redirect(['action' => 'attendanceSettings', 'prefix' => false]);
				}
				//$this->Flash->error(__('Manage Invoice Setting has not been. Please, try again.'));
				pr("error");die();
			}
		}
		//pr($Setting);die;
		$this->set(compact('Setting', 'GlobalSettings'));

	}
	public function priceweekly() {
		$this->autoRender = false;
		$this->loadModel('Settings');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		if ($this->request->is(['patch', 'post', 'put'])) {
			if ($Setting) {
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->priceweekly = $this->request->getData(['id']);
				if ($savedid = $this->Settings->save($Setting)) {
					$this->Flash->success(_('Price Weekly Service Saved Sucessfully.'));
					pr("update");die("update");
				}
			} else {
				$Setting = $this->Settings->newEntity();
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->bso_id = $dataid;
				$Setting->priceweekly = $this->request->getData(['id']);
				if (!$Setting->getErrors()) {
					$savedid = $this->Settings->save($Setting);
					$this->Flash->success(_('Price Weekly Service Saved Sucessfully.'));
					pr("save");die("save");
				}
				//$this->Flash->error(__('Manage Invoice Setting has not been. Please, try again.'));
				pr("error");die();
			}
		}
	}
	public function pricemonthly() {
		$this->autoRender = false;
		$this->loadModel('Settings');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		if ($this->request->is(['patch', 'post', 'put'])) {
			if ($Setting) {
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->pricemonthly = $this->request->getData(['id']);
				if ($savedid = $this->Settings->save($Setting)) {
					$this->Flash->success(_('Price Monthly Service Saved Sucessfully.'));
					pr("update");die("update");
				}
			} else {
				$Setting = $this->Settings->newEntity();
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->bso_id = $dataid;
				$Setting->pricemonthly = $this->request->getData(['id']);
				if (!$Setting->getErrors()) {
					$savedid = $this->Settings->save($Setting);
					$this->Flash->success(_('Price Monthly Service Saved Sucessfully.'));
					pr("save");die("save");
				}
				//$this->Flash->error(__('Manage Invoice Setting has not been. Please, try again.'));
				pr("error");die();
			}
		}
	}
	public function priceyearly() {
		$this->autoRender = false;
		$this->loadModel('Settings');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		if ($this->request->is(['patch', 'post', 'put'])) {
			if ($Setting) {
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->priceyearly = $this->request->getData(['id']);
				if ($savedid = $this->Settings->save($Setting)) {
					$this->Flash->success(_('Price Yearly Service Saved Sucessfully.'));
					pr("update");die("update");
				}
			} else {
				$Setting = $this->Settings->newEntity();
				$Setting = $this->Settings->patchEntity($Setting, $this->request->getData());
				$Setting->bso_id = $dataid;
				$Setting->priceyearly = $this->request->getData(['id']);
				if (!$Setting->getErrors()) {
					$savedid = $this->Settings->save($Setting);
					$this->Flash->success(_('Price Yearly Service Saved Sucessfully.'));
					pr("save");die("save");
				}
				//$this->Flash->error(__('Manage Invoice Setting has not been. Please, try again.'));
				pr("error");die();
			}
		}
	}
	public function shiftPlan($id = null) {
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->loadModel('GlobalSettings');
		$this->viewBuilder()->setLayout('admin');
		$child_id = $this->UuId->uuid($id);
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$Currentdate = date("Y-m-d");
		$plandata = $this->Contracts->find('all')
			->contain(['Users' =>
				['fields' =>
					['firstname',
						'lastname',
						'encryptionkey',
						'uuid',
						'relation'],
				],
			])
			->where(
				['Contracts.child_id' => $child_id,
					'expirey_date >=' => $Currentdate,
					'status' => '1',
				]
			)
			->hydrate(false)
			->toArray();

		//$plandata['user'] = $this->Encryption->encryption($plandata[0]['user']);
		//pr($plandata);die;

		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $bso_id])->first();
		$this->set(compact('plandata', 'GlobalSettings'));

	}
	public function buyServices($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('BsoServices');
	}
	public function serviceSettings() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Settings');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		$this->set(compact('Setting'));
	}
	public function invoiceSettings() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Settings');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		//pr($dataid);die;
		$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
		//pr($Setting);die;
		$this->set(compact('Setting'));
	}

}