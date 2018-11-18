<?php
// src/Controller/ArticlesController.php
namespace App\Controller;

class ArticlesController extends AppController
{

	public function initialize()
	{
		parent::initialize();
		
		$this->loadComponent('Paginator');
		$this->loadComponent('Flash');
	}

	public function index()
	{
		$articles = $this->Paginator->paginate($this->Articles->find());
		// query keyword for templates
		$this->set(compact('articles'));
	}

	public function view($slug = null)
	{
		$article = $this->Articles->findBySlug($slug)->firstOrFail();
		$this->set(compact('article'));
	}

	public function add()
	{
		$article = $this->Articles->newEntity();
		if ($this->request->is('post')) {
			$article = $this->Articles->patchEntity($article, $this->request->getData());

			$article->user_id = 1;

			if ($this->Articles->save($article)) {
				$this->Flash->success(__('Your article has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to add your article.'));
		}
		$this->set('article', $article);
	}
}