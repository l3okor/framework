<?php

class PageView
{
	public function __construct(Template $tpl)
	{
		$this->tpl = $tpl;
	}

	public function showAboutPage($data)
	{
		$this->tpl->setFile('tpl_content', 'page/about.tpl');
		$this->tpl->setVar('TITLE', 'About Us');
		$this->tpl->setVar('MESSAGE', 'World');
		$this->tpl->setBlock('tpl_content', 'clients', '_clients');
		foreach ($data as $client)
		{
			$this->tpl->setVar('CLIENT_ID', $client['id']);
			$this->tpl->setVar('CLIENT_NAME', $client['name']);
			$this->tpl->setVar('CLIENT_CAR', $client['car']);
			$this->tpl->parse('_clients', 'clients', TRUE);

		}


	}
}