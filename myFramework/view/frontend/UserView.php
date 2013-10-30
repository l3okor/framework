<?php

class UserView extends Template
{
	public function __construct(Template $tpl)
	{
		$this->tpl = $tpl;
	}

	public function setIndexTpl()
	{
		$this->setFile('tpl_index', 'index.tpl');
	}


	public function loginPage()
	{
		$this->tpl->setFile('tpl_content', 'user/login.tpl');
		$this->tpl->parse('index.tpl', 'tpl_content');
	}

	public function registerPage( $data )
	{
		$this->tpl->setFile('tpl_content', 'user/register.tpl');

		if (!empty($data))
		{
			// checked. pana aici merge. primeste $data-ul
			$this->tpl->setVar('USERNAME', $data['username']);
			$this->tpl->setVar('EMAIL', $data['email']);
			$this->tpl->setVar('NAME', $data['name']);
			$this->tpl->setVar('SURNAME', $data['surname']);
			//Core::debug($data);
		}
		$this->tpl->parse('index.tpl', 'tpl_content');
	}

	public function myAccountPage()
	{
		$this->tpl->setFile('tpl_content', 'user/myaccount.tpl');

		$this->tpl->parse('index.tpl', 'tpl_content');

	}

}