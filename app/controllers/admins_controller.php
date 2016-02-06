<?php
App::import('Sanitize');
class AdminsController extends AppController {
	var $name = 'Admins';
	var $uses = array('User', 'AgeGroup', 'AgeUserGroup', 'LevelUserDesc', 'TypeUserDesc', 'TypeAccessDesc', 'TypeAccessRealnameDesc', 'UserTypeUpload', 'UserAddon', 'ActivityFilegetHistory', 'ActivityFileputHistory', 'MenuMain', 'MenuAddon');

	public $components = array('RequestHandler');

	var $queryusers = array(
			'fields' => array(
				'User.users_id','User.users_username','User.users_password','User.users_username_realname','User.users_level','User.users_type','User.users_se_author','TypeUserDesc.type_users_desc','LevelUserDesc.level_users_desc','AgeUserGroup.group_id','AgeGroup.group_desc'),
			'joins' => array(
				array(
					'table' => 'getput_level_users_desc',
					'type' => 'INNER',
					'alias' => 'LevelUserDesc',
					'conditions' => array('User.users_level = LevelUserDesc.level_users_num')
				),
				array(
					'table' => 'getput_type_users_desc',
					'type' => 'INNER',
					'alias' => 'TypeUserDesc',
					'conditions' => array('User.users_type = TypeUserDesc.type_users_num')
				),
				array(
					'table' => 'getput_ageusersgroup',
					'type' => 'INNER',
					'alias' => 'AgeUserGroup',
					'conditions' => array('User.users_id = AgeUserGroup.users_id')
				),
				array(
					'table' => 'getput_agegroup',
					'type' => 'INNER',
					'alias' => 'AgeGroup',
					'conditions' => array('AgeUserGroup.group_id = AgeGroup.group_id')
				)
			),
			'limit' => '',
			'conditions' => '',
			'contain' => '',
			'order' => array(
				'User.users_username' => 'asc')
	);

	var $report_listusers = array(
		'fields' => array(
			'User.users_username','User.users_password','User.users_username_realname','User.users_se_author','TypeUserDesc.type_users_desc','LevelUserDesc.level_users_desc','AgeGroup.group_desc'),
			'joins' => array(
				array(
					'table' => 'getput_level_users_desc',
					'type' => 'INNER',
					'alias' => 'LevelUserDesc',
					'conditions' => array('User.users_level = LevelUserDesc.level_users_num')
				),
				array(
					'table' => 'getput_type_users_desc',
					'type' => 'INNER',
					'alias' => 'TypeUserDesc',
					'conditions' => array('User.users_type = TypeUserDesc.type_users_num')
				),
				array(
					'table' => 'getput_ageusersgroup',
					'type' => 'INNER',
					'alias' => 'AgeUserGroup',
					'conditions' => array('User.users_id = AgeUserGroup.users_id')
				),
				array(
					'table' => 'getput_agegroup',
					'type' => 'INNER',
					'alias' => 'AgeGroup',
					'conditions' => array('AgeUserGroup.group_id = AgeGroup.group_id')
				)
			),
		'conditions' => '',
		'contain' => '',
		'order' => array(
			'User.users_username' => 'asc')
	);


	function beforeFilter()
	{
		Configure::write('debug', 0);
		Configure::write('log', false);

		// check session status
		$this->checkSession();
		// check permission status
		$this->checkPermission( $this->params['controller'], $this->params['action'], $this->params['pass']);
	}

	function index() 
	{
		$this->autoRender = false;
	}

	function gestusers()
	{
	}

	function listusers()
	{
	}

	function viewPdf()
	{
		$this->autoRender = false;
		$this->layout = 'pdf'; //this will use the pdf.ctp layout

		$report_pdf = $this->Session->read('jsonPrintPdf.reportPdf');
		
		if ( empty($report_pdf) )
		{
			$this->log('AdminsController:viewPdf - report_pdf is null', Configure::read('log_file'));
		}
		else
		{
			//set table UserList
			$this->set(compact('report_pdf'));

			$this->render();
		}
	}

	function jsonPrintPdf()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		//$this->queryusers['limit'] = $_POST['start'].",".$_POST['limit'];

		$filters = array();

		$filtCount = 0;

		// reset reportPdf session var
		$this->Session->write('jsonPrintPdf.reportPdf', "");

		if ( isset($_POST['username']) && $_POST['username'] && $_POST['username'] != '' ) {

			$filters[$filtCount] = "User.users_username LIKE '".$_POST['username']."%'";

			++$filtCount;
		}

		if ( isset($_POST['usertype']) && $_POST['usertype'] && $_POST['usertype'] != '' ) {

			$filters[$filtCount] = "TypeUserDesc.type_users_desc LIKE '".$_POST['usertype']."'";

			++$filtCount;
		}

