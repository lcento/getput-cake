<?php
class MenuItems extends AppModel {
	var $name = 'MenuItems';
	var $useTable = 'getput_menu_items';
	var $primaryKey = 'menu_items_id';
	var $belongsTo = array(
		'MenuMain'=>array(
			'className'=>'MenuMain',
			'foreignKey'=>'menu_items_main_id',
			'conditions'=>null,
			'fields'=>null
		)
	);
}
?>