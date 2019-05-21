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
		$this->loadComponent('Encryption');

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

		if ($this->request->is('post')) {
			// //pr($this->request->getData('email'));
			//$emailkey = ENCRYPTION_SLUG;
			//$this->request->data['email'] = $this->mc_encrypt($this->request->getData('email'), $emailkey);
			$this->request->data['email'] = base64_encode($_POST['email'] . ENCRYPTION_SLUG);

			//pr($_POST);
			// // $userauth = array(
			// // 	"_method" => "POST",
			// // 	"email" => base64_encode($_POST['email']),
			// // 	"password" => $_POST['password'],
			// // );
			// //pr($userauth);
			//pr($this->request->getData());
			$user = $this->Auth->identify();
			//pr($user);die;
			if ($user) {
				$this->Auth->setUser($user);

				if ($user['role_id'] == '1') {
					return $this->redirect(['controller' => 'Users', 'action' => 'dashboard', 'prefix' => 'admin']);
				}

				if ($user['role_id'] == '2' && $user['is_active'] == '1') {

					if ($user['flag'] == 0 || $user['flag'] == '') {
						return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => false]);
					} else {
						return $this->redirect(['controller' => 'Users', 'action' => 'index']);
					}
				} else {
					$this->Flash->error(__('Not Activated username or password, Contact BSO'));
				}

				if ($user['role_id'] == '4' && $user['is_active'] == '1') {

					if ($user['flag'] == 0 || $user['flag'] == '') {

						return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => 'parent']);
					} else {
						return $this->redirect(['controller' => 'Users', 'action' => 'index', 'prefix' => 'parent']);

					}

				} else {
					$this->Flash->error(__('Not Activated username or password, Contact BSO'));
				}

				if ($user['role_id'] == '3' && $user['is_active'] == '1') {

					if ($user['flag'] == 0 || $user['flag'] == '') {

						return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => 'parent']);
					} else {
						return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);

					}

				} else {
					$this->Flash->error(__('Not Activated username or password, Contact BSO'));
				}

			} else {
				$this->Flash->error(__('Invalid username or password, try again'));
			}
		}
	}

	public function usersetup() {
		$this->autoRender = false;
		$ids = '';
		$dataid = $this->request->getSession()->read('Auth.User.id');

		if ($this->request->is('post')) {
			$action = $_POST['action'];
			$role = $_POST['role'];
			$parent_id = $_POST['parent_id'];

			if (isset($_POST['bso_id'])) {
				$dataid = $_POST['bso_id'];
			}

			if ($_POST['role'] == 7) {

				if (isset($_POST['ids'])) {
					$ids = $_POST['ids'];

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

				if (isset($_POST['ids'])) {
					$ids = $_POST['ids'];
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
					$session->write('Auth.User.image', $$img_return);
					$session->write('Auth.User.name', $user->firstname . ' ' . $user->lastname);

					$this->Flash->success(__('Your profile update successfuly.'));
					return $this->redirect(['action' => 'profile-edit', 'prefix' => false, $id]);
				}

				$this->Flash->error(__('There are some problem to update profile. Please try again!'));

			}

			$this->set('user', $user);
		}
	}

	public function index($role = null, $id = null) {

		if (empty($role)) {
			$dataid = $this->request->getSession()->read('Auth.User.id');
			$this->viewBuilder()->setLayout('admin');
			$this->paginate = [
				'limit' => 10,
				'contain' => [],
				'conditions' => [
					"CONCAT(firstname,'',lastname) LIKE" => $id . "%",
					'bso_id' => $dataid,
				],
				'order' => [
					'Users.id' => 'DESC',
				],
			];

			$users = $this->paginate($this->Users);
			$this->set(compact('users'));
		} else {
			$dataid = $this->request->getSession()->read('Auth.User.id');
			$this->viewBuilder()->setLayout('admin');

			$this->paginate = ['limit' => 10, 'order' => ['Users.id' => 'DESC'], 'contain' => [], 'conditions' => ["CONCAT(firstname, ' ', lastname) LIKE" => "%$id%", 'role_id' => $role, 'bso_id' => $dataid]];

			$users = $this->paginate($this->Users);
			$this->set(compact('users', 'role'));
		}
		$this->set('_serialize', 'users');
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
		$this->viewBuilder()->setLayout('admin');

		if ($this->request->is(['patch', 'post', 'put'])) {
			// $user->lastname = base64_decode($user['lastname']);aa
			// $user->firstname = base64_decode($user['firstname']);
			// $user->email = base64_decode($user['email']);
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$password = $_POST['password'];
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

		$link = $params['pass'][0];
		//pr($link);die;
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

				$to = base64_encode($user->email);
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
			$userEmail = $this->request->getdata('email');

			$users = TableRegistry::get('users')
				->find()
				->where(['email' => $userEmail])
				->first();

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

				$to = $userEmail;
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

		$childs = $this->paginate($this->Users);

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
		$guardian = $this->paginate($this->Users);
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
			$newdob = explode(' ', $_POST['dob']);
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
				$string = base64_decode($savedid['email']);
				$user = strstr($string, '.com', true);
				$sendmail = $user . '.com';
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

			$newdob = explode(' ', $_POST['dob']);
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
			$newdob = explode(' ', $_POST['dob']);
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));

			if ($_POST['relation1'] == '3') {
				$relation = $_POST['relation'];
			} elseif ($_POST['relation1'] == '2') {
				$relation = 'Daughter';
			} elseif ($_POST['relation1'] == '1') {
				$relation = 'Son';
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
			$newdob = explode(' ', $_POST['dob']);
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));
			$file = array();

			if ($_POST['relation1'] == '3') {
				$relation = $_POST['relation'];
			} elseif ($_POST['relation1'] == '2') {
				$relation = 'Daughter';
			} elseif ($_POST['relation1'] == '1') {
				$relation = 'Son';
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
			$newdob = explode(' ', $_POST['dob']);
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));

			if ($_POST['relation1'] == '3') {
				$relation = $_POST['relation'];
			} elseif ($_POST['relation1'] == '2') {
				$relation = 'Daughter';
			} elseif ($_POST['relation1'] == '1') {
				$relation = 'Son';
			}
			$file = array();
			$imageinfo = $this->request->getData('image');

			if ($imageinfo['name'] != '') {
				$file = $this->request->getData('image');
			}

			unset($this->request->data['image']);
			$schoolspostdata = array(
				'name' => $_POST['school'],
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
							pr($regid);die;
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

			$parant = $this->Users->find('all')->where(['id' => $user->parent_id])->first();
			//pr($parant);die;
			$newdob = explode(' ', $_POST['dob']);
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$newdob = explode(' ', $_POST['dob']);
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));

			if ($_POST['relation1'] == '3') {
				$relation = $_POST['relation'];
			} elseif ($_POST['relation1'] == '2') {
				$relation = 'Daughter';
			} elseif ($_POST['relation1'] == '1') {
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
				return $this->redirect(['action' => 'parentProfile', $parant['uuid'], '#' => 'child-section', 'prefix' => false]);
			}

			$this->Flash->error(__('There are some problem to update Child. Please try again!'));
		}
		$this->set(compact('user'));
	}

	public function childServices($id = null) {
		$uuid = $id;
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->viewBuilder()->setLayout('admin');
		$parentid = $this->UuId->uuid($id);
		$Currentdate = date("Y-m-d");
		$plandata = $this->Contracts->find('all')
			->contain(['Users' =>
				['fields' =>
					['firstname',
						'lastname',
						'encryptionkey',
						'relation'],
				],
			])
			->where(
				['Contracts.child_id' => $parentid,
					'expirey_date >=' => $Currentdate,
					//'status' => '1',
				]
			)
			->hydrate(false)
			->toArray();
		//pr($plandata);die;
		$this->set(compact('plandata', 'uuid'));
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
		$this->viewBuilder()->setLayout('admin');
		$Createddate = date("Y-m-d");
		$service = $this->BsoServices->newEntity();
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$employee = $this->Users->find('all')->where(['bso_id' => $dataid, 'role_id' => 3])->toArray();
		$days = ['sunday' => 'zondag', 'monday' => 'maandag', 'tuesday' => 'dinsdag', 'wednesday' => 'woensdag', 'thursday' => 'donderdag', 'friday' => 'vrijdag', 'saturday' => 'zaterdag'];

		if ($this->request->is('post')) {
			$day = $_POST['service_day'];
			$saveday = array_search($day, $days);
			$whichday = "previous" . " " . $saveday;
			//pr($whichday);
			$startdate = date("Y-m-d", strtotime($whichday));
			//pr($startdate);die;
			if (!empty($_POST['to'])) {
				//
				$teachers = implode(',', $_POST['to']);
				$day = $_POST['service_day'];
				$Starttime = $_POST['start_time'];
				$endtime = $_POST['end_time'];
				$savestart_time = date("H:i:s", strtotime($Starttime));
				$saveend_time = date("H:i:s", strtotime($endtime));
				$start_eventdate = $startdate . ' ' . $savestart_time;
				$end_eventdate = $startdate . ' ' . $saveend_time;
				$user = $this->BsoServices->find('all')->where([
					'bso_id' => $dataid,
					'service_day' => $day,
					'end_time >=' => $savestart_time,
					'start_time <=' => $saveend_time,
					'min_age' => $_POST['min_age'],
					'max_age' => $_POST['max_age'],
				])->toArray();

				if (empty($user)) {

					$service = $this->BsoServices->patchEntity($service, $this->request->getData());

					if (!$service->getErrors()) {

						$service->bso_id = $dataid;
						$service->created = $Createddate;
						$service->start_time = $savestart_time;
						$service->start_eventdate = $start_eventdate;
						$service->end_eventdate = $end_eventdate;
						$service->end_time = $saveend_time;
						$service->service_status = 1;
						$service->total_plans_counts = 0;
						$service->min_age = $_POST['min_age'];
						$service->max_age = $_POST['max_age'];
						$service->add_teacher_no = $_POST['add_teacher_no'];
						$service->add_teacher = $teachers;
						$service->uuid = Text::uuid();
						// pr($service);die;
						$savedid = $this->BsoServices->save($service);
						//pr($savedid);die('qwe');
						if ($savedid) {

							if (!empty($_POST['child_group_name'])) {

								for ($i = 0; $i < count($_POST['child_group_name']); $i++) {
									$childgroup = $this->ChildGroups->newEntity();
									$childgroup->service_id = $savedid['id'];
									$childgroup->child_group_name = $_POST['child_group_name'][$i];
									$childgroup->no_of_childs = $_POST['no_of_childs'][$i];
									$childgroup->no_of_teachers = $_POST['no_of_teachers'][$i];
									$result = $this->ChildGroups->save($childgroup);

								}
							}

							for ($i = 0; $i < count($_POST['to']); $i++) {

								$teachersallotedjob = $this->TeachersAllotedJobs->newEntity();
								$teachersallotedjob->service_id = $savedid['id'];
								$teachersallotedjob->employee_id = $_POST['to'][$i];
								$result = $this->TeachersAllotedJobs->save($teachersallotedjob);
							}

							$this->Flash->success(__('Service has been saved.'));

						}

						return $this->redirect(['action' => 'manageServices']);
					}

					$this->Flash->error(__('This service could not be saved. Please, try again.'));
				} else {
					$this->Flash->error(__('Time slot or Age Group is not valid so it could not be saved. Please, try again.'));

				}
			} else {
				$this->Flash->error(__('No Teacher Avalable For Job, try again.'));

			}
		}
		$this->set(compact('service', 'employee'));
	}

	public function editServices($id = null) {
		$this->loadModel('BsoServices');
		$this->loadModel('Employees');
		$this->loadModel('TeachersAllotedJobs');
		$this->loadModel('ChildGroups');
		$this->loadModel('Users');
		$this->viewBuilder()->setLayout('admin');

		$Createddate = date("Y-m-d");
		$service = $this->BsoServices->find('all')->where(['uuid' => $id])->first();
		$dataid = $this->request->getSession()->read('Auth.User.id');
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

			$teachers = implode(',', $_POST['to']);
			$day = $_POST['service_day'];
			$Starttime = $_POST['start_time'];
			$endtime = $_POST['end_time'];
			$savestart_time = date("H:i:s", strtotime($Starttime));
			$saveend_time = date("H:i:s", strtotime($endtime));

			$user = $this->BsoServices->find('all')->where([
				'bso_id' => $dataid,
				'service_day' => $day,
				'end_time >=' => $savestart_time,
				'start_time <=' => $saveend_time,
				'min_age' => $_POST['min_age'],
				'max_age' => $_POST['max_age'],
			])->toArray();
			$service = $this->BsoServices->patchEntity($service, $this->request->getData());

			if (!$service->getErrors()) {
				$service->bso_id = $dataid;
				$service->created = $Createddate;
				$service->start_time = $savestart_time;
				$service->end_time = $saveend_time;
				$service->start_eventdate = date("Y-m-d H:i:s", strtotime($Starttime));
				$service->end_eventdate = date("Y-m-d H:i:s", strtotime($endtime));
				$service->min_age = $_POST['min_age'];
				$service->max_age = $_POST['max_age'];
				$service->add_teacher_no = $_POST['add_teacher_no'];
				$service->add_teacher = $teachers;

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
					$teachers = array();
					for ($i = 0; $i < count($_POST['to']); $i++) {
						$this->TeachersAllotedJobs->deleteAll(array('TeachersAllotedJobs.service_id' => $service['id'], 'TeachersAllotedJobs.employee_id' => $_POST['to'][$i]));

					}

					for ($i = 0; $i < count($_POST['to']); $i++) {

						$teachersallotedjob = $this->TeachersAllotedJobs->newEntity();
						$teachersallotedjob->service_id = $savedid['id'];
						$teachersallotedjob->employee_id = $_POST['to'][$i];
						$result = $this->TeachersAllotedJobs->save($teachersallotedjob);

					}
					$this->Flash->success(__('Service has been saved.'));
					return $this->redirect(['action' => 'manageServices']);

				}

			}
			$this->Flash->error(__('This service could not be saved. Please, try again.'));

		}

		$this->set(compact('service', 'employee', 'avalableemployee', 'groups', 'employees'));

	}

	public function getservices() {
		$this->autoRender = false;
		$this->loadModel('BsoServices');
		$dataid = $this->request->getSession()->read('Auth.User.id');

		if ($this->request->is('post')) {

			$day = $_POST['day'];
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
		$search = isset($_GET['ids']) ? $_GET['ids'] : "";
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
		$start = date("H:m:s", strtotime($_POST['start']));
		$end = date("H:m:s", strtotime($_POST['end']));
		$service_day = $_POST['service_day'];

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
		//pr($employee);die;
		foreach ($employee as $key => $value) {

			$valid_employees[] = $this->Encryption->encryption($value);

		}
		//pr($valid_employees);die;
		echo json_encode($valid_employees);
		die;

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
	public function viewInvoice($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$userid = $this->UuId->uuid($id);
		$this->loadModel('Contracts');
		$this->loadModel('Attendances');
		$users = $this->Users->find('all')->contain(['Contracts', 'Attendances'])->where(['Users.id' => $userid])->first();
		//pr($users);die('users');
		$this->set(compact('users'));
	}

	public function sendInvoice($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$userid = $this->UuId->uuid($id);
		$this->loadModel('Contracts');
		$this->loadModel('Attendances');
		$users = $this->Users->find('all')->contain(['Contracts', 'Attendances'])->where(['Users.id' => $userid])->first();
		//pr($users);die('users');
		$this->set(compact('users'));

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

		$recption = $this->Recptions->find('all')->where(['child_id' => $id])->toArray();

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
			$count = count($_POST['data']);
			$Createddate = date("Y-m-d h:i:sa");

			for ($i = 0; $i < $count; $i++) {
				$user = $this->Users->newEntity();
				$id = $_POST['ids'][$i];

				if ($_POST['ids'][$i] == '-1') {
					$name = $_POST['data'][$i]['name'];
					$relation1 = $_POST['data'][$i]['relation1'];
					$relation = $_POST['data'][$i]['relation'];

					if ($relation1 == 1) {
						$relation = 'Son';
					} elseif ($relation1 == 2) {
						$relation = 'Daughter';
					} elseif ($relation1 == 3) {
						$relation = $_POST['data'][$i]['relation'];
					}

					$user->firstname = $name;
					$user->created = $Createddate;
					$user->role_id = "4";
					$user->group_id = "4";
					$user->parent_id = $_POST['parent_id'];
					$user->bso_id = $_POST['bsoid'];
					$user->relation = $relation;
					$user->uuid = Text::uuid();
					$savedid = $this->Users->save($user);

				}

			}
			$count2 = count($_POST['reception']);

			$recptiondata = $this->Recptions->find('all')->where(['child_id' => $_POST['child_id']])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('Recptions');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $_POST['child_id']])
					->execute();

			}

			for ($i = 0; $i < count($_POST['reception']); $i++) {
				$recption = $this->Recptions->newEntity();
				$recption->ingestion_date = date('Y-m-d', strtotime($_POST['ingestion_date']));
				$recption->mobile_no = $_POST['mobile_no'];
				$recption->child_id = $_POST['child_id'];
				$recption->reception = $_POST['reception'][$i];
				$recption->parent_id = $_POST['parent_id'];
				$recption->bso_id = $_POST['bsoid'];
				$recption->reception_date = date('Y-m-d', strtotime($_POST['reception_date'][$i]));
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
			$recptiondata = $this->BehaviorandSocials->find('all')->where(['child_id' => $_POST['child_id']])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('BehaviorandSocials');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $_POST['child_id']])
					->execute();

			}

			$BehaviorandSocial = $this->BehaviorandSocials->newEntity();
			$BehaviorandSocial->childlike = $_POST['childlike'];

			if ($_POST['group5'] == 2) {
				$BehaviorandSocial->childlike = "2";
			}

			$BehaviorandSocial->childprefer = $_POST['childprefer'];
			$BehaviorandSocial->childbusy = $_POST['childbusy'];

			if ($_POST['allergy'] == 2) {
				$BehaviorandSocial->childbusy = "2";
			}

			$BehaviorandSocial->childhappypeers = $_POST['childhappypeers'];
			$BehaviorandSocial->childhavebfgif = $_POST['childhavebfgif'];
			$BehaviorandSocial->childhappybrothersis = $_POST['childhappybrothersis'];
			$BehaviorandSocial->childhappyparent = $_POST['childhappyparent'];
			$BehaviorandSocial->childmove = $_POST['childmove'];
			$BehaviorandSocial->childargue = $_POST['childargue'];
			$BehaviorandSocial->child_id = $_POST['child_id'];
			$BehaviorandSocial->childinterest_otherchildern = $_POST['childinterest_otherchildern'];

			if ($_POST['argue'] == 2) {
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
			$recptiondata = $this->MedicalEmotionals->find('all')->where(['child_id' => $_POST['child_id']])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('MedicalEmotionals');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $_POST['child_id']])
					->execute();

			}

			$MedicalEmotional = $this->MedicalEmotionals->newEntity();
			$MedicalEmotional->specialdiseases = $_POST['specialdiseases'];

			if ($_POST['group15'] == 2) {
				$MedicalEmotional->specialdiseases = "2";
			}

			$MedicalEmotional->allergies = $_POST['allergies'];

			if ($_POST['group16'] == 2) {
				$MedicalEmotional->allergies = "2";
			}

			$MedicalEmotional->senses = $_POST['senses'];

			if ($_POST['group17'] == 2) {
				$MedicalEmotional->senses = "2";
			}

			$MedicalEmotional->motordevelopment = $_POST['motordevelopment'];
			$MedicalEmotional->childsick = $_POST['childsick'];

			$MedicalEmotional->differentemotions = $_POST['differentemotions'];
			$MedicalEmotional->anxiety = $_POST['anxiety'];
			$MedicalEmotional->blijheid = $_POST['blijheid'];
			$MedicalEmotional->boosheid = $_POST['boosheid'];
			$MedicalEmotional->verdriet = $_POST['verdriet'];
			$MedicalEmotional->child_id = $_POST['child_id'];

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
			$recptiondata = $this->EducationalLanguages->find('all')->where(['child_id' => $_POST['child_id']])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('EducationalLanguages');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $_POST['child_id']])
					->execute();

			}

			$EducationalLanguage = $this->EducationalLanguages->newEntity();
			$EducationalLanguage->upbringing = $_POST['upbringing'];
			$EducationalLanguage->childunderstandable = $_POST['childunderstandable'];
			$EducationalLanguage->childalwaysunderstand = $_POST['childalwaysunderstand'];

			if ($_POST['group23'] == 2) {
				$EducationalLanguage->childalwaysunderstand = "2";
			}

			$EducationalLanguage->enoughvocabulary = $_POST['enoughvocabulary'];
			$EducationalLanguage->childspeakeasily = $_POST['childspeakeasily'];
			$EducationalLanguage->stutteryourchild = $_POST['Stutteryourchild'];
			$EducationalLanguage->child_id = $_POST['child_id'];

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
			$recptiondata = $this->Otherinformations->find('all')->where(['child_id' => $_POST['child_id']])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('Otherinformations');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $_POST['child_id']])
					->execute();

			}
			$Otherinformation = $this->Otherinformations->newEntity();
			$Otherinformation->nationality_child = $_POST['nationality_child'];
			$Otherinformation->socmed_indicatie = $_POST['socmed_indicatie'];
			$Otherinformation->general_practitioner = $_POST['general_practitioner'];
			$Otherinformation->dentist = $_POST['dentist'];
			$Otherinformation->wantto_gobso = $_POST['wantto_gobso'];
			$Otherinformation->visitaplayroom = $_POST['visitaplayroom'];
			$Otherinformation->seeatransfer = $_POST['seeatransfer'];
			$Otherinformation->additionalinformation = $_POST['additionalinformation'];

			if ($_POST['group29'] == 2) {
				$Otherinformation->additionalinformation = "2";
			}

			$Otherinformation->whomwithchild_likestoplay = $_POST['whomwithchild_likestoplay'];

			if ($_POST['group30'] == 2) {
				$Otherinformation->whomwithchild_likestoplay = "2";
			}

			$Otherinformation->contactwithschool = $_POST['contactwithschool'];

			if ($_POST['group31'] == 2) {
				$Otherinformation->contactwithschool = "2";
			}

			$Otherinformation->parentsexpect = $_POST['parentsexpect'];
			$Otherinformation->child_id = $_POST['child_id'];

			if (!$Otherinformation->getErrors()) {

				$savedOtherinformation = $this->Otherinformations->save($Otherinformation);

				if ($savedOtherinformation) {
					pr($savedOtherinformation);die;

				}
			}
		}

	}

}