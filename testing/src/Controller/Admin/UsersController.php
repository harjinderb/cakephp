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
		if ($this->request->is('post')) {
			$file = array();
			$dobnew = date('Y-m-d', strtotime($_POST['dob']));
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
					$savedid = $this->Users->save($user);
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
								// $savedimage = $this->Users->save(array('image'=>$img_return['name']));

							}
						}
					}

					//$string = 'saasadmin@yopmail.com16a123a114ae114a4e980ac15fd3c2b2b35da2bc8e18a115a19a8218a15a19a';
					$string = base64_decode($savedid['email']);
					$user = strstr($string, '.com', true);
					$sendmail = $user . '.com';
					//echo base64_decode($sendmail);die;
					$message = 'You are Register with BSO Portal' . '<br/>';
					$message .= 'Link:' . '' . '' . BASE_URL . '<br/>';
					$message .= 'Your Email:' . '' . '' . $sendmail . '<br/>';
					$message .= 'Your Password:' . '' . '' . $password . '<br/>';

					$to = $sendmail;
					//pr($to);die;
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

		$this->set(compact('user'));
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
		$this->set(compact('user'));
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