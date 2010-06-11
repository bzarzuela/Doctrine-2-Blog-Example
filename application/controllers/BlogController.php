<?php

class BlogController extends Zend_Controller_Action
{
	/**
	 * Lists the blog entries.
	 *
	 * @return void
	 * @author Bryan Zarzuela
	 */
    public function listAction()
    {
		$posts = D2Test_Model_Post::findAll();
		$this->view->posts = $posts;
    }

	/**
	 * Just forwards the request to list.
	 *
	 * @return void
	 * @author Bryan Zarzuela
	 */
	public function indexAction()
	{
		$this->_forward('list');
	}

	/**
	 * Creates a new blog entry
	 *
	 * @return void
	 * @author Bryan Zarzuela
	 */
	public function newAction()
	{
		/*
			TODO Use Zend_Form
		*/
		
		
		if ($this->_request->isPost()) {
			$post = new D2Test_Model_Post;
			$post->fromArray(array(
				'title' => $this->_getParam('title'),
				'body' => $this->_getParam('body'),
			));

			// $em = Zend_Registry::get('EntityManager');
			// $em->persist($post);
			// $em->flush();
			
			// $this->_redirect('/blog/list');
		} 
		
	}
}

