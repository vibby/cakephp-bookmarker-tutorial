<?php

namespace App\Controller;

/**
 * Tags Controller.
 *
 * @property \App\Model\Table\TagsTable $Tags
 */
class TagsController extends AppController
{
    /**
     * Index method.
     */
    public function index()
    {
        $this->set('tags', $this->paginate($this->Tags));
        $this->set('_serialize', ['tags']);
    }

    /**
     * View method.
     *
     * @param null|string $id tag id
     *
     * @throws \Cake\Network\Exception\NotFoundException when record not found
     */
    public function view($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['Bookmarks'],
        ]);
        $this->set('tag', $tag);
        $this->set('_serialize', ['tag']);
    }

    /**
     * Add method.
     */
    public function add()
    {
        $tag = $this->Tags->newEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->data);
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $bookmarks = $this->Tags->Bookmarks->find('list', ['limit' => 200]);
        $this->set(compact('tag', 'bookmarks'));
        $this->set('_serialize', ['tag']);
    }

    /**
     * Edit method.
     *
     * @param null|string $id tag id
     *
     * @throws \Cake\Network\Exception\NotFoundException when record not found
     */
    public function edit($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['Bookmarks'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tag = $this->Tags->patchEntity($tag, $this->request->data);
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $bookmarks = $this->Tags->Bookmarks->find('list', ['limit' => 200]);
        $this->set(compact('tag', 'bookmarks'));
        $this->set('_serialize', ['tag']);
    }

    /**
     * Delete method.
     *
     * @param null|string $id tag id
     *
     * @throws \Cake\Network\Exception\NotFoundException when record not found
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag has been deleted.'));
        } else {
            $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
