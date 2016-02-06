<?php
class AppController extends Controller
{
	var $helpers = array('Html', 'Ajax', 'Javascript', 'Form', 'Session', 'Text', 'Cache');
	var $uses = array('CtrlActPermit','UserTypeUpload','MenuAddon');


	function checkSession()
	{
		// if the session info hasn't been set...
		if ( !$this->Session->check('User') )
		{
			// Force the user to login
			$this->redirect('/users/login');
			exit();
		}
	}

	function checkPermission( $_controller=null, $_action=null, $_pass=null )
	{
		$ctrl_act_permit_enable = 0;


		$ctrl_act_permit = $this->CtrlActPermit->find('first', array(
						'fields' => array('ctrl_act_menu_id','ctrl_act_type'),
						'conditions' => array(
							'ctrl_act_controller' => $_controller,
							'ctrl_act_action' => $_action)));

		$user_type_upload = $this->UserTypeUpload->findByusers_type_upload_id($this->Session->read('User.id'));


		if ( !empty($ctrl_act_permit) )
		{
			if ( $this->Session->read('User.level') < 10 )
			{
				$ctrl_act_type = $ctrl_act_permit['CtrlActPermit']['ctrl_act_type'];
				$ctrl_act_menu_id = $ctrl_act_permit['CtrlActPermit']['ctrl_act_menu_id'];

				// check menu type 
				if ( ($this->Session->read('User.level') == 2 || $this->Session->read('User.level') == 3) && ($ctrl_act_type == Configure::read('download.files')) )
				{
					$ctrl_act_permit_enable = 1;
				}
				else if ( ($this->Session->read('User.level') == 1 || $this->Session->read('User.level') == 3) && ($ctrl_act_type == Configure::read('upload.articoli')) )
				{
					if ( !empty($user_type_upload) && ($user_type_upload['UserTypeUpload']['users_type_upload_art'] == 1) )
						$ctrl_act_permit_enable = 1;
				}
				else if ( ($this->Session->read('User.level') == 1 || $this->Session->read('User.level') == 3) && ($ctrl_act_type == Configure::read('upload.foto')) )
				{
					if ( !empty($user_type_upload) && ($user_type_upload['UserTypeUpload']['users_type_upload_pho'] == 1) )
						$ctrl_act_permit_enable = 1;
				}
				else if ( ($this->Session->read('User.level') == 1 || $this->Session->read('User.level') == 3) && ($ctrl_act_type == Configure::read('upload.files')) )
				{
					if ( !empty($user_type_upload) && ($user_type_upload['UserTypeUpload']['users_type_upload_all'] == 1) )
						$ctrl_act_permit_enable = 1;
				}
				// check editor download
				else if ( $ctrl_act_type == Configure::read('download.editor_software') )
				{
					$ctrl_act_permit_enable = 1;
				}
				else if ( $ctrl_act_type == Configure::read('download.editor_manual') )
				{
					$ctrl_act_permit_enable = 1;
				}
				else if ( $ctrl_act_type == Configure::read('download.cms_manual') )
				{
					$ctrl_act_permit_enable = 1;
				}
				// check help docs
				else if ( $ctrl_act_type == Configure::read('doc.help_base') )
				{
					$ctrl_act_permit_enable = 1;
				}
				else if ( $ctrl_act_type == Configure::read('addon') )
				{
					$menu_addon_permit = $this->MenuAddon->find('first', array(
								'conditions' => array(
									'menu_addon_user_id' => $this->Session->read('User.id'),
									'menu_addon_main_id' => $ctrl_act_menu_id ),
								'fields' => array('menu_addon_main_id')));

					if ( !empty($menu_addon_permit) )
						$ctrl_act_permit_enable = 1;
				}
			}
			else
			{
				// check if admin type
				$ctrl_act_permit_enable = 1;
			}
		}
		else
		{
			$this->log('AppController:checkPermission - Unable query CtrlActPermit record : '.$_action, Configure::read('log_file'));

			$ctrl_act_permit_enable = 1;
		}


		if ( !$ctrl_act_permit_enable )
		{
			$this->log('AppController:checkPermission - Access denied', Configure::read('log_file'));
			$this->redirect('/');
			exit();
		}
		else
			return;
	}
}