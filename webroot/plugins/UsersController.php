<?php
namespace App\Controller\Parent;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

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
		$this->loadComponent('Flash');
		$this->loadComponent('EmailSend');
		$this->loadComponent('UuId');
		$this->loadComponent('TimetoSec');
		$this->loadComponent('GenratePdf');
		$this->Auth->allow(array('paymentPdf'));
		$this->loadComponent('Encryption');

	}

	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */

	public function index() {
		$this->viewBuilder()->setLayout('Parent');

		$users = $this->paginate($this->Users);

		$this->set(compact('users'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */

	public function view($id = null) {
		$this->viewBuilder()->setLayout('Parent');

		$user = $this->Users->get($id, [
			'contain' => [],
		]);

		$this->set('user', $user);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */

	public function add() {
		$this->viewBuilder()->setLayout('Parent');
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('User has been updated.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('User could not be updated. Please, try again.'));
		}
		$this->set(compact('user'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */

	public function edit($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		$user = $this->Users->get($id, [
			'contain' => [],
		]);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());

			if ($this->Users->save($user)) {
				$this->Flash->success(__('User has been saved.'));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('User could not be saved. Please, try again.'));
		}

		$this->set(compact('user'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */

	public function delete($id = null) {
		//pr($id);die;
		$userid = $this->UuId->uuid($id);
		//$this->request->allowMethod(['post', 'delete']);
		$user = $this->Users->get($userid);

		if ($this->Users->delete($user)) {
			$this->Flash->success(__('User has been deleted.'));
		} else {
			$this->Flash->error(__('User could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	public function profileEdit($id) {

		if ($userid = $this->UuId->uuid($id)) {
			$this->viewBuilder()->setLayout('Parent');
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
				$newdob = explode(' ', $_POST['dob']);
				$idob = implode('/', $newdob);
				$var = ltrim($idob, '/');
				$date = str_replace('/', '-', $var);
				$newdob = explode(' ', $_POST['dob']);
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
						return $this->redirect(['action' => 'profile-edit', 'prefix' => 'parent', $id]);
					}
				}
				$this->Flash->error(__('There are some problem to update profile. Please try again!'));

			}
			$user = $this->Encryption->encryption($user);
			$this->set(compact('user'));
			//$this->set('user',$user);
		}
	}

	public function resetPassword() {
		$id = $this->request->getSession()->read('Auth.User.id');
		$emal = $this->request->getSession()->read('Auth.User.email');
		$user = $this->Users->get($id);
		$this->viewBuilder()->setLayout('Parentplan');

		if ($this->request->is(['patch', 'post', 'put'])) {

			// $user->lastname = base64_decode($user['lastname']);
			// $user->firstname = base64_decode($user['firstname']);
			// $user->email = base64_decode($user['email']);
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$password = $_POST['password'];

			if (!$user->getErrors()) {
				$user->flag = "1";

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
				return $this->redirect(['action' => 'logout']);

			} else {
				$this->Flash->error(_('Password could not be Updated. Please, try again.'));
			}
		}
		$this->set(compact('user'));
	}

	public function logout() {
		$this->autoRender = false;
		$this->Auth->logout();
		return $this->redirect(['controller' => 'users', 'action' => 'login', 'prefix' => false]);
	}

	/***Basic Info Details***/

	public function personaldata() {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->loadModel('Recptions');
			//pr($this->request->getData());die;
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
			//pr($_POST);
			$count = count($_POST['data']);
			$Createddate = date("Y-m-d h:i:sa");
			$dataid = $this->request->getSession()->read('Auth.User.uuid');
			$user = $this->Users->find('all')->where(['uuid' => $dataid])->first();
			$encryptionKey = $user['encryptionkey'];
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
					$user->encryptionkey = $encryptionKey;
					//	pr($user);die;
					$this->Users->encryptData = 'Yes';
					$this->Users->encryptionKey = $encryptionKey;
					//pr($user); die;
					$savedid = $this->Users->save($user);

				}

			}
			$count2 = count($_POST['reception']);
			//pr($_POST['child_id']);die;
			$childid = $this->UuId->uuid($_POST['child_id']);
			$recptiondata = $this->Recptions->find('all')->where(['child_id' => $childid])->first();

			if (!empty($recptiondata)) {
				$recptions = TableRegistry::get('Recptions');
				$query = $recptions->query();
				$query->delete()
					->where(['child_id' => $childid])
					->execute();

			}

			for ($i = 0; $i < count($_POST['reception']); $i++) {
				$recption = $this->Recptions->newEntity();
				$recption->ingestion_date = date('Y-m-d', strtotime($_POST['ingestion_date']));
				$recption->mobile_no = $_POST['mobile_no'];
				$recption->child_id = $childid;
				$recption->reception = $_POST['reception'][$i];
				$recption->parent_id = $_POST['parent_id'];
				$recption->bso_id = $_POST['bsoid'];
				$recption->reception_date = date('Y-m-d', strtotime($_POST['reception_date'][$i]));
				$this->Recptions->encryptData = 'Yes';
				$this->Recptions->encryptionKey = $encryptionKey;
				$savedreception = $this->Recptions->save($recption);
			}
			$responce = $this->Flash->success(__('success'));
			pr($responce);die('end');

		}

	}

	public function socialbehavior() {
		$this->autoRender = false;
		$savedBehaviorandSocial = array("failed");

		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($this->request->getdata());die;
			$user = $this->Users->find('all')->where(['uuid' => $_POST['child_id']])->first();
			$encryptionKey = $user['encryptionkey'];
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
				$this->BehaviorandSocials->encryptData = 'Yes';
				$this->BehaviorandSocials->encryptionKey = $encryptionKey;
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

	public function addChild($id = null) {
		$dataid = $this->request->getSession()->read('Auth.User.uuid');
		$user = $this->Users
			->find('all')
			->where(['uuid' => $dataid])
			->first();
		$encryptionKey = $user['encryptionkey'];

		$parents = $this->Users
			->find('all')
			->where(['id' => $user->id])
			->first();
		$this->viewBuilder()->setLayout('Parent');
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

				$dataid = $this->request->getSession()->read('Auth.User.bso_id');
				$password = $this->request->getParam('password');

				if (!$user->getErrors()) {

					$user->created = $Createddate;
					$user->role_id = "5";
					$user->group_id = "5";
					$user->bso_id = $dataid;
					$user->created = $Createddate;
					$user->relation = $relation;
					$user->dob = $dobnew;
					$user->is_active = '1';
					$user->school = $schoolid;
					$user->uuid = Text::uuid();
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

					$this->Flash->success(__('Child has been saved.'));
					return $this->redirect(['action' => 'manageChildren', 'prefix' => 'parent']);

				}
			}
			$this->Flash->error(__('Child could not be saved. Please, try again.'));
		} else {

		}

		$this->set(compact('user', 'parents'));
	}

	public function childEdit($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		$this->loadModel('Schools');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$Schools = $this->Schools->find('all')->where(['id' => $user['school']])->first();
		$this->Users->getValidator()->remove('image');
		$this->Users->getValidator()->remove('email');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('gender');
		$this->Users->getValidator()->remove('dob');
		$this->Users->getValidator()->remove('lastname');
		$this->Users->getValidator()->remove('confirm_password');

		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($this->request->getData());die;
			if ($_POST['relation1'] == '3') {
				$relation = $_POST['relation'];
			} elseif ($_POST['relation1'] == '2') {
				$relation = 'Daughter';
			} elseif ($_POST['relation1'] == '1') {
				$relation = 'Son';
			}
			$parant = $this->Users->find('all')->where(['id' => $user->parent_id])->first();
			$newdob = explode(' ', $_POST['dob']);
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
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
			$user->relation = $relation;
			$user->dob = $dobnew;
			//pr($user);die;
			// $bsouuid =
			$encryptionKey = $user['encryptionkey'];
			//$user->encryptionkey =
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

						}
					}
				}
				$this->Flash->success(_('Child profile has been updated.'));
				return $this->redirect(['action' => 'manageChildren']);
			}

			$this->Flash->error(__('There are some problem to update Child. Please try again!'));
		}
		$user = $this->Encryption->encryption($user);
		//pr($user);die;
		$this->set(compact('user', 'Schools'));

	}

	public function childDeactivate($id = null) {
		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($id);
			$user = $this->Users->get($userid, ['contain' => []]);
			$user->is_active = "0";

			if ($this->Users->save($user)) {
				$this->Flash->success(_('Child has been deactivated.'));
				return $this->redirect(['action' => 'manageChildren', 'prefix' => 'parent']);
			}

			$this->Flash->error(_('Employee could not be deactivated.'));
		}

		$this->set(compact('user'));

	}

	public function childActivate($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($id);
			$user = $this->Users->get($userid, ['contain' => []]);
			$user->is_active = "1";

			if ($save = $this->Users->save($user)) {

				$this->Flash->success(_('Child has been activated.'));
				return $this->redirect(['action' => 'manageChildren', 'prefix' => 'parent']);
			}

			$this->Flash->error(_('Child could not be deactivated.'));
		}

		$this->set(compact('user'));

	}

	public function childDelete($id) {
		$this->autoRender = false;
		//$this->request->allowMethod(['post', 'delete']);
		$userid = $this->UuId->uuid($id);
		$user = $this->Users->get($userid);

		if ($this->Users->delete($user)) {
			$this->Flash->success(__('Child has been deleted.'));
		} else {
			$this->Flash->error(__('Child could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'manageChildren', 'prefix' => 'parent']);
	}

	public function basicInfo($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		$userid = $this->UuId->uuid($id);
		$this->loadModel('Recptions');
		$this->loadModel('BehaviorandSocials');
		$this->loadModel('MedicalEmotionals');
		$this->loadModel('EducationalLanguages');
		$this->loadModel('Schools');
		$this->loadModel('Otherinformations');
		$this->loadModel('Contracts');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$user = $this->Encryption->encryption($user);
		$Schools = $this->Schools->find('all')->where(['id' => $user['school']])->first();
		$recption = $this->Recptions->find('all')->where(['child_id' => $userid])->toArray();
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
		$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'clint_sign', 'encryptionkey'])->where(['id' => $childparent, 'role_id' => '4', 'bso_id' => $bsoid])->first();
		$parent = $this->Encryption->encryption($parent);

		if (empty($parent)) {
			$parent = $this->Users->newEntity();
		}

		$guardian = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'relation', 'id', 'encryptionkey'])->where(['parent_id' => $childparent, 'role_id' => '4', 'bso_id' => $bsoid])->toArray();
		$guardian = $this->Encryption->encryption($guardian);
		$this->set(compact('guardian', 'user', 'recption', 'behaviorandSocial', 'otherinformations', 'educationallanguages', 'medicalemotionals', 'childparent', 'bsoid', 'id', 'Schools', 'parent', 'contracts'));
	}
	public function childview($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		$userid = $this->UuId->uuid($id);
		$this->loadModel('Recptions');
		$this->loadModel('BehaviorandSocials');
		$this->loadModel('MedicalEmotionals');
		$this->loadModel('EducationalLanguages');
		$this->loadModel('Otherinformations');
		$this->loadModel('Schools');
		$this->loadModel('Contracts');
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

		$guardian = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'relation', 'id', 'encryptionkey'])->where(['parent_id' => $childparent, 'role_id' => '4', 'bso_id' => $bsoid])->toArray();

		foreach ($guardian as $key => $value) {
			//pr($value);die;

			$guardiandata[] = $this->Encryption->encryption($value);
		}
		//pr($guardiandata);die;
		$this->set(compact('guardian', 'user', 'recption', 'behaviorandSocial', 'otherinformations', 'educationallanguages', 'medicalemotionals', 'childparent', 'bsoid', 'id', 'Schools', 'parent', 'contracts'));
	}
	public function manageChildren() {
		$this->viewBuilder()->setLayout('Parent');
		$childCondition = [];
		$search = isset($_GET['ids']) ? $_GET['ids'] : "";
		$childCondition[] = ["CONCAT(firstname,'',lastname) LIKE" => "%" . $search . "%"];
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$bsoid = $this->request->getSession()->read('Auth.User.bso_id');
		// $profile = $this->Users->get($userid, ['contain' => []]);
		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				$childCondition,
				'role_id' => 5,
				'bso_id' => $bsoid,
				'parent_id' => $dataid,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];

		$users = $this->paginate($this->Users);

		//$this->set(compact('users'));

	}
	public function manageChildrendata() {
		$this->viewBuilder()->setLayout('ajax');
		$childCondition = [];
		$record = [];
		$detail = [];
		$search = isset($_GET['ids']) ? $_GET['ids'] : "";
		$childCondition[] = ["CONCAT(firstname,'',lastname) LIKE" => "%" . $search . "%"];
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$bsoid = $this->request->getSession()->read('Auth.User.bso_id');
		// $profile = $this->Users->get($userid, ['contain' => []]);
		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				$childCondition,
				'role_id' => 5,
				'bso_id' => $bsoid,
				'parent_id' => $dataid,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];

		$users = $this->paginate($this->Users);
		foreach ($users as $key => $value) {
			$info = $this->Encryption->encryption($value);
			if ($info->gender == 1) {$gender = "Male";} else { $gender = "Female";}
			if ($info->is_active == 0) {$status = "Not Activated Yet";} else { $status = "Activated";}
			$record[] = array(
				'id' => $info['id'],
				'uuid' => $info['uuid'],
				'name' => $info['firstname'] . ' ' . $info['lastname'],
				'image' => ($info['image']) ? $info['image'] : '',
				'gender' => $gender,
				'dob' => date('d-m-Y', strtotime($info['dob'])),
				'status' => $status,
			);
		}
		//pr($record);die;

		$countrecord = count($record);
		$detail = array(
			"draw" => 1,
			"recordsTotal" => $countrecord,
			"recordsFiltered" => $countrecord,
			"data" => $record,
		);
		echo json_encode($detail);die;
		// $this->set(compact('users'));

	}

	public function manageGuardian() {
		$this->viewBuilder()->setLayout('Parent');
		$parentCondition = [];
		$userdata = [];
		$search = isset($_GET['ids']) ? $_GET['ids'] : "";
		$parentCondition[] = ["CONCAT(firstname,'',lastname) LIKE" => "%" . $search . "%"];
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$bsoid = $this->request->getSession()->read('Auth.User.bso_id');
		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				$parentCondition,
				'role_id' => 4,
				'bso_id' => $bsoid,
				'parent_id' => $dataid,

			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];
		$users = $this->paginate($this->Users);
		foreach ($users as $key => $value) {
			$userdata[] = $this->Encryption->encryption($value);
		}
		$this->set(compact('userdata'));
	}
	public function manageGuardiandata() {
		$this->viewBuilder()->setLayout('ajax');
		$parentCondition = [];
		$search = isset($_GET['ids']) ? $_GET['ids'] : "";
		$parentCondition[] = ["CONCAT(firstname,'',lastname) LIKE" => "%" . $search . "%"];
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$bsoid = $this->request->getSession()->read('Auth.User.bso_id');
		$record = [];
		$this->paginate = [
			'limit' => 10,
			'contain' => [],
			'conditions' => [
				$parentCondition,
				'role_id' => 4,
				'bso_id' => $bsoid,
				'parent_id' => $dataid,

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
	}
	public function viewGuardian($id = null) {
		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($this->request->getData(['id']));
			$guardian = $this->Users->find('all')->where(['id' => $userid])->first();
			$guardian = $this->Encryption->encryption($guardian);
			echo json_encode($guardian);die;
		}

	}
	public function guardianDeactivate($id = null) {
		$this->autoRender = false;
		//pr($id);die;

		$userid = $this->UuId->uuid($id);
		$user = $this->Users->get($userid, ['contain' => []]);
		$user->is_active = "0";

		if ($this->Users->save($user)) {
			$this->Flash->success(_('Child has been deactivated.'));
			return $this->redirect(['action' => 'manageGuardian', 'prefix' => 'parent']);
		}

		$this->Flash->error(_('Employee could not be deactivated.'));

		$this->set(compact('user'));

	}

	public function guardianActivate($id = null) {
		$this->autoRender = false;

		$userid = $this->UuId->uuid($id);
		$user = $this->Users->get($userid, ['contain' => []]);
		$user->is_active = "1";

		if ($save = $this->Users->save($user)) {

			$this->Flash->success(_('Child has been activated.'));
			return $this->redirect(['action' => 'manageGuardian', 'prefix' => 'parent']);
		}

		$this->Flash->error(_('Child could not be deactivated.'));

		$this->set(compact('user'));

	}

	public function guardianDelete($id) {
		$this->autoRender = false;
		$userid = $this->UuId->uuid($id);
		// $this->request->allowMethod(['post', 'delete']);
		$user = $this->Users->get($userid);

		if ($this->Users->delete($user)) {
			$this->Flash->success(__('Child has been deleted.'));
		} else {
			$this->Flash->error(__('Child could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'manageGuardian', 'prefix' => 'parent']);
	}

	public function addGuardian() {
		$this->viewBuilder()->setLayout('Parent');
		$dataid = $this->request->getSession()->read('Auth.User.uuid');
		$parentid = $this->UuId->uuid($dataid);
		$parents = $this->Users->find('all')->where(['id' => $parentid])->first();
		$encryptionKey = $parents['encryptionkey'];

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

			$file = $this->request->getData('image');
			unset($this->request->data['image']);
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$dataid = $this->request->getSession()->read('Auth.User.bso_id');

			if (!$user->getErrors()) {
				$user->bso_id = $parents->bso_id;
				$user->role_id = "4";
				$user->group_id = "4";
				$user->dob = $dobnew;
				$user->is_active = '1';
				$user->parent_id = $parentid;
				$user->relation = $relation;
				$user->created = $Createddate;
				$user->uuid = Text::uuid();
				$user->encryptionkey = $encryptionKey;
				$this->Users->encryptData = 'Yes';
				$this->Users->encryptionKey = $encryptionKey;

				if ($savedid = $this->Users->save($user)) {

					$regid = $this->Encryption->genrateInvoiceNumber($savedid->id);
					//pr($regid);die;
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

					$this->Flash->success(__('Employee has been saved.'));
					return $this->redirect(['action' => 'manageGuardian', 'prefix' => 'parent']);
				}
			}
			$this->Flash->error(__('Employee could not be saved. Please, try again.'));

		}

		$this->set(compact('user', 'parents'));
	}

	public function guardianEdit($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$user = $this->Encryption->encryption($user);
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
			$encryptionKey = $user['encryptionkey'];
			//$user->encryptionkey =
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
				$this->Flash->success(_('Child profile has been updated.'));
				return $this->redirect(['action' => 'manageGuardian']);
			}

			$this->Flash->error(__('There are some problem to update Child. Please try again!'));
		}
		$this->set(compact('user'));
	}

	public function buyServices($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		$this->loadModel('BsoServices');
		$this->loadModel('Contracts');
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : "";
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : "";
		$min_age = isset($_GET['min_age']) ? $_GET['min_age'] : "";
		$max_age = isset($_GET['max_age']) ? $_GET['max_age'] : "";
		$dataid = $this->request->getSession()->read('Auth.User.uuid');
		$parentid = $this->UuId->uuid($dataid);
		$user = $this->Users->find('all')->where(['uuid' => $dataid])->first();
		$Currentdate = date("Y-m-d");

		$BsoServices = $this->BsoServices->find('all')->where(['bso_id' => $user['bso_id']])->toArray();

		$Contracts = [];
		$conditions = [];
		$conditions[] = ['BsoServices.bso_id' => $user->bso_id];
		$conditions[] = ['BsoServices.total_plans_counts < BsoServices.childin_batch'];

		if ($min_age) {
			$conditions[] = ['BsoServices.min_age' => $min_age];
		}

		if ($max_age) {
			$conditions[] = ['BsoServices.max_age' => $max_age];
		}

		if ($start_time) {
			$savestart_time = date("H:i:s", strtotime($start_time));
			$conditions[] = ['BsoServices.start_time >' => $savestart_time];
		}

		if ($end_time) {
			$saveend_time = date("H:i:s", strtotime($end_time));
			$conditions[] = ['BsoServices.end_time <' => $saveend_time];
		}

		//pr($conditions);die;

		$this->paginate = [
			'limit' => 10,
			'contain' => ['Contracts' => [
				'fields' => [
					'parent_id',
					'id',
					'plan_id',
				],
			],
			],
			'conditions' => $conditions,
			// 'order' => [
			//     'Users.id' => 'DESC',
			// ],
		];

		$bsos = $this->paginate($this->BsoServices);
		// pr($bsos);die;
		$this->set(compact('bsos'));
	}
	public function selectChild($day = null) {
		$this->viewBuilder()->setLayout('Parentplan');
		$this->loadModel('BsoServices');
		$data = $this->request->getSession()->read('Auth.User');
		$parent_id = $data['id'];
		$bso_id = $data['bso_id'];
		$user = $this->Users->find('all')->select([
			'uuid',
			'firstname',
			'encryptionkey',
			'lastname',
		])->where(['parent_id' => $parent_id, 'role_id' => '5', 'bso_id' => $bso_id])->toArray();

		$this->set(compact('user'));
	}

	public function buyPlan($day = null) {

		$this->viewBuilder()->setLayout('Parentplan');
		$this->loadModel('BsoServices');
		$data = $this->request->getSession()->read('Auth.User');
		$parent_id = $data['id'];
		$bso_id = $data['bso_id'];
		$day = isset($_GET['day']) ? $_GET['day'] : '';
		$service_day = strtolower($day);
		//pr($_GET['child_id']);die;
		$plan_type = '';
		$user_uuid = $_GET['child_id'];
		$this->request->session()->write('plan.childdata.child_id', $user_uuid);
		//pr($this->request->getSession()->read('plan.plandata'));die;
		//$Services = $this->BsoServices->find('all')->where(['bso_id' => $bso_id])->toArray();
		$user = $this->Users->find('all')->where(['uuid' => $user_uuid, 'role_id' => '5', 'bso_id' => $bso_id])->first();
		$userdata = $this->Encryption->encryption($user);
		$dob = $userdata['dob'];
		$from = new \DateTime($dob);
		$to = new \DateTime('today');
		$age = $from->diff($to)->y;

		$conditions = [];
		$conditions[] = ['BsoServices.bso_id' => $bso_id];
		$conditions[] = ['BsoServices.total_plans_counts < BsoServices.childin_batch'];

		if ($age) {
			$conditions[] = ['BsoServices.min_age <=' => $age];
		}

		if ($age) {
			$conditions[] = ['BsoServices.max_age >=' => $age];
		}

		if ($service_day) {

			$conditions[] = ['BsoServices.service_day' => $service_day];
		}

		$this->paginate = [
			'contain' => [],
			'conditions' => $conditions,

		];
		$BsoServices = $this->paginate($this->BsoServices);

		$this->set(compact('BsoServices'));

	}
	public function selectPlan() {
		$this->viewBuilder()->setLayout('Parentplan');
		$this->loadModel('BsoServices');
		$data = $this->request->getSession()->read('Auth.User');
		$parent_id = $data['id'];
		$bso_id = $data['bso_id'];
		$day = isset($_GET['day']) ? $_GET['day'] : '';
		$service_day = strtolower($day);
		$child_id = $this->request->getSession()->read('plan.childdata');
		//if ($this->request->is(['patch', 'post', 'put'])) {
		///pr($this->request->getSession()->read('plan.plandata'));die;
		$plans_id = $_GET['plans_id'];
		foreach ($plans_id as $key => $values) {
			$BsoServices[] = $this->BsoServices->find('all')->where(['uuid' => $values])->toArray();
		}

		foreach ($BsoServices as $key => $value) {
			if ($value[0]['total_plans_counts'] >= $value[0]['childin_batch']) {
				$savestart_time = date("H:i:s", strtotime($value[0]['start_time']));
				$saveend_time = date("H:i:s", strtotime($value[0]['end_time']));
				$data = $value[0]['service_day'] . '<br/>';
				$data .= $value[0]['service_type'] . '<br/>';
				$data .= 'Time Slot' . ' ' . $savestart_time . ' ' . 'To' . ' ' . $saveend_time . '<br/>';
				//pr($data);die;
				$this->Flash->error(_($data . 'This plan has been SoldOut.'));
				return $this->redirect(['action' => 'buyServices', 'prefix' => 'parent']);
			}
		}

		//}
		$this->set(compact('BsoServices', 'child_id'));
	}
	public function joiningWeekselection() {
		$this->viewBuilder()->setLayout('Parentplan');
		$this->loadModel('BsoServices');
		$data = $this->request->getSession()->read('Auth.User');
		$parent_id = $data['id'];
		$bso_id = $data['bso_id'];
		$day = isset($_GET['day']) ? $_GET['day'] : '';
		$service_day = strtolower($day);
		if ($this->request->is(['patch', 'post', 'put'])) {

			$data = $this->request->getData(['data']);
			$this->request->session()->write('plan.plandata', $data);
			//pr($this->request->getSession()->read('plan.plandata'));
			//pr($this->request->getSession()->read('plan.childdata'));

			//die;
		}

	}
	public function bsoAgrement($id = null) {
		$this->viewBuilder()->setLayout('Parentplan');
		$this->loadModel('BsoServices');
		$this->loadModel('Schools');
		$this->loadModel('Recptions');
		$data = $this->request->getSession()->read('Auth.User');
		$parent_id = $data['id'];
		$bso_id = $data['bso_id'];
		$day = isset($_GET['day']) ? $_GET['day'] : '';
		$service_day = strtolower($day);
		$child_id = $this->request->getSession()->read('plan.childdata.child_id');
		$childid = $this->UuId->uuid($child_id);

		//if ($this->request->is(['patch', 'post', 'put'])) {
		$data = isset($_GET['data']) ? $_GET['data'] : '';
		//$data = $this->request->getData(['data']);
		//pr($data);die;
		$joiningdate = isset($_GET['joiningdate']) ? $_GET['joiningdate'] : '';
		$this->request->session()->write('plan.plandata', $data);

		foreach ($data as $key => $values) {

			$BsoServices[] = $this->BsoServices->find('all')->where(['uuid' => $values['planname']])->toArray();
			$BsoServices[$key][0]->cost = $values['cost'];

		}
		foreach ($BsoServices as $key => $value) {
			if ($value[0]['total_plans_counts'] >= $value[0]['childin_batch']) {
				$savestart_time = date("H:i:s", strtotime($value[0]['start_time']));
				$saveend_time = date("H:i:s", strtotime($value[0]['end_time']));
				$data = $value[0]['service_day'] . '<br/>';
				$data .= $value[0]['service_type'] . '<br/>';
				$data .= 'Time Slot' . ' ' . $savestart_time . ' ' . 'To' . ' ' . $saveend_time . '<br/>';
				$this->Flash->error(_($data . 'This plan has been SoldOut.'));
				return $this->redirect(['action' => 'buyServices', 'prefix' => 'parent']);
			}
		}
		$user = $this->Users->find('all')->where(['uuid' => $child_id])->first();
		//$childparent = $user['parent_id'];
		$encryptionkey = $user['encryptionkey'];
		$Recptions = $this->Recptions->find('all')->where(['child_id' => $childid])->toArray();

		//pr($Recptions);die('qw die');
		$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'clint_sign', 'encryptionkey', 'mobile_no'])->where(['id' => $parent_id, 'role_id' => '4', 'bso_id' => $bso_id])->first();
		$guardian = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'encryptionkey'])->where(['parent_id' => $parent_id, 'role_id' => '4', 'bso_id' => $bso_id])->toArray();
		$school_id = $user['school'];
		$school = $this->Schools->find('all')->where(['id' => $school_id])->first();

		//}
		$this->set(compact('BsoServices', 'user', 'price', 'school', 'guardian', 'parent', 'day', 'joiningdate', 'Recptions', 'encryptionkey'));

	}

	public function contract($id = null) {
		$this->viewBuilder()->setLayout('Parentplan');
		$this->loadModel('BsoServices');
		$this->loadModel('Schools');
		$this->loadModel('Recptions');
		$data = $this->request->getSession()->read('Auth.User');
		$parent_id = $data['id'];
		$bso_id = $data['bso_id'];
		$day = isset($_GET['day']) ? $_GET['day'] : '';
		$service_day = strtolower($day);
		$child_id = $this->request->getSession()->read('plan.childdata.child_id');
		$childid = $this->UuId->uuid($child_id);
		//if ($this->request->is(['patch', 'post', 'put'])) {
		$joiningdate = isset($_GET['joiningdate']) ? $_GET['joiningdate'] : '';
		//pr($joiningdate);die;
		$data = $this->request->getSession()->read('plan.plandata');
		//$data = isset($_GET['data']) ? $_GET['data'] : '';
		foreach ($data as $key => $values) {
			//pr($values['cost']);die;
			$BsoServices[] = $this->BsoServices->find('all')->where(['uuid' => $values['planname']])->toArray();
			$BsoServices[$key][0]->cost = $values['cost'];
		}
		foreach ($BsoServices as $key => $value) {
			if ($value[0]['total_plans_counts'] >= $value[0]['childin_batch']) {
				$savestart_time = date("H:i:s", strtotime($value[0]['start_time']));
				$saveend_time = date("H:i:s", strtotime($value[0]['end_time']));
				$data = $value[0]['service_day'] . '<br/>';
				$data .= $value[0]['service_type'] . '<br/>';
				$data .= 'Time Slot' . ' ' . $savestart_time . ' ' . 'To' . ' ' . $saveend_time . '<br/>';
				$this->Flash->error(_($data . 'This plan has been SoldOut.'));
				return $this->redirect(['action' => 'buyServices', 'prefix' => 'parent']);
			}
		}
		$user = $this->Users->find('all')->where(['uuid' => $child_id])->first();
		$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'clint_sign', 'encryptionkey', 'mobile_no'])->where(['id' => $parent_id, 'role_id' => '4', 'bso_id' => $bso_id])->first();
		$bso = $this->Users->find('all')->where(['id' => $bso_id])->first();
		//pr($bso);die;

		//}
		$this->set(compact('BsoServices', 'user', 'bso', 'school', 'guardian', 'parent', 'day', 'joiningdate', 'Recptions', 'encryptionkey'));
	}

	public function saveContract($id = null) {
		$this->autoRender = false;
		$this->loadModel('BsoServices');
		$this->loadModel('Schools');
		$this->loadModel('Recptions');
		$this->loadModel('Contracts');
		$data = $this->request->getSession()->read('Auth.User');
		$parent_id = $data['id'];
		$userids = $data['uuid'];
		$bso_id = $data['bso_id'];
		$day = isset($_GET['day']) ? $_GET['day'] : '';
		$service_day = strtolower($day);
		//pr($service_day);die;
		$child_id = $this->request->getSession()->read('plan.childdata.child_id');
		$childid = $this->UuId->uuid($child_id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$joiningdate = $this->request->getData('joiningdate');
			//pr($joiningdate);die;
			$data = $this->request->getSession()->read('plan.plandata');
			//pr($data);
			foreach ($data as $key => $values) {
				$BsoServices[] = $this->BsoServices->find('all')->where(['uuid' => $values['planname']])->toArray();
				$BsoServices[$key][0]->cost = $values['cost'];
			}
			foreach ($BsoServices as $key => $value) {
				if ($value[0]['total_plans_counts'] >= $value[0]['childin_batch']) {
					$savestart_time = date("H:i:s", strtotime($value[0]['start_time']));
					$saveend_time = date("H:i:s", strtotime($value[0]['end_time']));
					$data = $value[0]['service_day'] . '<br/>';
					$data .= $value[0]['service_type'] . '<br/>';
					$data .= 'Time Slot' . ' ' . $savestart_time . ' ' . 'To' . ' ' . $saveend_time . '<br/>';
					$this->Flash->error(_($data . 'This plan has been SoldOut.'));
					return $this->redirect(['action' => 'buyServices', 'prefix' => 'parent']);
				}
			}
			foreach ($data as $key => $values) {
				$costvalue = explode('-', $values['cost']);

				$Contractsplan = $this->Contracts->find('all')->where(['plan_id' => $values['planname'], 'bso_id' => $bso_id, 'child_id' => $childid])->first();
				if (!empty($Contractsplan)) {
					$plan_type = $costvalue[1];
					$service_day = $service_day;
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
					$BsoServices = $this->BsoServices->find('all')->where(['uuid' => $values['planname']])->first();
					//pr($service_day);die;
					$Contract = $this->Contracts->newEntity();
					$add_teacher_no = $BsoServices['add_teacher_no'];
					$Contract->parent_id = $parent_id;
					$Contract->child_id = $childid;
					$Contract->bso_id = $bso_id;
					$plan_type = $costvalue[1];
					$service_day = $service_day;
					$expireydate = $this->TimetoSec->expireydate($plan_type, $service_day, $joiningdate);
					//pr($expireydate);die;
					$savestart_time = date("H:i:s", strtotime($BsoServices['start_time']));
					$saveend_time = date("H:i:s", strtotime($BsoServices['end_time']));
					$Contract->price = $costvalue[0];
					$Contract->service_day = $service_day;
					$Contract->service_type = '';
					$Contract->status = 1;
					$Contract->plan_type = $plan_type;
					$Contract->start_time = $savestart_time;
					$Contract->end_time = $saveend_time;
					$Contract->start_date = date("Y-m-d", strtotime($joiningdate));
					$Contract->min_age = $BsoServices['min_age'];
					$Contract->max_age = $BsoServices['max_age'];
					$Contract->add_teacher = $add_teacher_no;
					$Contract->expirey_date = $expireydate;
					$Contract->plan_id = $values['planname'];
					$Contract->service_id = $BsoServices['id'];
					$saved = $this->Contracts->save($Contract);
					$users = TableRegistry::get('Contracts');
					$query = $users->query();
					$query->update()
						->set(['registration_id' => $saved->id])
						->where(['id' => $saved->id])
						->execute();
				}

			}
			$file = array();
			$imageinfo = $this->request->getData('clint_sign');
			//pr($imageinfo);die;
			if ($imageinfo['name'] != '') {
				$file = $this->request->getData('clint_sign');

			}
			unset($this->request->data['image']);
			if (isset($file['name']) && !empty($file['name'])) {
				$imageArray = $file;
				$allowdedImageExtension = array('jpg', 'jpeg', 'png');
				$image_ext = explode(".", $imageArray["name"]);
				$ext = end($image_ext);

				if (in_array($ext, $allowdedImageExtension)) {
					$this->loadComponent('Utility');
					$img_return = $this->Utility->saveImageToServer($userids, $imageArray, USER_PICTURE_FOLDER_DIRECTORY_PATH, USER_PICTURE_FOLDER_URL_PATH);

					if ($img_return['status']) {
						$imageEntity = $this->Users->get($parent_id);
						$imageEntity->clint_sign = $img_return['name'];
						$users = TableRegistry::get('Users');
						$query = $users->query();
						$query->update()
							->set(['clint_sign' => $img_return['name']])
							->where(['id' => $parent_id])
							->execute();

					}
				}
			}
			//die;
			return $this->redirect(['action' => 'myServices', $userids, 'prefix' => 'parent']);

		}

		$this->set(compact('planides', 'bso_id', 'parent_id', 'child_id'));

	}

	// public function payment($id = null) {
	//     //$this->autoRender = false;
	//     $this->viewBuilder()->setLayout('Parent');
	//     $this->loadModel('BsoServices');
	//     $this->loadModel('Schools');
	//     $this->loadModel('Contracts');
	//     $Contract = $this->Contracts->newEntity();
	//     if ($this->request->is(['patch', 'post', 'put'])) {
	//        // pr($_POST);
	//         for($i=0; $i<= count($_POST['planid']); $i++){
	//             echo $planid =$_POST['planid'][$i];
	//             $plan[] = $this->BsoServices->find('all')->where(['id'=> $planid])->first();
	//             pr($plan);die;
	//         }

	//         $Contract = $this->Contracts->patchEntity($Contract, $this->request->getData());
	//        //// pr($Contract);die;
	//             $user->bso_id = $dataid;
	//             $user->role_id = "4";
	//         if (!$Contract->getErrors()) {
	//             $saved= $this->Contracts->save($Contract);
	//             $users = TableRegistry::get('Contracts');
	//                 $query = $users->query();
	//                 $query->update()
	//                     ->set(['registration_id' => $saved->id])
	//                     ->where(['id' => $saved->id])
	//                     ->execute();
	//         }
	//     }
	//     //$this->set(compact('user'));
	// }

	public function stopService($id = null, $parent_id = null) {
		$this->loadModel('Contracts');
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$parant = $this->Users->find('all')->where(['id' => $parent_id])->first();
			$userid = $parant['uuid'];
			$Contract = $this->Contracts->get($id, ['contain' => []]);
			$Contract->status = "2";

			if ($save = $this->Contracts->save($Contract)) {

				$this->Flash->success(_('Service has been Stoped.'));
				return $this->redirect(['action' => 'myServices', $userid, 'prefix' => 'parent']);
			}

			$this->Flash->error(_('Service could not be Stoped.'));
		}

		$this->set(compact('user'));

	}

	public function resumeService($id = null, $parent_id = null) {
		$this->loadModel('Contracts');
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$parant = $this->Users->find('all')->where(['id' => $parent_id])->first();
			$userid = $parant['uuid'];
			$Contract = $this->Contracts->get($id, ['contain' => []]);
			$Contract->status = "1";

			if ($save = $this->Contracts->save($Contract)) {

				$this->Flash->success(_('Service has been Resumed.'));
				return $this->redirect(['action' => 'myServices', $userid, 'prefix' => 'parent']);
			}

			$this->Flash->error(_('Service could not be Resumed.'));
		}

		$this->set(compact('user'));

	}

	public function payService() {
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$bso_id = $_POST['bso_id'];
			$parent_id = $_POST['parent_id'];
			$child_id = $_POST['child_id'];
			$planw = trim($_POST['planid'][0], "[]");
			$planwdde = trim($planw, '""');
			$planwdr = trim($planwdde, "[]");
			$planids = explode(',', $planwdr);

			$parant = $this->Users->find('all')->where(['id' => $parent_id])->first();
			$userids = $parant['uuid'];

			for ($i = 0; $i < count($planids); $i++) {
				$plan[] = $this->BsoServices->find('all')->where(['id' => $planids[$i], 'bso_id' => $bso_id])->first();

				if ($plan[$i]['total_plans_counts'] >= $plan[$i]['childin_batch']) {
					$savestart_time = date("H:i:s", strtotime($plan[$i]['start_time']));
					$saveend_time = date("H:i:s", strtotime($plan[$i]['end_time']));
					$data = $plan[$i]['service_day'] . '<br/>';
					$data .= $plan[$i]['service_type'] . '<br/>';
					$data .= 'Time Slot' . ' ' . $savestart_time . 'To' . $saveend_time . '<br/>';
					$this->Flash->error(_($data . 'This plan has been SoldOut.'));
					return $this->redirect(['action' => 'buyServices', 'prefix' => 'parent']);
				}

				$service = $this->Contracts->find('all')->where(['plan_id' => $planids[$i], 'bso_id' => $bso_id, 'child_id' => $child_id])->toArray();
				$userid = $service[0]['id'];
				$Contract = $this->Contracts->get($userid, ['contain' => []]);
				$Contract->status = "1";
				$save = $this->Contracts->save($Contract);
			}

			return $this->redirect(['action' => 'myServices', $userids, 'prefix' => 'parent']);
		}
		$this->set(compact('user'));
	}

	public function offlinePayment($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->loadModel('Schools');

		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($_POST);die('qww');
			$bso_id = $_POST['bso_id'];
			$parent_id = $_POST['parent_id'];
			$child_id = $_POST['child_id'];
			$planw = trim($_POST['planid'][0], "[]");
			$planwdde = trim($planw, '""');
			$planwdr = trim($planwdde, "[]");
			$planids = explode(',', $planwdr);
		} else {
			$childid = $this->UuId->uuid($id);
			$contractuser = $this->Contracts->find('all')->where(['child_id' => $childid])->toArray();
			//pr($contractuser);
			$bso_id = $contractuser[0]['bso_id'];
			$parent_id = $contractuser[0]['parent_id'];
			$child_id = $contractuser[0]['child_id'];

			foreach ($contractuser as $key => $value) {
				$planids[] = $value['plan_id'];
			}
		}

		$parent = $this->Users->find('all')->where(['id' => $parent_id])->first();
		$userids = $parent['uuid'];
		$user = $this->Users->find('all')->where(['id' => $child_id])->first();
		$school_id = $user['school'];
		$childuuid = $user['uuid'];
		$school = $this->Schools->find('all')->where(['id' => $school_id])->first();
		$bso = $this->Users->find('all')->where(['id' => $bso_id])->first();

		for ($i = 0; $i < count($planids); $i++) {
			$plan[] = $this->BsoServices->find('all')->where(['id' => $planids[$i], 'bso_id' => $bso_id])->first();

			if ($plan[$i]['total_plans_counts'] >= $plan[$i]['childin_batch']) {
				$savestart_time = date("H:i:s", strtotime($plan[$i]['start_time']));
				$saveend_time = date("H:i:s", strtotime($plan[$i]['end_time']));
				$data = $plan[$i]['service_day'] . '<br/>';
				$data .= $plan[$i]['service_type'] . '<br/>';
				$data .= 'Time Slot' . ' ' . $savestart_time . 'To' . $saveend_time . '<br/>';
				$this->Flash->error(_($data . 'This plan has been SoldOut.'));
				return $this->redirect(['action' => 'buyServices', 'prefix' => 'parent']);
			}

			$service = $this->Contracts->find('all')->where(['plan_id' => $planids[$i], 'bso_id' => $bso_id, 'child_id' => $child_id])->toArray();
			$userid = $service[0]['id'];
			$Contract = $this->Contracts->get($userid, ['contain' => []]);
			$Contract->status = "1";
			$save[] = $this->Contracts->save($Contract);
			$datetime1 = new \DateTime($plan[$i]['start_time']);
			$datetime2 = new \DateTime($plan[$i]['end_time']);
			$interval = $datetime1->diff($datetime2);
			$timeslot = $interval->format('%h') . '.' . $interval->format('%i');
			$expdtimeslot = explode('.', $timeslot);
			$hour = $expdtimeslot[0];
			$minutes = $expdtimeslot[1];
			$difference[] = $this->TimetoSec->timetosec($hour, $minutes);
			$amount[] = $save[$i]['price'];

		}

		$amount = array_sum($amount);
		$difference = array_sum($difference);

		// return $this->redirect(['action' => 'myServices',$userids,'prefix' => 'parent']);

		$this->set(compact('parent', 'save', 'difference', 'amount', 'school', 'user', 'bso', 'childuuid'));

		// if(isset($this->request->query['send_email'])) {
		//     $this->viewBuilder()->setLayout('pdf');
		//     $attachment_path = $this->genratepdf($parent,$save,$difference,$amount,$school,$user,$bso,$parent_id,$child_id);

		//     $emal=$parent['email'];
		//     $message = 'Your  Invoice Please Check attachment.' . '<br/>';

		//     $to = $emal;
		//     $from = 'rtestoffshore@gmail.com';
		//     $title = 'BSO';
		//     $subject = 'Invoice Send';
		//     $attachment = $attachment_path ;
		//     $this->EmailSend->emailSendwithattach($from, $title, $to, $subject,$attachment,$message);
		//     return $this->redirect(['action' => 'offline-payment', $childuuid, 'prefix' => 'parent']);
		// }

	}

	public function paymentPdf($id = null) {
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->loadModel('Schools');
		//$this->viewBuilder()->setLayout('pdf');
		// $this->autoRender = false;
		$childid = $this->UuId->uuid($id);
		//pr($childid);die;
		$contractuser = $this->Contracts->find('all')->where(['child_id' => $childid])->toArray();
		$bso_id = $contractuser[0]['bso_id'];
		$parent_id = $contractuser[0]['parent_id'];
		$child_id = $contractuser[0]['child_id'];

		foreach ($contractuser as $key => $value) {
			$planids[] = $value['plan_id'];
		}

		$parent = $this->Users->find('all')->where(['id' => $parent_id])->first();
		$userids = $parent['uuid'];
		$user = $this->Users->find('all')->where(['id' => $child_id])->first();
		$school_id = $user['school'];
		$childuuid = $user['uuid'];
		$school = $this->Schools->find('all')->where(['id' => $school_id])->first();
		$bso = $this->Users->find('all')->where(['id' => $bso_id])->first();

		for ($i = 0; $i < count($planids); $i++) {
			$plan[] = $this->BsoServices->find('all')->where(['id' => $planids[$i], 'bso_id' => $bso_id])->first();

			if ($plan[$i]['total_plans_counts'] >= $plan[$i]['childin_batch']) {
				$savestart_time = date("H:i:s", strtotime($plan[$i]['start_time']));
				$saveend_time = date("H:i:s", strtotime($plan[$i]['end_time']));
				$data = $plan[$i]['service_day'] . '<br/>';
				$data .= $plan[$i]['service_type'] . '<br/>';
				$data .= 'Time Slot' . ' ' . $savestart_time . 'To' . $saveend_time . '<br/>';
				$this->Flash->error(_($data . 'This plan has been SoldOut.'));
				return $this->redirect(['action' => 'buyServices', 'prefix' => 'parent']);
			}

			$service = $this->Contracts->find('all')->where(['plan_id' => $planids[$i], 'bso_id' => $bso_id, 'child_id' => $child_id])->toArray();
			$userid = $service[0]['id'];
			$save[] = $this->Contracts->get($userid, ['contain' => []]);
			$datetime1 = new \DateTime($plan[$i]['start_time']);
			$datetime2 = new \DateTime($plan[$i]['end_time']);
			$interval = $datetime1->diff($datetime2);
			$timeslot = $interval->format('%h') . '.' . $interval->format('%i');
			$expdtimeslot = explode('.', $timeslot);
			$hour = $expdtimeslot[0];
			$minutes = $expdtimeslot[1];
			$difference[] = $this->TimetoSec->timetosec($hour, $minutes);
			$amount[] = $save[$i]['price'];

		}

		$amount = array_sum($amount);
		$difference = array_sum($difference);
		$this->set(compact('parent', 'save', 'difference', 'amount', 'school', 'user', 'bso', 'childuuid'));
		$builder = $this->viewBuilder();
		$builder->template('Parent/Users/paymentpdf');
		$view = $builder->build(compact('parent', 'save', 'difference', 'amount', 'school', 'user', 'bso', 'childuuid'));
		$html = $view->render(); //
		//die;

		// render to a variable
		$this->genratepdf($parent, $save, $difference, $amount, $school, $user, $parent_id, $bso, $child_id, $id, $html);

		//  if(isset($this->request->query['send_email']) && $this->request->query['send_email'] == 'true') {
		//     if($attachment_path = $this->genratepdf($parent,$save,$difference,$amount,$school,$user,$parent_id,$bso,$child_id,$id, $pdfHtml)) {
		//         // http://localhost/kindplanner_dta/parent/users/paymentpdf/'.$child_id
		//          // pr($attachment_path);die('path  condition');
		//         $emal=$parent['email'];
		//         $message = 'Your  Invoice Please Check attachment.' . '<br/>';
		//         $to = $emal;
		//         $from = 'rtestoffshore@gmail.com';
		//         $title = 'BSO';
		//         $subject = 'Invoice Send';
		//         $attachment = $attachment_path ;
		//         //pr($attachment);die('attachment_path');
		//         if ($attachment) {
		//             if($this->EmailSend->emailSendwithattach($from, $title, $to, $subject,$attachment,$message)) {
		//             //if($this->EmailSend->emailSend($from, $title, $to, $subject, $message)){
		//                 return $this->redirect(['action' => 'offlinePayment', $childuuid, 'prefix' => 'parent']);
		//                 // return $this->redirect(['action' => 'offline-payment', $childuuid, 'prefix' => 'parent']);
		//             } else {
		//                 die('not send');
		//             }
		//         }
		//   }
		// }

	}

	public function myServices($id = null) {
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->viewBuilder()->setLayout('Parent');
		$parentid = $this->UuId->uuid($id);
		//pr($parentid);die;
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
				['Contracts.parent_id' => $parentid,
					'expirey_date >=' => $Currentdate,
					'status' => '1',
				]
			)
			->hydrate(false)
			->toArray();
		//pr($plandata);die;
		$this->set(compact('plandata'));
	}

	public function mypreviousServices($id = null) {
		$this->loadModel('Contracts');
		$this->loadModel('BsoServices');
		$this->viewBuilder()->setLayout('Parent');
		$parentid = $this->UuId->uuid($id);
		$Currentdate = date("Y-m-d");
		$conditions = [];

		$conditions['AND'][] = ['Contracts.parent_id' => $parentid];

		$conditions['AND']['OR'][] = ['Contracts.status' => 0];
		$conditions['AND']['OR'][] = ['Contracts.status' => 2];
		$conditions['AND']['OR'][] = ['Contracts.status' => 1, 'expirey_date <=' => $Currentdate];

		$plandata = $this->Contracts->find('all')
			->contain([
				'Users' => [
					'fields' => [
						'firstname',
						'lastname',
						'encryptionkey',
						'id',
					],
				],
				'BsoServices' => [
					'fields' => [
						'end_time',
						'start_time',
						'price_weekly',
						'price_monthly',
						'price_yearly',
						'uuid',
					],
				],
			])
			->where($conditions)
			->hydrate(false)
			->toArray();

		$this->set(compact('plandata'));
	}

	public function myinvoices($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		$this->loadModel('ParentpaymentInvoices');
		$parentid = $this->UuId->uuid($id);
		$invoices = $this->ParentpaymentInvoices->find('all')->contain([
			'Users' => [
				'fields' => [
					'firstname',
					'lastname',
					'encryptionkey',
					'image',
					'uuid',
					'id',
				],
			],

		])
			->where(['ParentpaymentInvoices.parent_id' => $parentid])
			->distinct(['ParentpaymentInvoices.invoice_group'])
			->hydrate(false)->toArray();
		// pr($invoices);
		// pr($parentid);die;
		$this->set(compact('invoices'));
	}

	public function downloadInvoice($id = null) {
		$this->viewBuilder()->setLayout('Parent');
		//$this->viewBuilder()->setLayout('ajax');
		if ($this->request->is(['patch', 'put', 'get'])) {
			$invoicestart = $_GET['invoicestart'];
			$invoiceend = $_GET['invoiceend'];
			$due_date = $_GET['due_date'];
			$invoice_group = $_GET['invoice_group'];
			$this->loadModel('ParentpaymentInvoices');
			$userid = $this->UuId->uuid($id);
			$childdata = $this->Users->find('all')->where(['id' => $userid])->first();
			$dataid = $childdata['bso_id'];
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
			$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
			$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'encryptionkey'])->where(['id' => $users['parent_id']])->first();
			$school_id = $users['school'];
			$school = $this->Schools->find('all')->where(['id' => $school_id])->first();
			$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid, 'invoice_group' => $invoice_group])->toArray();
			// 	$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid])->order(['ParentpaymentInvoices.id' => 'DESC'])->limit($limit)->toArray();
			// asort($invoives);, strtotime($invoives[0]['createddate'])
			$Createddate = date('Y-m-d');
			$dateed = $Createddate;
			//pr($invoives[0]['createddate']);die;
			$this->set(compact('users', 'parent', 'school', 'Setting', 'invoives', 'invoicestart', 'invoiceend', 'due_date'));
			// $builder = $this->viewBuilder();
			// $builder->template('/Parent/Users/download_invoice');
			// $view = $builder->build(compact('users', 'parent', 'school', 'Setting', 'invoives', 'invoicestart', 'invoiceend', 'due_date'));
			// $html = $view->render();
			// $pdfName = 'invoice_receipt_' . $userid . '.pdf'; //name of the pdf file
			// $basePath = WWW_ROOT . 'uploads' . DS . 'invoices' . DS . $users['parent_id'] . DS . $userid . DS . $dateed . DS;
			// //$basePath = WWW_ROOT . 'uploads' . DS . 'invoices' . DS;
			// @chmod($basePath, 777);
			// $path = $basePath . $pdfName;
			// $attachment_path = $this->GenratePdf->downloadPdf($html, $path, $basePath);
			// if ($attachment_path) {
			// 	echo "pdf created";die;

			// } else {
			// 	echo "pdf not created";die;
			// }
		}
	}
	public function sendInvoice($id = null) {
		$this->viewBuilder()->setLayout('ajax');
		if ($this->request->is(['patch', 'put', 'get'])) {
			$invoice_group = $_GET['invoice_group'];
			$this->loadModel('ParentpaymentInvoices');
			$userid = $this->UuId->uuid($id);
			$childdata = $this->Users->find('all')->where(['id' => $userid])->first();
			$dataid = $childdata['bso_id'];
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
			$Setting = $this->Settings->find('all')->where(['bso_id' => $dataid])->first();
			$parent = $this->Users->find('all')->select(['uuid', 'firstname', 'lastname', 'encryptionkey'])->where(['id' => $users['parent_id']])->first();
			$school_id = $users['school'];
			$school = $this->Schools->find('all')->where(['id' => $school_id])->first();
			$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid, 'invoice_group' => $invoice_group])->toArray();
			// 	$invoives = $this->ParentpaymentInvoices->find('all')->where(['bso_id' => $dataid, 'child_id' => $userid])->order(['ParentpaymentInvoices.id' => 'DESC'])->limit($limit)->toArray();
			// asort($invoives);, strtotime($invoives[0]['createddate'])
			$Createddate = date('Y-m-d');
			$dateed = $Createddate;
			//pr($invoives[0]['createddate']);die;
			//$this->set(compact('users', 'parent', 'school', 'Setting', 'invoives', 'invoicestart', 'invoiceend', 'due_date'));
			$builder = $this->viewBuilder();
			$builder->template('/Parent/Users/send_invoice');
			$view = $builder->build(compact('users', 'parent', 'school', 'Setting', 'invoives', 'invoicestart', 'invoiceend', 'due_date'));
			$html = $view->render();
			$pdfName = 'invoice_receipt_' . $userid . '.pdf'; //name of the pdf file
			$basePath = WWW_ROOT . 'uploads' . DS . 'invoices' . DS . $users['parent_id'] . DS . $userid . DS . $dateed . DS;
			//$basePath = WWW_ROOT . 'uploads' . DS . 'invoices' . DS;
			@chmod($basePath, 777);
			$path = $basePath . $pdfName;
			$attachment_path = $this->GenratePdf->downloadPdf($html, $path, $basePath);
			if ($attachment_path) {
				echo "pdf created";die;

			} else {
				echo "pdf not created";die;
			}
		}

	}
}