<?php
class AgeGroup extends AppModel {
	var $name = 'AgeGroup';
	var $useTable = 'getput_agegroup';
	var $primaryKey = 'group_id';
	var $hasMany = array(
		'AgeUserGroup' => array(
			'className' => 'AgeUserGroup',
			'foreignKey' => 'group_id',
			'conditions' => null,
			'fields' => null
		)
	);
}
?>