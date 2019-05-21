<?php
namespace App\Controller;

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

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        $this->loadComponent('EmailSend');
        $this->loadComponent('UuId');

    }

    public function beforeFilter(Event $event)
    {
         parent::beforeFilter($event);
         if ($this->request->is('post') && $this->request->getData('id')) {
            
            $role = $this->request->getData('role');
           if($role == 3){

            return $this->redirect(['action' => 'employees', $this->request->getData('role'), $this->request->getData('id')]);
           }
            if($role == 4){

            return $this->redirect(['action' => 'parents', $this->request->getData('role'), $this->request->getData('id')]);
           }
       

        }

    }
/**
 * Index method
 *
 * @return \Cake\Http\Response|void
 */
    public function login()
    {
        if ($this->Auth->user()) {
            return $this->redirect(['action' => 'dashboard']);
        }

        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();

            if ($user) {

                $this->Auth->setUser($user);

                if ($user['role_id'] == '1') {
                    return $this->redirect(['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin']);
                }

                if ($user['role_id'] == '2') {
                    if ($user['flag'] == 0 || $user['flag'] == '') {
                        return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => false]);
                    } else {
                        return $this->redirect(['controller' => 'Users', 'action' => 'index']);
                    }
                }


                if ($user['role_id'] == '4') {
                    if ($user['flag'] == 0 || $user['flag'] == '') {
                        return $this->redirect(['controller' => 'Users', 'action' => 'resetPassword', 'prefix' => 'parent']);
                    } else {
                        return $this->redirect(['action' => 'login']);

                    }
                }

            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }
     public function usersetup()
    {
        $this->autoRender = false;
        $ids='';
         $dataid = $this->request->getSession()->read('Auth.User.id');
        if ($this->request->is('post')) {
          // pr($_POST);die;
            $action = $_POST['action'];
            $role =$_POST['role'];
            if($_POST['role']== 2){
               $dataid = 0;

            }

        if(isset($_POST['ids'])){
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
                            'parent_id' => '0',
                        ],
                    ];
                    $users = $this->paginate($this->Users);
                    // pr($users);die;
                    $this->set(compact('users'));

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
                            'parent_id' => '0',
                        ],
                    ];
                    $users = $this->paginate($this->Users);
                    $this->set(compact('users'));

                    echo $this->render('/Element/Users/index');
                    die();
                    break;
                case "3":
                    $this->Users->deleteAll(['id IN' => $ids]);
                    $this->paginate = ['limit' => 10, 'order' => ['Users.id' => 'DESC'], 'contain' => [], 'conditions' => ['role_id' => $role,'bso_id' => $dataid,'parent_id' => '0']];
                    $users = $this->paginate($this->Users);
                    $this->set(compact('users'));
                    echo $this->render('/Element/Users/index');
                    
                    break;
                default:
                $this->Flash->error(__('You have not selected action'));
