<?php
class MenuMain extends AppModel {
	var $name = 'MenuMain';
	var $useTable = 'getput_menu_main';
	var $primaryKey = 'menu_main_id';
	var $hasMany = array(
		'MenuItem' => array(
			'className' => 'MenuItem',
			'foreignKey' => 'menu_items_main_id',
			'conditions' => null,
			'fields' => null
		)
	);
}
?>