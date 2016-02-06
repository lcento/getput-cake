<?php
App::import('Sanitize');
class DownloadsController extends AppController {
	var $name = 'Downloads';
	var $uses = array('User', 'ActivityHistory', 'ActivityFilegetHistory', 'FileInfo', 'FileStatus');
	var $dirpath = "";

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

	function items()
	{
        }

	function jsonGetListFileView()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		// load table db record with files elements
		$this->__loadDbItems();

		if ( $_POST['limit'] &&  $_POST['limit'] != '' )
		{
			$joins = array(
				array(
					'table' => 'getput_filestatus',
					'alias' => 'FileStatus',
					'type' => 'LEFT',
					'conditions' => array('fileinfo_id = FileStatus.filestatus_fileinfo_key')));

			$arrayInfo = array(
				'joins' => $joins,
				'conditions' => array(
					'FileInfo.fileinfo_dirname' => $this->dirpath,
					'FileStatus.filestatus_users_id' => $this->Session->read('User.id')),
					'fields' => array(
						'FileInfo.fileinfo_id',
						'FileInfo.fileinfo_dirname',
						'FileInfo.fileinfo_filename',
						'FileInfo.fileinfo_absfilename',
						'FileInfo.fileinfo_ext',
						'FileInfo.fileinfo_size',
						'FileInfo.fileinfo_filedate',
						'FileStatus.filestatus_status',
						'FileStatus.filestatus_id'),
					'limit' => $_POST['start'].",".$_POST['limit'],
					'order' => 'FileInfo.fileinfo_absfilename ASC'
			);
		
			$extJson = array();
		
			$infofile = $this->FileInfo->find('all', $arrayInfo);
	
			// preload user count
			$infocount = $this->FileInfo->find('count', $arrayInfo);
	
			foreach ($infofile as $object)
			{
				$extJson[] = array(
					"fileinfo_filename" => $object['FileInfo']['fileinfo_filename'],
					"filestatus_status" => $object['FileStatus']['filestatus_status'],
					"fileinfo_size" => $object['FileInfo']['fileinfo_size'],
					"fileinfo_filedate" => $object['FileInfo']['fileinfo_filedate'],
					"filestatus_id" => $object['FileStatus']['filestatus_id']
				);

			}
	
			$json = array(
				"success" => true,
				"totalCount" => $infocount,
				"records" => $extJson
			);
	
			echo json_encode($json);
		}
		else
			$this->log('DownloadsController:jsonGetListFileView - Unable output Json data', Configure::read('log_file'));

	}

	function __loadDbItems()
	{
		// variable used to determine the read dir time
		$acdate = strtotime("now");

		// check to see whether a valid directory was passed to the script
		if ( $this->Session->read('User.dirname_get') )
		{
			// if it is valid, we'll set it as the directory to read data from
			$this->dirpath = $this->Session->read('User.dirname_get');
		}
		else
		{
			// if it is invalid, we'll use the default directory
			$this->dirpath = Configure::read('default_get_dir');
		}

		// use Folder class
		$dir = new Folder($this->dirpath);

		// try to change the current working directory to the one from wich i want to read contents from
		if (!$dir->cd($this->dirpath))
		{
			// if the change failed, I'll use the default directory
			$this->dirpath = Configure::read('default_get_dir');
			$dir->cd(Configure::read('default_get_dir'));
		}

		// once the current working directory is set, it is opened and read from
		$dir_listing = $dir->read(true,false,true);

		if ( $dir_listing )
		{
			// while there are still entries
			foreach($dir_listing[1] as $entry) 
			{
				// if the entry is to be shown (not part of the 'not_to_be_shown' array)
				if (!in_array($entry, Configure::read('not_to_be_shown'))) 
				{
					$file = new File($entry);
	
					if ( $file->readable() )
					{
						// store the file extension
						$fext = $file->ext();
	
						// store the filename
						$fname = $file->name;
	
						// store the lowercased extension
						$lfext = strtolower($fext);
	
						// store size of file into KB
						$fsize = round($file->size()/1024,2);
	
						// store date of file
						$fidate = $file->lastChange();
	
						// store dirpath with file
						$finfokey = $entry;
		
						// store absfilename
						$fnameabs = $file->name();

						// define check for filestatus_status (if updated)
						$update_status = Configure::read('msg_items_file_unselected');

	
						// check table fileinfo for update or insert
						$file_info = $this->FileInfo->find('first', array(
							'conditions' => array('fileinfo_id' => $finfokey),
							'fields' => array('fileinfo_id','fileinfo_filedate')));
	
						if ( !empty($file_info) )
						{
							$this->FileInfo->read( null, $file_info['FileInfo']['fileinfo_id'] );
	
							$this->FileInfo->set( array(
								'fileinfo_dirname' => $this->dirpath,
								'fileinfo_filename' => $fname,
								'fileinfo_absfilename' => $fnameabs,
								'fileinfo_ext' => $lfext,
								'fileinfo_size' => $fsize,
								'fileinfo_filedate' => $fidate,
								'fileinfo_timenow' => $acdate));
				
							$this->FileInfo->save();
	
							// check data modified file is changed
							if ( $fidate > $file_info['FileInfo']['fileinfo_filedate'] )
								$update_status = Configure::read('msg_items_file_updated');
						}
						else
						{
							$this->FileInfo->create();
	
							$this->FileInfo->set( array(
								'fileinfo_id' => $finfokey,
								'fileinfo_dirname' => $this->dirpath,
								'fileinfo_filename' => $fname,
								'fileinfo_absfilename' => $fnameabs,
								'fileinfo_ext' => $lfext,
								'fileinfo_size' => $fsize,
								'fileinfo_filedate' => $fidate,
								'fileinfo_timenow' => $acdate));
	
							$this->FileInfo->save();
						}


						// check table filestatus for update or insert
						$file_status = $this->FileStatus->find('first', array(
							'conditions' => array(
									'filestatus_fileinfo_key' => $finfokey,
									'filestatus_users_id' => $this->Session->read('User.id')),
							'fields' => array('filestatus_id','filestatus_status')));
	
						if ( !empty($file_status) )
						{
							if ( $file_status['FileStatus']['filestatus_status'] == Configure::read('msg_items_file_selected') && $update_status != Configure::read('msg_items_file_updated') )
								$update_status = Configure::read('msg_items_file_selected');

							$this->FileStatus->read( null, $file_status['FileStatus']['filestatus_id'] );
	
							$this->FileStatus->set( array(
								'filestatus_status' => $update_status,
								'filestatus_users_id' => $this->Session->read('User.id'),
								'filestatus_timenow' => $acdate));
				
							$this->FileStatus->save();
						}
						else
						{
							$this->FileStatus->create();
	
							$this->FileStatus->set( array(
								'filestatus_fileinfo_key' => $finfokey,
								'filestatus_status' => $update_status,
								'filestatus_users_id' => $this->Session->read('User.id'),
								'filestatus_timenow' => $acdate));
	
							$this->FileStatus->save();
						}	
					}
				}
			}

			// check consistency : delete from db files that's removed from directory
			$file_info_del = $this->FileInfo->deleteAll(array('fileinfo_timenow < ' => $acdate));

			if ( !$file_info_del )
				$this->log('DownloadsController:__loadDbItems - Unable delete FileInfo model record', Configure::read('log_file'));


			// check consistency : delete from db files that's removed from directory
			$file_status_del = $this->FileStatus->deleteAll( array(
								'filestatus_timenow < ' => $acdate,
								'filestatus_users_id' => $this->Session->read('User.id')));

			if ( !$file_status_del )
				$this->log('DownloadsController:__loadDbItems - Unable delete FileStatus model record', Configure::read('log_file'));
		}

	}

	function download( $_fileStatusId, $_fileName )
	{
		$this->autoRender = false;

		// set acfiabsname
		$fn = $this->Session->read('User.dirname_get')."/".$_fileName;

		// set file extension for ctype
		$file_extension = strtolower(substr(strrchr($_fileName,"."),1));
		
		// required for IE, otherwise Content-disposition is ignored
		if(ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off');
		
		switch($file_extension)
		{
			case "pdf": $ctype="application/pdf"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "zip": $ctype="application/zip"; break;
			case "doc": $ctype="application/msword"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			default: $ctype="application/force-download";
		}
		
		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers
		header("Content-Type: $ctype");
		
		// change, added quotes to allow spaces in filenames, by Rajkumar Singh
		header("Content-Disposition: attachment; filename=\"".$_fileName."\";" );
		header("Content-Transfer-Encoding: binary");

		//header("Content-Length: ".filesize($_fileName));
		//header("Content-Disposition: attachment; filename=".$_fileName);

		if ( !in_array($file_extension, Configure::read('deniedDownloadTypes')) )
		{
			// the source file is output
                        @readfile($fn);

			$update_status = Configure::read('msg_items_file_selected');
			$acdate = strtotime("now");

	
			if ( $this->FileStatus->read( null, $_fileStatusId ) )
			{
				$this->FileStatus->set( array(
					'filestatus_status' => $update_status,
					'filestatus_users_id' => $this->Session->read('User.id'),
					'filestatus_timenow' => $acdate));

				$this->FileStatus->save();
			}
			else
				$this->log('DownloadsController:download - Unable save update FileStatus model record', Configure::read('log_file'));


			// check table getput_activity for update or insert
			$user_activity = $this->ActivityHistory->findByactivity_users_id( $this->Session->read('User.id') );

			if ( !empty($user_activity) )
			{
				$this->ActivityHistory->read( null, $user_activity['ActivityHistory']['activity_users_id'] );

				$this->ActivityHistory->set( array(
					'activity_lastget' => $acdate) );
	
				if ( !$this->ActivityHistory->save() )
					$this->log('DownloadsController:download - Unable save update ActivityHistory model record', Configure::read('log_file'));

			}
			else
			{
				$this->ActivityHistory->create();

				$this->ActivityHistory->set( array(
					'activity_users_id' => $this->Session->read('User.id'),
					'activity_lastget' => $acdate) );

				if ( !$this->ActivityHistory->save() )
					$this->log('DownloadsController:download - Unable save insert ActivityHistory model record', Configure::read('log_file'));
			}

			// insert data into getput_activity_fileget_history
			$this->ActivityFilegetHistory->create();

			$this->ActivityFilegetHistory->set( array(
				'activity_fileget_history_users_id' => $this->Session->read('User.id'),
				'activity_fileget_history_filename' => $fn,
				'activity_fileget_history_absfilename' => $_fileName,
				'activity_fileget_history_users_realname' => $this->Session->read('User.realname'),
				'activity_fileget_history_date' => $acdate) );

			if ( !$this->ActivityFilegetHistory->save() )
				$this->log('DownloadsController:download - Unable save ActivityFilegetHistory model record', Configure::read('log_file'));
		}
		else
			$this->Session->setFlash(Configure::read('msg_items_not_allowed'),'flash_downloads_error1');
	}

	function getgen( $_fileName )
	{
		$this->autoRender = false;

		// set acfiabsname
		$fn = Configure::read('get_gen_dir')."/".$_fileName;

		// set file extension for ctype
		$file_extension = strtolower(substr(strrchr($_fileName,"."),1));
		
		// required for IE, otherwise Content-disposition is ignored
		if(ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off');

		switch($file_extension)
		{
			case "pdf": $ctype="application/pdf"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "zip": $ctype="application/zip"; break;
			case "doc": $ctype="application/msword"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			default: $ctype="application/force-download";
		}
		
		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers
		header("Content-Type: $ctype");
		
		// change, added quotes to allow spaces in filenames, by Rajkumar Singh
		header("Content-Disposition: attachment; filename=\"".$_fileName."\";" );
		header("Content-Transfer-Encoding: binary");

		//header("Content-Length: ".filesize($_fileName));
		//header("Content-Disposition: attachment; filename=".$_fileName);

		ob_clean();
		flush();

		// the source file is output
		@readfile($fn);

		$update_status = Configure::read('msg_items_file_selected');
		$acdate = strtotime("now");

		// check table getput_activity for update or insert
		$user_activity = $this->ActivityHistory->findByactivity_users_id( $this->Session->read('User.id') );

		if ( !empty($user_activity) )
		{
			$this->ActivityHistory->read( null, $user_activity['ActivityHistory']['activity_users_id'] );

			$this->ActivityHistory->set( array(
				'activity_lastget' => $acdate) );

			if ( !$this->ActivityHistory->save() )
				$this->log('DownloadsController:getgen - Unable save update ActivityHistory model record', Configure::read('log_file'));

		}
		else
		{
			$this->ActivityHistory->create();

			$this->ActivityHistory->set( array(
				'activity_users_id' => $this->Session->read('User.id'),
				'activity_lastget' => $acdate) );

			if ( !$this->ActivityHistory->save() )
				$this->log('DownloadsController:getgen - Unable save insert ActivityHistory model record', Configure::read('log_file'));
		}

		// insert data into getput_activity_fileget_history
		$this->ActivityFilegetHistory->create();

		$this->ActivityFilegetHistory->set( array(
			'activity_fileget_history_users_id' => $this->Session->read('User.id'),
			'activity_fileget_history_filename' => $fn,
			'activity_fileget_history_absfilename' => $_fileName,
			'activity_fileget_history_users_realname' => $this->Session->read('User.realname'),
			'activity_fileget_history_date' => $acdate) );

		if ( !$this->ActivityFilegetHistory->save() )
			$this->log('DownloadsController:getgen - Unable save ActivityFilegetHistory model record', Configure::read('log_file'));
	}
}
?>