//echo "Your favorite color is neither red, blue, nor green!";
                break;
            }
        }else{
           $this->Flash->error(__('Please try again!'));
        }

    }

    }
      public function getservices()
    {
        $this->autoRender = false;
        $this->loadModel('BsoServices');
        $dataid = $this->request->getSession()->read('Auth.User.id');
        if ($this->request->is('post')) {
            
            $day = $_POST['day'];
          
            $services = TableRegistry::get('bso_services')
            ->find()
            ->select([
                'start_time',
                'end_time'
            ])
            ->where(['bso_id' => $dataid,'service_day' => $day])
            ->toArray();
            $service_array= array();
            //$service_array = $services;
            foreach ($services as $key => $value) {
                list($sdate,$stime)= mbsplit(',', $value->start_time);
                list($stime1,$stime2)= mbsplit(' ', $stime);
                list($edate,$etime)= mbsplit(',', $value->end_time);
                list($etime1,$etime2)= mbsplit(' ', $etime);

            $service_array[] = array('start_time'=>$stime,'end_time'=>$etime);
            }
           
            
          print_r(json_encode($service_array)); die();
            $this->set(compact('services'));
         }   
    }

    public function logout()
    {
        $this->autoRender = false;
        $this->Auth->logout();
        return $this->redirect(['controller' => 'users', 'action' => 'login', 'prefix' => false]);
    }


    public function profile($id)
    {
        if($userid = $this->UuId->uuid($id)) 
        {

            $profile = $this->Users->get($userid, ['contain' => []]);
            $this->viewBuilder()->setLayout('admin');
            $this->set('profile', $profile);
        }
        
    }
    public function dashboard(){
      $this->viewBuilder()->setLayout('admin');  
    }

    public function profileEdit($id)
    {
         if($userid = $this->UuId->uuid($id)) 
        {
        $this->viewBuilder()->setLayout('admin');
        $user = $this->Users->get($userid, ['contain' => []]);
        $this->Users->getValidator()->remove('image');
        $this->Users->getValidator()->remove('email');
        $this->Users->getValidator()->remove('lastname');
        $this->Users->getValidator()->remove('password');
        $this->Users->getValidator()->remove('confirm_password');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $file = array();
            $imageinfo = $this->request->getData('image');
            if ($imageinfo['name'] != '') {
                $file = $this->request->getData('image');

            }

            if (!empty($this->request->data('password'))) {
                $user = $this->Users->patchEntity(
                    $user,
                    $this->request->getData(),
                    ['validate' => 'Profile']
                );
            } else {
                unset($this->request->data['password']);
                $user = $this->Users->patchEntity($user, $this->request->getData());
            }

            $user->is_active = 1;
            $Createddate = date("Y-m-d h:i:sa");
            $user->modified = $Createddate;
            unset($user->image);

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
                        $img_return = $this->Utility->saveImageToServer($user->id, $imageArray, USER_PICTURE_FOLDER_DIRECTORY_PATH, USER_PICTURE_FOLDER_URL_PATH);
                        if ($img_return['status']) {
                            $saveImage['image'] = $img_return['name'];
                        }

                        $imageEntity = $this->Users->get($user->id);
                        $patchImageEntity = $this->Users->patchEntity($imageEntity, $saveImage);

                        $this->Users->save($patchImageEntity);
                        $session->write('Auth.User.image', $img_return['name']);
                    }
                }


                $session->write('Auth.User.firstname', $user->firstname);
                $session->write('Auth.User.lastname', $user->lastname);
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


    public function manageServices($search = null)
    {
        $this->loadModel('BsoServices');
        $this->viewBuilder()->setLayout('admin');
        $dataid = $this->request->getSession()->read('Auth.User.id');
        $search = isset($_GET['ids'])?$_GET['ids']:"";
        $servicesCondition[] = ["service_day   LIKE" => "%".$search . "%"];
       // $profile = $this->Users->get($userid, ['contain' => []]);
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
       
        $services = $this->paginate($this->BsoServices);
      
        $this->set(compact('services'));
    }

