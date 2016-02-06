<?php
class SupplinksController extends AppController {
	var $name = 'Supplinks';
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

	function agenzie()
	{
		//$this->autoRender = false;
		$sessionId = md5(uniqid(time()));
		$this->set('sessionId',$sessionId);
        }

        function sendcms()
        {
        }
}
?>