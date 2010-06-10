<?php

class BlogController extends Zend_Controller_Action
{
	protected $_em;
	
    public function init()
    {
        $this->_em = $this->getInvokeArg('bootstrap')->getResource('doctrine');
    }

	public function postDispatch()
	{
		$this->_em->flush();
	}

	/**
	 * Lists the blog entries.
	 *
	 * @return void
	 * @author Bryan Zarzuela
	 */
    public function indexAction()
    {
		$posts = $this->_em->createQuery("SELECT p FROM D2Test_Model_Post p")->getResult();
		$this->view->posts = $posts;
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
			$post->setTitle($this->_getParam('title'));
			$post->setBody($this->_getParam('body'));

			$this->_em->persist($post);
			
			// $this->_redirect('/blog');
		} 
		
	}
}

