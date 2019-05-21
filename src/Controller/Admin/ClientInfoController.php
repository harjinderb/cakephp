<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ClientInfo Controller
 *
 * @property \App\Model\Table\ClientInfoTable $ClientInfo
 *
 * @method \App\Model\Entity\ClientInfo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientInfoController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');
        $clientInfo = $this->paginate($this->ClientInfo);

        $this->set(compact('clientInfo'));
    }

    /**
     * View method
     *
     * @param string|null $id Client Info id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientInfo = $this->ClientInfo->get($id, [
            'contain' => [],
        ]);

        $this->set('clientInfo', $clientInfo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientInfo = $this->ClientInfo->newEntity();
        if ($this->request->is('post')) {
            $clientInfo = $this->ClientInfo->patchEntity($clientInfo, $this->request->getData());
            if ($this->ClientInfo->save($clientInfo)) {
                $this->Flash->success(__('The client info has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client info could not be saved. Please, try again.'));
        }
        $this->set(compact('clientInfo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Info id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientInfo = $this->ClientInfo->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientInfo = $this->ClientInfo->patchEntity($clientInfo, $this->request->getData());
            if ($this->ClientInfo->save($clientInfo)) {
                $this->Flash->success(__('The client info has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client info could not be saved. Please, try again.'));
        }
        $this->set(compact('clientInfo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Info id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientInfo = $this->ClientInfo->get($id);
        if ($this->ClientInfo->delete($clientInfo)) {
            $this->Flash->success(__('The client info has been deleted.'));
        } else {
            $this->Flash->error(__('The client info could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
