<?php
App::import('Sanitize');
class UploadsController extends AppController {
	var $name = 'Uploads';
	var $uses = array('User', 'ActivityHistory', 'ActivityFileputHistory', 'FileDest');

	function beforeFilter()
	{
		Configure::write('debug', 0);
		Configure::write('log', false);

		$this->checkSession();
		// check permission status
		$this->checkPermission( $this->params['controller'], $this->params['action'], $this->params['pass']);
	}

	function afterFilter()
	{
		// set session default var
		$this->Session->write('Pho.fname1', 0);
		$this->Session->write('Pho.fname2', 0);
		$this->Session->write('Pho.fname3', 0);
		$this->Session->write('Pho.fname4', 0);
		$this->Session->write('Pho.fname5', 0);

		$this->Session->write('Item.fname1', 0);
		$this->Session->write('Item.fname2', 0);
		$this->Session->write('Item.fname3', 0);
		$this->Session->write('Item.fname4', 0);
		$this->Session->write('Item.fname5', 0);
	}

	function index() 
	{
		$this->autoRender = false;
	}

	function articles()
	{
		if ( !empty($this->data) )
		{
			$flagError = false;

			$user = $this->User->findByusers_id($this->Session->read('User.id'));

			// store author name
                	if ( !empty($user['User']['users_se_author']) )
                	{
				$authorName = $user['User']['users_se_author'];
			}
                	else
				$authorName = "";

			// store destination name
			$selectDest = $this->data['Uploads']['file_dest'];

			// check to see whether a valid directory was passed to the script
			if ( $this->Session->read('User.dirname_put_art') )
			{
				// if it is valid, we'll set it as the directory to read data from
				$uploadDirArt = $this->Session->read('User.dirname_put_art');
			}
			else
			{
				// if it is invalid, we'll use the default directory
				$uploadDirArt = Configure::read('default_put_dir');
			}


			$fname = $this->data['Uploads']['txfileupload']['name'];
			$type = $this->data['Uploads']['txfileupload']['type'];
			$fsize = $this->data['Uploads']['txfileupload']['size'];
			$fext  = array_pop(explode('.', $fname));
			$fnameabs = basename($fname, '.'.$fext);


			if ( !empty($fname) )
			{
                        	// check if extensions file is correct
                        	if ( !in_array($fext, Configure::read('allowedArtTypes')) )
				{
					$flagError = true;
                                	$this->Session->setFlash(Configure::read('msg_articles_file_invalid'),'flash_uploads_error1');
				}
				// check if file size is correct
				else if ( $fsize > Configure::read('max_upload_artsize') || $fsize == 0 )
				{
					$flagError = true;
					$this->Session->setFlash(Configure::read('msg_articles_file_size'),'flash_uploads_error1');
				}
			}
			else
			{
				$flagError = true;
				$this->Session->setFlash(Configure::read('msg_articles_file_empty'),'flash_uploads_error1');
			}

			if ( !$flagError )
			{
				if ( $authorName == "" )
					$uploadFile = $uploadDirArt.$selectDest."_".ereg_replace( '(\\ +|\\_+|\\.)', '', $fnameabs ).".".$fext;
				else
				{
					$uploadFile = $uploadDirArt.$selectDest."_".ereg_replace( '(\\ +|\\_+|\\.)', '', $fnameabs )."@".$authorName.".".$fext;
				}

				if ( move_uploaded_file($this->data['Uploads']['txfileupload']['tmp_name'], $uploadFile) )
				{
					// Store db activity information
                                	$acdate = strtotime("now");
                                	$acfiabsname = ereg_replace( '(\\ +|\\_+|\\.)', '', $fnameabs ).".".$fext;

                                	// check table getput_activity for update or insert
					$user_activity = $this->ActivityHistory->findByactivity_users_id( $this->Session->read('User.id') );

					if ( !empty($user_activity) )
					{
						$this->ActivityHistory->read( null, $user_activity['ActivityHistory']['activity_users_id'] );

						$this->ActivityHistory->set( array(
							'activity_lastput' => $acdate) );
			
						if ( !$this->ActivityHistory->save() )
							$this->log('UploadsController:articles - Unable save update ActivityHistory model record', Configure::read('log_file'));

					}
					else
					{
						$this->ActivityHistory->create();

						$this->ActivityHistory->set( array(
							'activity_users_id' => $this->Session->read('User.id'),
							'activity_lastput' => $acdate) );

						if ( !$this->ActivityHistory->save() )
							$this->log('UploadsController:articles - Unable save insert ActivityHistory model record', Configure::read('log_file'));
					}

                                	// insert data into getput_activity_fileput_history
					$this->ActivityFileputHistory->create();

					$this->ActivityFileputHistory->set( array(
						'activity_fileput_history_users_id' => $this->Session->read('User.id'),
						'activity_fileput_history_filename' => $uploadFile,
						'activity_fileput_history_absfilename' => $acfiabsname,
						'activity_fileput_history_users_realname' => $this->Session->read('User.realname'),
						'activity_fileput_history_filedest' => $selectDest,
						'activity_fileput_history_date' => $acdate) );

					if ( !$this->ActivityFileputHistory->save() )
						$this->log('UploadsController:articles - Unable save ActivityFileputHistory model record', Configure::read('log_file'));


					$this->Session->setFlash(Configure::read('msg_articles_upload_ok'),'flash_uploads_ok1');
				}
				else
                        	{
					$this->Session->setFlash(Configure::read('msg_articles_upload_error'),'flash_uploads_error1');
				}
                        }

			$this->redirect('/');
		}

		// preload lastput view
		$user_activity = $this->ActivityHistory->findByactivity_users_id( $this->Session->read('User.id') );

		if ( !empty($user_activity) )
		{
			$this->set('lastput',$user_activity['ActivityHistory']['activity_lastput']);

			$user_activity_fileput = $this->ActivityFileputHistory->find('first',array(
				'conditions' => array(
					'activity_fileput_history_users_id' => $this->Session->read('User.id'),
					'activity_fileput_history_date' => $user_activity['ActivityHistory']['activity_lastput']),
				'fields' => array('activity_fileput_history_absfilename'),
				'order' => 'activity_fileput_history_num_id DESC'));

			if ( !empty($user_activity_fileput) )
				$this->set('lastfileput',$user_activity_fileput['ActivityFileputHistory']['activity_fileput_history_absfilename']);
			else
				$this->set('lastfileput',"");
		}
		else
			$this->set('lastput',"");


		// preload fileDest
		$file_dest = $this->FileDest->find('list', array(
						'fields' => array('filedest_id','filedest_desc'),
						'order' => 'filedest_desc ASC'));

		if ( $file_dest )
			$this->set('fileDest',$file_dest);
		else
			$this->log('UploadsController:articles - Unable query FileDest', Configure::read('log_file'));
	}

