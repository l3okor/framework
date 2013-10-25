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
}