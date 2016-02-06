<?php
class MenusController extends AppController {
	var $name = 'Menus';
	var $uses = array('MenuMain', 'MenuItem', 'MenuAddon', 'UserTypeUpload');

	function beforeFilter() 
	{
		$this->checkSession();
	}

	function index() 
	{
		$this->autoRender = false;
	}

	function menu()
	{
		$this->autoRender = false;

		$menus = $this->MenuMain->find('all', array(
					'conditions' => array('menu_main_status' => 1 ),
					'fields' => array('menu_main_id', 'menu_main_desc', 'menu_main_controller','menu_main_action', 'menu_main_items', 'menu_main_addon', 'menu_main_type'),
					'order' => 'menu_main_orderid ASC'));


		return $menus;
	}

	function menuAddon()
	{
		$this->autoRender = false;

		// menu addon permit enabled
		$this->MenuAddon->bindModel(array(
			'belongsTo' => array(
				'MenuMain' => array(
					'className' => 'MenuMain',
					'foreignKey' => false,
					'conditions' => array(
						'MenuMain.menu_main_id = MenuAddon.menu_addon_main_id'),
					'fields' => null
			)
		)), false );

		$menu_addon_permit = $this->MenuAddon->find('all', array(
							'conditions' => array(
								'MenuAddon.menu_addon_user_id' => $this->Session->read('User.id'),
								'MenuAddon.menu_addon_status' => 1),
							'fields' => array('menu_addon_main_id')));


		return $menu_addon_permit;
	}

	function menuTypeUpload()
	{
		$this->autoRender = false;

		$user_type_upload = $this->UserTypeUpload->findByusers_type_upload_id($this->Session->read('User.id'));


		return $user_type_upload;
	}

	function menuStatus( $sessionMenu = null )
	{
		if ( $this->Session->check($sessionMenu) && $this->Session->read($sessionMenu) == 1 )
		{
			$this->Session->write($sessionMenu, 0);
		}
		else
			$this->Session->write($sessionMenu, 1);

		$this->redirect('/');
	}
}
?>