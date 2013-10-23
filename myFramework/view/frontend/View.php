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
}