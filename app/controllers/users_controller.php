<?php
App::import('Sanitize');
class UsersController extends AppController {
	var $name = 'Users';
	var $uses = array('User', 'AgeGroup', 'AgeUserGroup', 'IpPermit');

	public $components = array('RequestHandler');
	var $helpers = array('Javascript', 'Html', 'Paginator');


	function index() 
	{
		$this->autoRender = false;
	}

	function beforeFilter() 
	{
		Configure::write('debug', 0);
		Configure::write('log', true);
	}

	function login()
	{
		$ip = $this->RequestHandler->getClientIp();
		
		if ( !empty($this->data) )
		{
			$user = $this->User->findByusers_username(Sanitize::paranoid($this->data['User']['txUsername']));

			$user_group = $this->AgeGroup->AgeUserGroup->find('first',array(
				'conditions' => array('AgeUserGroup.users_id' => $user['User']['users_id']),
				'fields' => array('AgeGroup.group_desc')));
  
			$ip_permit = $this->IpPermit->find('first',array(
				'conditions' => array('IpPermit.ip_permit_address = "'.$ip.'"'),
				'fields' => array('IpPermit.ip_permit_alias')));

			$ip_permit = true;		

			$conn_status = 0;

			if ( ($user['User']['users_level'] < 10) && ($user['User']['users_level'] > 0) && ($user['User']['users_level'] != 4) && (empty($user_group['AgeGroup']['group_desc'])) || (!in_array($user_group['AgeGroup']['group_desc'], Configure::read('allowed_group_connect'))))
        		{
				$this->jsonSuccessFalse("Username e password errati o non validi !!!");
        		}
			else if ( $user['User']['users_level'] > 0 )
			{
				// check ip permit if ADMIN or OPUSER
				if ( ($user['User']['users_level'] == 10 || $user['User']['users_level'] == 4) && !$ip_permit )
				{
					$this->jsonSuccessFalse("Connessione non consentita da questo ip !!!");

					$this->log('Admin Connect Error From : '.$ip, Configure::read('log_file'));
				}
				else
				{
					if ( $user['User']['users_level'] == 10 )
					{
						$this->log('Admin Connect From : '.$ip.' - '.$ip_permit['IpPermit']['ip_permit_alias'], Configure::read('log_file'));
					}
                                        else if ( $user['User']['users_level'] == 4 )
                                        {
                                                $this->log('OpUser Connect From : '.$ip.' - '.$ip_permit['IpPermit']['ip_permit_alias'], Configure::read('log_file'));
                                        }

					// mysql autentication
					if ( !empty($user) && $user['User']['users_type_access'] == 0 )
					{
						if ( !empty($user['User']['users_password']) && md5($user['User']['users_password']) == md5($this->data['User']['txPassword']) )
						{
							$conn_status = 1;
						}
						else
							$this->jsonSuccessFalse("Username e password errati o non validi !!!");
					}
					// imap autentication
					else if ( $user['User']['users_type_access'] == 1 )
					{
						$username = Sanitize::paranoid($this->data['User']['txUsername']);
						$passwd = Sanitize::paranoid($this->data['User']['txPassword']);
	
						if ( $this->__checkImapCon($username,$passwd) )
						{
							$conn_status = 1;
						}
						else
							$this->jsonSuccessFalse("Username e password errati o non validi !!!");
					}
	
					// set Session vars
					if ( $conn_status )
					{
						$this->Session->write('User.id', $user['User']['users_id']);
						$this->Session->write('User.username', $user['User']['users_username']);
						$this->Session->write('User.level', $user['User']['users_level']);
						$this->Session->write('User.dirname_get', $user['User']['users_dirname_get']."/");
						$this->Session->write('User.dirname_put_art', $user['User']['users_dirname_put_art']."/");
						$this->Session->write('User.dirname_put_pho', $user['User']['users_dirname_put_pho']."/");
						$this->Session->write('User.dirname_put_all', $user['User']['users_dirname_put_all']."/");
	
						// check for ldap real name
						if ( $user['User']['users_type_access_realname'] == 1 )
						{
							$this->Session->write('User.realname', $this->__searchIntoLdap());
						}
						else
						{
							$this->Session->write('User.realname', $user['User']['users_username_realname']);
						}
	
						// return true json data
						$this->jsonSuccessTrue();

						// update User Connect data
						$this->requestAction(array('controller' => 'UsersConnect', 'action' => 'updateUserConnect'));
					}
				}
			}
			else
				$this->jsonSuccessFalse("Username e password errati o non validi !!!");
		}
	}