		if ( isset($_POST['agegroup']) && $_POST['agegroup'] && $_POST['agegroup'] != '' ) {

			$filters[$filtCount] = "AgeGroup.group_desc LIKE '".$_POST['agegroup']."'";
		}


		if ( !empty($filters) )
			$this->report_listusers['conditions'] = $filters;


		$user_list_report = $this->User->find('all', $this->report_listusers);


		if ( !empty($user_list_report) ) {
			$json = array(
				"success" => true
			);

			// update report_lst for print pdf
			$this->Session->write('jsonPrintPdf.reportPdf', $user_list_report);
		}
		else {
			$json = array(
				"success" => false,
				"msg" => "Report is not valid !!!"
			);
		}

		echo json_encode($json);
	}

	function jsonGetListViewUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['limit'] &&  $_POST['limit'] != '' )
		{
			$this->queryusers['limit'] = $_POST['start'].",".$_POST['limit'];
	
	
			$extJson = array();
			$filters = array();
	
			$filtCount = 0;
	
			if ( isset($_POST['username']) && $_POST['username'] && $_POST['username'] != '' ) {
	
				$filters[$filtCount] = "User.users_username LIKE '".$_POST['username']."%'";
	
				++$filtCount;
			}
	
			if ( isset($_POST['usertype']) && $_POST['usertype'] && $_POST['usertype'] != '' ) {
	
				$filters[$filtCount] = "TypeUserDesc.type_users_desc LIKE '".$_POST['usertype']."'";
	
				++$filtCount;
			}
	
			if ( isset($_POST['agegroup']) && $_POST['agegroup'] && $_POST['agegroup'] != '' ) {
	
				$filters[$filtCount] = "AgeGroup.group_desc LIKE '".$_POST['agegroup']."'";
			}
	
	
			if ( !empty($filters) )
				$this->queryusers['conditions'] = $filters;
	
	
			$listuser = $this->User->find('all', $this->queryusers);
	
			// reset limit query users
			$this->queryusers['limit'] = '';
			// query for count result
			$this->User->find('all', $this->queryusers);
			// update infocount result
			$infocount = $this->User->getAffectedRows();
	
			$cnt = 0;
	
			foreach ($listuser as $object)
			{
				$extJson[$cnt] = array(
					"users_id" => $object['User']['users_id'],
					"users_username" => $object['User']['users_username'],
					"users_password" => $object['User']['users_password'],
					"users_username_realname" => $object['User']['users_username_realname'],
					"users_level" => $object['LevelUserDesc']['level_users_desc'],
					"users_type" => $object['TypeUserDesc']['type_users_desc'],
					"agency_group" => $object['AgeGroup']['group_desc'],
					"users_se_author" => $object['User']['users_se_author']
				);
	
				++$cnt;
			}
	
			$json = array(
				"success" => true,
				"totalCount" => $infocount,
				"records" => $extJson
			);
	
			echo json_encode($json);
		}
		else
			$this->log('AdminsController:jsonGetListViewUser - Unable output Json data', Configure::read('log_file'));
	}

	function jsonGetUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		$user = $this->User->findByusers_id($_POST['id']);
		
		if ( $user )
		{
			// load levelUser
			$level_user = $this->LevelUserDesc->find('first', array(
							'fields' => array('level_users_desc'),
							'conditions' => array('level_users_num' => $user['User']['users_level'])));

			// load typeUser
			$type_user = $this->TypeUserDesc->find('first', array(
							'fields' => array('type_users_desc'),
							'conditions' => array('type_users_num' => $user['User']['users_type'])));

			// load typeAccess
			$type_access = $this->TypeAccessDesc->find('first', array(
							'fields' => array('type_access_desc'),
							'conditions' => array('type_access_num' => $user['User']['users_type_access'])));

			// load typeAccessRealname
			$type_access_realname = $this->TypeAccessRealnameDesc->find('first', array(
							'fields' => array('type_access_realname_desc'),
							'conditions' => array('type_access_realname_num' => $user['User']['users_type_access_realname'])));

			// load ageUserGroup
			$age_user_group = $this->AgeUserGroup->findByusers_id($_POST['id']);

			// load ageGroup
			$age_group = $this->AgeGroup->find('first', array(
						'fields' => array('group_desc'),
						'conditions' => array('group_id' => $age_user_group['AgeUserGroup']['group_id'])));

			// load typeUpload
			$user_type_upload = $this->UserTypeUpload->findByusers_type_upload_id($_POST['id']);


			// join menu addon permit
			$this->MenuAddon->bindModel(array(
				'belongsTo' => array(
					'MenuMain' => array(
						'className' => 'MenuMain',
						'foreignKey' => false,
						'conditions' => array(
							'MenuMain.menu_main_id = MenuAddon.menu_addon_main_id',
							'MenuMain.menu_main_addon = 1'),
						'fields' => 'MenuMain.menu_main_desc'
				)
			)), false );

			$menu_addon_permit = $this->MenuAddon->find('all', array(
								'conditions' => array('MenuAddon.menu_addon_user_id' => $_POST['id']),
								'fields' => array('menu_addon_main_id','menu_addon_status','MenuMain.menu_main_desc')));

			// set menu addon var
			$agency_mnu = 0;
			$collab_mnu = 0;
			$sndcms_mnu = 0;
			$extern_mnu = 0;


			foreach ( $menu_addon_permit as $menuDesc )
			{
				if ( $menuDesc['MenuAddon']['menu_addon_status'] == 1 )
				{
					if ( $menuDesc['MenuMain']['menu_main_desc'] == Configure::read('menu_addon.agency') )
						$agency_mnu = 1;
					else if ( $menuDesc['MenuMain']['menu_main_desc'] == Configure::read('menu_addon.collab') )
						$collab_mnu = 1;
					else if ( $menuDesc['MenuMain']['menu_main_desc'] == Configure::read('menu_addon.sendcms') )
						$sndcms_mnu = 1;
					else if ( $menuDesc['MenuMain']['menu_main_desc'] == Configure::read('menu_addon.extern') )
						$extern_mnu = 1;
				}

			}


			$extJson = array(
				"users_id" => $user['User']['users_id'],
				"users_username" => $user['User']['users_username'],
				"users_password" => $user['User']['users_password'],
				"users_username_realname" => $user['User']['users_username_realname'],
				"users_se_author" => $user['User']['users_se_author'],
				"users_level" => $level_user['LevelUserDesc']['level_users_desc'],
				"users_type" => $type_user['TypeUserDesc']['type_users_desc'],
				"users_access" => $type_access['TypeAccessDesc']['type_access_desc'],
				"users_access_realname" => $type_access_realname['TypeAccessRealnameDesc']['type_access_realname_desc'],
				"agency_group" => $age_group['AgeGroup']['group_desc'],
				"dirname_get" => $user['User']['users_dirname_get'],
				"dirname_put_art" => $user['User']['users_dirname_put_art'],
				"dirname_put_pho" => $user['User']['users_dirname_put_pho'],
				"dirname_put_all" => $user['User']['users_dirname_put_all'],
				"put_art" => $user_type_upload['UserTypeUpload']['users_type_upload_art'],
				"put_pho" => $user_type_upload['UserTypeUpload']['users_type_upload_pho'],
				"put_all" => $user_type_upload['UserTypeUpload']['users_type_upload_all'],
				"agency_mnu" => $agency_mnu,
				"collab_mnu" => $collab_mnu,
				"extern_mnu" => $extern_mnu,
				"sndcms_mnu" => $sndcms_mnu
			);

			$json = array(
				"success" => true,
				"data" => $extJson
			);
	
			echo json_encode($json);
		}
		else
			$this->log('AdminsController:jsonGetUser - Unable query User', Configure::read('log_file'));
	}

	function jsonGetListUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['limit'] &&  $_POST['limit'] != '' )
		{
			$arrayUser = array(
				'fields' => array('users_id','users_username'),
				'conditions' => array('User.users_username LIKE ' => $_POST['username'].'%'),
				'limit' => $_POST['start'].",".$_POST['limit'],
				'order' => 'users_username ASC'
			);
	
			$arrayCountUser = array(
				'conditions' => array('User.users_username LIKE ' => $_POST['username'].'%')
			);
	
			$extJson = array();
	
	
			$infouser = $this->User->find('all', $arrayUser);
	
			// preload user count
			$infocount = $this->User->find('count', $arrayCountUser);
	
			foreach ($infouser as $object)
			{
				$extJson[] = $object['User']; 
			}
	
			$json = array(
				"success" => true,
				"totalCount" => $infocount,
				"records" => $extJson
			);
	
			echo json_encode($json);
		}
		else
			$this->log('AdminsController:jsonGetListUser - Unable output Json data', Configure::read('log_file'));
	}

	function jsonGetDefUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '' )
		{
			// preload userId
			$id_user = $this->User->find('first', array(
						'fields' => array('users_id'),
						'order' => 'users_id DESC'));
	
			// preload levelUser
			$level_user = $this->LevelUserDesc->find('first', array(
							'fields' => array('level_users_desc'),
							'conditions' => array('level_users_num' => 0)));
	
			// preload typeUser
			$type_user = $this->TypeUserDesc->find('first', array(
							'fields' => array('type_users_desc'),
							'conditions' => array('type_users_num' => 0)));
	
			// preload typeAccess
			$type_access = $this->TypeAccessDesc->find('first', array(
							'fields' => array('type_access_desc'),
							'conditions' => array('type_access_num' => 0)));
	
			// preload typeAccessRealname
			$type_access_realname = $this->TypeAccessRealnameDesc->find('first', array(
							'fields' => array('type_access_realname_desc'),
							'conditions' => array('type_access_realname_num' => 0)));
	
			// preload ageGroup
			$age_group = $this->AgeGroup->find('first', array(
							'fields' => array('group_desc'),
							'conditions' => array('group_id' => 1)));
	
	
			if ( $id_user )
			{
				$usersId = $id_user['User']['users_id'] + 1;
			}
			else
			{
				$usersId = 1;
			}
	
			$extJson = array(
				"users_id" => $usersId,
				"users_level" => $level_user['LevelUserDesc']['level_users_desc'],
				"users_type" => $type_user['TypeUserDesc']['type_users_desc'],
				"users_access" => $type_access['TypeAccessDesc']['type_access_desc'],
				"users_access_realname" => $type_access_realname['TypeAccessRealnameDesc']['type_access_realname_desc'],
				"agency_group" => $age_group['AgeGroup']['group_desc'],
				"dirname_get" => Configure::read('dirname_get_collab'),
				"dirname_put_art" => Configure::read('dirname_put_art_collab'),
				"dirname_put_pho" => Configure::read('dirname_put_pho_collab'),
				"dirname_put_all" => Configure::read('dirname_put_all_collab'),
				"put_art" => 1,
				"put_pho" => 1,
				"put_all" => 1,
				"agency_mnu" => 0,
				"collab_mnu" => 0,
				"extern_mnu" => 0,
				"sndcms_mnu" => 0
			);
	
			$json = array(
				"success" => true,
				"data" => $extJson
			);
	
			echo json_encode($json);
		}
		else
			$this->log('AdminsController:jsonGetDefUser - Unable output Json data', Configure::read('log_file'));
	}

	function jsonGetLevelUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// preload levelUser
		$level_user = $this->LevelUserDesc->find('all', array(
						'fields' => array('level_users_num','level_users_desc'),
						'order' => 'level_users_num ASC'));

		if ( !$level_user )
			$this->log('AdminsController:jsonGetLevelUser - Unable query LevelUserDesc', Configure::read('log_file'));

		else if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '')
		{
			$extJson = array();

			foreach ($level_user as $object)
			{
				$extJson[] = $object['LevelUserDesc']; 
			}

			$json = array(
				"success" => true,
				"records" => $extJson
			);

			echo json_encode($json);
		}
	}

	function jsonGetTypeUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// preload typeUser
		$type_user = $this->TypeUserDesc->find('all', array(
						'fields' => array('type_users_num','type_users_desc'),
						'order' => 'type_users_num ASC'));

		if ( !$type_user )
			$this->log('AdminsController:jsonGetTypeUser - Unable query TypeUserDesc', Configure::read('log_file'));

		else if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '')
		{
			$extJson = array();

			foreach ($type_user as $object)
			{
				$extJson[] = $object['TypeUserDesc']; 
			}

			$json = array(
				"success" => true,
				"records" => $extJson
			);

			echo json_encode($json);
		}
	}

	function jsonGetAccessUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// preload typeAccess
		$type_access = $this->TypeAccessDesc->find('all', array(
						'fields' => array('type_access_num','type_access_desc'),
						'order' => 'type_access_num ASC'));

		if ( !$type_access )
			$this->log('AdminsController:jsonGetAccessUser - Unable query TypeAccessDesc', Configure::read('log_file'));

		else if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '')
		{
			$extJson = array();

			foreach ($type_access as $object)
			{
				$extJson[] = $object['TypeAccessDesc']; 
			}

			$json = array(
				"success" => true,
				"records" => $extJson
			);

			echo json_encode($json);
		}
	}

	function jsonGetAccessRealnameUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// preload typeAccessRealname
		$type_access_realname = $this->TypeAccessRealnameDesc->find('all', array(
						'fields' => array('type_access_realname_num','type_access_realname_desc'),
						'order' => 'type_access_realname_num ASC'));

		if ( !$type_access_realname )
			$this->log('AdminsController:jsonGetAccessRealnameUser - Unable query TypeAccessRealnameDesc', Configure::read('log_file'));

		else if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '')
		{
			$extJson = array();

			foreach ($type_access_realname as $object)
			{
				$extJson[] = $object['TypeAccessRealnameDesc']; 
			}

			$json = array(
				"success" => true,
				"records" => $extJson
			);

			echo json_encode($json);
		}
	}

	function jsonGetAgencyGroup()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// preload ageGroup
		$age_group = $this->AgeGroup->find('all', array(
						'fields' => array('group_id','group_desc'),
						'order' => 'group_id ASC'));

		if ( !$age_group )
			$this->log('AdminsController:jsonGetAgencyGroup - Unable query AgeGroup', Configure::read('log_file'));

		else if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '' )
		{
			$extJson = array();

			foreach ($age_group as $object)
			{
				$extJson[] = $object['AgeGroup']; 
			}

			$json = array(
				"success" => true,
				"records" => $extJson
			);

			echo json_encode($json);
		}
	}

	function jsonDelUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		$json = array();

		if ( $this->User->delete($_POST['id']) )
		{
			$json = array(
				"success" => true,
				"msg" => Configure::read('msg_canusers_ok')
			);
		}
		else
		{
			$this->log('AdminsController:jsonDelUser - Unable delete User record', Configure::read('log_file'));

			$json = array(
				"success" => false,
				"msg" => Configure::read('msg_canusers_err')
			);
		}

		echo json_encode($json);
	}

	function jsonSaveUserIfValid()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		$errorMessages = "";
		$checkValidError = false;
		$checkSaveError = false;

		$select_user = $this->User->findByusers_id($_POST['users_id']);

		// load levelUser id num
		$level_user = $this->LevelUserDesc->find('first', array(
						'fields' => array('level_users_num'),
						'conditions' => array('level_users_desc' => $_POST['users_level'])));

		// load typeUser id num
		$type_user = $this->TypeUserDesc->find('first', array(
						'fields' => array('type_users_num'),
						'conditions' => array('type_users_desc' => $_POST['users_type'])));

		// load typeAccess id num
		$type_access = $this->TypeAccessDesc->find('first', array(
						'fields' => array('type_access_num'),
						'conditions' => array('type_access_desc' => $_POST['users_access'])));

		// load typeAccessRealname id num
		$type_access_realname = $this->TypeAccessRealnameDesc->find('first', array(
						'fields' => array('type_access_realname_num'),
						'conditions' => array('type_access_realname_desc' => $_POST['users_access_realname'])));

		// load ageGroup id num
		$age_group = $this->AgeGroup->find('first', array(
					'fields' => array('group_id'),
					'conditions' => array('group_desc' => $_POST['agency_group'])));

		// load user addon id
		$select_addon = $this->UserAddon->find('first', array(
					'fields' => array('users_addon_num'),
					'conditions' => array('users_addon_id' => $_POST['users_id'])));

		// load age menu id num
		$age_menu_id = $this->MenuMain->find('first', array(
					'fields' => array('menu_main_id'),
					'conditions' => array('menu_main_desc' => Configure::read('menu_addon.agency'))));

		// load collab menu id num
		$collab_menu_id = $this->MenuMain->find('first', array(
					'fields' => array('menu_main_id'),
					'conditions' => array('menu_main_desc' => Configure::read('menu_addon.collab'))));

		// load collab menu id num
		$extern_menu_id = $this->MenuMain->find('first', array(
					'fields' => array('menu_main_id'),
					'conditions' => array('menu_main_desc' => Configure::read('menu_addon.extern'))));

		// load sendcms menu id num
		$sendcms_menu_id = $this->MenuMain->find('first', array(
					'fields' => array('menu_main_id'),
					'conditions' => array('menu_main_desc' => Configure::read('menu_addon.sendcms'))));


		// join menu addon permit
		$this->MenuAddon->bindModel(array(
			'belongsTo' => array(
				'MenuMain' => array(
					'className' => 'MenuMain',
					'foreignKey' => false,
					'conditions' => array(
						'MenuMain.menu_main_id = MenuAddon.menu_addon_main_id',
						'MenuMain.menu_main_addon = 1'),
					'fields' => 'MenuMain.menu_main_desc'
			)
		)), false );

		
		// load agency mnu num
		if ( isset($_POST['agency_mnu']) && $_POST['agency_mnu'] )
			$agencyMnu = 1;
		else
			$agencyMnu = 0;

		// load collab mnu num
		if ( isset($_POST['collab_mnu']) && $_POST['collab_mnu'] )
			$collabMnu = 1;
		else
			$collabMnu = 0;

		// load extern mnu num
		if ( isset($_POST['extern_mnu']) && $_POST['extern_mnu'] )
			$externMnu = 1;
		else
			$externMnu = 0;

		// load sndcms mnu num
		if ( isset($_POST['sndcms_mnu']) && $_POST['sndcms_mnu'] )
			$sndcmsMnu = 1;
		else
			$sndcmsMnu = 0;

		// load put_art id num
		if ( $_POST['put_art'] )
			$putArtId = 1;
		else 
			$putArtId = 0;

		// load put_pho id num
		if ( $_POST['put_pho'] )
			$putPhoId = 1;
		else 
			$putPhoId = 0;

		// load put_all id num
		if ( $_POST['put_all'] )
			$putAllId = 1;
		else 
			$putAllId = 0;
  

		if ( $select_user )
		{
			// modify operation
			$this->User->read( null, $_POST['users_id'] );

			$this->User->set(array(
				'users_username' => $_POST['users_username'],
				'users_password' => Sanitize::paranoid($_POST['users_password']),
				'users_username_realname' => $_POST['users_username_realname'],
				'users_se_author' => $_POST['users_se_author'],
				'users_level' => $level_user['LevelUserDesc']['level_users_num'],
				'users_type' => $type_user['TypeUserDesc']['type_users_num'],
				'users_type_access' => $type_access['TypeAccessDesc']['type_access_num'],
				'users_type_access_realname' => $type_access_realname['TypeAccessRealnameDesc']['type_access_realname_num'],
				'users_dirname_get' => $_POST['dirname_get'],
				'users_dirname_put_art' => $_POST['dirname_put_art'],
				'users_dirname_put_pho' => $_POST['dirname_put_pho'],
				'users_dirname_put_all' => $_POST['dirname_put_all']));

			$this->AgeUserGroup->read( null, $_POST['users_id'] );

			$this->AgeUserGroup->set(array(
				'group_id' => $age_group['AgeGroup']['group_id']));

			$this->UserTypeUpload->read( null, $_POST['users_id'] );

			$this->UserTypeUpload->set(array(
				'users_type_upload_art' => $putArtId,
				'users_type_upload_pho' => $putPhoId,
				'users_type_upload_all' => $putAllId));

			$this->UserAddon->read( null, $select_addon['UserAddon']['users_addon_num'] );

			$this->UserAddon->set(array(
				'users_addon_level' => 1,
				'users_addon_status' => $agencyMnu));
		}
		else
		{
			// insert operation
			$this->User->set(array(
				'users_id' => $_POST['users_id'],
				'users_username' => $_POST['users_username'],
				'users_password' => Sanitize::paranoid($_POST['users_password']),
				'users_username_realname' => $_POST['users_username_realname'],
				'users_se_author' => $_POST['users_se_author'],
				'users_level' => $level_user['LevelUserDesc']['level_users_num'],
				'users_type' => $type_user['TypeUserDesc']['type_users_num'],
				'users_type_access' => $type_access['TypeAccessDesc']['type_access_num'],
				'users_type_access_realname' => $type_access_realname['TypeAccessRealnameDesc']['type_access_realname_num'],
				'users_dirname_get' => $_POST['dirname_get'],
				'users_dirname_put_art' => $_POST['dirname_put_art'],
				'users_dirname_put_pho' => $_POST['dirname_put_pho'],
				'users_dirname_put_all' => $_POST['dirname_put_all']));

			$this->AgeUserGroup->set(array(
				'users_id' => $_POST['users_id'],
				'group_id' => $age_group['AgeGroup']['group_id']));

			$this->UserTypeUpload->set(array(
				'users_type_upload_id' => $_POST['users_id'],
				'users_type_upload_art' => $putArtId,
				'users_type_upload_pho' => $putPhoId,
				'users_type_upload_all' => $putAllId));

			$this->UserAddon->set(array(
				'users_addon_id' => $_POST['users_id'],
				'users_addon_level' => 1,
				'users_addon_status' => $agencyMnu));
		}

		$extJson = array();

		if ( !$this->User->validates() )
		{
			$errorMessages = $this->validateErrors($this->User);


			if ( isset($errorMessages['users_id']) && !empty($errorMessages['users_id']) )
			{
				$errorMessage = $errorMessages['users_id'];
				$extJson = array("users_id" => $errorMessages['users_id']);

				$checkValidError = true;
			}
			else if ( isset($errorMessages['users_username']) && !empty($errorMessages['users_username']) )
			{
				$errorMessage = $errorMessages['users_username'];
				$extJson = array("users_username" => $errorMessages['users_username']);

				$checkValidError = true;
			}
			else if ( ($_POST['users_access'] == "LOCAL") && isset($errorMessages['users_password']) && !empty($errorMessages['users_password']) )
			{
				$errorMessage = $errorMessages['users_password'];
				$extJson = array("users_password" => $errorMessages['users_password']);

				$checkValidError = true;
			}
			else if ( isset($errorMessages['users_se_author']) && !empty($errorMessages['users_se_author']) )
			{
				$errorMessage = $errorMessages['users_se_author'];
				$extJson = array("users_se_author" => $errorMessages['users_se_author']);

				$checkValidError = true;
			}
			else if ( isset($errorMessages['users_dirname_get']) && !empty($errorMessages['users_dirname_get']) )
			{
				$errorMessage = $errorMessages['users_dirname_get'];
				$extJson = array("dirname_get" => $errorMessages['users_dirname_get']);

				$checkValidError = true;
			}
			else if ( isset($errorMessages['users_dirname_put_art']) && !empty($errorMessages['users_dirname_put_art']) )
			{
				$errorMessage = $errorMessages['users_dirname_put_art'];
				$extJson = array("dirname_put_art" => $errorMessages['users_dirname_put_art']);

				$checkValidError = true;
			}
			else if ( isset($errorMessages['users_dirname_put_pho']) && !empty($errorMessages['users_dirname_put_pho']) )
			{
				$errorMessage = $errorMessages['users_dirname_put_pho'];
				$extJson = array("dirname_put_pho" => $errorMessages['users_dirname_put_pho']);

				$checkValidError = true;
			}
			else if ( isset($errorMessages['users_dirname_put_all']) && !empty($errorMessages['users_dirname_put_all']) )
			{
				$errorMessage = $errorMessages['users_dirname_put_all'];
				$extJson = array("dirname_put_all" => $errorMessages['users_dirname_put_all']);

				$checkValidError = true;
			}
		}

		if ( $checkValidError )
		{
			$json = array(
				"success" => false,
				"msg" => 'Save emp error',
				"errors" => $extJson
			);
		}
		else
		{
			// save User model record
			if ( $this->User->save(null,false) )
			{
				// save UserAddon model
				if ( !$this->UserAddon->save() )
				{
					$this->log('AdminsController:jsonSaveUserIfValid - Unable save UserAddon model record', Configure::read('log_file'));
				
					$checkSaveError = true;
				}

				// save UserTypeUpload model
				if ( !$this->UserTypeUpload->save() )
				{
					$this->log('AdminsController:jsonSaveUserIfValid - Unable save UserTypeUpload model record', Configure::read('log_file'));

					$checkSaveError = true;
				}

				// save AgeUserGroup model
				if ( !$this->AgeUserGroup->save() )
				{
					$this->log('AdminsController:jsonSaveUserIfValid - Unable save AgeUserGroup model record', Configure::read('log_file'));

					$checkSaveError = true;
				}

				// search for menu addon agency permit
				$menu_addon_agency_permit = $this->MenuAddon->find('first', array(
									'conditions' => array(
										'MenuAddon.menu_addon_user_id' => $_POST['users_id'],
										'MenuMain.menu_main_desc' => Configure::read('menu_addon.agency')),
									'fields' => array('menu_addon_id','menu_addon_main_id', 'menu_addon_status')));

				if ( $menu_addon_agency_permit )
				{
					if ( $menu_addon_agency_permit['MenuAddon']['menu_addon_status'] != $agencyMnu )
					{
						//update menu addon
						$this->MenuAddon->read( null, $menu_addon_agency_permit['MenuAddon']['menu_addon_id'] );
	
						$this->MenuAddon->set(array(
							'menu_addon_main_id' => $menu_addon_agency_permit['MenuAddon']['menu_addon_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $agencyMnu));
	
						// save MenuAddon model
						if ( !$this->MenuAddon->save() )
						{
							$this->log('AdminsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
		
							$checkSaveError = true;
						}
					}
				}
				else
				{
					//insert menu addo
					$this->MenuAddon->set(array(
						'menu_addon_main_id' => $age_menu_id['MenuMain']['menu_main_id'],
						'menu_addon_user_id' => $_POST['users_id'],
						'menu_addon_status' => $agencyMnu));

					// save MenuAddon model
					if ( !$this->MenuAddon->save() )
					{
						$this->log('AdminsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
	
						$checkSaveError = true;
					}

				}

				// search for menu addon collab permit
				$menu_addon_collab_permit = $this->MenuAddon->find('first', array(
									'conditions' => array(
										'MenuAddon.menu_addon_user_id' => $_POST['users_id'],
										'MenuMain.menu_main_desc' => Configure::read('menu_addon.collab')),
									'fields' => array('menu_addon_id','menu_addon_main_id', 'menu_addon_status')));

				if ( $menu_addon_collab_permit )
				{
					if ( $menu_addon_collab_permit['MenuAddon']['menu_addon_status'] != $collabMnu )
					{
						//update menu addon
						$this->MenuAddon->read( null, $menu_addon_collab_permit['MenuAddon']['menu_addon_id'] );
	
						$this->MenuAddon->set(array(
							'menu_addon_main_id' => $menu_addon_collab_permit['MenuAddon']['menu_addon_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $collabMnu));
	
						// save MenuAddon model
						if ( !$this->MenuAddon->save() )
						{
							$this->log('AdminsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
		
							$checkSaveError = true;
						}
					}
				}
				else
				{
					if ( $this->MenuAddon->id )
					{
						//insert menu addo
						$this->MenuAddon->set(array(
							'menu_addon_id' => ($this->MenuAddon->id + 1),
							'menu_addon_main_id' => $collab_menu_id['MenuMain']['menu_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $collabMnu));
					}
					else
					{
						//insert menu addo
						$this->MenuAddon->set(array(
							'menu_addon_main_id' => $collab_menu_id['MenuMain']['menu_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $collabMnu));
					}

					// save MenuAddon model
					if ( !$this->MenuAddon->save() )
					{
						$this->log('AdminsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
	
						$checkSaveError = true;
					}
				}

				// search for menu addon extern permit
				$menu_addon_extern_permit = $this->MenuAddon->find('first', array(
									'conditions' => array(
										'MenuAddon.menu_addon_user_id' => $_POST['users_id'],
										'MenuMain.menu_main_desc' => Configure::read('menu_addon.extern')),
									'fields' => array('menu_addon_id','menu_addon_main_id', 'menu_addon_status')));


				if ( $menu_addon_extern_permit )
				{
					if ( $menu_addon_extern_permit['MenuAddon']['menu_addon_status'] != $externMnu )
					{
						//update menu addon
						$this->MenuAddon->read( null, $menu_addon_extern_permit['MenuAddon']['menu_addon_id'] );
	
						$this->MenuAddon->set(array(
							'menu_addon_main_id' => $menu_addon_extern_permit['MenuAddon']['menu_addon_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $externMnu));
	
						// save MenuAddon model
						if ( !$this->MenuAddon->save() )
						{
							$this->log('AdminsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
		
							$checkSaveError = true;
						}
					}
				}
				else
				{
					if ( $this->MenuAddon->id )
					{
						//insert menu addo
						$this->MenuAddon->set(array(
							'menu_addon_id' => ($this->MenuAddon->id + 1),
							'menu_addon_main_id' => $extern_menu_id['MenuMain']['menu_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $externMnu));
					}
					else
					{
						//insert menu addo
						$this->MenuAddon->set(array(
							'menu_addon_main_id' => $extern_menu_id['MenuMain']['menu_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $externMnu));
					}

					// save MenuAddon model
					if ( !$this->MenuAddon->save() )
					{
						$this->log('AdminsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
	
						$checkSaveError = true;
					}
				}

				// search for menu addon sndcms permit
				$menu_addon_sndcms_permit = $this->MenuAddon->find('first', array(
									'conditions' => array(
										'MenuAddon.menu_addon_user_id' => $_POST['users_id'],
										'MenuMain.menu_main_desc' => Configure::read('menu_addon.sendcms')),
									'fields' => array('menu_addon_id','menu_addon_main_id', 'menu_addon_status')));

				if ( $menu_addon_sndcms_permit )
				{
					if ( $menu_addon_sndcms_permit['MenuAddon']['menu_addon_status'] != $sndcmsMnu )
					{
						//update menu addon
						$this->MenuAddon->read( null, $menu_addon_sndcms_permit['MenuAddon']['menu_addon_id'] );
	
						$this->MenuAddon->set(array(
							'menu_addon_main_id' => $menu_addon_sndcms_permit['MenuAddon']['menu_addon_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $sndcmsMnu));
	
						// save MenuAddon model
						if ( !$this->MenuAddon->save() )
						{
							$this->log('AdminsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
		
							$checkSaveError = true;
						}
					}
				}
				else
				{
					if ( $this->MenuAddon->id )
					{
						//insert menu addo
						$this->MenuAddon->set(array(
							'menu_addon_id' => ($this->MenuAddon->id + 1),
							'menu_addon_main_id' => $sendcms_menu_id['MenuMain']['menu_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $sndcmsMnu));
					}
					else
					{
						//insert menu addo
						$this->MenuAddon->set(array(
							'menu_addon_main_id' => $sendcms_menu_id['MenuMain']['menu_main_id'],
							'menu_addon_user_id' => $_POST['users_id'],
							'menu_addon_status' => $sndcmsMnu));
					}

					// save MenuAddon model
					if ( !$this->MenuAddon->save() )
					{
						$this->log('AdminsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
	
						$checkSaveError = true;
					}
				}
			}
			else
			{
				$this->log('AdminsController:jsonSaveUserIfValid - Unable save User model record', Configure::read('log_file'));

				$checkSaveError = true;
			}

			if ( $checkSaveError )
			{
				$json = array(
					"success" => false,
					"msg" => Configure::read('msg_check_save_error')
				);
			}
			else
			{
				$extJson = array(
					"users_id" => $_POST['users_id'],
					"users_username" => $_POST['users_username'] );

				$json = array(
					"success" => true,
					"msg" => Configure::read('msg_insusers_ok'),
					"data" => $extJson
				);
			}
		}

		echo json_encode($json);
	}
}
?>