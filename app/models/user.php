<?php
class User extends AppModel {
	var $name = 'User';
	var $useTable = 'getput_users';
	var $primaryKey = 'users_id';
	var $validate = array(
		'users_id' => array(
			'rule1' => array(
				'rule' => 'numeric',
				'allowEmpty' => false,
				'on' => 'create',
				'message' => 'Il campo users_id non è corretto.'
			),
			'rule2' => array(
				'rule' => array('checkUniqueUid','users_id'),
				'on' => 'create',
				'message' => 'Il campo users_id è già utilizzato.'
			)
		),
		'users_username' => array(
			'rule1' => array(
				'rule' => array('checkUniqueUname','users_username','users_id'),
				'message' => 'il campo users_username è già utilizzato.'
			),
			'rule2' => array(
				'rule' => 'alphaNumeric',
				'allowEmpty' => false,
				'message' => 'Il campo users_username non è corretto.'
			)
		),
		'users_password' => array(
			'rule1' => array(
				'rule' => 'alphaNumeric',
				'allowEmpty' => false,
				'message' => 'Il campo users_password è vuoto.'
			)
		),
		'users_dirname_get' => array(
			'rule1' => array(
				'rule' => array('checkDir','users_dirname_get'),
				'allowEmpty' => false,
				'message' => 'Il campo dirname_get non è valido.'
			)
		),
		'users_dirname_put_art' => array(
			'rule1' => array(
				'rule' => array('checkDir','users_dirname_put_art'),
				'allowEmpty' => false,
				'message' => 'Il campo dirname_put_art non è valido.'
			)
		),
		'users_dirname_put_pho' => array(
			'rule1' => array(
				'rule' => array('checkDir','users_dirname_put_pho'),
				'allowEmpty' => false,
				'message' => 'Il campo dirname_put_pho non è valido'
			)
		),
		'users_dirname_put_all' => array(
			'rule1' => array(
				'rule' => array('checkDir','users_dirname_put_all'),
				'allowEmpty' => false,
				'message' => 'Il campo dirname_put_all non è valido.'
			)
		),
		'users_se_author' => array(
			'rule1' => array(
				'rule' => array('checkUniqueUname','users_se_author','users_id'),
				'message' => 'il campo users_se_author è già utilizzato.'
			),
			'rule2' => array(
				'rule' => 'notEmpty',
				'message' => 'Il campo users_se_author non è corretto.'
			)
		)
	);

	function checkDir($data, $fieldName)
	{
		return ( in_array($this->data['User'][$fieldName], Configure::read('allowed_dir')) );
	}

	function checkUniqueUid($data, $fieldName)
	{
		return ($this->find('count', array('conditions' => array($fieldName => $this->data['User'][$fieldName]))) == 0);
	}

	function checkUniqueUname($data, $fieldName, $fieldId)
	{
		return ($this->find('count', array('conditions' => array($fieldName => $this->data['User'][$fieldName], $fieldId." <>" => $_POST[$fieldId]))) == 0);
	}
}
?>