	function loginOld()
	{
		$ip = $this->RequestHandler->getClientIp();

		if ( !empty($this->data) )
		{
			$user = $this->User->findByusers_username(Sanitize::paranoid($this->data['User']['txUsername']));
	
			$user_group = $this->AgeGroup->AgeUserGroup->find('first',array(
				'conditions' => array('AgeUserGroup.users_id' => $user['User']['users_id']),
				'fields' => array('AgeGroup.group_desc')));
	
			$ip_permit = $this->IpPermit->find('first',array(
				'conditions' => array('IpPermit.ip_permit_address = "'.$ip.'"'),
				'fields' => array('IpPermit.ip_permit_alias')));

			$ip_permit = true;
	
			$conn_status = 0;
	
	
			if ( ($user['User']['users_level'] < 10) && ($user['User']['users_level'] > 0) && (empty($user_group['AgeGroup']['group_desc'])) || (!in_array($user_group['AgeGroup']['group_desc'], Configure::read('allowed_group_connect'))))
			{
				$this->Session->setFlash('Username e password errati o non validi !!!','flash_login_error1');
			}
			else if ( $user['User']['users_level'] > 0 )
			{
				if ( $user['User']['users_level'] == 10 && !$ip_permit )
				{
					$this->log('Admin Connect Error From : '.$ip, Configure::read('log_file'));
	
					$this->Session->setFlash('Connessione non consentita !!!','flash_login_error1');
				}
				else
				{
					if ( $user['User']['users_level'] == 10 )
					{
						$this->log('Admin Connect From : '.$ip.' - '.$ip_permit['IpPermit']['ip_permit_alias'], Configure::read('log_file'));
					}
	
					// mysql autentication
					if ( !empty($user) && $user['User']['users_type_access'] == 0 )
					{
						if ( !empty($user['User']['users_password']) && md5($user['User']['users_password']) == md5($this->data['User']['txPassword']) )
						{
							$conn_status = 1;
						}
						else
							$this->Session->setFlash('Username e password errati o non validi !!!','flash_login_error1');
					}
					// imap autentication
					else if ( $user['User']['users_type_access'] == 1 )
					{
						$imapconn = imap_open( Configure::read('imap_string_connect'), Sanitize::paranoid($this->data['User']['txUsername']), Sanitize::paranoid($this->data['User']['txPassword']) );
	
						if ( $imapconn )
						{
							$conn_status = 1;
	
							imap_close($imapconn);
						}
						else
							$this->Session->setFlash('Username e password errati o non validi !!!','flash_login_error1');
					}
	
					// set Session vars
					if ( $conn_status )
					{
						$this->Session->write('User.id', $user['User']['users_id']);
						$this->Session->write('User.username', $user['User']['users_username']);
						$this->Session->write('User.level', $user['User']['users_level']);
						$this->Session->write('User.dirname_get', $user['User']['users_dirname_get']."/");
						$this->Session->write('User.dirname_put_art', $user['User']['users_dirname_put_art']."/");
						$this->Session->write('User.dirname_put_pho', $user['User']['users_dirname_put_pho']."/");
						$this->Session->write('User.dirname_put_all', $user['User']['users_dirname_put_all']."/");
	
						// check for ldap real name
						if ( $user['User']['users_type_access_realname'] == 1 )
						{
							$this->Session->write('User.realname', $this->__searchIntoLdap());
						}
						else
						{
							$this->Session->write('User.realname', $user['User']['users_username_realname']);
						}
	
						// update User Connect data
						$this->requestAction(array('controller' => 'UsersConnect', 'action' => 'updateUserConnect'));
					}
				}
			}
			else
				$this->Session->setFlash('Username e password errati o non validi !!!','flash_login_error1');
	
			$this->redirect('/');
		}

	}

	function __checkImapCon($username='',$passwd='')
	{
		if ( !empty($username) && !empty($passwd) )
		{
			$imapconn = @imap_open(Configure::read('imap_string_connect'), $username, $passwd, NULL, 1);

			if ( $imapconn )
			{
				imap_close($imapconn);
	
				return true;
			}
			else
				return false;
		}
		else
			return false;
	}

	function __searchIntoLdap()
	{
		$usrrealname = "";

		// Enable search filter
		$filter = "(uid=".$this->Session->read('User.username').")";

		if ( !($ldapconnect=@ldap_connect(Configure::read('ldap_server'))) )
		{
			$this->log('Could not connect to ldap server', Configure::read('log_file'));
		}
		else
		{
			if (!($ldapsearch=@ldap_search($ldapconnect, Configure::read('ldap_base_dn'), $filter)))
			{
				$this->log('Unable to search ldap server', Configure::read('log_file'));
			}
			else
			{
				if ( ($number_returned = ldap_count_entries($ldapconnect,$ldapsearch)) > 0 )
				{
					$info = ldap_get_entries($ldapconnect, $ldapsearch);

					$usrrealname = $info[0]["cn"][0];
				}
			}
		}

		return $usrrealname;
	}

	function jsonSuccessFalse($msg='')
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		echo json_encode(array(
			'success' => false,
			'message' => $msg
		));
	}

	function jsonSuccessTrue()
	{
		$this->autoRender = false;

		$this->layout = 'ajax';

		echo json_encode(array(
			'success' => true
		));
	}

	function logout()
	{
		$this->Session->destroy();

		$this->redirect('/');
	}
}
?>