	function photo()
	{
		if ( !empty($this->data) )
		{
			$flagError = false;

			$user = $this->User->findByusers_id($this->Session->read('User.id'));

			// store author name
                	if ( !empty($user['User']['users_se_author']) )
                	{
				$authorName = $user['User']['users_se_author'];
			}
                	else
				$authorName = "";

			// store destination name
			$selectDest = $this->data['Uploads']['file_dest'];

			// check to see whether a valid directory was passed to the script
			if ( $this->Session->read('User.dirname_put_pho') )
			{
				// if it is valid, we'll set it as the directory to read data from
				$uploadDirPho = $this->Session->read('User.dirname_put_pho');
			}
			else
			{
				// if it is invalid, we'll use the default directory
				$uploadDirPho = Configure::read('default_put_dir');
			}

			// set session default var
			$this->Session->write('Pho.fname1', 0);
			$this->Session->write('Pho.fname2', 0);
			$this->Session->write('Pho.fname3', 0);
			$this->Session->write('Pho.fname4', 0);
			$this->Session->write('Pho.fname5', 0);

			$fname1 = $this->data['Uploads']['phfileupload1']['name'];
			$type1 = $this->data['Uploads']['phfileupload1']['type'];
			$fsize1 = $this->data['Uploads']['phfileupload1']['size'];
			$fext1  = array_pop(explode('.', $fname1));
			$fnameabs1 = "";

			$fname2 = $this->data['Uploads']['phfileupload2']['name'];
			$type2 = $this->data['Uploads']['phfileupload2']['type'];
			$fsize2 = $this->data['Uploads']['phfileupload2']['size'];
			$fext2  = array_pop(explode('.', $fname2));
			$fnameabs2 = "";

			$fname3 = $this->data['Uploads']['phfileupload3']['name'];
			$type3 = $this->data['Uploads']['phfileupload3']['type'];
			$fsize3 = $this->data['Uploads']['phfileupload3']['size'];
			$fext3  = array_pop(explode('.', $fname3));
			$fnameabs3 = "";

			$fname4 = $this->data['Uploads']['phfileupload4']['name'];
			$type4 = $this->data['Uploads']['phfileupload4']['type'];
			$fsize4 = $this->data['Uploads']['phfileupload4']['size'];
			$fext4  = array_pop(explode('.', $fname4));
			$fnameabs4 = "";

			$fname5 = $this->data['Uploads']['phfileupload5']['name'];
			$type5 = $this->data['Uploads']['phfileupload5']['type'];
			$fsize5 = $this->data['Uploads']['phfileupload5']['size'];
			$fext5  = array_pop(explode('.', $fname5));
			$fnameabs5 = "";


			if ( empty($fname1) && empty($fname2) && empty($fname3) && empty($fname4) && empty($fname5) )
			{
				$this->Session->write('Pho.fname1', 1);
				$this->Session->write('Pho.fname2', 1);
				$this->Session->write('Pho.fname3', 1);
				$this->Session->write('Pho.fname4', 1);
				$this->Session->write('Pho.fname5', 1);

				$flagError = true;
				$this->Session->setFlash(Configure::read('msg_photo_file_empty'),'flash_uploads_error2');
			}
			else
			{
				if ( !empty($fname1) )
				{
					// check if extensions file1 is correct
					if ( !in_array($fext1, Configure::read('allowedPhoTypes')) )
					{
						// set var fname1 session
						$this->Session->write('Pho.fname1', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_invalid1'),'flash_uploads_error2');
					}
					// check if file1 size is correct
					else if ( $fsize1 > Configure::read('max_upload_photosize') || $fsize1 == 0 )
					{
						// set var fname1 session
						$this->Session->write('Pho.fname1', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_size1'),'flash_uploads_error2');
					}
					else
						$fnameabs1 = basename($fname1, '.'.$fext1);
				}

				if ( !$flagError && !empty($fname2) )
				{
					// check if extensions file2 is correct
					if ( !in_array($fext2, Configure::read('allowedPhoTypes')) )
					{
						// set var fname2 session
						$this->Session->write('Pho.fname2', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_invalid2'),'flash_uploads_error2');
					}
					// check if file2 size is correct
					else if ( $fsize2 > Configure::read('max_upload_photosize') || $fsize2 == 0 )
					{
						// set var fname2 session
						$this->Session->write('Pho.fname2', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_size2'),'flash_uploads_error2');
					}
					else
						$fnameabs2 = basename($fname2, '.'.$fext2);
				}

				if ( !$flagError && !empty($fname3) )
				{
					// check if extensions file3 is correct
					if ( !in_array($fext3, Configure::read('allowedPhoTypes')) )
					{
						// set var fname3 session
						$this->Session->write('Pho.fname3', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_invalid3'),'flash_uploads_error2');
					}
					// check if file3 size is correct
					else if ( $fsize3 > Configure::read('max_upload_photosize') || $fsize3 == 0 )
					{
						// set var fname3 session
						$this->Session->write('Pho.fname3', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_size3'),'flash_uploads_error2');
					}
					else
						$fnameabs3 = basename($fname3, '.'.$fext3);
				}

				if ( !$flagError && !empty($fname4) )
				{
					// check if extensions file4 is correct
					if ( !in_array($fext4, Configure::read('allowedPhoTypes')) )
					{
						// set var fname4 session
						$this->Session->write('Pho.fname4', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_invalid4'),'flash_uploads_error2');
					}
					// check if file4 size is correct
					else if ( $fsize4 > Configure::read('max_upload_photosize') || $fsize4 == 0 )
					{
						// set var fname4 session
						$this->Session->write('Pho.fname4', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_size4'),'flash_uploads_error2');
					}
					else
						$fnameabs4 = basename($fname4, '.'.$fext4);
				}

				if ( !$flagError && !empty($fname5) )
				{
					// check if extensions file5 is correct
					if ( !in_array($fext5, Configure::read('allowedPhoTypes')) )
					{
						// set var fname5 session
						$this->Session->write('Pho.fname5', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_invalid5'),'flash_uploads_error2');
					}
					// check if file5 size is correct
					else if ( $fsize5 > Configure::read('max_upload_photosize') || $fsize5 == 0 )
					{
						// set var fname5 session
						$this->Session->write('Pho.fname5', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_file_size5'),'flash_uploads_error2');
					}
					else
						$fnameabs5 = basename($fname5, '.'.$fext5);
				}


				if ( $authorName == "" )
				{
					$uploadFile1 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname1 );
					$uploadFile2 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname2 );
					$uploadFile3 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname3 );
					$uploadFile4 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname4 );
					$uploadFile5 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname5 );
				}
				else
				{
					$uploadFile1 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs1 )."@".$authorName.".".$fext1;
					$uploadFile2 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs2 )."@".$authorName.".".$fext2;
					$uploadFile3 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs3 )."@".$authorName.".".$fext3;
					$uploadFile4 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs4 )."@".$authorName.".".$fext4;
					$uploadFile5 = $uploadDirPho.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs5 )."@".$authorName.".".$fext5;
				}

				//try upload file 1
				if ( !$flagError && !empty($fnameabs1) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['phfileupload1']['tmp_name'], $uploadFile1, $fname1, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_upload_error'),'flash_uploads_error2');
					}
				}

				//try upload file 2
				if ( !$flagError && !empty($fnameabs2) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['phfileupload2']['tmp_name'], $uploadFile2, $fname2, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_upload_error'),'flash_uploads_error2');
					}
				}

				//try upload file 3
				if ( !$flagError && !empty($fnameabs3) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['phfileupload3']['tmp_name'], $uploadFile3, $fname3, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_upload_error'),'flash_uploads_error2');
					}
				}

