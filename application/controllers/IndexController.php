<?php

class IndexController extends Zend_Controller_Action
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

    public function indexAction()
    {
		$test = new D2Test_Model_User;
		$test->setName('Bryan');
		
		$this->_em->persist($test);
    }
}

