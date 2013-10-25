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
			$messages = $_SESSION['text'];
			if (!is_array($messages))
				$messages = array($messages);
			$this->setFile('MESSAGES', 'messages.tpl');
			$this->setBlock('MESSAGES', 'list', '_list');
			foreach ($messages as $list)
			{
				$this->setVar('LIST', $list);
				$this->parse('_list', 'list', TRUE);

			}

		}
	}

}