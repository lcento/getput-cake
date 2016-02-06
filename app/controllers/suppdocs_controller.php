<?php
class SuppdocsController extends AppController {
	var $name = 'Suppdocs';
	var $uses = array('User');

	function beforeFilter()
	{
		Configure::write('debug', 0);
		Configure::write('log', false);

		// // check session status
		$this->checkSession();
		// check permission status
		$this->checkPermission( $this->params['controller'], $this->params['action'], $this->params['pass']);
	}

	function afterFilter()
	{
		// set session default var
	}

	function index() 
	{
		$this->autoRender = false;
	}

	function help()
	{
        }
}
?>