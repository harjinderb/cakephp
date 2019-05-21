<?php
namespace App\Controller\Employee;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 *
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController {

	public function initialize() {
		parent::initialize();
		$this->loadComponent('Paginator');
		$this->loadComponent('Flash');
		$this->loadComponent('EmailSend');
		$this->loadComponent('UuId');
		$this->loadComponent('TimetoSec');
		$this->Auth->allow(array('paymentPdf'));
		$this->loadComponent('Encryption');

	}
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */

	public function index() {
		$this->paginate = [
			'contain' => ['Roles', 'Bsos', 'ParentEmployees', 'Groups'],
		];
		$employees = $this->paginate($this->Employees);

		$this->set(compact('employees'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Employee id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */

	public function view($id = null) {
		$employee = $this->Employees->get($id, [
			'contain' => ['Roles', 'Bsos', 'ParentEmployees', 'Groups', 'ChildEmployees'],
		]);

		$this->set('employee', $employee);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */

	public function add() {
		$employee = $this->Employees->newEntity();

		if ($this->request->is('post')) {
			$employee = $this->Employees->patchEntity($employee, $this->request->getData());

			if ($this->Employees->save($employee)) {
				$this->Flash->success(__('The employee has been saved.'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('The employee could not be saved. Please, try again.'));
		}

		$roles = $this->Employees->Roles->find('list', ['limit' => 200]);
		$bsos = $this->Employees->Bsos->find('list', ['limit' => 200]);
		$parentEmployees = $this->Employees->ParentEmployees->find('list', ['limit' => 200]);
		$groups = $this->Employees->Groups->find('list', ['limit' => 200]);
		$this->set(compact('employee', 'roles', 'bsos', 'parentEmployees', 'groups'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Employee id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */

	public function edit($id = null) {
		$employee = $this->Employees->get($id, ['contain' => []]);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$employee = $this->Employees->patchEntity($employee, $this->request->getData());

			if ($this->Employees->save($employee)) {
				$this->Flash->success(__('The employee has been saved.'));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('The employee could not be saved. Please, try again.'));
		}

		$roles = $this->Employees->Roles->find('list', ['limit' => 200]);
		$bsos = $this->Employees->Bsos->find('list', ['limit' => 200]);
		$parentEmployees = $this->Employees->ParentEmployees->find('list', ['limit' => 200]);
		$groups = $this->Employees->Groups->find('list', ['limit' => 200]);
		$this->set(compact('employee', 'roles', 'bsos', 'parentEmployees', 'groups'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Employee id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */

	public function delete($id = null) {

		$this->request->allowMethod(['post', 'delete']);
		$employee = $this->Employees->get($id);

		if ($this->Employees->delete($employee)) {
			$this->Flash->success(__('The employee has been deleted.'));
		} else {
			$this->Flash->error(__('The employee could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
	/*
		        EMPLOYEE FUNCTIONALITY
		        STARTS
	*/

	public function employees($role = null, $id = null) {
		$this->loadModel('Users');
		$this->viewBuilder()->setLayout('admin');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$bsouuid = $this->Users->find('all')->where(['id' => $dataid])->first();
		$encryptionKey = $bsouuid['uuid'];
		if ($this->request->is('post') && $this->request->getData('id')) {
			$id = $this->request->getData('id');
			$dataid = $this->request->getSession()->read('Auth.User.id');
			$this->paginate = [
				'limit' => 10,
				'contain' => [],
				'conditions' => [
					'OR' => [
						"CONCAT(firstname,'',lastname) LIKE" => "%" . $id . "%",
						//"id LIKE" => $id . "%",
					],
					'role_id' => $role,
					'bso_id' => $dataid,
					'parent_id' => '0',
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
				'OR' => [
					"CONCAT(firstname,'',lastname) LIKE" => "%" . $id . "%",
					//"id LIKE" => $id . "%",
				],
				'role_id' => 3,
				'bso_id' => $dataid,
				'parent_id' => '0',
			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];
		$users = $this->paginate($this->Users);
		$this->set(compact('users', 'encryptionKey'));
	}

	public function addEmployee() {
		$this->loadModel('Users');
		$this->viewBuilder()->setLayout('admin');
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('relation1');
		$this->Users->getValidator()->remove('account');
		$this->Users->getValidator()->remove('bank_name');
		$this->Users->getValidator()->remove('password');
		$this->Users->getValidator()->remove('confirm_password');
		$Createddate = date("Y-m-d h:i:sa");
		$employee = $this->Users->newEntity();
		$user = $this->Users->newEntity();

		if ($this->request->is('post')) {
			$file = array();
			$imageinfo = $this->request->getData('image');
			$newdob = explode(' ', $_POST['dob']);
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));

			$newjoining_date = explode(' ', $_POST['joining_date']);
			$ijoining_date = implode('/', $newjoining_date);
			$varjoining_date = ltrim($ijoining_date, '/');
			$datejoining_date = str_replace('/', '-', $varjoining_date);
			$joining_date = date('Y-m-d', strtotime($datejoining_date));

			$file = $this->request->getData('image');
			unset($this->request->data['image']);

			$user = $this->Users->patchEntity($user, $this->request->getData());
			$dataid = $this->request->getSession()->read('Auth.User.id');
			$bsouuid = $this->Users->find('all')->where(['id' => $dataid])->first();
			$encryptionKey = md5($bsouuid['uuid']);
			$length2 = 5;
			$chars1 = "0123456789";
			$registration_id = substr(str_shuffle($chars1), 0, $length2);
			$length = 8;
			$chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$password = substr(str_shuffle($chars), 0, $length);
			$user->bso_id = $dataid;
			// $user->registration_id = $registration_id;
			$user->role_id = "3";
			$user->group_id = "3";
			$user->dob = $dobnew;
			$user->is_active = '1';
			$user->joining_date = $joining_date;
			$user->password = $password;
			$user->created = $Createddate;
			$user->uuid = Text::uuid();
			$user->encryptionkey = $encryptionKey;

			if (!$user->getErrors()) {
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
								//$this->Users->save($imageEntity);
							}
						}
					}
					$string = base64_decode($savedid['email']);
					$user = strstr($string, '.com', true);
					$sendmail = $user . '.com';
					//pr($emailsend);die;
					$message = 'You are Register with BSO Portal' . '<br/>';
					$message .= 'Your Email:' . '' . $sendmail . '<br/>';
					$message .= 'Your Password:' . '' . $password . '<br/>';

					$to = $sendmail;
					$from = 'rtestoffshore@gmail.com';
					$title = 'Bso';
					$subject = 'You Register With BSO';

					$this->EmailSend->emailSend($from, $title, $to, $subject, $message);

					$this->Flash->success(__('Employee has been created.'));
					return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);
				} else {
					$this->Flash->error(__('Employee could not be created. Please, try again.'));
				}
			} else {
				$this->Flash->error(__('Employee could not be created. Please, try again.'));
			}
		}

		$this->set(compact('user'));
	}

	public function empEdit($id = null) {
		$this->viewBuilder()->setLayout('admin');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$bsouuid = $this->Users->find('all')->where(['id' => $dataid])->first();
		$encryptionKey = md5($bsouuid['uuid']);
		$employee = $this->Employees->find('all')->where(['user_uuid' => $id])->first();
		$this->Users->getValidator()->remove('school');
		$this->Users->getValidator()->remove('relation');
		$this->Users->getValidator()->remove('relation1');
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
			$newdob = explode(' ', $_POST['joining_date']);
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));
			$newjoining_date = explode(' ', $_POST['dob']);
			$ijoining_date = implode('/', $newjoining_date);
			$varjoining_date = ltrim($ijoining_date, '/');
			$datejoining_date = str_replace('/', '-', $varjoining_date);
			$joining_date = date('Y-m-d', strtotime($datejoining_date));
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
			$user->joining_date = $joining_date;
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

				$this->Flash->success(_('Employee profile has been updated.'));
				return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);
			}

			$this->Flash->error(__('There are some problem to update Employee. Please try again!'));
		}
		$this->set(compact('user', 'encryptionKey'));
	}

	public function empDeactivate($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($id);
			$user = $this->Users->get($userid, ['contain' => []]);
			$user->is_active = "0";

			if ($this->Users->save($user)) {
				$this->Flash->success(_('Employee has been deactivated.'));
				return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);
			}
			$this->Flash->error(_('Employee could not be deactivated.'));
		}

		$this->set(compact('user'));

	}

	public function empActivate($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($id);
			$user = $this->Users->get($userid, ['contain' => []]);
			$user->is_active = "1";

			if ($this->Users->save($user)) {
				$this->Flash->success(_('Employee has been deactivated.'));
				return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);
			}
			$this->Flash->error(_('Employee could not be deactivated.'));
		}
		$this->set(compact('user'));

	}

	public function empProfile($id) {

		if ($userid = $this->UuId->uuid($id)) {
			$employee = $this->Employees->find('all')->where(['user_uuid' => $id])->first();
			$profile = $this->Users->get($userid, ['contain' => []]);
			$this->viewBuilder()->setLayout('admin');
			$this->set(compact('profile'));
		}
	}

	/*
		START OF
		EMPLOYEE AVAILBALITY
	*/
	public function employeeAvailabelty($id) {
		//echo "Qwerty";die;

		if ($userid = $this->UuId->uuid($id)) {

			$this->viewBuilder()->setLayout('admin');
			$profile = $this->Users->get($userid, ['contain' => []]);
			//pr($profile);die;
		}
		$this->set(compact('profile', 'id'));

	}

	public function employeeavailabeltydata($id = null, $selectDate = null) {
		//$this->viewBuilder()->setLayout('admin');
		$this->loadModel('BsoServices');
		$this->loadModel('TeachersAllotedJobs');
		$userid = $this->UuId->uuid($id);
		$events = array();
		//'TeachersAllotedJobs.BsoServices'
		if (!empty($selectDate)) {
			$Createddate = date("Y-m-d H:m:s", strtotime($selectDate . '+ 7 days'));
			$detail = null;
			$employee = $this->Employees->find('all')->contain([])->where(['Employees.user_uuid' => $id, 'Employees.start_eventdate <=' => $Createddate])->toArray();

			foreach ($employee as $key => $row) {
				//$detail = "Name:" . ' ' . $row['event_name'] . '<br/>';
				switch ($row['week_day']) {
				case 'maandag':
					$backColor = "#a338b5cc";
					$borderColor = "#a338b5cc";
					$barColor = "#a338b5cc";
					break;
				case 'dinsdag':
					$backColor = "#5b9bd5";
					$borderColor = "#5b9bd5";
					$barColor = "#5b9bd5";
					break;
				case 'woensdag':
					$backColor = "#17540ce0";
					$borderColor = "#17540ce0";
					$barColor = "#17540ce0";
					break;
				case 'donderdag':
					$backColor = "#c79b15";
					$borderColor = "#c79b15";
					$barColor = "#c79b15";
					break;
				case 'vrijdag':
					$backColor = "#b33a31";
					$borderColor = "#b33a31";
					$barColor = "#b33a31";
					break;

				default:
					$backColor = "";
					$borderColor = "";
					$barColor = "";
					break;
				}

				if ($row['continues'] == 1 || $row['workstart_time'] >= $selectDate) {
					$arrae[$key] = $row;
					$selecteddate = date("Y-m-d", strtotime($row['start_eventdate']));
					$endddate = date("Y-m-d", strtotime($selectDate));
					$Createddate = date("Y-m-d");
					$min = date('W', strtotime($selecteddate));
					$max = date('W', strtotime($endddate));
					$diff[$key] = $max - $min;
					if ($row['week_day']) {
						// $detail .= "Name:".' '.$row['event_name'].'<br/>';
						$detail .= "Day:" . ' ' . $row['week_day'] . '<br/>';
						$detail .= "Employee Available From:" . ' ' . date("H:i:s", strtotime($row['start_eventdate'])) . '<br/>';
						$detail .= "Employee Available To" . ' ' . date("H:i:s", strtotime($row['end_eventdate'])) . '<br/>';
						$detail .= "<br/>";
					}

					$events[] = array(
						"id" => $row['id'],
						"text" => $detail,
						"start" => date("Y-m-d H:i:s", strtotime($row['start_eventdate'] . "+" . $diff[$key] . "week")),
						"end" => date("Y-m-d H:i:s", strtotime($row['end_eventdate'] . "+" . $diff[$key] . "week")),
						"backColor" => $backColor,
						"borderColor" => $borderColor,
						"barColor" => $barColor,
						"continues" => $row['continues'],
					);

				}
			}

		} else {
			$Createddate = date("Y-m-d h:i:s");
			$ddated = date("Y-m-d H:i:s", strtotime($Createddate . '+ 7 days'));
			$daygetted = '';
			$backColor = "";
			$borderColor = "";
			$barColor = "";
			$employee = $this->Employees->find('all')->contain([])->where(['user_uuid' => $id, 'start_eventdate <=' => $ddated])->hydrate(false)->toArray();
			//pr($employee);die;end_eventdate
			foreach ($employee as $key => $row) {
				//pr($row);
				$detail = "Name:" . ' ' . $row['event_name'] . '<br/>';
				switch ($row['week_day']) {
				case 'maandag':
					$backColor = "#a338b5cc";
					$borderColor = "#a338b5cc";
					$barColor = "#a338b5cc";
					break;
				case 'dinsdag':
					$backColor = "#5b9bd5";
					$borderColor = "#5b9bd5";
					$barColor = "#5b9bd5";
					break;
				case 'woensdag':
					$backColor = "#17540ce0";
					$borderColor = "#17540ce0";
					$barColor = "#17540ce0";
					break;
				case 'donderdag':
					$backColor = "#c79b15";
					$borderColor = "#c79b15";
					$barColor = "#c79b15";
					break;
				case 'vrijdag':
					$backColor = "#b33a31";
					$borderColor = "#b33a31";
					$barColor = "#b33a31";
					break;

				default:
					$backColor = "";
					$borderColor = "";
					$barColor = "";
					break;
				}
				if ($row['continues'] == 1 || $row['start_eventdate'] >= $ddated) {
					$startdate_time = explode('T', $row['start_eventdate']);
					$selecteddate = $startdate_time[0];
					$Createddate = date("Y-m-d");
					$min = date('W', strtotime($selecteddate));
					$max = date('W', strtotime($Createddate));
					$diff[$key] = $max - $min;
					if ($row['week_day']) {
						// $detail .= "Name:".' '.$row['event_name'].'<br/>';
						$detail .= "Day:" . ' ' . $row['week_day'] . '<br/>';
						$detail .= "Employee Available From:" . ' ' . date("H:i:s", strtotime($row['start_eventdate'])) . '<br/>';
						$detail .= "Employee Available To" . ' ' . date("H:i:s", strtotime($row['end_eventdate'])) . '<br/>';
						$detail .= "<br/>";
					}

					$events[] = array(
						"id" => $row['id'],
						"text" => $detail,
						"start" => date("Y-m-d H:i:s", strtotime($row['start_eventdate'] . "+" . $diff[$key] . "week")),
						"end" => date("Y-m-d H:i:s", strtotime($row['end_eventdate'] . "+" . $diff[$key] . "week")),
						"backColor" => $backColor,
						"borderColor" => $borderColor,
						"barColor" => $barColor,
						"continues" => $row['continues'],
					);
				}

			}
			//die;
		}
		echo json_encode($events);
		die;
	}

	public function rosteradd($id = null) {
		$userid = $this->UuId->uuid($id);
		$bso_id = $this->request->getSession()->read('Auth.User.id');
		$this->autoRender = false;
		$days = ['Zondag' => 'Sunday', 'Maandag' => 'Monday', 'Dinsdag' => 'Tuesday', 'Woensdag' => 'Wednesday', 'Donderdag' => 'Thursday', 'Vrijdag' => 'Friday', 'Zaterdag' => 'Saturday'];

		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($_POST);die;
			$Createddate = date("Y-m-d h:i:s");
			$day = date("Y-m-d", strtotime($_POST['start']));
			$getday = date('l', strtotime($day));
			$saveday = array_search($getday, $days);
			$savedays = strtolower($saveday);
			$continues = 0;
			$getendtime = date("Y-m-d H:i:s", strtotime($_POST['end'])) . '<br/>';
			if (date("H:i:s", strtotime($_POST['end'])) == "00:00:00") {
				$enddatetime = explode('T', $_POST['start']);
				$enddatetime[0];
				$end_time = $enddatetime[0] . ' ' . '23:59:59';
				$workend_time = '23:59:59';
			} else {
				$end_time = date("Y-m-d H:i:s", strtotime($_POST['end']));
				$workend_time = date("H:i:s", strtotime($_POST['end']));
			}
			if (!empty($_POST['continues'])) {
				$continues = 1;
				$employee = $this->Employees->newEntity();
				$employee->workstart_time = date("H:i:s", strtotime($_POST['start']));
				$employee->user_uuid = $id;
				$employee->user_id = $userid;
				$employee->bso_id = $bso_id;
				$employee->continues = $continues;
				$employee->workend_time = $workend_time;
				$employee->start_eventdate = date("Y-m-d H:i:s", strtotime($_POST['start']));
				$employee->end_eventdate = $end_time;
				$employee->week_day = $savedays;
				$employee->event_name = $_POST['name'];
				$employee->created = $Createddate;
			} else {

				$employee = $this->Employees->newEntity();
				$employee->workstart_time = date("H:i:s", strtotime($_POST['start']));
				$employee->user_uuid = $id;
				$employee->user_id = $userid;
				$employee->continues = $continues;
				$employee->workend_time = $workend_time;
				$employee->start_eventdate = date("Y-m-d H:i:s", strtotime($_POST['start']));
				$employee->end_eventdate = $end_time;
				$employee->week_day = $savedays;
				$employee->bso_id = $bso_id;
				$employee->event_name = $_POST['name'];
				$employee->created = $Createddate;
				//
			}
			//pr($employee);die('bferror');die();
			//class Result {}
			if (!$employee->getErrors()) {
				if ($savedid = $this->Employees->save($employee)) {
					$response = array(

						'result' => 'OK',
						'message' => 'Created with id: ' . $savedid['id'],
					);
					echo json_encode($response);
				}
			}

		}

	}

	public function rosteraddResize($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$workstart_time = date("H:i:s", strtotime($_POST['newStart']));
			$start_eventdate = date("Y-m-d H:i:s", strtotime($_POST['newStart']));
			$getendtime = date("Y-m-d H:i:s", strtotime($_POST['newEnd']));

			if (date("H:i:s", strtotime($_POST['newEnd'])) == "00:00:00") {
				$enddatetime = explode('T', $_POST['newStart']);
				$enddatetime[0];
				$end_eventdate = $enddatetime[0] . ' ' . '23:59:59';
				$workend_time = '23:59:59';

			} else {
				$end_eventdate = date("Y-m-d H:i:s", strtotime($_POST['newEnd']));
				$workend_time = date("H:i:s", strtotime($_POST['newEnd']));
			}

			$employee = TableRegistry::get('Employees');
			$query = $employee->query();

			$query->update()
				->set(['workstart_time' => $workstart_time, 'workend_time' => $workend_time, 'start_eventdate' => $start_eventdate, 'end_eventdate' => $end_eventdate])
				->where(['id' => $_POST['id']])
				->execute();

			$response = array(

				'result' => 'OK',
				'message' => 'Update successful',
			);

			echo json_encode($response);

		}

	}

	public function rosteraddMove($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$workstart_time = date("H:i:s", strtotime($_POST['newStart']));
			$start_eventdate = date("Y-m-d H:i:s", strtotime($_POST['newStart']));

			if (date("H:i:s", strtotime($_POST['newEnd'])) == "00:00:00") {
				$enddatetime = explode('T', $_POST['newStart']);
				$enddatetime[0];
				$end_eventdate = $enddatetime[0] . ' ' . '23:59:59';
				$workend_time = '23:59:59';

			} else {
				$end_eventdate = date("Y-m-d H:i:s", strtotime($_POST['newEnd']));
				$workend_time = date("H:i:s", strtotime($_POST['newEnd']));
			}

			$employee = TableRegistry::get('Employees');
			$query = $employee->query();

			$query->update()
				->set(['workstart_time' => $workstart_time, 'workend_time' => $workend_time, 'start_eventdate' => $start_eventdate, 'end_eventdate' => $end_eventdate])
				->where(['id' => $_POST['id']])
				->execute();

			$response = array(

				'result' => 'OK',
				'message' => 'Update successful',
			);
			echo json_encode($response);

		}

	}

	public function rostereventDelete($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$employee = $this->Employees->get($_POST['id']);

			if ($this->Employees->delete($employee)) {
				$response = array(

					'result' => 'OK',
					'message' => 'Delete successful',
				);
				echo json_encode($response);
			}

		}

	}

	public function empDelete($id) {
		$this->autoRender = false;
		$this->request->allowMethod(['post', 'delete']);
		$user = $this->Users->get($id);

		if ($this->Users->delete($user)) {
			$this->Flash->success(__('Student has been deleted.'));
		} else {
			$this->Flash->error(__('Student could not be deleted. Please, try again.'));
		}
		return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);
	}
	/*
		END OF
		EMPLOYEE AVAILBALITY
	*/
	/*
		START OF
		EMPLOYEE ROSTER
	*/

	public function roster($id) {

		if ($userid = $this->UuId->uuid($id)) {
			$this->viewBuilder()->setLayout('admin');
			$profile = $this->Users->get($userid, ['contain' => []]);
			$this->set(compact('profile', 'id'));
		}
	}

	public function employeroster($id = null, $selectDate = null) {
		$this->loadModel('BsoServices');
		$this->loadModel('TeachersAllotedJobs');
		$userid = $this->UuId->uuid($id);
		$events = array();

		if (!empty($selectDate)) {
			$Createddate = date("Y-m-d H:m:s", strtotime($selectDate . '+ 7 days'));
			$detail = null;
			//$employee = $this->Employees->find('all')->contain(['TeachersAllotedJobs.BsoServices'])->where(['Employees.user_uuid' => $id, 'Employees.start_eventdate <=' => $Createddate])->toArray();
			$employee = $this->TeachersAllotedJobs->find('all')->contain([])->where(['TeachersAllotedJobs.employee_id' => $userid])->toArray();

			foreach ($employee as $key => $row) {
				$services = $this->BsoServices->find('all')->contain([])->where(['BsoServices.start_eventdate <=' => $Createddate, 'id' => $row['service_id']])->toArray();

				foreach ($services as $key => $row) {
					$arrae[$key] = $row;
					$selecteddate = date("Y-m-d", strtotime($row['start_eventdate']));
					$endddate = date("Y-m-d", strtotime($selectDate));
					$Createddate = date("Y-m-d");
					$min = date('W', strtotime($selecteddate));
					$max = date('W', strtotime($endddate));
					$diff[$key] = $max - $min;
					$qwe = true;

					if ($row['service_day']) {
						// $detail .= "Name:".' '.$row['event_name'].'<br/>';
						$detail = "Day:" . ' ' . $row['service_day'] . '<br/>';
						$detail .= "Service Type:" . ' ' . $row['service_type'] . '<br/>';
						$detail .= "Start Time:" . ' ' . date("H:i:s", strtotime($row['start_time'])) . '<br/>';
						$detail .= "End Time:" . ' ' . date("H:i:s", strtotime($row['end_time'])) . '<br/>';
						$detail .= "<br/>";
					}

					if (strtotime($row['start_time']) >= strtotime("00:01:00") && strtotime($row['end_time']) <= strtotime("06:00:00")) {

						$backColor = "#a338b5cc";
						$borderColor = "#a338b5cc";
						$barColor = "#a338b5cc";
					}

					if (strtotime($row['start_time']) >= strtotime("06:01:00") && strtotime($row['end_time']) <= strtotime("12:00:00")) {

						$backColor = "#5b9bd5";
						$borderColor = "#5b9bd5";
						$barColor = "#5b9bd5";
					}

					if (strtotime($row['start_time']) >= strtotime("12:01:00") && strtotime($row['end_time']) <= strtotime("18:00:00")) {

						$backColor = "#b33a31";
						$borderColor = "#b33a31";
						$barColor = "#b33a31";
					}

					if (strtotime($row['start_time']) >= strtotime("18:01:00") && strtotime($row['end_time']) <= strtotime("24:00:00")) {

						$backColor = "#17540ce0";
						$borderColor = "#17540ce0";
						$barColor = "#17540ce0";
					}

					$events[] = array(
						"id" => $row['id'],
						"text" => $detail,
						"start" => date("Y-m-d H:i:s", strtotime($row['start_eventdate'] . "+" . $diff[$key] . "week")),
						"end" => date("Y-m-d H:i:s", strtotime($row['end_eventdate'] . "+" . $diff[$key] . "week")),
						"backColor" => $backColor,
						"borderColor" => $borderColor,
						"barColor" => $barColor,
						"continues" => $row['continues'],
					);

				}
			}

		} else {
			$Createddate = date("Y-m-d h:i:s");
			$ddated = date("Y-m-d H:i:s", strtotime($Createddate . '+ 7 days'));
			$employee = $this->TeachersAllotedJobs->find('all')->contain([])->where(['TeachersAllotedJobs.employee_id' => $userid])->toArray();

			foreach ($employee as $key => $row) {
				$services = $this->BsoServices->find('all')->contain([])->where(['BsoServices.start_eventdate <=' => $ddated, 'id' => $row['service_id']])->toArray();

				foreach ($services as $key => $row) {
					//echo strtotime($row['end_time']) . '<br/>' . 'end';
					if ($row['start_eventdate'] <= $ddated) {
						$startdate_time = explode('T', $row['start_eventdate']);
						$selecteddate = $startdate_time[0];
						$Createddate = date("Y-m-d");
						$min = date('W', strtotime($selecteddate));
						$max = date('W', strtotime($Createddate));
						$diff[$key] = $max - $min;
						$backColor = "";
						$borderColor = "";
						$barColor = "";
						//echo strtotime($row['end_time']) . '<br/>' . 'end';
						if ($row['service_day']) {
							// $detail .= "Name:".' '.$row['event_name'].'<br/>';
							$detail = "Day:" . ' ' . $row['service_day'] . '<br/>';
							$detail .= "Service Type:" . ' ' . $row['service_type'] . '<br/>';
							$detail .= "Start Time:" . ' ' . date("H:i:s", strtotime($row['start_time'])) . '<br/>';
							$detail .= "End Time:" . ' ' . date("H:i:s", strtotime($row['end_time'])) . '<br/>';
							$detail .= "<br/>";
						}

						$row['start_time'] = date("H:i:s", strtotime($row['start_time']));
						$row['start_time'] = date("H:i:s", strtotime($row['end_time']));
						// echo strtotime($row['start_time']) . '<br/>' . 'start';
						// echo strtotime("00:01:00") . '<br/>' . 'apna start';
						// echo strtotime($row['end_time']) . '<br/>' . 'wend';
						// echo strtotime("00:01:00") . '<br/>' . 'apna end';
						if (strtotime($row['start_time']) >= strtotime("00:01:00") && strtotime($row['end_time']) <= strtotime("06:00:00")) {

							$backColor = "#a338b5cc";
							$borderColor = "#a338b5cc";
							$barColor = "#a338b5cc";
						}

						if (strtotime($row['start_time']) >= strtotime("06:01:00") && strtotime($row['end_time']) <= strtotime("12:00:00")) {

							$backColor = "#5b9bd5";
							$borderColor = "#5b9bd5";
							$barColor = "#5b9bd5";
						}

						if (strtotime($row['start_time']) >= strtotime("12:01:00") && strtotime($row['end_time']) <= strtotime("18:00:00")) {

							$backColor = "#b33a31";
							$borderColor = "#b33a31";
							$barColor = "#b33a31";
						}

						if (strtotime($row['start_time']) >= strtotime("18:01:00") && strtotime($row['end_time']) <= strtotime("24:00:00")) {

							$backColor = "#17540ce0";
							$borderColor = "#17540ce0";
							$barColor = "#17540ce0";
						}

						$events[] = array(
							"id" => $row['id'],
							"text" => $detail,
							"start" => date("Y-m-d H:i:s", strtotime($row['start_eventdate'] . "+" . $diff[$key] . "week")),
							"end" => date("Y-m-d H:i:s", strtotime($row['end_eventdate'] . "+" . $diff[$key] . "week")),
							"backColor" => $backColor,
							"borderColor" => $borderColor,
							"barColor" => $barColor,
							"moveDisabled" => true,
							"continues" => $row['continues'],
						);
					}
				}
			}

		}
		echo json_encode($events);
		die;
	}

	/*
		EMPLOYEE PLANNING
	*/
	public function planning() {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('BsoServices');
		$this->loadModel('TeachersAllotedJobs'); //$this->autoRender = false;
		$this->loadModel('Users');
		$employee = array();
		$dataid = $this->request->getSession()->read('Auth.User.id');
		//echo $dataid = $this->request->getSession()->read('Auth.User.id');die;
		$user = $this->Users->find('all')->where(['role_id' => 3, 'bso_id' => $dataid, 'parent_id' => '0'])->toArray();
		$monday = strtotime("last monday");
		$monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;
		$sunday = strtotime(date("Y-m-d", $monday) . " +6 days");
		$date = date("Y-m-d", $monday);
		$this_week_ed = date("Y-m-d", $sunday);
		$backColor = "";
		$borderColor = "";
		$barColor = "";
		$detail = "";
		//pr($user);die;
		foreach ($user as $key => $value) {
			// pr($value);die("value");
			$value = $this->Encryption->encryption($value);
			$employee[] = array(
				"name" => $value['firstname'] . ' ' . $value['lastname'],
				"id" => (string) $value['id'],
				"backColor" => "",
			);
		}
		if (!empty($date)) {
			$ddated = date("Y-m-d H:i:s", strtotime($date . '+ 7 days'));
			// $employee = $this->TeachersAllotedJobs->find('all')->contain([])->toArray();
			//'BsoServices.start_eventdate <=' => $ddated
			// foreach ($employee as $key => $row) {
			$services = $this->TeachersAllotedJobs->find('all')->contain(['BsoServices'])->where()->toArray();
			foreach ($services as $key => $row) {
				//pr($row['bso_service']['start_eventdate']);die;
				if ($row['bso_service']['start_eventdate'] <= $ddated) {
					$startdate_time = explode('T', $row['bso_service']['start_eventdate']);
					$selecteddate = $startdate_time[0];
					$Createddate = date("Y-m-d");
					$min = date('W', strtotime($selecteddate));
					$max = date('W', strtotime($Createddate));
					$diff[$key] = $max - $min;
					//die;
				}

				if ($row['bso_service']['service_day']) {
					// $detail .= "Name:".' '.$row['event_name'].'<br/>';
					$detail = "Day:" . ' ' . $row['bso_service']['service_day'] . '<br/>';
					$detail .= "Service Type:" . ' ' . $row['bso_service']['service_type'] . '<br/>';
					$detail .= "Start Time:" . ' ' . date("H:i:s", strtotime($row['bso_service']['start_time'])) . '<br/>';
					$detail .= "End Time:" . ' ' . date("H:i:s", strtotime($row['bso_service']['end_time'])) . '<br/>';
					$detail .= "<br/>";
				}

				$row['bso_service']['start_time'] = date("H:i:s", strtotime($row['bso_service']['start_time']));
				$row['bso_service']['start_time'] = date("H:i:s", strtotime($row['bso_service']['end_time']));

				if (strtotime($row['bso_service']['start_time']) >= strtotime("00:01:00") && strtotime($row['bso_service']['end_time']) <= strtotime("06:00:00")) {

					$backColor = "#a338b5cc";
					$borderColor = "#a338b5cc";
					$barColor = "#a338b5cc";
				}

				if (strtotime($row['bso_service']['start_time']) >= strtotime("06:01:00") && strtotime($row['bso_service']['end_time']) <= strtotime("12:00:00")) {

					$backColor = "#5b9bd5";
					$borderColor = "#5b9bd5";
					$barColor = "#5b9bd5";
				}

				if (strtotime($row['bso_service']['start_time']) >= strtotime("12:01:00") && strtotime($row['bso_service']['end_time']) <= strtotime("18:00:00")) {

					$backColor = "#b33a31";
					$borderColor = "#b33a31";
					$barColor = "#b33a31";
				}

				if (strtotime($row['bso_service']['start_time']) >= strtotime("18:01:00") && strtotime($row['bso_service']['end_time']) <= strtotime("24:00:00")) {

					$backColor = "#17540ce0";
					$borderColor = "#17540ce0";
					$barColor = "#17540ce0";
				}

				$events[] = array(
					"start" => date("Y-m-d H:i:s", strtotime($row['bso_service']['start_eventdate'] . "+" . $diff[$key] . "week")),
					"end" => date("Y-m-d H:i:s", strtotime($row['bso_service']['end_eventdate'] . "+" . $diff[$key] . "week")),
					"id" => (string) $row['id'],
					"text" => $detail,
					"resource" => (string) $row['employee_id'],
					"eventHeight" => "120",
					"backColor" => $backColor,
					"borderColor" => $borderColor,
					"barColor" => $barColor,
				);
			}
			//}
			//die;

		}

		$events_list = json_encode($events);
		//pr($events_list);die;
		$employee_list = json_encode($employee);
		//pr();die;
		$this->set(compact('employee_list', 'events_list'));
	}

}
