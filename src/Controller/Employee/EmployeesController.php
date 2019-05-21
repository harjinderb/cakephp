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
		$this->loadComponent('GenratePdf');
		$this->loadComponent('TimetoSec');
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
	public function dashboard() {
		$this->viewBuilder()->setLayout('emplayout');
		$this->loadModel('TeachersAllotedJobs');
		$this->viewBuilder()->setLayout('emplayout');
		$this->loadModel('BsoServices');
		$id = $this->request->getSession()->read('Auth.User.uuid');
		$userid = $this->UuId->uuid($id);
		$finalservices = [];
		$services = '';
		$current_date = date('d-m-Y');
		//$day = 'monday';
		$day = strtolower(date('l', strtotime($current_date))); //
		$employee = $this->TeachersAllotedJobs->find('all')->contain([])->where(['TeachersAllotedJobs.employee_id' => $userid])->toArray();
		if ($employee) {
			foreach ($employee as $key => $row) {
				$services[] = $this->BsoServices->find('all')->contain([])->where(['service_day' => $day, 'id' => $row['service_id']])->toArray();

			}

		}
		if ($services) {
			$finalservices = array_filter($services);
		}
		$this->set(compact('finalservices'));

	}
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
	public function attendance($uuid = null) {
		$this->viewBuilder()->setLayout('emplayout');
		$this->loadModel('Attendances');
		$this->loadModel('Employees');
		$this->loadModel('GlobalSettings');
		$this->loadModel('Settings');
		// pr($uuid);die;
		if ($uuid == '') {
			$employee_id = $this->request->getSession()->read('Auth.User.uuid');
		} else {
			$employee_id = $uuid;
		}
		$userid = $this->UuId->uuid($employee_id);
		$user = $this->Users->find('all')->where(['uuid' => $employee_id])->first();
		$user = $this->Encryption->encryption($user);
		$bsoid = $user['bso_id'];
		$maindescription = [];
		$GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $user['bso_id']])->first();
		$Settings = $this->Settings->find('all')->where(['bso_id' => $bsoid])->first();
		$attendance_relif_time = /*$Settings['attendance_relif_time'];*/'';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$id = $this->request->getData('id');
			$month = $this->request->getData('month');
			$userid = $this->UuId->uuid($id);
			$data = [];
			$alldates = [];
			$userdata = $this->Users->find('all')->contain([
				'Employees.Attendances' => [
					'conditions' => [
						'Attendances.type' => 'Auth',
						'Attendances.user_id' => $userid,
					],
				],
			])->where([
				'Users.uuid' => $employee_id,
			])->first();
			//pr($userdata);
			foreach ($userdata['employees'] as $key => $availablety) {
				$alldates = [];
				//$plandate = date('Y-m-01');
				$plandate = date('Y-' . $month . '-01');
				$pday = date('l', strtotime($plandate));
				$plandateday = strtolower($pday);
				$planday = $availablety['week_day'];
				$next = 'next' . ' ' . $planday;
				$nextdate = date('Y-m-d', strtotime($next, strtotime($plandate)));
				$date1 = date('Y-m-d', strtotime($nextdate));
				$date = new \DateTime($date1);
				$createddate = date("Y-m-d");
				$currentdate = strtotime($createddate);
				$thisMonth = $date->format('m');
				while ($date->format('m') === $thisMonth) {
					$alldates[] = strtotime($date->format('Y-m-d'));
					$date->modify($next);
				}
				if ($plandateday == $planday) {
					$stmplandate = strtotime($plandate);
					array_push($alldates, $stmplandate);
				}
				//pr($alldates);
				$keyc = $key;

				if (!empty($availablety->attendances)) {
					foreach ($availablety->attendances as $key => $attendtt) {
						$dateday = date('l', strtotime($attendtt['date_time']));
						if ($attendtt['type'] == 'Auth') {
							$empAttandance[$key] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
						}
						$empAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
						//[$keyc]['attendances']
						//pr($userdata['contracts']);
						//pr($attendtt['date_time']);die;
						//pr($GlobalSettings->timezone);die;
						$tz = new \DateTimeZone($GlobalSettings->timezone);
						$dateattenstart = new \DateTime($attendtt['date_time']);
						$dateattenstart->setTimezone($tz);
						$attenstart_timey = $dateattenstart->format('H:i:s');
						$attenstart_time = strtotime($attenstart_timey);

						if (!empty($attendtt['date_time_end'])) {
							$tp = new \DateTimeZone($GlobalSettings->timezone);
							$dateattenend = new \DateTime($attendtt['date_time_end']);
							$dateattenend->setTimezone($tp);
							$attenend_timey = $dateattenend->format('H:i:s');
							$attenend_time = strtotime($attenend_timey);
						} else {
							$attenend_timey = '';
							$attenend_time = '';
						}
						//pr($availablety);die;
						$contract_strttimey = date('H:i:s', strtotime($availablety->workstart_time));
						$contract_strttime = strtotime($contract_strttimey);
						$contract_endtimey = date('H:i:s', strtotime($availablety->end_eventdate));
						$contract_endtime = strtotime($contract_endtimey);

					}
					if (!empty($userdata['employees'][$keyc]['attendances'])) {
						$result = array_diff($alldates, $empAttandance);
					} else {
						$result = $alldates;
					}
					$resultmerge = array_merge($result, $empAttandance);
					$finalAttendanceArray = array_unique($resultmerge);
					sort($finalAttendanceArray);
					foreach ($finalAttendanceArray as $key => $finalData) {
						if (in_array($finalData, $empAttandance)) {
							$eventdate = '';
							$eventdate = $empAttandanceDatesheet[$finalData][0]['date_time'];

							if ($attenstart_time < $contract_strttime) {
								$c = new \DateTime($attenstart_timey);
								$d = new \DateTime($contract_strttimey);
								$classtime = $c->diff($d);
								$classtimehr = $classtime->format("%H");
								$classtimemin = $classtime->format("%I");
								$classtimsec = $classtime->format("%S");
								if ($classtimehr == '00') {
									if ($classtimemin <= $attendance_relif_time) {
										$description = "";
										$time = "";
									} else {
										$description = "Over time";
										$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
									}
								} else {
									$description = "Over time";
									$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
								}
								$disinfo = $description . ' ' . $time;
								array_push($maindescription, $disinfo);
							} elseif ($attenstart_time > $contract_endtime) {
								$c = new \DateTime($attenstart_timey);
								$d = new \DateTime($contract_endtimey);
								$classtime = $c->diff($d);
								$classtimehr = $classtime->format("%H");
								$classtimemin = $classtime->format("%I");
								$classtimsec = $classtime->format("%S");
								if ($classtimehr == '00') {
									if ($classtimemin <= $attendance_relif_time) {
										$description = "";
										$time = "";
									} else {
										$description = "Over time";
										$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
									}
								} else {
									$description = "Over time";
									$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
								}
								$disinfo = $description . ' ' . $time;
								array_push($maindescription, $disinfo);
							} elseif ($attenstart_time > $contract_strttime) {
								$c = new \DateTime($attenstart_timey);
								$d = new \DateTime($contract_strttimey);
								$classtime = $c->diff($d);
								$classtimehr = $classtime->format("%H");
								$classtimemin = $classtime->format("%I");
								$classtimsec = $classtime->format("%S");
								if ($classtimehr == '00') {
									if ($classtimemin <= $attendance_relif_time) {
										$description = "";
										$time = "";
									} else {
										$description = "Short time";
										$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
									}
								} else {
									$description = "Short time";
									$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
								}
								$disinfo = $description . ' ' . $time;
								array_push($maindescription, $disinfo);
							}
							if (!empty($attenend_time)) {
								if ($attenend_time > $contract_endtime) {
									$c = new \DateTime($attenend_timey);
									$d = new \DateTime($contract_endtimey);
									$classtime = $c->diff($d);
									$classtimehr = $classtime->format("%H");
									$classtimemin = $classtime->format("%I");
									$classtimsec = $classtime->format("%S");
									if ($classtimehr == '00') {
										if ($classtimemin <= $attendance_relif_time) {
											$description = "";
											$time = "";
										} else {
											$description = "Over time";
											$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
										}
									} else {
										$description = "Over time";
										$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
									}
									$disinfo = $description . ' ' . $time;
									array_push($maindescription, $disinfo);

								}
							}
							//echo date('H:i:s', $attenend_time);
							//echo date('H:i:s', $contract_endtime);die;
							if (!empty($attenend_time)) {
								if ($attenend_time < $contract_endtime) {
									$c = new \DateTime($attenend_timey);
									$d = new \DateTime($contract_endtimey);
									$classtime = $c->diff($d);
									$classtimehr = $classtime->format("%H");
									$classtimemin = $classtime->format("%I");
									$classtimsec = $classtime->format("%S");
									if ($classtimehr == '00') {
										if ($classtimemin <= $attendance_relif_time) {
											$description = "";
											$time = "";
										} else {
											$description = "Short time";
											$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
										}
									} else {
										$description = "Short time";
										$time = $classtimehr . ":" . $classtimemin . ":" . $classtimsec;
									}
									$disinfo = $description . ' ' . $time;
									array_push($maindescription, $disinfo);
								}
							}
							$azs = array_unique($maindescription);
							$azp = array_values($azs);
							$data[] = [
								"title" => "Present",
								"start" => $eventdate,
								"description" => $azp,
								"backgroundColor" => '#43dcdc', //red
								"borderColor" => '#43dcdc',
							];
						} else {
							$eventdate = '';
							$eventdate = date('Y-m-d', $finalData);
							if ($finalData < $currentdate) {
								$title = "Absent";
								$backgroundColor = "#ff9360";
								$borderColor = "#ff9360";
							} else {
								$title = "N/A";
								$backgroundColor = "#7ccdef";
								$borderColor = "#7ccdef";
							}
							$data[] = [
								"title" => $title,
								"start" => $eventdate,
								"backgroundColor" => $backgroundColor, //red
								"borderColor" => $borderColor,
							];

						}

					}
					//pr($empAttandance);
				} else {
					$alldates = array_unique($alldates);
					foreach ($alldates as $key => $finalData) {
						$eventdate = '';
						$eventdate = date('Y-m-d', $finalData);
						if ($finalData < $currentdate) {
							$title = "Absent";
							$backgroundColor = "#ff9360";
							$borderColor = "#ff9360";
						} else {
							$title = "N/A";
							$backgroundColor = "#7ccdef";
							$borderColor = "#7ccdef";
						}
						$data[] = [
							"title" => $title,
							"start" => $eventdate,
							"backgroundColor" => $backgroundColor, //red
							"borderColor" => $borderColor,
						];
					}

				}

				//pr($alldates);
			}
			echo json_encode($data);die;
		}
		$this->set(compact('user'));
	}
	public function empAttendance($uuid = null) {
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('Attendances');
		$this->loadModel('Employees');
		$employee_id = $uuid;
		$userid = $this->UuId->uuid($employee_id);
		$user = $this->Users->find('all')->where(['uuid' => $employee_id])->first();
		$user = $this->Encryption->encryption($user);
		// if ($this->request->is(['patch', 'post', 'put'])) {
		// 	$id = $this->request->getData('id'];
		// 	$month = $this->request->getData('month'];
		// 	$userid = $this->UuId->uuid($id);
		// 	$data = [];
		// 	$alldates = [];
		// 	$userdata = $this->Users->find('all')->contain([
		// 		'Employees.Attendances' => [
		// 			'conditions' => [
		// 				'Attendances.type' => 'Auth',
		// 				'Attendances.user_id' => $userid,
		// 			],
		// 		],
		// 	])->where([
		// 		'Users.uuid' => $employee_id,
		// 	])->first();
		// 	foreach ($userdata['employees'] as $key => $availablety) {
		// 		$alldates = [];
		// 		//$plandate = date('Y-m-01');
		// 		$plandate = date('Y-' . $month . '-01');
		// 		$pday = date('l', strtotime($plandate));
		// 		$plandateday = strtolower($pday);
		// 		$planday = $availablety['week_day'];
		// 		$next = 'next' . ' ' . $planday;
		// 		$nextdate = date('Y-m-d', strtotime($next, strtotime($plandate)));
		// 		$date1 = date('Y-m-d', strtotime($nextdate));
		// 		$date = new \DateTime($date1);
		// 		$createddate = date("Y-m-d");
		// 		$currentdate = strtotime($createddate);
		// 		$thisMonth = $date->format('m');
		// 		while ($date->format('m') === $thisMonth) {
		// 			$alldates[] = strtotime($date->format('Y-m-d'));
		// 			$date->modify($next);
		// 		}
		// 		if ($plandateday == $planday) {
		// 			$stmplandate = strtotime($plandate);
		// 			array_push($alldates, $stmplandate);
		// 		}
		// 		//pr($alldates);
		// 		$keyc = $key;
		// 		//pr($userdata['contracts'][$keyc]['attendances']);die;
		// 		if (!empty($userdata['employees'][$keyc]['attendances'])) {
		// 			foreach ($userdata['employees'][$keyc]['attendances'] as $key => $attendtt) {
		// 				$dateday = date('l', strtotime($attendtt['date_time']));
		// 				if ($attendtt['type'] == 'Auth') {
		// 					$empAttandance[$key] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
		// 				}
		// 				$empAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
		// 			}
		// 			if (!empty($userdata['employees'][$keyc]['attendances'])) {
		// 				$result = array_diff($alldates, $empAttandance);
		// 			} else {
		// 				$result = $alldates;
		// 			}
		// 			$resultmerge = array_merge($result, $empAttandance);
		// 			$finalAttendanceArray = array_unique($resultmerge);
		// 			sort($finalAttendanceArray);
		// 			foreach ($finalAttendanceArray as $key => $finalData) {
		// 				if (in_array($finalData, $empAttandance)) {
		// 					$eventdate = '';
		// 					$eventdate = $empAttandanceDatesheet[$finalData][0]['date_time'];
		// 					$data[] = [
		// 						"title" => "Present",
		// 						"start" => $eventdate,
		// 						"backgroundColor" => '#43dcdc', //red
		// 						"borderColor" => '#43dcdc',
		// 					];
		// 				} else {
		// 					$eventdate = '';
		// 					$eventdate = date('Y-m-d', $finalData);
		// 					if ($finalData < $currentdate) {
		// 						$title = "Absent";
		// 						$backgroundColor = "#ff9360";
		// 						$borderColor = "#ff9360";
		// 					} else {
		// 						$title = "N/A";
		// 						$backgroundColor = "#7ccdef";
		// 						$borderColor = "#7ccdef";
		// 					}
		// 					$data[] = [
		// 						"title" => $title,
		// 						"start" => $eventdate,
		// 						"backgroundColor" => $backgroundColor, //red
		// 						"borderColor" => $borderColor,
		// 					];

		// 				}

		// 			}
		// 			//pr($empAttandance);
		// 		} else {
		// 			$alldates = array_unique($alldates);
		// 			foreach ($alldates as $key => $finalData) {
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

		// 		//pr($alldates);
		// 	}
		// 	echo json_encode($data);die;
		// }
		$this->set(compact('user'));
	}

	public function markAttendance() {
		$this->viewBuilder()->setLayout('emplayout');
		$this->loadModel('TeachersAllotedJobs');
		$this->loadModel('Contracts');
		$this->loadModel('Users');
		$this->loadModel('Attendances');
		$id = $this->request->getSession()->read('Auth.User.uuid');
		$Currentdate = date("Y-m-d");
		$userid = $this->UuId->uuid($id);
		$day = strtolower(date('l', strtotime($Currentdate)));
		$child = [];
		$services = $this->TeachersAllotedJobs->find('all')->contain(['Contracts'])->where(['TeachersAllotedJobs.employee_id' => $userid, 'Contracts.service_day' => $day])->toArray();
		foreach ($services as $key => $value) {
			$servisdata[$value['contract']['child_id']] = $value['contract'];
		}
		if ($services) {
			$servisdata = array_values($servisdata);
			foreach ($servisdata as $key => $value) {
				$user = $this->Users->find('all')->contain([])->where(['id' => $value->child_id])->first();
				$child[] = $user = $this->Encryption->encryption($user);

			}
		}
		if ($this->request->is('post')) {
			$postdata = $this->request->getData('data');

			foreach ($postdata as $key => $value) {
				//pr($postdata);die;
				if (isset($postdata[$value['child_id']]['attendance'])) {
					if ($value['attendance'] == 1) {
						$type = 'Auth';
					} elseif ($value['attendance'] == 2) {
						$type = 'Absent';
					} elseif ($value['attendance'] == 3) {
						$type = 'Leave';
					}
				} else {
					$type = '';
					//$this->Flash->error(__('Date not selected proper'));
				}
				if (empty($value['attendance_id'])) {
					$attendance = $this->Attendances->newEntity();
					//$attendance = $this->Attendances->patchEntity($attendance, $this->request->getData());
					if (!$attendance->getErrors()) {
						$attendance->user_id = $value['child_id'];
						$attendance->date_time = $Currentdate;
						$attendance->bso_id = $value['bso_id'];
						$attendance->status = 1;
						$attendance->type = $type;
						$attendance->contract_id = $value['contract_id'];
						$attendance->role_id = 5;
						$attendance->note = $value['note'];
						//pr($attendance);die;
						$savedid = $this->Attendances->save($attendance);
					}

				} else {
					$attendances = $this->Attendances->get($value['attendance_id'], ['contain' => []]);
					//$attendances = $this->Attendances->find('all')->where(['id' => $user_id])->first();
					$users = TableRegistry::get('Attendances');
					$query = $users->query();
					$query->update()
						->set([
							'date_time_end' => $Currentdate,
							'status' => 1,
							'type' => $type,
							'note' => $value['note'],

						])
						->where(['id' => $value['attendance_id']])
						->execute();

				}
			}
			return $this->redirect(['action' => 'markAttendance', 'prefix' => 'employee']);
		}

		$this->set(compact('child'));

		// $created = date('Y-m-d 00:00:00');
		// $this->loadModel('Schools');
		// $this->loadModel('Attendances');
		// $this->loadModel('Contracts');
		// $this->loadModel('Settings');
		// $this->loadModel('GlobalSettings');
		// $user = $this->Users->find('all')->where(['uuid' => $id])->first();
		// $user = $this->Encryption->encryption($user);
		// $parent_id = $user['parent_id'];
		// $bsoid = $user['bso_id'];
		// $GlobalSettings = $this->GlobalSettings->find('all')->where(['user_id' => $user['bso_id']])->first();

	}

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

		$this->set(compact('users', 'encryptionKey'));
	}
	public function employeesdata($role = null, $id = null) {
		$this->loadModel('Users');
		$this->viewBuilder()->setLayout('admin');
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$bsouuid = $this->Users->find('all')->where(['id' => $dataid])->first();
		$encryptionKey = $bsouuid['uuid'];
		$record = [];
		$detail = [];
		$dataid = $this->request->getSession()->read('Auth.User.id');
		$this->paginate = [
			'contain' => [],
			'conditions' => [
				// 'OR' => [
				// 	"CONCAT(firstname,'',lastname) LIKE" => "%" . $id . "%",
				// 	//"id LIKE" => $id . "%",
				// ],
				'role_id' => 3,
				'bso_id' => $dataid,
				'parent_id' => '0',
			],
			'order' => [
				'Users.id' => 'DESC',
			],
		];
		$users = $this->paginate($this->Users);
		//pr($users);die;
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
		$countrecord = count($record);
		$detail = array(
			"draw" => 1,
			"recordsTotal" => $countrecord,
			"recordsFiltered" => $countrecord,
			"data" => $record,
		);
		echo json_encode($detail);die;
	}
	public function viewemployee($id = null) {
		$this->autoRender = false;
		if ($this->request->is(['patch', 'post', 'put'])) {
			$userid = $this->UuId->uuid($this->request->getData(['id']));
			$guardian = $this->Users->find('all')->where(['id' => $userid])->first();
			$guardian = $this->Encryption->encryption($guardian);
			echo json_encode($guardian);die;
		}

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
			$newdob = explode(' ', $this->request->getData('dob'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));

			$newjoining_date = explode(' ', $this->request->getData('joining_date'));
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
			$user->parent_id = 0;
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
					$sendmail = base64_decode($savedid['email']);
					// $user = strstr($string, '.com', true);
					// $sendmail = $user . '.com';
					//pr($emailsend);die;
					$message = 'You are Register with BSO Portal' . '<br/>';
					$message .= 'Link:' . '' . '' . BASE_URL . '<br/>';
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
		$this->loadModel('Users');
		$user = $this->Users->find('all')->where(['uuid' => $id])->first();
		$user = $this->Encryption->encryption($user);
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
			$newdob = explode(' ', $this->request->getData('joining_date'));
			$idob = implode('/', $newdob);
			$var = ltrim($idob, '/');
			$date = str_replace('/', '-', $var);
			$dobnew = date('Y-m-d', strtotime($date));
			$newjoining_date = explode(' ', $this->request->getData('dob'));
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

		// if ($this->request->is(['patch', 'post', 'put'])) {
		$userid = $this->UuId->uuid($id);
		$user = $this->Users->get($userid, ['contain' => []]);
		$user->is_active = "0";

		if ($this->Users->save($user)) {
			$this->Flash->success(_('Employee has been deactivated.'));
			return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);
		}
		$this->Flash->error(_('Employee could not be deactivated.'));
		// }

		$this->set(compact('user'));

	}

	public function empActivate($id = null) {
		$this->autoRender = false;

		// if ($this->request->is(['patch', 'post', 'put'])) {
		$userid = $this->UuId->uuid($id);
		$user = $this->Users->get($userid, ['contain' => []]);
		$user->is_active = "1";

		if ($this->Users->save($user)) {
			$this->Flash->success(_('Employee has been deactivated.'));
			return $this->redirect(['controller' => 'Employees', 'action' => 'employees', 'prefix' => 'employee']);
		}
		$this->Flash->error(_('Employee could not be deactivated.'));
		// }
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

	public function profileEdit($id) {
		$this->viewBuilder()->setLayout('emplayout');
		$this->loadModel('Users');
		if ($userid = $this->UuId->uuid($id)) {
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
					$user = $this->Encryption->encryption($user);
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
						return $this->redirect(['action' => 'profile-edit', 'prefix' => 'employee', $id]);
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
				return $this->redirect(['action' => 'index', 'prefix' => 'employee']);

			} else {
				$this->Flash->error(_('Password could not be Updated. Please, try again.'));
			}
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
				case 'monday':
					$backColor = "#a338b5cc";
					$borderColor = "#a338b5cc";
					$barColor = "#a338b5cc";
					break;
				case 'tuesday':
					$backColor = "#5b9bd5";
					$borderColor = "#5b9bd5";
					$barColor = "#5b9bd5";
					break;
				case 'wednesday':
					$backColor = "#17540ce0";
					$borderColor = "#17540ce0";
					$barColor = "#17540ce0";
					break;
				case 'thursday':
					$backColor = "#c79b15";
					$borderColor = "#c79b15";
					$barColor = "#c79b15";
					break;
				case 'friday':
					$backColor = "#b33a31";
					$borderColor = "#b33a31";
					$barColor = "#b33a31";
					break;
				case 'saturday':
					$backColor = "#6672fc";
					$borderColor = "#6672fc";
					$barColor = "#6672fc";
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
				case 'monday':
					$backColor = "#a338b5cc";
					$borderColor = "#a338b5cc";
					$barColor = "#a338b5cc";
					break;
				case 'tuesday':
					$backColor = "#5b9bd5";
					$borderColor = "#5b9bd5";
					$barColor = "#5b9bd5";
					break;
				case 'wednesday':
					$backColor = "#17540ce0";
					$borderColor = "#17540ce0";
					$barColor = "#17540ce0";
					break;
				case 'thursday':
					$backColor = "#c79b15";
					$borderColor = "#c79b15";
					$barColor = "#c79b15";
					break;
				case 'friday':
					$backColor = "#b33a31";
					$borderColor = "#b33a31";
					$barColor = "#b33a31";
					break;
				case 'saturday':
					$backColor = "#6672fc";
					$borderColor = "#6672fc";
					$barColor = "#6672fc";
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
		$this->loadModel('Users');
		$user = $this->Users->find('all')->where(['id' => $userid])->first();

		$bso_id = $this->request->getSession()->read('Auth.User.id');

		$this->autoRender = false;
		// $days = ['Zondag' => 'Sunday', 'Maandag' => 'Monday', 'Dinsdag' => 'Tuesday', 'Woensdag' => 'Wednesday', 'Donderdag' => 'Thursday', 'Vrijdag' => 'Friday', 'Zaterdag' => 'Saturday'];

		if ($this->request->is(['patch', 'post', 'put'])) {
			//pr($this->request->getData);die;
			$Createddate = date("Y-m-d h:i:s");
			$day = date("Y-m-d", strtotime($this->request->getData('start')));
			$getday = date('l', strtotime($day));
			//$saveday = array_search($getday, $days);
			$savedays = strtolower($getday);
			$continues = 0;
			$getendtime = date("Y-m-d H:i:s", strtotime($this->request->getData('end'))) . '<br/>';
			if (date("H:i:s", strtotime($this->request->getData('end'))) == "00:00:00") {
				$enddatetime = explode('T', $this->request->getData('start'));
				$enddatetime[0];
				$end_time = $enddatetime[0] . ' ' . '23:59:59';
				$workend_time = '23:59:59';
			} else {
				$end_time = date("Y-m-d H:i:s", strtotime($this->request->getData('end')));
				$workend_time = date("H:i:s", strtotime($this->request->getData('end')));
			}
			if (!empty($this->request->getData('continues'))) {
				$continues = 1;
				$employee = $this->Employees->newEntity();
				$employee->workstart_time = date("H:i:s", strtotime($this->request->getData('start')));
				$employee->user_uuid = $id;
				$employee->user_id = $userid;
				$employee->bso_id = $bso_id;
				$employee->continues = $continues;
				$employee->workend_time = $workend_time;
				$employee->start_eventdate = date("Y-m-d H:i:s", strtotime($this->request->getData('start')));
				$employee->end_eventdate = $end_time;
				$employee->week_day = $savedays;
				$employee->event_name = $this->request->getData('name');
				$employee->created = $Createddate;
			} else {
				$employee = $this->Employees->newEntity();
				$employee->workstart_time = date("H:i:s", strtotime($this->request->getData('start')));
				$employee->user_uuid = $id;
				$employee->user_id = $userid;
				$employee->continues = $continues;
				$employee->workend_time = $workend_time;
				$employee->start_eventdate = date("Y-m-d H:i:s", strtotime($this->request->getData('start')));
				$employee->end_eventdate = $end_time;
				$employee->week_day = $savedays;
				$employee->bso_id = $bso_id;
				$employee->event_name = $this->request->getData('name');
				$employee->created = $Createddate;
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
			$workstart_time = date("H:i:s", strtotime($this->request->getData('newStart')));
			$start_eventdate = date("Y-m-d H:i:s", strtotime($this->request->getData('newStart')));
			$getendtime = date("Y-m-d H:i:s", strtotime($this->request->getData('newEnd')));

			if (date("H:i:s", strtotime($this->request->getData('newEnd'))) == "00:00:00") {
				$enddatetime = explode('T', $this->request->getData('newStart'));
				$enddatetime[0];
				$end_eventdate = $enddatetime[0] . ' ' . '23:59:59';
				$workend_time = '23:59:59';

			} else {
				$end_eventdate = date("Y-m-d H:i:s", strtotime($this->request->getData('newEnd')));
				$workend_time = date("H:i:s", strtotime($this->request->getData('newEnd')));
			}

			$employee = TableRegistry::get('Employees');
			$query = $employee->query();

			$query->update()
				->set(['workstart_time' => $workstart_time, 'workend_time' => $workend_time, 'start_eventdate' => $start_eventdate, 'end_eventdate' => $end_eventdate])
				->where(['id' => $this->request->getData('id')])
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
			$workstart_time = date("H:i:s", strtotime($this->request->getData('newStart')));
			$start_eventdate = date("Y-m-d H:i:s", strtotime($this->request->getData('newStart')));

			if (date("H:i:s", strtotime($this->request->getData('newEnd'))) == "00:00:00") {
				$enddatetime = explode('T', $this->request->getData('newStart'));
				$enddatetime[0];
				$end_eventdate = $enddatetime[0] . ' ' . '23:59:59';
				$workend_time = '23:59:59';

			} else {
				$end_eventdate = date("Y-m-d H:i:s", strtotime($this->request->getData('newEnd')));
				$workend_time = date("H:i:s", strtotime($this->request->getData('newEnd')));
			}

			$employee = TableRegistry::get('Employees');
			$query = $employee->query();

			$query->update()
				->set(['workstart_time' => $workstart_time, 'workend_time' => $workend_time, 'start_eventdate' => $start_eventdate, 'end_eventdate' => $end_eventdate])
				->where(['id' => $this->request->getData('id')])
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
			$employee = $this->Employees->get($this->request->getData('id'));

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
	public function rosterEpanel() {
		$this->viewBuilder()->setLayout('emplayout');
		$id = $this->request->getSession()->read('Auth.User.uuid');
		if ($userid = $this->UuId->uuid($id)) {
			$profile = $this->Users->get($userid, ['contain' => []]);
			$this->set(compact('profile', 'id'));
		}

	}
	public function epanelAvailabelty() {
		$id = $this->request->getSession()->read('Auth.User.uuid');
		if ($userid = $this->UuId->uuid($id)) {
			$this->viewBuilder()->setLayout('emplayout');
			$profile = $this->Users->get($userid, ['contain' => []]);
			//pr($profile);die;
		}
		$this->set(compact('profile', 'id'));
	}
	public function assignedClasses($selectday = null) {
		$id = $this->request->getSession()->read('Auth.User.uuid');
		$userid = $this->UuId->uuid($id);
		$this->loadModel('TeachersAllotedJobs');
		$this->viewBuilder()->setLayout('emplayout');
		$this->loadModel('BsoServices');
		$finalservices = [];
		$services = '';
		if ($selectday != null) {
			$employee = $this->TeachersAllotedJobs->find('all')->contain([])->where(['TeachersAllotedJobs.employee_id' => $userid])->toArray();
			if ($employee) {
				foreach ($employee as $key => $row) {
					$services[] = $this->BsoServices->find('all')->contain([])->where(['service_day' => $selectday, 'id' => $row['service_id']])->toArray();
				}
			}
			$finalservices = array_filter($services);
			if ($finalservices) {
				foreach ($finalservices as $key => $value) {

					$servicearray[] = array(
						'empid' => $id,
						'service_day' => $value[0]['service_day'],
						'start_time' => date('H:i:s', strtotime($value[0]['start_time'])),
						'end_time' => date('H:i:s', strtotime($value[0]['end_time'])),

					);
				}

			}
			echo json_encode($servicearray);die;
		} else {
			$current_date = date('d-m-Y');
			$day = strtolower(date('l', strtotime($current_date))); //'monday';
			$employee = $this->TeachersAllotedJobs->find('all')->contain([])->where(['TeachersAllotedJobs.employee_id' => $userid])->toArray();
			if ($employee) {
				foreach ($employee as $key => $row) {
					$services[] = $this->BsoServices->find('all')->contain([])->where(['service_day' => $day, 'id' => $row['service_id']])->toArray();

				}

			}
			if ($services) {
				$finalservices = array_filter($services);
			}
			//pr($finalservices);die;
		}

		$this->set(compact('finalservices'));

	}
	public function markassignedClasses($selectday = null) {
		$this->autoRender = false;
		$id = $this->request->getSession()->read('Auth.User.uuid');
		$userid = $this->UuId->uuid($id);
		$this->loadModel('TeachersAllotedJobs');
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('BsoServices');
		$finalservices = [];
		$servicearray = [];
		$services = '';
		if ($selectday != null) {
			$employee = $this->TeachersAllotedJobs->find('all')->contain([])->where(['TeachersAllotedJobs.employee_id' => $userid])->toArray();
			if ($employee) {
				foreach ($employee as $key => $row) {
					$services[] = $this->BsoServices->find('all')->contain([])->where(['service_day' => $selectday, 'id' => $row['service_id']])->toArray();
				}
			}
			//pr($services);die;
			$finalservices = array_filter($services);
			$finalservices = array_values($finalservices);
			if ($finalservices) {

				foreach ($finalservices as $key => $value) {

					$servicearray[] = array(
						'empid' => $id,
						'service_day' => $value[0]['service_day'],
						'start_time' => date('H:i:s', strtotime($value[0]['start_time'])),
						'end_time' => date('H:i:s', strtotime($value[0]['end_time'])),
					);
				}

			}
			$this->set(compact('servicearray'));
			echo $this->render('/Element/Employees/markassignedClasses');
			die;
		}
	}
	public function getchildAttendance() {
		$this->autoRender = false;
		$this->viewBuilder()->setLayout('ajax');
		//$this->viewBuilder()->setLayout('emplayout');
		$this->loadModel('TeachersAllotedJobs');
		$this->loadModel('Contracts');
		$this->loadModel('Users');
		$this->loadModel('Attendances');
		$id = $this->request->getSession()->read('Auth.User.uuid');
		$userid = $this->UuId->uuid($id);
		$child = [];
		if ($this->request->is('post')) {
			$postdata = $this->request->getData();
			$day = $postdata['day'];
			$date = $postdata['date'];
			$dateday = strtolower(date('l', strtotime($date)));

			//die;
			$timeslot = $postdata['timeslot'];
			$services = $this->TeachersAllotedJobs->find('all')->contain(['Contracts'])->where(['TeachersAllotedJobs.employee_id' => $userid, 'Contracts.service_day' => $day])->toArray();
			foreach ($services as $key => $value) {
				$servisdata[$value['contract']['child_id']] = $value['contract'];
			}

			if ($services) {
				foreach ($servisdata as $key => $dataval) {
					$value = $this->Users->find('all')->contain([
						'Attendances' => [
							'conditions' => [
								//'Attendances.date_time' => $date,
								'EXTRACT(DAY from Attendances.date_time) = ' => date('d', strtotime($date)),
								'EXTRACT(MONTH from Attendances.date_time) = ' => date('m', strtotime($date)),
							],
						],
					])->where(['id' => $dataval->child_id])->toArray();

					//pr($value);
					$value[0]->contract_id = $dataval['id'];
					$childe[] = $this->Encryption->encryption($value[0]);
					//$contract_id = $dataval['id'];
				}

			}
			//pr($childe);
			//echo $contract_id;
			//die;

		}
		//pr($childe);die;
		$this->set(compact('childe', 'day', 'dateday'));
		echo $this->render('/Element/Employees/getchildAttendance');
		die;
	}

	public function assignStudents($id = null, $day = null) {

		$this->viewBuilder()->setLayout('emplayout');
		$this->loadModel('TeachersAllotedJobs');
		$this->loadModel('Contracts');
		$this->loadModel('Users');
		$userid = $this->UuId->uuid($id);
		$child = [];
		$services = $this->TeachersAllotedJobs->find('all')->contain(['Contracts'])->where(['TeachersAllotedJobs.employee_id' => $userid, 'Contracts.service_day' => $day])->toArray();

		foreach ($services as $key => $value) {

			$servisdata[$value['contract']['child_id']] = $value['contract'];

		}

		if ($services) {
			foreach ($servisdata as $key => $value) {

				$child[] = $this->Users->find('all')->contain([])->where(['id' => $value->child_id])->toArray();

			}

		}

		//$data = array_unique($child);

		$this->set(compact('child'));

	}

	public function employeroster($id = null, $selectDate = null) {
		$this->loadModel('BsoServices');
		$this->loadModel('Employees');
		$this->loadModel('TeachersAllotedJobs');
		$userid = $this->UuId->uuid($id);
		$events = array();
		$type = '';
		if (!empty($selectDate)) {
			$Createddate = date("Y-m-d H:m:s", strtotime($selectDate . '+ 7 days'));
			$employeeroste = $this->Employees->find('all')->select(['week_day'])->where(['user_uuid' => $id])->toArray();
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
					if (in_array($row['service_day'], $employeeroste)) {
						$type = "Regular";
					} else {
						$type = "Overtime";
					}

					if ($row['service_day']) {
						// $detail .= "Name:".' '.$row['event_name'].'<br/>';
						$detail = "Day:" . ' ' . $row['service_day'] . '<br/>';
						$detail .= "Service Type:" . ' ' . $type . '<br/>';
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
			//pr('qqw');die;
			$employeeroster = $this->Employees->find('all')->select(['week_day'])->where(['user_uuid' => $id])->toArray();
			$employeeroste = array_column($employeeroster, 'week_day');

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
						if (in_array($row['service_day'], $employeeroste)) {
							$type = "Regular";
						} else {
							$type = "Overtime";
						}

						if ($row['service_day']) {
							// $detail .= "Name:".' '.$row['event_name'].'<br/>';
							$detail = "Day:" . ' ' . $row['service_day'] . '<br/>';
							$detail .= "Service Type:" . ' ' . $type . '<br/>';
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
	public function planning($start = null, $end = null) {

		if ($this->request->is('ajax')) {
			echo json_encode([
				'status' => 'success',
				'message' => __('Teacher has been deleted from this service.'),
			]);
			die;
		}
		$this->viewBuilder()->setLayout('admin');
		$this->loadModel('BsoServices');
		$this->loadModel('TeachersAllotedJobs'); //$this->autoRender = false;
		$this->loadModel('Users');
		$this->loadModel('Employees');
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
		//$events[] = array();
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
				//pr($row);die;
				$useru = $this->Users->find('all')->where(['id' => $row->employee_id])->first();

				//$user = $this->Users->get($row->employee_id, ['contain' => []]);
				$user = $this->Encryption->encryption($useru);
				//pr($user);die;
				$employeeroster = $this->Employees->find('all')->select(['week_day'])->where(['user_uuid' => $user['uuid']])->toArray();
				$employeeroste = array_column($employeeroster, 'week_day');

				if ($row['bso_service']['start_eventdate'] <= $ddated) {
					$startdate_time = explode('T', $row['bso_service']['start_eventdate']);
					$selecteddate = $startdate_time[0];
					$Createddate = date("Y-m-d");
					$min = date('W', strtotime($selecteddate));
					$max = date('W', strtotime($Createddate));
					$diff[$key] = $max - $min;
					//die;
				}

				if (in_array($row['bso_service']['service_day'], $employeeroste)) {
					$type = "Regular";
				} else {
					$type = "Overtime";
				}

				if ($row['bso_service']['service_day']) {
					$edit_url = BASE_URL . 'users/services-assign/' . $row->bso_service->uuid;
					// $detail .= "Name:".' '.$row['event_name'].'<br/>';
					$detail = __("Day") . ":" . ' ' . $row['bso_service']['service_day'] . '<br/>';
					$detail .= __("Service Type") . ":" . ' ' . $type . '<br/>';
					$detail .= __("Start Time") . ":" . ' ' . date("H:i:s", strtotime($row['bso_service']['start_time'])) . '<br/>';
					$detail .= __("End Time") . ":" . ' ' . date("H:i:s", strtotime($row['bso_service']['end_time'])) . '<br/>';
					//$detail .=fa fa-pencil" aria-hidden="true "<br/>"<i class="fa fa-pencil-square-o" aria-hidden="true"></i>;

					$detail .= '<a href="' . $edit_url . '" class="edit-assignteacher" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
</a>' . '<br/>';
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
					"service_id" => (string) $row['service_id'],
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
		if (!empty($events)) {
			$events = $events;
		} else {
			$events = '';
		}

		$events_list = json_encode($events);
		$employee_list = json_encode($employee);
		//pr();die;
		$this->set(compact('employee_list', 'events_list'));
	}

}
