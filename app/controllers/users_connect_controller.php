<?php
class UsersConnectController extends AppController {
	var $name = 'UsersConnect';
	var $uses = array('UserConnect');

	function beforeFilter() 
	{
		$this->checkSession();
	}

	function index() 
	{
		$this->autoRender = false;
	}

	function infoUserConnect()
	{
		$this->autoRender = false;

		$user_connect = $this->UserConnect->findByusers_connect_id( $this->Session->read('User.id') );

		if ( !empty($user_connect) )
		{
			return $user_connect;

		}
		else
			return null;
	}

	function updateUserConnect()
	{
		$this->autoRender = false;

		$time_now = strtotime("now");

		$user_connect = $this->UserConnect->findByusers_connect_id( $this->Session->read('User.id') );

		if ( !empty($user_connect) )
		{
			$this->UserConnect->read( null, $user_connect['UserConnect']['users_connect_id'] );

			$this->UserConnect->set( array(
				'users_connect_lastcon' => $user_connect['UserConnect']['users_connect_nowcon'],
				'users_connect_nowcon' => $time_now));
			
			$this->UserConnect->save();
		}
		else
		{
			$this->UserConnect->create();

			$this->UserConnect->set( array(
				'users_connect_id' => $this->Session->read('User.id'),
				'users_connect_username' => $this->Session->read('User.username'),
				'users_connect_nowcon' => $time_now));

			$this->UserConnect->save();
		}

		return null;
	}

}
?>