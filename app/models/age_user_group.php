<?php
class AgeUserGroup extends AppModel {
	var $name = 'AgeUserGroup';
	var $useTable = 'getput_ageusersgroup';
	var $primaryKey ='users_id';
	var $belongsTo = array(
		'AgeGroup' => array(
			'className' => 'AgeGroup',
			'foreignKey' => 'group_id',
			'conditions' => null,
			'fields' => null
		)
	);
}
?>