/* View method
 *
 * @param string|null $id User id.
 * @return \Cake\Http\Response|void
 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
 */

    public function view($id = null)
    {
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

    public function delete($id = null)
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The student has been deleted.'));
        } else {
            $this->Flash->error(__('The student could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index', $user->role_id]);
    }


    public function resetPassword()
    {
        $id = $this->request->getSession()->read('Auth.User.id');
        $emal = $this->request->getSession()->read('Auth.User.email');

        $user = $this->Users->get($id);
        $this->viewBuilder()->setLayout('admin');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $password = $this->request->getParam('password');

            if (!$user->getErrors()) {
                $user->flag = "1";
                if ($this->Users->save($user)) {
                    $message = 'Your Password Has Been Changed' . '<br/>';
                    $message .= 'Your Email:' . '' . $emal . '<br/>';
                    $message .= 'Your Password:' . '' . $password . '<br/>';

                    $to = $emal;
                    $from = 'rtestoffshore@gmail.com';
                    $title = 'BSO';
                    $subject = 'You Register With BSO';

                    $this->EmailSend->emailSend($from, $title, $to, $subject, $message);
                }
                $this->Flash->success(_('The Password has been saved .'));
                return $this->redirect(['action' => 'logout']);

            } else {
                $this->Flash->error(_('The Password could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
    }


    public function updatePassword()
    {
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
                $message .= 'Email:' . '' . $user->email . '<br/>';
                $message .= 'New Password:' . 'As per you selected.<br/>';

                $to = $user->email;
                $from = 'rtestoffshore@gmail.com';
                $title = 'Kind Planner';
                $subject = 'New Password';

                $this->EmailSend->emailSend($from, $title, $to, $subject, $message);

                $this->Flash->success(_('The Password has been saved .'));
                return $this->redirect(['action' => 'login']);
            }

        }

        $this->viewBuilder()->setLayout('login');
        $this->set('user', $user);
    }

    public function forgotPassword()
    {
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

                $this->Flash->success(_('The password change link sent on your email.'));
                return $this->redirect(['action' => 'login']);

            }
            $this->Flash->error(__('Invalid email, try again'));
            return $this->redirect(['action' => 'login']);
        }
    }

    /*
        EMPLOYEE FUNCTIONALITY
        STARTS
    */
    public function employees($role = null, $id = null) {
        $this->viewBuilder()->setLayout('admin');
         $dataid = $this->request->getSession()->read('Auth.User.id');
      //  die;
        
         if ($this->request->is('post') && $this->request->getData('id')) {
        
            $id = $this->request->getData('id');
            $dataid = $this->request->getSession()->read('Auth.User.id');
            $this->paginate = [
                'limit' => 10,
                'contain' => [], 
                'conditions' => [
                        "CONCAT(firstname,'',lastname) LIKE" => "%".$id . "%",
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
                    "CONCAT(firstname,'',lastname) LIKE" => "%".$id . "%",
                    'role_id' => 3,
                    'bso_id' => $dataid,
                    'parent_id' => '0', 
            ],
            'order' => [
                'Users.id' => 'DESC',
            ],
        ];
        // $this->paginate = [
        //     'limit' => 10,
        //     'order' => [
        //     'Users.id' => 'DESC'
        //     ],
        //     'contain' => [], 
        //     'conditions' => [
        //     'bso_id' => $dataid, 
        //     'role_id' => 3
        //     ]
        // ];

        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    public function addEmployee()
    {
        $this->viewBuilder()->setLayout('admin');
        $this->Users->getValidator()->remove('school');
        $this->Users->getValidator()->remove('relation');
        $this->Users->getValidator()->remove('relation1');
        $this->Users->getValidator()->remove('account');
        $this->Users->getValidator()->remove('bank_name');
        $Createddate = date("Y-m-d h:i:sa");
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
         
            $file = array();
            $imageinfo = $this->request->getData('image');
            
            // if ($imageinfo['name'] != '') {
            //     $file = $this->request->getData('image');
            // }
           
          
            $dobnew = date('Y-m-d', strtotime($_POST['dob']));
            $joining_date =date('Y-m-d', strtotime($_POST['joining_date']));
            $file   = $this->request->getData('image');
                    unset($this->request->data['image']);

            $user = $this->Users->patchEntity($user, $this->request->getData());

            $dataid = $this->request->getSession()->read('Auth.User.id');
            $password = $this->request->getParam('password');
            $user->bso_id = $dataid;
            $user->role_id = "3";
            $user->group_id = "3";
            $user->dob = $dobnew;
            $user->joining_date = $joining_date;
            $user->created = $Createddate;
            $user->uuid = Text::uuid();
               
            if (!$user->getErrors()) {
                    
                if($savedid = $this->Users->save($user)){
                    //pr($savedid);die();
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
                                $this->Users->save($imageEntity);
                            }
                        }
                    }

                    $emailsend = $savedid['email'];
                    $message = 'You are Register with BSO Portal' . '<br/>';
                    $message .= 'Your Email:' . '' . $savedid['email'] . '<br/>';
                    $message .= 'Your Password:' . '' . $password . '<br/>';

                    $to = $emailsend;
                    $from = 'rtestoffshore@gmail.com';
                    $title = 'Bso';
                    $subject = 'You Register With BSO';

                    $this->EmailSend->emailSend($from, $title, $to, $subject, $message);
                

                    $this->Flash->success(__('The Employee has been saved.'));
                    return $this->redirect(['action' => 'employees', 'prefix' => false]);
                } else {
                    $this->Flash->error(__('The Employee could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The Employee could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('user'));
    }
    public function empEdit($id = null){
         $this->viewBuilder()->setLayout('admin');
        $user = $this->Users->find('all')->where(['uuid'=>$id])->first();
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
            
            $dobnew = date('Y-m-d', strtotime($_POST['dob']));
            $joining_date =date('Y-m-d', strtotime($_POST['joining_date']));
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
                            $this->Users->save($imageEntity);
                        }
                    }
                }
                $this->Flash->success(_('The Employee profile has been updated.'));
                return $this->redirect(['action' => 'employees','prefix' => false]);
            }

            $this->Flash->error(__('There are some problem to update Employee. Please try again!'));
        }
        $this->set(compact('user'));
    }

    public function empDeactivate($id = null){
        
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userid = $this->UuId->uuid($id);
            $user = $this->Users->get($userid, ['contain' => []]);
            $user->is_active = "0";
            if ($this->Users->save($user)) {
                $this->Flash->success(_('The employee has been deactivated.'));
                return $this->redirect(['action' => 'employees','prefix' => false]);
            }
            $this->Flash->error(_('The employee could not be deactivated.'));
        }
        $this->set(compact('user'));

    }
     public function empActivate($id = null){
       
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userid = $this->UuId->uuid($id);
            $user = $this->Users->get($userid, ['contain' => []]);
            $user->is_active = "1";
            if ($this->Users->save($user)) {
                $this->Flash->success(_('The employee has been deactivated.'));
                return $this->redirect(['action' => 'employees','prefix' => false]);
            }
            $this->Flash->error(_('The employee could not be deactivated.'));
        }
        $this->set(compact('user'));

    }
    public function empProfile($id)
    {
        if($userid = $this->UuId->uuid($id)) 
        {

            $profile = $this->Users->get($userid, ['contain' => []]);
            $this->viewBuilder()->setLayout('admin');
            $this->set('profile', $profile);
        }
    }

    public function empDelete($id)
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The student has been deleted.'));
        } else {
            $this->Flash->error(__('The student could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'employees', $user->role_id,'prefix' => false]);
    }
    /*
        END OF
        EMPLOYEE FUNCTIONALITY
     */

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
                        "CONCAT(firstname,'',lastname) LIKE" => "%".$id . "%",
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
                    "CONCAT(firstname,'',lastname) LIKE" => "%".$id . "%",
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
    public function parentProfile($id = null)
    {
    //echo $id;die;
        $this->viewBuilder()->setLayout('admin');
        $userid = $this->UuId->uuid($id);
        $section = isset($_GET['st'])?$_GET['st']:"";
        $search = isset($_GET['ids'])?$_GET['ids']:"";
        $role=isset($_GET['role'])?$_GET['role']:"";
        
        $childCondition = [];
        $parentCondition = [];
        if($section =='child-section'){
            $childCondition[] = ["CONCAT(firstname,'',lastname) LIKE" => "%".$search . "%"];
        } elseif($section =='guardian-section') {
            $parentCondition[] = ["CONCAT(firstname,'',lastname) LIKE" => "%".$search . "%"];
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
        $this->set(compact('profile','childs','guardian')); 
    }

    public function addparents($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $Createddate = date("Y-m-d h:i:sa");
        $this->Users->getValidator()->remove('school');
            $this->Users->getValidator()->remove('relation');
            $this->Users->getValidator()->remove('relation1');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            
            $dobnew = date('Y-m-d', strtotime($_POST['dob']));
            $file = array();
            $imageinfo = $this->request->getData('image');
            if ($imageinfo['name'] != '') {
                $file = $this->request->getData('image');
            }
            $user = $this->Users->patchEntity($user, $this->request->getData());
             
                $dataid = $this->request->getSession()->read('Auth.User.id');
                $password = $this->request->getParam('password');
                $user->created = $Createddate;
                $user->role_id = "4";
                $user->group_id = "4";
                $user->bso_id = $dataid;
                $user->created = $Createddate;
                $user->dob = $dobnew;
                $user->uuid = Text::uuid();
            if (!$user->getErrors()) {
                
                
                
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
                        $this->Users->save($patchImageEntity);
                    }

                    $emailsend = $savedid['email'];
                    $message = 'You are Register with BSO Portal' . '<br/>';
                    $message .= 'Your Email:' . '' . $savedid['email'] . '<br/>';
                    $message .= 'Your Password:' . '' . $password . '<br/>';

                    $to = $emailsend;
                    $from = 'rtestoffshore@gmail.com';
                    $title = 'Bso';
                    $subject = 'You Register With BSO';

                    $this->EmailSend->emailSend($from, $title, $to, $subject, $message);

                }

                $this->Flash->success(__('The Parent has been saved.'));
                return $this->redirect(['action' => 'parents']);

            }
            $this->Flash->error(__('The Parent could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }


    public function editParents($id = null) {
        $this->viewBuilder()->setLayout('admin');
        $user = $this->Users->find('all')->where(['uuid'=>$id])->first();
        $this->Users->getValidator()->remove('image');
        $this->Users->getValidator()->remove('email');
        $this->Users->getValidator()->remove('password');
        $this->Users->getValidator()->remove('gender');
        $this->Users->getValidator()->remove('dob');
        $this->Users->getValidator()->remove('lastname');
        $this->Users->getValidator()->remove('confirm_password');

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $dobnew = date('Y-m-d', strtotime($_POST['dob']));
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
                            $this->Users->save($imageEntity);
                        }
                    }
                }
                $this->Flash->success(_('The Parents profile has been updated.'));
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
            $dobnew = date('Y-m-d', strtotime($_POST['dob']));
             if($_POST['relation1']=='3'){
                $relation=$_POST['relation'];
            }elseif($_POST['relation1']=='2'){
                $relation='Daughter';
            }elseif($_POST['relation1']=='1'){
               $relation='Son'; 
            }

            $file   = $this->request->getData('image');
                 //   unset($this->request->data['image']);

            $user = $this->Users->patchEntity($user, $this->request->getData());

                $dataid = $this->request->getSession()->read('Auth.User.id');
                //$password = $this->request->getParam('password');
                     
            if (!$user->getErrors()) {
                
                $user->bso_id = $dataid;
                $user->role_id = "4";
                $user->group_id = "4";
                $user->dob = $dobnew;
                $user->relation = $relation;
                $user->created = $Createddate;
                $user->uuid = Text::uuid();
              
                if($savedid = $this->Users->save($user)){

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
                                $this->Users->save($imageEntity);
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
                

                    $this->Flash->success(__('The Guardian has been saved.'));
                    return $this->redirect(['action' => 'parents', 'prefix' => false]);
                }
            }
            $this->Flash->error(__('The Guardian could not be saved. Please, try again.'));

        }

        $this->set(compact('user','parents'));
    }
    
     public function guardianEdit($id = null) {
    
        $this->viewBuilder()->setLayout('admin');
        $user = $this->Users->find('all')->where(['uuid'=>$id])->first();

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
          
            $parant = $this->Users->find('all')->where(['id'=>$user->parent_id])->first();
            //pr($parant);die;
            $dobnew = date('Y-m-d', strtotime($_POST['dob']));
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
                            $this->Users->save($imageEntity);
                        }
                    }
                }
                $this->Flash->success(_('The Child profile has been updated.'));
                return $this->redirect(['action' => 'parent-profile',$parant['uuid']]);
            }

            $this->Flash->error(__('There are some problem to update Child. Please try again!'));
        }
        $this->set(compact('user'));
    }
     public function parentDeactivate($id = null){
        
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userid = $this->UuId->uuid($id);
            $user = $this->Users->get($userid, ['contain' => []]);
            $user->is_active = "0";
            if ($this->Users->save($user)) {
                $this->Flash->success(_('The parent has been deactivated.'));
                return $this->redirect(['action' => 'parents','prefix' => false]);
            }
            $this->Flash->error(_('The employee could not be deactivated.'));
        }
        $this->set(compact('user'));

    }
     public function parentActivate($id = null){
       
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userid = $this->UuId->uuid($id);
            $user = $this->Users->get($userid, ['contain' => []]);
            $user->is_active = "1";
            if ($this->Users->save($user)) {
                $this->Flash->success(_('The parent has been deactivated.'));
                return $this->redirect(['action' => 'parents','prefix' => false]);
            }
            $this->Flash->error(_('The employee could not be deactivated.'));
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
        $parents = $this->Users->find('all')->where(['uuid'=>$id])->first();
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
            $dobnew = date('Y-m-d', strtotime($_POST['dob']));
            if($_POST['relation1']=='3'){
                $relation=$_POST['relation'];
            }elseif($_POST['relation1']=='2'){
                $relation='Daughter';
            }elseif($_POST['relation1']=='1'){
               $relation='Son'; 
            }
            $file = array();
            $imageinfo = $this->request->getData('image');
            if ($imageinfo['name'] != '') {
                $file = $this->request->getData('image');
            }
            $schoolspostdata=array(
                    'name'=>$_POST['school'],
            );
            $schooldata=$this->Schools->patchEntity($school,$schoolspostdata);
             
                
           if($result = $this->Schools->save($schooldata)){

                $schoolid=$result['id'];
               
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
                        $this->Users->save($patchImageEntity);
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

                $this->Flash->success(__('The CHILD has been saved.'));
                return $this->redirect(['action' => 'parents']);

            }
           }
            $this->Flash->error(__('The CHILD could not be saved. Please, try again.'));
        }else{

            $userid = $this->UuId->uuid($id);
            $parents = $this->Users->get($userid, ['contain' => []]);
        }
     
        $this->set(compact('user','parents'));
    }
    public function childEdit($id = null) {
    
        $this->viewBuilder()->setLayout('admin');
        $user = $this->Users->find('all')->where(['uuid'=>$id])->first();

       
        
        $this->Users->getValidator()->remove('image');
        $this->Users->getValidator()->remove('email');
        $this->Users->getValidator()->remove('password');
        $this->Users->getValidator()->remove('gender');
        $this->Users->getValidator()->remove('dob');
        $this->Users->getValidator()->remove('lastname');
        $this->Users->getValidator()->remove('confirm_password');

        if ($this->request->is(['patch', 'post', 'put'])) {
          
            $parant = $this->Users->find('all')->where(['id'=>$user->parent_id])->first();
            //pr($parant);die;
            $dobnew = date('Y-m-d', strtotime($_POST['dob']));
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
                            $this->Users->save($imageEntity);
                        }
                    }
                }
                $this->Flash->success(_('The Child profile has been updated.'));
                return $this->redirect(['action' => 'parent-profile',$parant['uuid']]);
            }

            $this->Flash->error(__('There are some problem to update Child. Please try again!'));
        }
        $this->set(compact('user'));
    }
    
    /*
    END OF
    CHILD FUNCTIONALITY
    
     */

    public function checkPassword($value, $context)
    {
        if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $context['data']['password'])) {
            return false;
        } else {
            return true;
        }
    }
    /*********Add services of bso ************/
        public function addServices()
        {
            $this->loadModel('BsoServices');
            $this->viewBuilder()->setLayout('admin');
            //$Createddate = date("Y-m-d h:i:sa");
            $Createddate = date("Y-m-d");
            $service = $this->BsoServices->newEntity();
            $dataid = $this->request->getSession()->read('Auth.User.id');
            if ($this->request->is('post')) {
              
                    $day= $_POST['service_day'];
                    $Starttime=$_POST['start_time'];
                    $endtime= $_POST['end_time'];
                    $savestart_time = date("H:i:s", strtotime($Starttime));
                    $saveend_time = date("H:i:s", strtotime($endtime));
                 
                  
            $user = $this->BsoServices->find('all')->where([
                                                            'bso_id'=> $dataid,
                                                            'service_day'=> $day,
                                                           'end_time >='=> $savestart_time,
                                                           'start_time <='=> $saveend_time,
                                                            ])->toArray();

                 
                if(empty($user)){

                    
                      $service = $this->BsoServices->patchEntity($service, $this->request->getData());
                            if (!$service->getErrors()) {
                                $service->bso_id = $dataid;
                                $service->created = $Createddate;
                                $service->start_time = $savestart_time;
                                $service->end_time = $saveend_time;
                                $service->uuid = Text::uuid();
                                $savedid = $this->BsoServices->save($service);
                                $this->Flash->success(__('Service has been saved.'));
                                return $this->redirect(['action' => 'manageServices']);
                            }
                            $this->Flash->error(__('This service could not be saved. Please, try again.'));
                }else{
                        $this->Flash->error(__('Time slot is not valid so it could not be saved. Please, try again.'));
                    
                }
                 // foreach ($user as $key => $value) {
                 //          $value['service_day'];
                 //          $Starttime1= strtotime($value['start_time']);
                 //           $endtime1= strtotime($value['end_time']);

                 //   if($Starttime1 > $Starttime < $endtime1){

                   
                 //    echo "time slot alrady ";
                 //   }else{
                 //    echo "string";
                 //   }
                  

                 // }
                           
            }
            $this->set(compact('service'));
        }
    /***********End****************/

}
