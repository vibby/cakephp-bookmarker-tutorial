<?php

namespace App\Controller;

use App\Application\GetBookmark\GetBookmarkHandler;
use App\Application\GetBookmark\GetBookmarkInput;
use App\Application\UpdateBookmark\UpdateBookmarkHandler;
use App\Application\UpdateBookmark\UpdateBookmarkInput;
use App\Domain\Bookmark\Exception\ViolationCollectionException;

/**
 * Bookmarks Controller.
 *
 * @property \App\Model\Table\BookmarksTable                        $Bookmarks
 * @property \App\Controller\Component\ContainerComponent           $Container
 * @property \App\Controller\Component\BookmarkTransformerComponent $BookmarkTransformer
 */
class BookmarksController extends AppController
{
    /**
     * Index method.
     */
    public function index()
    {
        $this->paginate = [
            'conditions' => [
                'Bookmarks.user_id' => $this->Auth->user('id'),
            ],
        ];
        $this->set('bookmarks', $this->paginate($this->Bookmarks));
        $this->set('_serialize', ['bookmarks']);
    }

    /**
     * View method.
     *
     * @param null|string $id bookmark id
     *
     * @throws \Cake\Network\Exception\NotFoundException when record not found
     */
    public function view($id = null)
    {
        $input = new GetBookmarkInput((int) $id);
        $handler = $this->Container->get(GetBookmarkHandler::class);
        $bookmarkModel = $handler($input);
        $bookmark = $this->BookmarkTransformer->modelToEntity($bookmarkModel);

        $this->set('bookmark', $bookmark);
        $this->set('_serialize', ['bookmark']);
    }

    /**
     * Add method.
     */
    public function add()
    {
        $bookmark = $this->Bookmarks->newEntity();
        if ($this->request->is('post')) {
            $bookmark = $this->Bookmarks->patchEntity($bookmark, $this->request->getData());
            $bookmark->user_id = $this->Auth->user('id');
            if ($this->Bookmarks->save($bookmark)) {
                $this->Flash->success('The bookmark has been saved.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The bookmark could not be saved. Please, try again.');
        }
        $tags = $this->Bookmarks->Tags->find('list');
        $this->set(compact('bookmark', 'tags'));
        $this->set('_serialize', ['bookmark']);
    }

    /**
     * Edit method.
     *
     * @param null|string $id bookmark id
     *
     * @throws \Cake\Network\Exception\NotFoundException when record not found
     */
    public function edit($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $input = new UpdateBookmarkInput(
                id: $id,
                title: $this->request->getData()['title'],
                url: $this->request->getData()['url'],
                description: $this->request->getData()['description'],
                tagsTitle: array_filter(array_unique(
                    array_map(
                        'trim',
                        explode(',', $this->request->getData()['tag_string'])
                    )
                ))
            );
            $handler = $this->Container->get(UpdateBookmarkHandler::class);

            try {
                $handler($input);
                $this->Flash->success('The bookmark has been saved.');

                return $this->redirect(['action' => 'index']);
            } catch (ViolationCollectionException $exception) {
                $this->Flash->error(implode(' ', $exception->violationCollection));
            }
        }
        $input = new GetBookmarkInput((int) $id);
        $handler = $this->Container->get(GetBookmarkHandler::class);
        $bookmarkModel = $handler($input);
        $bookmark = $this->BookmarkTransformer->modelToEntity($bookmarkModel);
        $tags = $this->Bookmarks->Tags->find('list');
        $this->set(compact('bookmark', 'tags'));
        $this->set('_serialize', ['bookmark']);
    }

    /**
     * Delete method.
     *
     * @param null|string $id bookmark id
     *
     * @throws \Cake\Network\Exception\NotFoundException when record not found
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookmark = $this->Bookmarks->get($id);
        if ($this->Bookmarks->delete($bookmark)) {
            $this->Flash->success(__('The bookmark has been deleted.'));
        } else {
            $this->Flash->error(__('The bookmark could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function tags()
    {
        // The 'pass' key is provided by CakePHP and contains all
        // the passed URL path segments in the request.
        $tags = $this->request->getParam('pass');

        // Use the BookmarksTable to find tagged bookmarks.
        $bookmarks = $this->Bookmarks->find('tagged', [
            'tags' => $tags,
        ]);

        // Pass variables into the view template context.
        $this->set([
            'bookmarks' => $bookmarks,
            'tags' => $tags,
        ]);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'add', 'tags'])) {
            return true;
        }
        // All other actions require an id.
        if (empty($this->request->getParam('pass')[0])) {
            return false;
        }

        // Check that the bookmark belongs to the current user.
        $id = $this->request->getParam('pass')[0];
        $bookmark = $this->Bookmarks->get($id);
        if ($bookmark->user_id == $user['id']) {
            return true;
        }

        return false;
    }
}
