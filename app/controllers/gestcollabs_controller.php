<?php
App::import('Sanitize');
class GestcollabsController extends AppController {
	var $name = 'Gestcollabs';
	var $uses = array('User', 'AgeGroup', 'AgeUserGroup', 'LevelUserDesc', 'TypeUserDesc', 'TypeAccessDesc', 'TypeAccessRealnameDesc', 'UserTypeUpload', 'UserAddon', 'ActivityFilegetHistory', 'ActivityFileputHistory', 'ActivityFileputHistoryOldest', 'MenuMain', 'MenuAddon');

	var $querycontr = array(
		'fields' => '',
		'limit' => '',
		'conditions' => '',
		'contain' => '',
		'group' => '',
		'order' => ''
	);

	var $report_listcontr = array(
		'fields' => '',
		'conditions' => '',
		'contain' => '',
		'group' => '',
		'order' => ''
	);


	function beforeFilter()
	{
		Configure::write('debug', 0);
		Configure::write('log', false);

		$this->checkSession();
		// check permission status
		$this->checkPermission( $this->params['controller'], $this->params['action'], $this->params['pass']);
	}

	function index() 
	{
		$this->autoRender = false;
	}

	function gestcollabs()
	{
	}

	function listcontrput()
	{		
	}

	function graphitemput()
	{
	}