				//try upload file 4
				if ( !$flagError && !empty($fnameabs4) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['phfileupload4']['tmp_name'], $uploadFile4, $fname4, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_upload_error'),'flash_uploads_error2');
					}
				}

				//try upload file 5
				if ( !$flagError && !empty($fnameabs5) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['phfileupload5']['tmp_name'], $uploadFile5, $fname5, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_photo_upload_error'),'flash_uploads_error2');
					}
				}

				if ( !$flagError )
				{
					// set session default var
					$this->Session->write('Pho.fname1', 0);
					$this->Session->write('Pho.fname2', 0);
					$this->Session->write('Pho.fname3', 0);
					$this->Session->write('Pho.fname4', 0);
					$this->Session->write('Pho.fname5', 0);

					$this->Session->setFlash(Configure::read('msg_photo_upload_ok'),'flash_uploads_ok2');
				}
			}

			$this->redirect('/');
		}


		// preload lastput view
		$user_activity = $this->ActivityHistory->findByactivity_users_id( $this->Session->read('User.id') );

		if ( !empty($user_activity) )
		{
			$this->set('lastput',$user_activity['ActivityHistory']['activity_lastput']);

			$user_activity_fileput = $this->ActivityFileputHistory->find('first',array(
				'conditions' => array(
					'activity_fileput_history_users_id' => $this->Session->read('User.id'),
					'activity_fileput_history_date' => $user_activity['ActivityHistory']['activity_lastput']),
				'fields' => array('activity_fileput_history_absfilename'),
				'order' => 'activity_fileput_history_num_id DESC'));

			if ( !empty($user_activity_fileput) )
				$this->set('lastfileput',$user_activity_fileput['ActivityFileputHistory']['activity_fileput_history_absfilename']);
			else
				$this->set('lastfileput',"");
		}
		else
			$this->set('lastput',"");


		// preload fileDest
		$file_dest = $this->FileDest->find('list', array(
						'fields' => array('filedest_id','filedest_desc'),
						'order' => 'filedest_desc ASC'));

		if ( $file_dest )
			$this->set('fileDest',$file_dest);
		else
			$this->log('UploadsController:photo - Unable query FileDest', Configure::read('log_file'));
	}

	function items()
	{
		if ( !empty($this->data) )
		{
			$flagError = false;

			$user = $this->User->findByusers_id($this->Session->read('User.id'));

			// store author name
                	if ( !empty($user['User']['users_se_author']) )
                	{
				$authorName = $user['User']['users_se_author'];
			}
                	else
				$authorName = "";

			// store destination name
			$selectDest = $this->data['Uploads']['file_dest'];

			// check to see whether a valid directory was passed to the script
			if ( $this->Session->read('User.dirname_put_all') )
			{
				// if it is valid, we'll set it as the directory to read data from
				$uploadDirAll = $this->Session->read('User.dirname_put_all');
			}
			else
			{
				// if it is invalid, we'll use the default directory
				$uploadDirAll = Configure::read('default_put_dir');
			}

			// set session default var
			$this->Session->write('Item.fname1', 0);
			$this->Session->write('Item.fname2', 0);
			$this->Session->write('Item.fname3', 0);
			$this->Session->write('Item.fname4', 0);
			$this->Session->write('Item.fname5', 0);

			$fname1 = $this->data['Uploads']['fileupload1']['name'];
			$type1 = $this->data['Uploads']['fileupload1']['type'];
			$fsize1 = $this->data['Uploads']['fileupload1']['size'];
			$fext1  = array_pop(explode('.', $fname1));
			$fnameabs1 = "";

			$fname2 = $this->data['Uploads']['fileupload2']['name'];
			$type2 = $this->data['Uploads']['fileupload2']['type'];
			$fsize2 = $this->data['Uploads']['fileupload2']['size'];
			$fext2  = array_pop(explode('.', $fname2));
			$fnameabs2 = "";

			$fname3 = $this->data['Uploads']['fileupload3']['name'];
			$type3 = $this->data['Uploads']['fileupload3']['type'];
			$fsize3 = $this->data['Uploads']['fileupload3']['size'];
			$fext3  = array_pop(explode('.', $fname3));
			$fnameabs3 = "";

			$fname4 = $this->data['Uploads']['fileupload4']['name'];
			$type4 = $this->data['Uploads']['fileupload4']['type'];
			$fsize4 = $this->data['Uploads']['fileupload4']['size'];
			$fext4  = array_pop(explode('.', $fname4));
			$fnameabs4 = "";

			$fname5 = $this->data['Uploads']['fileupload5']['name'];
			$type5 = $this->data['Uploads']['fileupload5']['type'];
			$fsize5 = $this->data['Uploads']['fileupload5']['size'];
			$fext5  = array_pop(explode('.', $fname5));
			$fnameabs5 = "";

			if ( empty($fname1) && empty($fname2) && empty($fname3) && empty($fname4) && empty($fname5) )
			{
				$this->Session->write('Item.fname1', 1);
				$this->Session->write('Item.fname2', 1);
				$this->Session->write('Item.fname3', 1);
				$this->Session->write('Item.fname4', 1);
				$this->Session->write('Item.fname5', 1);

				$flagError = true;
				$this->Session->setFlash(Configure::read('msg_items_file_empty'),'flash_uploads_error3');
			}
			else
			{
				if ( !empty($fname1) )
				{
					// check if extensions file1 is correct
					if ( !in_array($fext1, Configure::read('allowedAllTypes')) )
					{
						// set var fname1 session
						$this->Session->write('Item.fname1', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_invalid1'),'flash_uploads_error3');
					}
					// check if file1 size is correct
					else if ( $fsize1 > Configure::read('max_upload_itemsize') || $fsize1 == 0 )
					{
						// set var fname1 session
						$this->Session->write('Item.fname1', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_size1'),'flash_uploads_error3');


					}
					else
						$fnameabs1 = basename($fname1, '.'.$fext1);
				}

				if ( !$flagError && !empty($fname2) )
				{
					// check if extensions file2 is correct
					if ( !in_array($fext2, Configure::read('allowedAllTypes')) )
					{
						// set var fname2 session
						$this->Session->write('Item.fname2', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_invalid2'),'flash_uploads_error3');
					}
					// check if file2 size is correct
					else if ( $fsize2 > Configure::read('max_upload_itemsize') || $fsize2 == 0 )
					{
						// set var fname2 session
						$this->Session->write('Item.fname2', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_size2'),'flash_uploads_error3');
					}
					else
						$fnameabs2 = basename($fname2, '.'.$fext2);
				}

				if ( !$flagError && !empty($fname3) )
				{
					// check if extensions file3 is correct
					if ( !in_array($fext3, Configure::read('allowedAllTypes')) )
					{
						// set var fname3 session
						$this->Session->write('Item.fname3', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_invalid3'),'flash_uploads_error3');
					}
					// check if file3 size is correct
					else if ( $fsize3 > Configure::read('max_upload_itemsize') || $fsize3 == 0 )
					{
						// set var fname3 session
						$this->Session->write('Item.fname3', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_size3'),'flash_uploads_error3');
					}
					else
						$fnameabs3 = basename($fname3, '.'.$fext3);
				}

				if ( !$flagError && !empty($fname4) )
				{
					// check if extensions file4 is correct
					if ( !in_array($fext4, Configure::read('allowedAllTypes')) )
					{
						// set var fname4 session
						$this->Session->write('Item.fname4', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_invalid4'),'flash_uploads_error3');
					}
					// check if file4 size is correct
					else if ( $fsize4 > Configure::read('max_upload_itemsize') || $fsize4 == 0 )
					{
						// set var fname4 session
						$this->Session->write('Item.fname4', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_size4'),'flash_uploads_error3');
					}
					else
						$fnameabs4 = basename($fname4, '.'.$fext4);
				}

				if ( !$flagError && !empty($fname5) )
				{
					// check if extensions file5 is correct
					if ( !in_array($fext5, Configure::read('allowedAllTypes')) )
					{
						// set var fname5 session
						$this->Session->write('Item.fname5', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_invalid5'),'flash_uploads_error3');
					}
					// check if file5 size is correct
					else if ( $fsize5 > Configure::read('max_upload_itemsize') || $fsize5 == 0 )
					{
						// set var fname5 session
						$this->Session->write('Item.fname5', 1);

						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_file_size5'),'flash_uploads_error3');
					}
					else
						$fnameabs5 = basename($fname5, '.'.$fext5);
				}


				if ( $authorName == "" )
				{
					$uploadFile1 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname1 );
					$uploadFile2 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname2 );
					$uploadFile3 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname3 );
					$uploadFile4 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname4 );
					$uploadFile5 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fname5 );
				}
				else
				{
					$uploadFile1 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs1 )."@".$authorName.".".$fext1;
					$uploadFile2 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs2 )."@".$authorName.".".$fext2;
					$uploadFile3 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs3 )."@".$authorName.".".$fext3;
					$uploadFile4 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs4 )."@".$authorName.".".$fext4;
					$uploadFile5 = $uploadDirAll.$selectDest."_".ereg_replace( '(\\ +|\\_+)', '', $fnameabs5 )."@".$authorName.".".$fext5;
				}

				//try upload file 1
				if ( !$flagError && !empty($fnameabs1) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['fileupload1']['tmp_name'], $uploadFile1, $fname1, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_upload_error'),'flash_uploads_error3');
					}
				}

				//try upload file 2
				if ( !$flagError && !empty($fnameabs2) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['fileupload2']['tmp_name'], $uploadFile2, $fname2, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_upload_error'),'flash_uploads_error3');
					}
				}

				//try upload file 3
				if ( !$flagError && !empty($fnameabs3) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['fileupload3']['tmp_name'], $uploadFile3, $fname3, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_upload_error'),'flash_uploads_error3');
					}
				}

				//try upload file 4
				if ( !$flagError && !empty($fnameabs4) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['fileupload4']['tmp_name'], $uploadFile4, $fname4, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_upload_error'),'flash_uploads_error3');
					}
				}

				//try upload file 5
				if ( !$flagError && !empty($fnameabs5) )
				{
					if ( !$this->__uploadMore( $this->data['Uploads']['fileupload5']['tmp_name'], $uploadFile5, $fname5, $selectDest) )
					{
						$flagError = true;
						$this->Session->setFlash(Configure::read('msg_items_upload_error'),'flash_uploads_error3');
					}
				}

				if ( !$flagError )
				{
					// set session default var
					$this->Session->write('Item.fname1', 0);
					$this->Session->write('Item.fname2', 0);
					$this->Session->write('Item.fname3', 0);
					$this->Session->write('Item.fname4', 0);
					$this->Session->write('Item.fname5', 0);

					$this->Session->setFlash(Configure::read('msg_items_upload_ok'),'flash_uploads_ok3');
				}
			}

			$this->redirect('/');
		}


		// preload lastput view
		$user_activity = $this->ActivityHistory->findByactivity_users_id( $this->Session->read('User.id') );

		if ( !empty($user_activity) )
		{
			$this->set('lastput',$user_activity['ActivityHistory']['activity_lastput']);

			$user_activity_fileput = $this->ActivityFileputHistory->find('first',array(
				'conditions' => array(
					'activity_fileput_history_users_id' => $this->Session->read('User.id'),
					'activity_fileput_history_date' => $user_activity['ActivityHistory']['activity_lastput']),
				'fields' => array('activity_fileput_history_absfilename'),
				'order' => 'activity_fileput_history_num_id DESC'));

			if ( !empty($user_activity_fileput) )
				$this->set('lastfileput',$user_activity_fileput['ActivityFileputHistory']['activity_fileput_history_absfilename']);
			else
				$this->set('lastfileput',"");
		}
		else
			$this->set('lastput',"");


		// preload fileDest
		$file_dest = $this->FileDest->find('list', array(
						'fields' => array('filedest_id','filedest_desc'),
						'order' => 'filedest_desc ASC'));

		if ( $file_dest )
			$this->set('fileDest',$file_dest);
		else
			$this->log('UploadsController:items - Unable query FileDest', Configure::read('log_file'));
	}

	function __uploadMore( $_phfileupload, $_uploadFile, $_fname, $_selectDest )
	{
		if ( move_uploaded_file($_phfileupload, $_uploadFile) )
		{
			// Store db activity information
			$acdate = strtotime("now");
			$acfiabsname = ereg_replace( '(\\ +|\\_+)', '', $_fname );

			// check table getput_activity for update or insert
			$user_activity = $this->ActivityHistory->findByactivity_users_id( $this->Session->read('User.id') );

			if ( !empty($user_activity) )
			{
				$this->ActivityHistory->read( null, $user_activity['ActivityHistory']['activity_users_id'] );

				$this->ActivityHistory->set( array(
					'activity_lastput' => $acdate) );
	
				if ( !$this->ActivityHistory->save() )
					$this->log('UploadsController:__uploadMore - Unable save update ActivityHistory model record', Configure::read('log_file'));

			}
			else
			{
				$this->ActivityHistory->create();

				$this->ActivityHistory->set( array(
					'activity_users_id' => $this->Session->read('User.id'),
					'activity_lastput' => $acdate) );

				if ( !$this->ActivityHistory->save() )
					$this->log('UploadsController:__uploadMore - Unable save insert ActivityHistory model record', Configure::read('log_file'));
			}

			// insert data into getput_activity_fileput_history
			$this->ActivityFileputHistory->create();

			$this->ActivityFileputHistory->set( array(
				'activity_fileput_history_users_id' => $this->Session->read('User.id'),
				'activity_fileput_history_filename' => $_uploadFile,
				'activity_fileput_history_absfilename' => $acfiabsname,
				'activity_fileput_history_users_realname' => $this->Session->read('User.realname'),
				'activity_fileput_history_filedest' => $_selectDest,
				'activity_fileput_history_date' => $acdate) );

			if ( !$this->ActivityFileputHistory->save() )
				$this->log('UploadsController:__uploadMore - Unable save ActivityFileputHistory model record', Configure::read('log_file'));

			return true;
		}
                else
			return false;
        }
}
?>