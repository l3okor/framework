<?php

class View extends Template{


	public function setIndexTpl()
	{
		$this->setFile('tpl_index', 'index.tpl');
	}

	public function setGlobals()
	{
		$this->setVar('SITE_TITLE', SITE_TITLE);
		$this->setVar('SITE_URL', SITE_URL);
	}

	public function setPageTitle($pageTitle)
	{
		$this->setVar('PAGE_TITLE', $pageTitle);
	}

	public function displayMessages()
	{
		if (isset($_SESSION['msg']))
		{
			$messages = $_SESSION['msg']['text'];

			if (!is_array($messages))
				$messages = array($messages);
			$this->setFile('tpl_messages', 'blocks/messages.tpl');
			$this->setVar('MSG_TYPE', $_SESSION['msg']['type']);
			$this->setBlock('tpl_messages', 'list', '_list');
			foreach ($messages as $list)
			{
				$this->setVar('MESSAGE', $list);
				$this->parse('_list', 'list', TRUE);

			}
			$this->parse('MESSAGES', 'tpl_messages');
			unset($_SESSION['msg']);
		}
		else
		{
		 	$this->setVar('MSG_TYPE', '');
		 	$this->setVar('MESSAGES', '');
		}
	}

}