	function jsonPutListContrib()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['limit'] &&  $_POST['limit'] != '' )
		{
			$this->querycontr['fields'] = array(
						'activity_fileput_history_filedest','total_put','activity_fileput_history_date','activity_fileput_history_filename');

			$this->querycontr['limit'] = $_POST['start'].",".$_POST['limit'];
			
			$this->querycontr['group'] = 'activity_fileput_history_filedest';

			$this->querycontr['order'] = array('activity_fileput_history_filedest' => 'asc');


			$extJson = array();
			$filters = array();
	
			$filtCount = 0;
	
			if ( isset($_POST['type_contr']) && $_POST['type_contr'] && $_POST['type_contr'] != '' ) {
	
				$filters[$filtCount] = "ActivityFileputHistory.activity_fileput_history_filename LIKE '%".$_POST['type_contr']."%'";

				++$filtCount;
			}

			if ( isset($_POST['dateflt']) && $_POST['dateflt'] && $_POST['dateflt'] != '' ) {

				if ( $_POST['dateflt'] == "O" ) {

					$filters[$filtCount] = "DATEDIFF(CURDATE(), FROM_UNIXTIME(ActivityFileputHistory.activity_fileput_history_date)) = 0";
				}
				else if ( $_POST['dateflt'] == "I" ) {

					$date_from = $_POST['datefrom']." 00:00:00";
					$date_to = $_POST['dateto']." 23:59:59";

					list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_from); 
					$timestamp_from = mktime($hour, $minute, $second, $month, $day, $year);

					list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_to); 
					$timestamp_to = mktime($hour, $minute, $second, $month, $day, $year);

					$filters[$filtCount] = "ActivityFileputHistory.activity_fileput_history_date >= ".$timestamp_from;
					$filters[$filtCount+1] = "ActivityFileputHistory.activity_fileput_history_date <= ".$timestamp_to;
				}
			}
		
			if ( !empty($filters) )
				$this->querycontr['conditions'] = $filters;
	
	
			$listcontrput = $this->ActivityFileputHistory->find('all', $this->querycontr);
	
			// reset limit query users
			$this->querycontr['limit'] = '';
			// query for count result
			$this->ActivityFileputHistory->find('all', $this->querycontr);
			// update infocount result
			$infocount = $this->ActivityFileputHistory->getAffectedRows();
	
			$cnt = 0;
	
			foreach ($listcontrput as $object)
			{
				$extJson[$cnt] = array(
					"num" => $cnt,
					"activity_fileput_history_filedest" => $object['ActivityFileputHistory']['activity_fileput_history_filedest'],
					"total_put" => $object['ActivityFileputHistory']['total_put']
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
			$this->log('GestcollabsController:jsonPutListViewUser - Unable output Json data', Configure::read('log_file'));
	}

	function viewContrPutPdf()
	{
		$this->autoRender = false;
		$this->layout = 'pdf'; //this will use the pdf.ctp layout

		$report_pdf = $this->Session->read('jsonPrintContrPutPdf.reportPdf');
		$report_typeContr = $this->Session->read('jsonPrintContrPutPdf.reportTypeContr');
		$report_date_filter = $this->Session->read('jsonPrintContrPutPdf.reportDataContr');

		$type_contr = Configure::read('type_contr');

		if ( !empty($report_typeContr) )
			$report_typeContr = $type_contr[$report_typeContr];
		
		if ( empty($report_pdf) )
		{
			$this->log('GestcollabsController:viewPutPdf - report_pdf is null', Configure::read('log_file'));
		}
		else
		{
			//set table UserList
			$this->set(compact('report_pdf'));

			//set var report_filter
			$this->set('report_date_filter',$report_date_filter);
			$this->set('report_type_filter',$report_typeContr);

			$this->render();
		}
	}

	function jsonPrintContrPutPdf()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		$this->report_listcontr['fields'] = array(
						'activity_fileput_history_filedest','total_put','activity_fileput_history_date','activity_fileput_history_filename');

		//$this->report_listcontr['limit'] = $_POST['start'].",".$_POST['limit'];

		$this->report_listcontr['group'] = 'activity_fileput_history_filedest';

		$this->report_listcontr['order'] = array('ActivityFileputHistory.activity_fileput_history_filedest' => 'asc');

		$filters = array();

		$filtCount = 0;

		$contrtype_report = "";
		$contrdata_report = "";

		// reset reportPdf session var
		$this->Session->write('jsonPrintPutPdf.reportPdf', "");

		if ( isset($_POST['type_contr']) && $_POST['type_contr'] && $_POST['type_contr'] != '' ) {

			$filters[$filtCount] = "ActivityFileputHistory.activity_fileput_history_filename LIKE '%".$_POST['type_contr']."%'";

			$contrtype_report = $_POST['type_contr'];

			++$filtCount;
		}

		if ( isset($_POST['dateflt']) && $_POST['dateflt'] && $_POST['dateflt'] != '' ) {

			if ( $_POST['dateflt'] == "O" ) {

				$filters[$filtCount] = "DATEDIFF(CURDATE(), FROM_UNIXTIME(ActivityFileputHistory.activity_fileput_history_date)) = 0";

				$date_list = Configure::read('date_list_gstc');
				$contrdata_report = $date_list[$_POST['dateflt']];
			}
			else if ( $_POST['dateflt'] == "I" ) {

				$date_from = $_POST['datefrom']." 00:00:00";
				$date_to = $_POST['dateto']." 23:59:59";

				list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_from); 
				$timestamp_from = mktime($hour, $minute, $second, $month, $day, $year);

				list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_to); 
				$timestamp_to = mktime($hour, $minute, $second, $month, $day, $year);

				$filters[$filtCount] = "ActivityFileputHistory.activity_fileput_history_date >= ".$timestamp_from;
				$filters[$filtCount+1] = "ActivityFileputHistory.activity_fileput_history_date <= ".$timestamp_to;

				$contrdata_report = $_POST['datefrom']." a ".$_POST['dateto'];
			}
		}

		if ( !empty($filters) )
			$this->report_listcontr['conditions'] = $filters;


		$contrput_list_report = $this->ActivityFileputHistory->find('all', $this->report_listcontr);

		$count_report_pdf = count($contrput_list_report);


		if ( !empty($contrput_list_report) && $count_report_pdf <= Configure::read('max_count_viewPutPdf') ) {
			$json = array(
				"success" => true
			);

			// update report_lst for print pdf
			$this->Session->write('jsonPrintContrPutPdf.reportPdf', $contrput_list_report);
			$this->Session->write('jsonPrintContrPutPdf.reportTypeContr', $contrtype_report);
			$this->Session->write('jsonPrintContrPutPdf.reportDataContr', $contrdata_report);
		}
		else {
			$json = array(
				"success" => false,
				"msg" => "Report is not valid !!!"
			);
		}

		echo json_encode($json);
	}

	function jsonGetTypeContrib()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		$type_contr = Configure::read('type_contr');

		if ( !$type_contr )
			$this->log('GestcollabsController:jsonGetTypeContrib - Unable find type_contr array', Configure::read('log_file'));

		else if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '')
		{
			$extJson = array();

			$cnt = 0;

			foreach ($type_contr as $key => $value)
			{
				$extJson[$cnt] = array(
					"type_contr_val" => $key,
					"type_contr_desc" => $value
				);

				++$cnt; 
			}

			$json = array(
				"success" => true,
				"records" => $extJson
			);

			echo json_encode($json);
		}
	}

	function jsonGetDefFilter()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '' )
		{
			$extJson = array(
				"rb_auto" => "T"
			);
	
			$json = array(
				"success" => true,
				"data" => $extJson
			);
	
			echo json_encode($json);
		}
		else
			$this->log('GestcollabsController:jsonGetDefFilter - Unable output Json data', Configure::read('log_file'));
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
			$sndcms_mnu = 0;


			foreach ( $menu_addon_permit as $menuDesc )
			{
				if ( $menuDesc['MenuAddon']['menu_addon_status'] == 1 )
				{
					if ( $menuDesc['MenuMain']['menu_main_desc'] == Configure::read('menu_addon.sendcms') )
						$sndcms_mnu = 1;
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
				"sndcms_mnu" => $sndcms_mnu
			);

			$json = array(
				"success" => true,
				"data" => $extJson
			);
	
			echo json_encode($json);
		}
		else
			$this->log('GestcollabsController:jsonGetUser - Unable query User', Configure::read('log_file'));
	}

	function jsonGetListUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['limit'] &&  $_POST['limit'] != '' )
		{
			// preload typeUserDesc COLLAB
			$type_user = $this->TypeUserDesc->find('all', array(
							'fields' => array('type_users_num'),
							'conditions' => array('OR' => array(
								array('type_users_desc' => Configure::read('user_type_collab')),
								array('type_users_desc' => Configure::read('user_type_collab_cms'))
							))));

			$arrayUser = array(
				'fields' => array('users_id','users_username'),
				'conditions' => array(
							'User.users_username LIKE ' => $_POST['username'].'%',
							array('OR' => array(
								array('User.users_type' => $type_user[0]['TypeUserDesc']['type_users_num']),
								array('User.users_type' => $type_user[1]['TypeUserDesc']['type_users_num'])))),
				'limit' => $_POST['start'].",".$_POST['limit'],
				'order' => 'users_username ASC'
			);
	
			$arrayCountUser = array(
				'conditions' => array(
							'User.users_username LIKE ' => $_POST['username'].'%',
							array('OR' => array(
								array('User.users_type' => $type_user[0]['TypeUserDesc']['type_users_num']),
								array('User.users_type' => $type_user[1]['TypeUserDesc']['type_users_num']))))
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
			$this->log('GestcollabsController:jsonGetListUser - Unable output Json data', Configure::read('log_file'));
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
							'conditions' => array('type_users_desc' => Configure::read('user_type_collab_cms'))));
	
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
				"put_pho" => 0,
				"put_all" => 0,
				"sndcms_mnu" => 1
			);
	
			$json = array(
				"success" => true,
				"data" => $extJson
			);
	
			echo json_encode($json);
		}
		else
			$this->log('GestcollabsController:jsonGetDefUser - Unable output Json data', Configure::read('log_file'));
	}

	function jsonGetLevelUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// preload levelUser
		$level_user = $this->LevelUserDesc->find('all', array(
						'fields' => array('level_users_num','level_users_desc'),
						'conditions' => array('level_users_num NOT LIKE ' => Configure::read('user_level_disable_collab')),
						'order' => 'level_users_num ASC'));

		if ( !$level_user )
			$this->log('GestcollabsController:jsonGetLevelUser - Unable query LevelUserDesc', Configure::read('log_file'));

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
						'conditions' => array('OR' => array(
							array('type_users_desc' => Configure::read('user_type_collab')),
							array('type_users_desc' => Configure::read('user_type_collab_cms')))),
						'order' => 'type_users_num DESC'));

		if ( !$type_user )
			$this->log('GestcollabsController:jsonGetTypeUser - Unable query TypeUserDesc', Configure::read('log_file'));

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
						'conditions' => array('type_access_desc' => Configure::read('user_type_access_collab')),
						'order' => 'type_access_num ASC'));

		if ( !$type_access )
			$this->log('GestcollabsController:jsonGetAccessUser - Unable query TypeAccessDesc', Configure::read('log_file'));

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
						'conditions' => array('type_access_realname_desc' => Configure::read('user_type_access_real_collab')),
						'order' => 'type_access_realname_num ASC'));

		if ( !$type_access_realname )
			$this->log('GestcollabsController:jsonGetAccessRealnameUser - Unable query TypeAccessRealnameDesc', Configure::read('log_file'));

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
			$this->log('GestcollabsController:jsonGetAgencyGroup - Unable query AgeGroup', Configure::read('log_file'));

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
			$this->log('GestcollabsController:jsonDelUser - Unable delete User record', Configure::read('log_file'));

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


		// load sndcms mnu num
		if ( isset($_POST['sndcms_mnu']) && $_POST['sndcms_mnu'] )
			$sndcmsMnu = 1;
		else
			$sndcmsMnu = 0;

		// load put_art id num
		if (  isset($_POST['put_art']) && $_POST['put_art'] )
			$putArtId = 1;
		else 
			$putArtId = 0;

		// load put_pho id num
		if ( isset($_POST['put_pho']) && $_POST['put_pho'] )
			$putPhoId = 1;
		else 
			$putPhoId = 0;

		// load put_all id num
		if ( isset($_POST['put_all']) && $_POST['put_all'] )
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
				// save UserTypeUpload model
				if ( !$this->UserTypeUpload->save() )
				{
					$this->log('GestcollabsController:jsonSaveUserIfValid - Unable save UserTypeUpload model record', Configure::read('log_file'));

					$checkSaveError = true;
				}

				// save AgeUserGroup model
				if ( !$this->AgeUserGroup->save() )
				{
					$this->log('GestcollabsController:jsonSaveUserIfValid - Unable save AgeUserGroup model record', Configure::read('log_file'));

					$checkSaveError = true;
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
							$this->log('GestcollabsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
		
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
						$this->log('GestcollabsController:jsonSaveUserIfValid - Unable save MenuAddon model record', Configure::read('log_file'));
	
						$checkSaveError = true;
					}
				}
			}
			else
			{
				$this->log('GestcollabsController:jsonSaveUserIfValid - Unable save User model record', Configure::read('log_file'));

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

	function jsonGetItemPutOld()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// query text_put_oldest
		$text_put_oldest = $this->ActivityFileputHistoryOldest->find('all', array(
						'fields' => array('total_put_txt','year'),
						'conditions' => array('activity_fileput_history_filename LIKE "%.txt%"'),
						'group' => 'year',
						'order' => 'year ASC'));

		// query photo_put_oldest
		$photo_put_oldest = $this->ActivityFileputHistoryOldest->find('all', array(
						'fields' => array('total_put_pho','year'),
						'conditions' => array('activity_fileput_history_filename LIKE "%.jpg%"'),
						'group' => 'year',
						'order' => 'year ASC'));

		// query text_put
		$text_put_cur = $this->ActivityFileputHistory->find('all', array(
						'fields' => array('total_put_txt','year'),
						'conditions' => array('activity_fileput_history_filename LIKE "%.txt%"'),
						'group' => 'year',
						'order' => 'year ASC'));

		// query photo_put
		$photo_put_cur = $this->ActivityFileputHistory->find('all', array(
						'fields' => array('total_put_pho','year'),
						'conditions' => array('activity_fileput_history_filename LIKE "%.jpg%"'),
						'group' => 'year',
						'order' => 'year ASC'));

		if ( !$text_put_oldest && !$photo_put_oldest && !$text_put_cur && !$photo_put_cur )
			$this->log('GestcollabsController:jsonGetItemPutOld - Unable query ActivityFileputHistoryOldest - ActivityFileputHistory', Configure::read('log_file'));
		else
		{
			if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '')
			{
				// union array
				$amerge1 = array_merge($text_put_oldest, $photo_put_oldest);
				$amerge2 = array_merge($text_put_cur, $photo_put_cur);
	
				// group by array
				foreach( $amerge1 as $key=>$val ) $amerge_group1[$val['ActivityFileputHistoryOldest']['year']][] = $val['ActivityFileputHistoryOldest'];
				foreach( $amerge2 as $key=>$val ) $amerge_group2[$val['ActivityFileputHistory']['year']][] = $val['ActivityFileputHistory'];

				// sum groups
				$amerge_group = $amerge_group1 + $amerge_group2;

				foreach( $amerge_group as $key=>$val ) {
	
					$put_txt = 0;
					$put_pho = 0;
					$year = $key;
	
					foreach ( $val as $key_deep=>$val_deep ) {
	
						if ( isset($val_deep['total_put_txt']) )
							$put_txt = $val_deep['total_put_txt'];
						else if ( isset($val_deep['total_put_pho']) )
							$put_pho = $val_deep['total_put_pho'];
					}
	
					$total = $put_txt + $put_pho;
	
					$extJson[] = array(
						"year" => $year,
						"photo" => $put_pho,
						"text" => $put_txt,
						"total" => $total
					);
				}
		

				$json = array(
					"success" => true,
					"records" => $extJson
				);
	
				echo json_encode($json);
			}
		}
	}

	function jsonGetItemPutCur()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '')
		{
			if ( isset($_POST['year']) &&  $_POST['year'] != '' )
			{
				// query text_put_oldest
				$text_put_oldest = $this->ActivityFileputHistoryOldest->find('all', array(
								'fields' => array('total_put_txt','month'),
								'conditions' => array(
									'activity_fileput_history_filename LIKE "%.txt%"',
									'year' => $_POST['year']),
								'group' => 'month',
								'order' => 'month ASC'));
		
				// query photo_put_oldest
				$photo_put_oldest = $this->ActivityFileputHistoryOldest->find('all', array(
								'fields' => array('total_put_pho','month'),
								'conditions' => array(
									'activity_fileput_history_filename LIKE "%.jpg%"',
									'year' => $_POST['year']),
								'group' => 'month',
								'order' => 'month ASC'));
		
				// query text_put
				$text_put_cur = $this->ActivityFileputHistory->find('all', array(
								'fields' => array('total_put_txt','month'),
								'conditions' => array(
									'activity_fileput_history_filename LIKE "%.txt%"',
									'year' => $_POST['year']),
								'group' => 'month',
								'order' => 'month ASC'));
		
				// query photo_put
				$photo_put_cur = $this->ActivityFileputHistory->find('all', array(
								'fields' => array('total_put_pho','month'),
								'conditions' => array(
									'activity_fileput_history_filename LIKE "%.jpg%"',
									'year' => $_POST['year']),
								'group' => 'month',
								'order' => 'month ASC'));

				if ( !$text_put_oldest && !$photo_put_oldest && !$text_put_cur && !$photo_put_cur )
					$this->log('GestcollabsController:jsonGetItemPutOld - Unable query ActivityFileputHistoryOldest - ActivityFileputHistory', Configure::read('log_file'));
				else
				{
					$amerge_group1 = array();
					$amerge_group2 = array();

					$amerge1 = array_merge($text_put_oldest, $photo_put_oldest);
					$amerge2 = array_merge($text_put_cur, $photo_put_cur);
	
					// group by array
					foreach( $amerge1 as $key=>$val ) $amerge_group1[$val['ActivityFileputHistoryOldest']['month']][] = $val['ActivityFileputHistoryOldest'];
					foreach( $amerge2 as $key=>$val ) $amerge_group2[$val['ActivityFileputHistory']['month']][] = $val['ActivityFileputHistory'];

					// sum groups
					$amerge_group = $amerge_group1 + $amerge_group2;
				}
			}
			else
			{
				// query text_put
				$text_put_cur = $this->ActivityFileputHistory->find('all', array(
								'fields' => array('total_put_txt','month'),
								'conditions' => array('activity_fileput_history_filename LIKE "%.txt%"'),
								'group' => 'month',
								'order' => 'month ASC'));
		
				// query photo_put
				$photo_put_cur = $this->ActivityFileputHistory->find('all', array(
								'fields' => array('total_put_pho','month'),
								'conditions' => array('activity_fileput_history_filename LIKE "%.jpg%"'),
								'group' => 'month',
								'order' => 'month ASC'));
	
				if ( !$text_put_cur && !$photo_put_cur )
					$this->log('GestcollabsController:jsonGetItemPutCur - Unable query ActivityFileputHistory', Configure::read('log_file'));
				else
				{
					// union array
					$amerge = array_merge($text_put_cur, $photo_put_cur);
		
					// group by array
					foreach( $amerge as $key=>$val ) $amerge_group[$val['ActivityFileputHistory']['month']][] = $val['ActivityFileputHistory'];
				}
			}

			if ( !empty($amerge_group) )
			{
				// set array month desc
				$mounth_list_desc = Configure::read('mounth_list_short');
		
				foreach( $amerge_group as $key=>$val ) {
	
					$put_txt = 0;
					$put_pho = 0;
					$month = $key;
	
					foreach ( $val as $key_deep=>$val_deep ) {
	
						if ( isset($val_deep['total_put_txt']) )
							$put_txt = $val_deep['total_put_txt'];
						else if ( isset($val_deep['total_put_pho']) )
							$put_pho = $val_deep['total_put_pho'];
					}
	
					$total = $put_txt + $put_pho;

					$extJson[] = array(
						"month" => $mounth_list_desc[$month],
						"photo" => $put_pho,
						"text" => $put_txt,
						"total" => $total
					);
				}
		
				$json = array(
					"success" => true,
					"records" => $extJson
				);
			}
			else
			{
				$json = array(
					"success" => false
				);
				
			}

			echo json_encode($json);
		}
	}
}
?>
