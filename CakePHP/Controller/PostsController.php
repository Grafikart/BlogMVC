<?php
class PostsController extends AppController{

    public $paginate = array(
        'fields'  => array('Post.id','Post.name','Post.slug','Post.created','Post.content','Category.slug','Category.name','User.username'),
        'contain' => array('Category','User'),
        'limit'   => 5,
        'paramType' => 'querystring'
    );
    public $helpers = array('Markdown.Markdown');

    public function index(){
        $conditions = null;

        // Category filter
        if(isset($this->request->params['category'])){
            $conditions = array('Category.slug' => $this->request->params['category']);
            $this->request->params['named']['category'] = $this->request->params['category'];
        }
        if(isset($this->request->params['user'])){
            $conditions = array('Post.user_id' => $this->request->params['user']);
            $this->request->params['named']['user'] = $this->request->params['user'];
        }


        $posts = $this->Paginate('Post', $conditions);
        $this->set(compact('posts'));
    }

    public function view($slug){
        $this->Post->contain('Category', 'User', 'Comment');
        $post = $this->Post->findBySlug($slug, array('Post.id','Post.name','Post.slug','Post.created','Post.content','Category.slug','Category.name','User.username'));
        if(empty($post)){
            throw new NotFoundException();
        }
        $this->set(compact('post'));

        // Comment submission
        if(!empty($this->request->data)){
            $this->Post->Comment->create($this->request->data, true);
            $this->request->data['Comment']['post_id'] = $post['Post']['id'];
            if($this->Post->Comment->save(null, true, array('mail', 'username', 'content', 'post_id'))){
                $this->Session->setFlash("Thanks for your comment","success");
                return $this->redirect($this->referer());
            }else{
                $this->Session->setFlash("You have to correct your errors first","error");
            }
        }
    }

    /**
    * Requested, get datas for sidebar
    **/
    public function sidebar(){
        $last_posts = $this->Post->find('all', array(
            'limit' => 2,
            'fields'=> array('Post.id','Post.slug','Post.name')
        ));
        $categories = $this->Post->Category->find('all');
        return compact('last_posts', 'categories');
    }

    /**
    * Admin panel
    **/
    public function admin_index(){
        $posts = $this->Paginate('Post');
        $this->set(compact('posts'));
    }

    public function admin_edit($id = null){
        if (!empty($this->request->data)) {
            if($this->Post->save($this->request->data)){
                $this->Session->setFlash("Post saved","success");
                $this->_clean_cache();
                return $this->redirect(array('action' => 'index'));
            }
        }elseif($id){
            $this->request->data = $this->Post->findById($id);
        }
        $users      = $this->Post->User->find('list');
        $categories = $this->Post->Category->find('list');
        $this->set(compact('users', 'categories'));
    }

    public function admin_delete($id){
        $this->Post->delete($id);
        $this->Session->setFlash("Post deleted","success");
        $this->_clean_cache();
        return $this->redirect($this->referer());
    }

    private function _clean_cache(){
        if(file_exists(CACHE . 'cake_element__sidebar_cache_callbacks')){
            unlink(CACHE . 'cake_element__sidebar_cache_callbacks');
        }
    }

}