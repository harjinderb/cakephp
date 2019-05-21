<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Xyz Controller
 *
 *
 * @method \App\Model\Entity\Xyz[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class XyzController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $xyz = $this->paginate($this->Xyz);

        $this->set(compact('xyz'));
    }

    /**
     * View method
     *
     * @param string|null $id Xyz id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $xyz = $this->Xyz->get($id, [
            'contain' => []
        ]);

        $this->set('xyz', $xyz);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $xyz = $this->Xyz->newEntity();
        if ($this->request->is('post')) {
            $xyz = $this->Xyz->patchEntity($xyz, $this->request->getData());
            if ($this->Xyz->save($xyz)) {
                $this->Flash->success(__('The xyz has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The xyz could not be saved. Please, try again.'));
        }
        $this->set(compact('xyz'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Xyz id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $xyz = $this->Xyz->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $xyz = $this->Xyz->patchEntity($xyz, $this->request->getData());
            if ($this->Xyz->save($xyz)) {
                $this->Flash->success(__('The xyz has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The xyz could not be saved. Please, try again.'));
        }
        $this->set(compact('xyz'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Xyz id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $xyz = $this->Xyz->get($id);
        if ($this->Xyz->delete($xyz)) {
            $this->Flash->success(__('The xyz has been deleted.'));
        } else {
            $this->Flash->error(__('The xyz could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
