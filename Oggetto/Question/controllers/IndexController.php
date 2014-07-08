<?php

class Oggetto_Question_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}

	public function sendAction()
	{
		$post = $this->getRequest()->getPost();

		$question = Mage::getModel('question/question');
		$question->setName($post['name']);
		$question->setEmail($post['email']);
		$question->setText($post['text']);

		$question->save();

		$this->_redirect('/');
	}
}
