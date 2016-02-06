<?php
App::import('Sanitize');
class HistoriesController extends AppController {
	var $name = 'Histories';
	var $uses = array('User', 'TypeUserDesc', 'ActivityFilegetHistory', 'ActivityFileputHistory', 'AgeGroup', 'AgeUserGroup', 'FileDest', 'UserConnect');
	var $queryusers = array(
		'fields' => '',
		'joins' => '',
		'limit' => '',
		'conditions' => '',
		'contain' => '',
		'order' => ''
	);

	var $report_histories = array(
		'fields' => '',
		'joins' => '',
		'conditions' => '',
		'contain' => '',
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

	function listfileget()
	{
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
			$this->log('HistoriesController:jsonGetDefUser - Unable output Json data', Configure::read('log_file'));
	}

	function jsonGetListViewUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['limit'] &&  $_POST['limit'] != '' )
		{
			$this->queryusers['fields'] = array(
				'User.users_id','User.users_username','User.users_username_realname','User.users_type','TypeUserDesc.type_users_desc','AgeUserGroup.group_id','AgeGroup.group_desc','ActivityFilegetHistory.activity_fileget_history_users_id','ActivityFilegetHistory.activity_fileget_history_absfilename','ActivityFilegetHistory.activity_fileget_history_date');

			$this->queryusers['joins'] = array(
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
						),
						array(
							'table' => 'getput_activity_fileget_history',
							'type' => 'INNER',
							'alias' => 'ActivityFilegetHistory',
							'conditions' => array('User.users_id = ActivityFilegetHistory.activity_fileget_history_users_id')
						)
					);

			$this->queryusers['limit'] = $_POST['start'].",".$_POST['limit'];

			$this->queryusers['order'] = array('ActivityFilegetHistory.activity_fileget_history_date' => 'desc');


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

				++$filtCount;
			}

			if ( isset($_POST['dateflt']) && $_POST['dateflt'] && $_POST['dateflt'] != '' ) {

				if ( $_POST['dateflt'] == "O" ) {

					$filters[$filtCount] = "DATEDIFF(CURDATE(), FROM_UNIXTIME(ActivityFilegetHistory.activity_fileget_history_date)) = 0";
				}
				else if ( $_POST['dateflt'] == "I" ) {

					$date_from = $_POST['datefrom']." 00:00:00";
					$date_to = $_POST['dateto']." 23:59:59";

					list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_from); 
					$timestamp_from = mktime($hour, $minute, $second, $month, $day, $year);

					list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_to); 
					$timestamp_to = mktime($hour, $minute, $second, $month, $day, $year);

					$filters[$filtCount] = "ActivityFilegetHistory.activity_fileget_history_date >= ".$timestamp_from;
					$filters[$filtCount+1] = "ActivityFilegetHistory.activity_fileget_history_date <= ".$timestamp_to;
				}
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
					"users_username_realname" => $object['User']['users_username_realname'],
					"users_type" => $object['TypeUserDesc']['type_users_desc'],
					"agency_group" => $object['AgeGroup']['group_desc'],
					"activity_fileget_history_absfilename" => $object['ActivityFilegetHistory']['activity_fileget_history_absfilename'],
					"activity_fileget_history_date" => $object['ActivityFilegetHistory']['activity_fileget_history_date']
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
			$this->log('HistoriesController:jsonGetListViewUser - Unable output Json data', Configure::read('log_file'));
	}

	function jsonPutListViewUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['limit'] &&  $_POST['limit'] != '' )
		{
			$this->queryusers['fields'] = array(
				'User.users_id','User.users_username','User.users_username_realname','User.users_type','TypeUserDesc.type_users_desc','AgeUserGroup.group_id','AgeGroup.group_desc','ActivityFileputHistory.activity_fileput_history_users_id','ActivityFileputHistory.activity_fileput_history_absfilename','ActivityFileputHistory.activity_fileput_history_filedest','ActivityFileputHistory.activity_fileput_history_date');

			$this->queryusers['joins'] = array(
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
						),
						array(
							'table' => 'getput_activity_fileput_history',
							'type' => 'INNER',
							'alias' => 'ActivityFileputHistory',
							'conditions' => array('User.users_id = ActivityFileputHistory.activity_fileput_history_users_id')
						)
					);

			$this->queryusers['limit'] = $_POST['start'].",".$_POST['limit'];

			$this->queryusers['order'] = array('ActivityFileputHistory.activity_fileput_history_date' => 'desc');


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

				++$filtCount;
			}

			if ( isset($_POST['filedest']) && $_POST['filedest'] && $_POST['filedest'] != '' ) {
	
				$filters[$filtCount] = "ActivityFileputHistory.activity_fileput_history_filedest LIKE '".$_POST['filedest']."'";

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
					"users_username_realname" => $object['User']['users_username_realname'],
					"users_type" => $object['TypeUserDesc']['type_users_desc'],
					"agency_group" => $object['AgeGroup']['group_desc'],
					"activity_fileput_history_absfilename" => $object['ActivityFileputHistory']['activity_fileput_history_absfilename'],
					"activity_fileput_history_filedest" => $object['ActivityFileputHistory']['activity_fileput_history_filedest'],
					"activity_fileput_history_date" => $object['ActivityFileputHistory']['activity_fileput_history_date']
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
			$this->log('HistoriesController:jsonPutListViewUser - Unable output Json data', Configure::read('log_file'));
	}

	function jsonConListViewUser()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		if ( $_POST['limit'] &&  $_POST['limit'] != '' )
		{
			$this->queryusers['fields'] = array(
			'User.users_id','User.users_username','User.users_username_realname','User.users_type','TypeUserDesc.type_users_desc','AgeUserGroup.group_id','AgeGroup.group_desc','UserConnect.users_connect_id','UserConnect.users_connect_nowcon');

			$this->queryusers['joins'] = array(
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
						),
						array(
							'table' => 'getput_users_connect',
							'type' => 'INNER',
							'alias' => 'UserConnect',
							'conditions' => array('User.users_id = UserConnect.users_connect_id')
						)
					);

			$this->queryusers['limit'] = $_POST['start'].",".$_POST['limit'];

			$this->queryusers['order'] = array('UserConnect.users_connect_nowcon' => 'desc');


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

				++$filtCount;
			}

			if ( isset($_POST['dateflt']) && $_POST['dateflt'] && $_POST['dateflt'] != '' ) {

				if ( $_POST['dateflt'] == "O" ) {

					$filters[$filtCount] = "DATEDIFF(CURDATE(), FROM_UNIXTIME(UserConnect.users_connect_nowcon)) = 0";
				}
				else if ( $_POST['dateflt'] == "I" ) {

					$date_from = $_POST['datefrom']." 00:00:00";
					$date_to = $_POST['dateto']." 23:59:59";

					list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_from); 
					$timestamp_from = mktime($hour, $minute, $second, $month, $day, $year);

					list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_to); 
					$timestamp_to = mktime($hour, $minute, $second, $month, $day, $year);

					$filters[$filtCount] = "UserConnect.users_connect_nowcon >= ".$timestamp_from;
					$filters[$filtCount+1] = "UserConnect.users_connect_nowcon <= ".$timestamp_to;
				}
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
					"users_username_realname" => $object['User']['users_username_realname'],
					"users_type" => $object['TypeUserDesc']['type_users_desc'],
					"agency_group" => $object['AgeGroup']['group_desc'],
					"users_connect_nowcon" => $object['UserConnect']['users_connect_nowcon']
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
			$this->log('HistoriesController:jsonConListViewUser - Unable output Json data', Configure::read('log_file'));
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
			$this->log('HistoriesController:jsonGetTypeUser - Unable query TypeUserDesc', Configure::read('log_file'));

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

	function jsonGetAgencyGroup()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// preload ageGroup
		$age_group = $this->AgeGroup->find('all', array(
						'fields' => array('group_id','group_desc'),
						'order' => 'group_id ASC'));

		if ( !$age_group )
			$this->log('HistoriesController:jsonGetAgencyGroup - Unable query AgeGroup', Configure::read('log_file'));

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

	function jsonGetFileDest()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// preload ageGroup
		$file_dest = $this->FileDest->find('all', array(
						'fields' => array('id_num','filedest_id','filedest_desc'),
						'order' => 'filedest_id ASC'));

		if ( !$file_dest )
			$this->log('HistoriesController:jsonGetFileDest - Unable query AgeGroup', Configure::read('log_file'));

		else if ( $_POST['permitUrl'] &&  $_POST['permitUrl'] != '' )
		{
			$extJson = array();

			foreach ($file_dest as $object)
			{
				$extJson[] = $object['FileDest']; 
			}

			$json = array(
				"success" => true,
				"records" => $extJson
			);

			echo json_encode($json);
		}
	}

	function viewGetPdf()
	{
		$this->autoRender = false;
		$this->layout = 'pdf'; //this will use the pdf.ctp layout

		$report_pdf = $this->Session->read('jsonPrintGetPdf.reportPdf');
		
		if ( empty($report_pdf) )
		{
			$this->log('HistoriesController:viewGetPdf - report_pdf is null', Configure::read('log_file'));
		}
		else
		{
			//set table UserList
			$this->set(compact('report_pdf'));

			$this->render();
		}
	}

	function jsonPrintGetPdf()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		$this->report_histories['fields'] = array(
			'User.users_username','User.users_username_realname','TypeUserDesc.type_users_desc','AgeGroup.group_desc','ActivityFilegetHistory.activity_fileget_history_absfilename','ActivityFilegetHistory.activity_fileget_history_date');

		$this->report_histories['joins'] = array(
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
					),
					array(
						'table' => 'getput_activity_fileget_history',
						'type' => 'INNER',
						'alias' => 'ActivityFilegetHistory',
						'conditions' => array('User.users_id = ActivityFilegetHistory.activity_fileget_history_users_id')
					)
				);

		//$this->queryusers['limit'] = $_POST['start'].",".$_POST['limit'];

		$this->report_histories['order'] = array('ActivityFilegetHistory.activity_fileget_history_date' => 'desc');

		$filters = array();

		$filtCount = 0;

		// reset reportPdf session var
		$this->Session->write('jsonPrintGetPdf.reportPdf', "");

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

			++$filtCount;
		}

		if ( isset($_POST['dateflt']) && $_POST['dateflt'] && $_POST['dateflt'] != '' ) {

			if ( $_POST['dateflt'] == "O" ) {

				$filters[$filtCount] = "DATEDIFF(CURDATE(), FROM_UNIXTIME(ActivityFilegetHistory.activity_fileget_history_date)) = 0";
			}
			else if ( $_POST['dateflt'] == "I" ) {

				$date_from = $_POST['datefrom']." 00:00:00";
				$date_to = $_POST['dateto']." 23:59:59";

				list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_from); 
				$timestamp_from = mktime($hour, $minute, $second, $month, $day, $year);

				list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_to); 
				$timestamp_to = mktime($hour, $minute, $second, $month, $day, $year);

				$filters[$filtCount] = "ActivityFilegetHistory.activity_fileget_history_date >= ".$timestamp_from;
				$filters[$filtCount+1] = "ActivityFilegetHistory.activity_fileget_history_date <= ".$timestamp_to;
			}
		}

		if ( !empty($filters) )
			$this->report_histories['conditions'] = $filters;


		$user_list_report = $this->User->find('all', $this->report_histories);

		$count_report_pdf = count($user_list_report);


		if ( !empty($user_list_report) && $count_report_pdf <= Configure::read('max_count_viewGetPdf') ) {
			$json = array(
				"success" => true
			);

			// update report_lst for print pdf
			$this->Session->write('jsonPrintGetPdf.reportPdf', $user_list_report);
		}
		else {
			$json = array(
				"success" => false,
				"msg" => "Report is not valid !!!"
			);
		}

		echo json_encode($json);
	}

	function viewPutPdf()
	{
		$this->autoRender = false;
		$this->layout = 'pdf'; //this will use the pdf.ctp layout

		$report_pdf = $this->Session->read('jsonPrintPutPdf.reportPdf');
		
		if ( empty($report_pdf) )
		{
			$this->log('HistoriesController:viewPutPdf - report_pdf is null', Configure::read('log_file'));
		}
		else
		{
			//set table UserList
			$this->set(compact('report_pdf'));

			$this->render();
		}
	}

	function jsonPrintPutPdf()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		$this->report_histories['fields'] = array(
			'User.users_username','User.users_username_realname','TypeUserDesc.type_users_desc','AgeGroup.group_desc','ActivityFileputHistory.activity_fileput_history_absfilename','ActivityFileputHistory.activity_fileput_history_filedest','ActivityFileputHistory.activity_fileput_history_date');


		$this->report_histories['joins'] = array(
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
					),
					array(
						'table' => 'getput_activity_fileput_history',
						'type' => 'INNER',
						'alias' => 'ActivityFileputHistory',
						'conditions' => array('User.users_id = ActivityFileputHistory.activity_fileput_history_users_id')
					)
				);

		//$this->queryusers['limit'] = $_POST['start'].",".$_POST['limit'];

		$this->report_histories['order'] = array('ActivityFileputHistory.activity_fileput_history_date' => 'desc');

		$filters = array();

		$filtCount = 0;

		// reset reportPdf session var
		$this->Session->write('jsonPrintPutPdf.reportPdf', "");

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

			++$filtCount;
		}

		if ( isset($_POST['filedest']) && $_POST['filedest'] && $_POST['filedest'] != '' ) {

			$filters[$filtCount] = "ActivityFileputHistory.activity_fileput_history_filedest LIKE '".$_POST['filedest']."'";

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
			$this->report_histories['conditions'] = $filters;


		$user_list_report = $this->User->find('all', $this->report_histories);

		$count_report_pdf = count($user_list_report);


		if ( !empty($user_list_report) && $count_report_pdf <= Configure::read('max_count_viewPutPdf') ) {
			$json = array(
				"success" => true
			);

			// update report_lst for print pdf
			$this->Session->write('jsonPrintPutPdf.reportPdf', $user_list_report);
		}
		else {
			$json = array(
				"success" => false,
				"msg" => "Report is not valid !!!"
			);
		}

		echo json_encode($json);
	}

	function viewConPdf()
	{
		$this->autoRender = false;
		$this->layout = 'pdf'; //this will use the pdf.ctp layout

		$report_pdf = $this->Session->read('jsonPrintConPdf.reportPdf');
		
		if ( empty($report_pdf) )
		{
			$this->log('HistoriesController:viewConPdf - report_pdf is null', Configure::read('log_file'));
		}
		else
		{
			//set table UserList
			$this->set(compact('report_pdf'));

			$this->render();
		}
	}

	function jsonPrintConPdf()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		$this->report_histories['fields'] = array(
			'User.users_username','User.users_username_realname','TypeUserDesc.type_users_desc','AgeGroup.group_desc','UserConnect.users_connect_nowcon');


		$this->report_histories['joins'] = array(
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
					),
					array(
						'table' => 'getput_users_connect',
						'type' => 'INNER',
						'alias' => 'UserConnect',
						'conditions' => array('User.users_id = UserConnect.users_connect_id')
					)
				);

		//$this->queryusers['limit'] = $_POST['start'].",".$_POST['limit'];

		$this->report_histories['order'] = array('UserConnect.users_connect_nowcon' => 'desc');

		$filters = array();

		$filtCount = 0;

		// reset reportPdf session var
		$this->Session->write('jsonPrintConPdf.reportPdf', "");

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

			++$filtCount;
		}

		if ( isset($_POST['dateflt']) && $_POST['dateflt'] && $_POST['dateflt'] != '' ) {

			if ( $_POST['dateflt'] == "O" ) {

				$filters[$filtCount] = "DATEDIFF(CURDATE(), FROM_UNIXTIME(UserConnect.users_connect_nowcon)) = 0";
			}
			else if ( $_POST['dateflt'] == "I" ) {

				$date_from = $_POST['datefrom']." 00:00:00";
				$date_to = $_POST['dateto']." 23:59:59";

				list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_from); 
				$timestamp_from = mktime($hour, $minute, $second, $month, $day, $year);

				list($day, $month, $year, $hour, $minute, $second) = split('[/ :]', $date_to); 
				$timestamp_to = mktime($hour, $minute, $second, $month, $day, $year);

				$filters[$filtCount] = "UserConnect.users_connect_nowcon >= ".$timestamp_from;
				$filters[$filtCount+1] = "UserConnect.users_connect_nowcon <= ".$timestamp_to;
			}
		}

		if ( !empty($filters) )
			$this->report_histories['conditions'] = $filters;


		$user_list_report = $this->User->find('all', $this->report_histories);

		$count_report_pdf = count($user_list_report);


		if ( !empty($user_list_report) && $count_report_pdf <= Configure::read('max_count_viewConPdf') ) {
			$json = array(
				"success" => true
			);

			// update report_lst for print pdf
			$this->Session->write('jsonPrintConPdf.reportPdf', $user_list_report);
		}
		else {
			$json = array(
				"success" => false,
				"msg" => "Report is not valid !!!"
			);
		}

		echo json_encode($json);
	}

	function listfileput()
	{
	}

	function connusers()
	{
	}
}
?>
